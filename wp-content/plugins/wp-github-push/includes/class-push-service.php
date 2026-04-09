<?php

defined('ABSPATH') || exit;

final class WPGP_Push_Service {
    /** Blob downloads per AJAX request — kept small to stay well within PHP/proxy timeouts. */
    private const PULL_CHUNK_SIZE = 10;

    /** Pull jobs can run a long time; refresh TTL each chunk so nothing expires mid-flight. */
    private const PULL_JOB_TTL = DAY_IN_SECONDS;

    private const PULL_JOB_TRANSIENT_PREFIX = 'wpgp_pull_job_';

    public static function init(): void {
        add_action('admin_post_wpgp_push', [self::class, 'handle_push']);
        add_action('admin_post_wpgp_pull', [self::class, 'handle_pull']);
        add_action('admin_post_wpgp_disconnect', [self::class, 'handle_disconnect']);
        add_action('admin_post_wpgp_connect_pat', [self::class, 'handle_connect_pat']);
        add_action('admin_post_wpgp_sync_selection', [self::class, 'handle_sync_selection']);
        add_action('wp_ajax_wpgp_direct_push', [self::class, 'ajax_direct_push']);
        add_action('wp_ajax_wpgp_pull_start', [self::class, 'ajax_pull_start']);
        add_action('wp_ajax_wpgp_pull_chunk', [self::class, 'ajax_pull_chunk']);
        add_action('wp_ajax_wpgp_discover_themes', [self::class, 'ajax_discover_themes']);
        // Backward compat: stale-cached JS may still send the old action name.
        add_action('wp_ajax_wpgp_direct_pull', [self::class, 'ajax_direct_pull_compat']);
    }

    // ------------------------------------------------------------------
    // Push – reads local files, pushes to GitHub in one atomic commit
    // ------------------------------------------------------------------

    public static function handle_push(): void {
        WPGP_Security::ensure_admin();
        WPGP_Security::verify_nonce('wpgp_push_nonce', 'wpgp_push_action');

        $settings = WPGP_Settings::get();
        $error = self::validate_github_settings($settings);
        if (is_wp_error($error)) {
            self::redirect_with_notice('error', $error->get_error_message());
        }

        @set_time_limit(300);

        $scan = WPGP_File_Scanner::build_manifest($settings);
        if (!empty($scan['error']) && is_wp_error($scan['error'])) {
            self::redirect_with_notice('error', $scan['error']->get_error_message());
        }

        $manifest = $scan['manifest'] ?? [];
        if (empty($manifest)) {
            self::redirect_with_notice('error', __('No files were eligible for push.', 'wp-github-push'));
        }

        $files = [];
        foreach ($manifest as $entry) {
            $files[] = [
                'path'           => $entry['relativePath'],
                'content_base64' => $entry['contentBase64'],
            ];
        }

        $commit_message = sanitize_text_field($_POST['wpgp_commit_message'] ?? '');
        if ('' === $commit_message) {
            $commit_message = 'Sync from WordPress';
        }

        $result = WPGP_GitHub_API::push_files(
            $settings['github_pat'],
            $settings['repo'],
            $settings['branch'],
            $commit_message,
            $files
        );

        if (is_wp_error($result)) {
            self::redirect_with_notice('error', __('Push failed: ', 'wp-github-push') . $result->get_error_message());
        }

        WPGP_Settings::update(['last_push_at' => gmdate('c')]);

        self::redirect_with_notice(
            'success',
            sprintf(
                __('Push successful – %d files committed (%s).', 'wp-github-push'),
                $result['files_pushed'],
                substr($result['commit_sha'], 0, 7)
            )
        );
    }

    /**
     * AJAX variant for push (used by the JS progress UI).
     */
    public static function ajax_direct_push(): void {
        WPGP_Security::ensure_admin();
        check_ajax_referer('wpgp_push_action', 'nonce');

        $settings = WPGP_Settings::get();
        $error = self::validate_github_settings($settings);
        if (is_wp_error($error)) {
            wp_send_json_error(['message' => $error->get_error_message()], 400);
        }

        @set_time_limit(300);

        $scan = WPGP_File_Scanner::build_manifest($settings);
        if (!empty($scan['error']) && is_wp_error($scan['error'])) {
            wp_send_json_error(['message' => $scan['error']->get_error_message()], 400);
        }

        $manifest = $scan['manifest'] ?? [];
        if (empty($manifest)) {
            wp_send_json_error(['message' => __('No files were eligible for push.', 'wp-github-push')], 400);
        }

        $files = [];
        foreach ($manifest as $entry) {
            $files[] = [
                'path'           => $entry['relativePath'],
                'content_base64' => $entry['contentBase64'],
            ];
        }

        $commit_message = sanitize_text_field($_POST['commit_message'] ?? 'Sync from WordPress');

        $result = WPGP_GitHub_API::push_files(
            $settings['github_pat'],
            $settings['repo'],
            $settings['branch'],
            $commit_message,
            $files
        );

        if (is_wp_error($result)) {
            wp_send_json_error(['message' => $result->get_error_message()], 500);
        }

        WPGP_Settings::update(['last_push_at' => gmdate('c')]);

        wp_send_json_success([
            'commit_sha'    => $result['commit_sha'],
            'files_pushed'  => $result['files_pushed'],
            'text_inline'   => $result['text_inline'] ?? 0,
            'blobs_created' => $result['blobs_created'] ?? 0,
        ]);
    }

    // ------------------------------------------------------------------
    // Pull – tree + blobs into active theme (and parent), chunked over AJAX
    // ------------------------------------------------------------------

    public static function handle_pull(): void {
        WPGP_Security::ensure_admin();
        WPGP_Security::verify_nonce('wpgp_pull_nonce', 'wpgp_pull_action');

        $settings = WPGP_Settings::get();
        $error = self::validate_github_settings($settings);
        if (is_wp_error($error)) {
            self::redirect_with_notice('error', $error->get_error_message());
        }

        @set_time_limit(300);

        $report = self::run_pull_to_completion($settings);
        if (is_wp_error($report)) {
            self::redirect_with_notice('error', $report->get_error_message());
        }

        WPGP_Settings::update(['last_pull_at' => gmdate('c')]);

        $error_count = count($report['errors']);

        if ($error_count > 0 && $report['changed'] > 0) {
            self::redirect_with_notice(
                'success',
                sprintf(
                    __('Pull done – %d files updated, %d failed (permission issue – run: sudo chmod -R 775 on your themes folder).', 'wp-github-push'),
                    $report['changed'],
                    $error_count
                )
            );
        }

        if ($error_count > 0 && 0 === $report['changed']) {
            self::redirect_with_notice('error', $report['errors'][0]);
        }

        self::redirect_with_notice(
            'success',
            sprintf(
                __('Pull successful – %d files updated, %d skipped.', 'wp-github-push'),
                $report['changed'],
                $report['skipped']
            )
        );
    }

    /**
     * AJAX: begin pull — fetches tree, stores job for chunked blob downloads.
     */
    public static function ajax_pull_start(): void {
        WPGP_Security::ensure_admin();
        check_ajax_referer('wpgp_pull_action', 'nonce');

        $settings = WPGP_Settings::get();
        $error = self::validate_github_settings($settings);
        if (is_wp_error($error)) {
            wp_send_json_error(['message' => $error->get_error_message()], 400);
        }

        @set_time_limit(120);

        $started = self::pull_job_start($settings);
        if (is_wp_error($started)) {
            wp_send_json_error(['message' => $started->get_error_message()], 500);
        }

        wp_send_json_success($started);
    }

    /**
     * AJAX: download and write the next chunk of files.
     */
    public static function ajax_pull_chunk(): void {
        WPGP_Security::ensure_admin();
        check_ajax_referer('wpgp_pull_action', 'nonce');

        $settings = WPGP_Settings::get();
        $error = self::validate_github_settings($settings);
        if (is_wp_error($error)) {
            wp_send_json_error(['message' => $error->get_error_message()], 400);
        }

        $job_id = sanitize_text_field((string) ($_POST['job_id'] ?? ''));
        if ('' === $job_id) {
            wp_send_json_error(['message' => __('Missing pull job id.', 'wp-github-push')], 400);
        }

        @set_time_limit(120);

        $result = self::pull_job_run_chunk($settings, $job_id);
        if (is_wp_error($result)) {
            self::pull_job_delete($job_id);
            wp_send_json_error(['message' => $result->get_error_message()], 500);
        }

        if (!empty($result['done'])) {
            WPGP_Settings::update(['last_pull_at' => gmdate('c')]);
            $report = $result['report'];
            $has_errors  = !empty($report['errors']);
            $has_changes = $report['changed'] > 0;

            if ($has_errors && !$has_changes) {
                wp_send_json_error(['message' => $report['errors'][0], 'report' => $report], 500);
            }

            if ($has_errors) {
                $report['permission_hint'] = sprintf(
                    'Some files could not be written due to permissions. Run: sudo chmod -R 775 %s',
                    trailingslashit(WP_CONTENT_DIR) . 'themes/'
                );
            }

            wp_send_json_success([
                'done'   => true,
                'report' => $report,
            ]);
            return;
        }

        wp_send_json_success([
            'done'            => false,
            'processed_total' => (int) $result['processed_total'],
            'total_files'     => (int) $result['total_files'],
        ]);
    }

    /**
     * AJAX: scan the GitHub repo tree and return all theme folder slugs found under themes/.
     */
    public static function ajax_discover_themes(): void {
        WPGP_Security::ensure_admin();
        check_ajax_referer('wpgp_discover_themes', 'nonce');

        $settings = WPGP_Settings::get();
        $error = self::validate_github_settings($settings);
        if (is_wp_error($error)) {
            wp_send_json_error(['message' => $error->get_error_message()]);
        }

        $data = WPGP_GitHub_API::get_tree($settings['github_pat'], $settings['repo'], $settings['branch']);
        if (is_wp_error($data)) {
            wp_send_json_error(['message' => $data->get_error_message()]);
        }

        $remote_slugs = [];
        foreach ($data['tree'] as $item) {
            $path = (string) ($item['path'] ?? '');
            if (preg_match('#^themes/([^/]+)/#', $path, $m)) {
                $remote_slugs[$m[1]] = true;
            }
        }

        $local_slugs = array_keys(wp_get_themes());

        $results = [];
        foreach (array_keys($remote_slugs) as $slug) {
            $results[] = [
                'slug'              => $slug,
                'installed_locally' => in_array($slug, $local_slugs, true),
            ];
        }

        usort($results, static fn ($a, $b) => strcmp($a['slug'], $b['slug']));

        wp_send_json_success(['themes' => $results]);
    }

    /**
     * Backward-compat: old cached JS sends wpgp_direct_pull — run synchronous pull.
     */
    public static function ajax_direct_pull_compat(): void {
        WPGP_Security::ensure_admin();
        check_ajax_referer('wpgp_pull_action', 'nonce');

        $settings = WPGP_Settings::get();
        $error = self::validate_github_settings($settings);
        if (is_wp_error($error)) {
            wp_send_json_error(['message' => $error->get_error_message()], 400);
        }

        @set_time_limit(300);

        $report = self::run_pull_to_completion($settings);
        if (is_wp_error($report)) {
            wp_send_json_error(['message' => $report->get_error_message()], 500);
        }

        WPGP_Settings::update(['last_pull_at' => gmdate('c')]);

        $has_errors  = !empty($report['errors']);
        $has_changes = $report['changed'] > 0;

        if ($has_errors && !$has_changes) {
            wp_send_json_error(['message' => $report['errors'][0], 'report' => $report], 500);
        }

        if ($has_errors) {
            $report['permission_hint'] = sprintf(
                'Some files could not be written due to permissions. Run: sudo chmod -R 775 %s',
                trailingslashit(WP_CONTENT_DIR) . 'themes/'
            );
        }

        wp_send_json_success($report);
    }

    // ------------------------------------------------------------------
    // PAT connection – validate via GitHub API and store locally
    // ------------------------------------------------------------------

    public static function handle_connect_pat(): void {
        WPGP_Security::ensure_admin();
        WPGP_Security::verify_nonce('wpgp_connect_pat_nonce', 'wpgp_connect_pat_action');

        $pat = sanitize_text_field((string) ($_POST['wpgp_personal_access_token'] ?? ''));
        if ('' === $pat) {
            self::redirect_with_notice('error', __('Personal access token is required.', 'wp-github-push'));
        }

        $user = WPGP_GitHub_API::validate_token($pat);
        if (is_wp_error($user)) {
            self::redirect_with_notice('error', __('Invalid token: ', 'wp-github-push') . $user->get_error_message());
        }

        $username = sanitize_text_field((string) ($user['login'] ?? ''));
        if ('' === $username) {
            self::redirect_with_notice('error', __('Could not retrieve GitHub username from token.', 'wp-github-push'));
        }

        WPGP_Settings::update([
            'github_pat'      => $pat,
            'github_username' => $username,
        ]);

        self::redirect_with_notice(
            'success',
            sprintf(__('GitHub connected as %s.', 'wp-github-push'), $username)
        );
    }

    // ------------------------------------------------------------------
    // Disconnect – clear stored PAT
    // ------------------------------------------------------------------

    public static function handle_disconnect(): void {
        WPGP_Security::ensure_admin();
        WPGP_Security::verify_nonce('wpgp_disconnect_nonce', 'wpgp_disconnect_action');

        WPGP_Settings::update([
            'github_pat'      => '',
            'github_username' => '',
            'connection_id'   => '',
        ]);

        self::redirect_with_notice('success', __('GitHub connection disconnected.', 'wp-github-push'));
    }

    // ------------------------------------------------------------------
    // Repo/branch selection (kept simple – just save to settings)
    // ------------------------------------------------------------------

    public static function handle_sync_selection(): void {
        WPGP_Security::ensure_admin();
        WPGP_Security::verify_nonce('wpgp_sync_selection_nonce', 'wpgp_sync_selection_action');

        $repo   = sanitize_text_field((string) ($_POST['wpgp_repo'] ?? ''));
        $branch = sanitize_text_field((string) ($_POST['wpgp_branch'] ?? ''));

        WPGP_Settings::update([
            'repo'   => $repo,
            'branch' => $branch,
        ]);

        self::redirect_with_notice('success', __('Repository and branch saved.', 'wp-github-push'));
    }

    // ------------------------------------------------------------------
    // Helpers
    // ------------------------------------------------------------------

    private static function validate_github_settings(array $settings) {
        if ('' === (string) ($settings['github_pat'] ?? '')) {
            return new WP_Error('wpgp_missing_pat', __('GitHub PAT is required. Connect via PAT first.', 'wp-github-push'));
        }
        if ('' === (string) ($settings['repo'] ?? '')) {
            return new WP_Error('wpgp_missing_repo', __('Repository is required.', 'wp-github-push'));
        }
        if ('' === (string) ($settings['branch'] ?? '')) {
            return new WP_Error('wpgp_missing_branch', __('Branch is required.', 'wp-github-push'));
        }
        return null;
    }

    /**
     * Run full pull in one request (form POST) using internal chunking.
     *
     * @return array|WP_Error
     */
    private static function run_pull_to_completion(array $settings) {
        $started = self::pull_job_start($settings);
        if (is_wp_error($started)) {
            return $started;
        }

        $job_id = $started['job_id'];

        while (true) {
            @set_time_limit(120);
            $step = self::pull_job_run_chunk($settings, $job_id);
            if (is_wp_error($step)) {
                self::pull_job_delete($job_id);
                return $step;
            }
            if (!empty($step['done'])) {
                return $step['report'];
            }
        }
    }

    /**
     * @return array|WP_Error { job_id, total_files, commit_sha? }
     */
    private static function pull_job_start(array $settings) {
        $list = self::fetch_pull_file_list($settings);
        if (is_wp_error($list)) {
            return $list;
        }

        $files = $list['files'];
        $job_id = wp_generate_password(32, false, false);

        $state = [
            'repo'         => (string) $settings['repo'],
            'branch'       => (string) $settings['branch'],
            'files'        => $files,
            'offset'       => 0,
            'report'       => [
                'changed' => 0,
                'skipped' => (int) ($list['skipped'] ?? 0),
                'errors'  => [],
            ],
            'backup_root'  => self::prepare_backup_root(),
            'created'      => time(),
        ];

        set_transient(self::PULL_JOB_TRANSIENT_PREFIX . $job_id, $state, self::PULL_JOB_TTL);

        $scope_note = WPGP_Settings::is_full_themes_directory_scope($settings)
            ? 'full wp-content/themes directory'
            : sprintf('%d configured theme(s)', count(WPGP_Settings::resolve_sync_theme_slugs($settings)));

        self::log_progress(
            'pull_phase',
            sprintf(
                'pull_job_started: %d files for %s',
                count($files),
                $scope_note
            )
        );

        return [
            'job_id'      => $job_id,
            'total_files' => count($files),
            'commit_sha'  => $list['commit_sha'] ?? '',
        ];
    }

    /**
     * @return array|WP_Error
     */
    private static function pull_job_run_chunk(array $settings, string $job_id) {
        $key = self::PULL_JOB_TRANSIENT_PREFIX . $job_id;
        $state = get_transient($key);

        if (!is_array($state)) {
            return new WP_Error('wpgp_pull_expired', __('Pull session expired. Please try again.', 'wp-github-push'));
        }

        if (($state['repo'] ?? '') !== (string) $settings['repo']
            || ($state['branch'] ?? '') !== (string) $settings['branch']) {
            return new WP_Error('wpgp_pull_mismatch', __('Repository settings changed during pull. Please try again.', 'wp-github-push'));
        }

        // Extend job lifetime before slow blob downloads so the transient cannot expire during this request.
        set_transient($key, $state, self::PULL_JOB_TTL);

        $files   = $state['files'];
        $offset  = (int) ($state['offset'] ?? 0);
        $total   = count($files);
        $chunk   = array_slice($files, $offset, self::PULL_CHUNK_SIZE);
        $report  = &$state['report'];
        $pat     = $settings['github_pat'];
        $repo    = $settings['repo'];
        $backup  = (string) ($state['backup_root'] ?? '');

        foreach ($chunk as $entry) {
            $relative_path = $entry['path'];
            $sha           = $entry['sha'];

            $content = WPGP_GitHub_API::get_blob_content($pat, $repo, $sha);
            if (is_wp_error($content)) {
                $report['errors'][] = $relative_path . ': ' . $content->get_error_message();
                continue;
            }

            self::write_pulled_file($relative_path, $content, $backup, $report);
        }

        $offset += count($chunk);
        $state['offset'] = $offset;

        $processed_total = min($offset, $total);

        if ($offset >= $total) {
            delete_transient($key);
            self::log_progress('pull_phase', sprintf(
                'pull_job_done: %d changed, %d skipped, %d errors',
                $report['changed'],
                $report['skipped'],
                count($report['errors'])
            ));

            return [
                'done'            => true,
                'report'          => $report,
                'processed_total' => $processed_total,
                'total_files'     => $total,
            ];
        }

        set_transient($key, $state, self::PULL_JOB_TTL);

        return [
            'done'            => false,
            'processed_total' => $processed_total,
            'total_files'     => $total,
        ];
    }

    private static function pull_job_delete(string $job_id): void {
        delete_transient(self::PULL_JOB_TRANSIENT_PREFIX . $job_id);
    }

    /**
     * List blob paths under the active theme (and parent theme if different), matching push scope.
     *
     * @return array|WP_Error
     */
    private static function fetch_pull_file_list(array $settings) {
        $scope_label = WPGP_Settings::is_full_themes_directory_scope($settings)
            ? 'scope=full_themes_dir'
            : 'theme_slugs=[' . implode(', ', WPGP_Settings::resolve_sync_theme_slugs($settings)) . ']';

        self::log_progress('pull_phase', sprintf(
            'fetching_tree | %s | pull_filters=theme_prefix+exclude (shared with aligned push)',
            $scope_label
        ));

        $data = WPGP_GitHub_API::get_tree($settings['github_pat'], $settings['repo'], $settings['branch']);
        if (is_wp_error($data)) {
            return $data;
        }

        if (!empty($data['truncated'])) {
            return new WP_Error(
                'wpgp_pull_truncated',
                __('The repository tree is too large for GitHub to return in one request. Try a smaller branch or shallow content.', 'wp-github-push')
            );
        }

        $self_prefix = self::get_self_content_prefix();

        $files           = [];
        $skipped         = 0;
        $skipped_exclude = 0;

        foreach ($data['tree'] as $item) {
            if (($item['type'] ?? '') !== 'blob') {
                continue;
            }

            $path = (string) ($item['path'] ?? '');
            $san  = self::sanitize_relative_path($path);
            if ('' === $san) {
                $skipped++;
                continue;
            }

            if ('' !== $self_prefix && 0 === strpos($san, $self_prefix)) {
                $skipped++;
                continue;
            }

            if (!WPGP_File_Scanner::path_eligible_pull_style($san, $settings)) {
                if (WPGP_File_Scanner::path_under_synced_themes($san, $settings)
                    && WPGP_File_Scanner::path_excluded_by_patterns($san, $settings)) {
                    $skipped_exclude++;
                }
                $skipped++;
                continue;
            }

            $sha = (string) ($item['sha'] ?? '');
            if ('' === $sha) {
                continue;
            }

            $files[] = [
                'path' => $san,
                'sha'  => $sha,
            ];
        }

        $total_blobs = 0;
        foreach ($data['tree'] as $item) {
            if (($item['type'] ?? '') === 'blob') {
                $total_blobs++;
            }
        }

        self::log_progress('pull_phase', sprintf(
            'tree_filtered: %d blobs total, %d matched theme prefixes, %d excluded by patterns, %d queued for download',
            $total_blobs,
            count($files) + $skipped,
            $skipped_exclude,
            count($files)
        ));

        return [
            'files'      => $files,
            'commit_sha' => (string) ($data['commit_sha'] ?? ''),
            'skipped'    => $skipped,
        ];
    }

    /**
     * Return this plugin's path relative to wp-content/ so the pull can skip overwriting itself.
     */
    private static function get_self_content_prefix(): string {
        if (!defined('WPGP_PLUGIN_DIR')) {
            return '';
        }
        $rel = str_replace(
            wp_normalize_path(trailingslashit(WP_CONTENT_DIR)),
            '',
            wp_normalize_path(trailingslashit(WPGP_PLUGIN_DIR))
        );
        return ltrim($rel, '/');
    }

    /**
     * @param array $report { changed, skipped, errors }
     */
    private static function write_pulled_file(string $relative_path, string $content, string $backup_root, array &$report): void {
        $target_path = trailingslashit(WP_CONTENT_DIR) . $relative_path;
        self::backup_file_if_exists($target_path, $backup_root);

        $parent_dir = dirname($target_path);
        if (!is_dir($parent_dir)) {
            if (!wp_mkdir_p($parent_dir)) {
                $grandparent = dirname($parent_dir);
                if (is_dir($grandparent)) {
                    @chmod($grandparent, 0755);
                }
                if (!wp_mkdir_p($parent_dir)) {
                    $report['errors'][] = sprintf(__('Failed to create directory for %s', 'wp-github-push'), $relative_path);
                    return;
                }
            }
            @chmod($parent_dir, 0755);
        }

        if (file_exists($target_path) && !is_writable($target_path)) {
            @chmod($target_path, 0644);
        }
        if (!file_exists($target_path) && !is_writable($parent_dir)) {
            @chmod($parent_dir, 0755);
        }

        if (false === @file_put_contents($target_path, $content)) {
            $err = error_get_last();
            $detail = $err ? $err['message'] : 'unknown reason';
            $report['errors'][] = sprintf('%s: %s', $relative_path, $detail);
            return;
        }

        @chmod($target_path, 0644);
        $report['changed']++;
    }

    /**
     * Write a progress entry to a transient (visible in debug log).
     */
    private static function log_progress(string $key, string $value): void {
        $log = get_transient('wpgp_api_debug_log') ?: [];
        array_unshift($log, [
            'time'          => gmdate('Y-m-d H:i:s') . ' UTC',
            'method'        => 'INTERNAL',
            'url'           => $key,
            'request_body'  => '',
            'status'        => 0,
            'response_body' => $value,
            'duration_ms'   => 0,
        ]);
        $log = array_slice($log, 0, 100);
        set_transient('wpgp_api_debug_log', $log, HOUR_IN_SECONDS);
    }

    private static function sanitize_relative_path(string $path): string {
        $normalized = wp_normalize_path($path);
        $normalized = ltrim($normalized, '/');
        if ('' === $normalized || false !== strpos($normalized, '..') || false !== strpos($normalized, "\0")) {
            return '';
        }
        return $normalized;
    }

    private static function prepare_backup_root(): string {
        $upload_dir = wp_upload_dir();
        $base_dir = trailingslashit($upload_dir['basedir']) . 'wpgp-backups/' . gmdate('Ymd-His');
        wp_mkdir_p($base_dir);
        return $base_dir;
    }

    private static function backup_file_if_exists(string $target_path, string $backup_root): void {
        if (!file_exists($target_path) || !is_file($target_path)) {
            return;
        }

        $relative = ltrim(str_replace(wp_normalize_path(WP_CONTENT_DIR), '', wp_normalize_path($target_path)), '/');
        $backup_path = trailingslashit($backup_root) . $relative;
        $backup_dir = dirname($backup_path);
        if (!is_dir($backup_dir)) {
            wp_mkdir_p($backup_dir);
        }
        @copy($target_path, $backup_path);
    }

    private static function redirect_with_notice(string $type, string $message): void {
        $url = add_query_arg(
            [
                'page' => 'wpgp',
                'wpgp_notice_type' => rawurlencode($type),
                'wpgp_notice_message' => rawurlencode($message),
            ],
            admin_url('admin.php')
        );

        wp_safe_redirect($url);
        exit;
    }
}

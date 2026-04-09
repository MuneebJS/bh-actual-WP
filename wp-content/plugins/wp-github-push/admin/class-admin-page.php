<?php

defined('ABSPATH') || exit;

final class WPGP_Admin_Page {
    public static function init(): void {
        add_action('admin_menu', [self::class, 'register_menu']);
        add_action('admin_enqueue_scripts', [self::class, 'enqueue_assets']);
        add_action('wp_ajax_wpgp_clear_debug_log', [self::class, 'handle_clear_debug_log']);
    }

    public static function handle_clear_debug_log(): void {
        check_ajax_referer('wpgp_clear_debug_log', 'nonce');
        WPGP_API_Client::clear_debug_log();
        wp_send_json_success();
    }

    public static function register_menu(): void {
        add_menu_page(
            __('WP GitHub Push', 'wp-github-push'),
            __('WP GitHub Push', 'wp-github-push'),
            'manage_options',
            'wpgp',
            [self::class, 'render'],
            'dashicons-upload'
        );
    }

    public static function enqueue_assets(string $hook): void {
        if ('toplevel_page_wpgp' !== $hook) {
            return;
        }

        wp_enqueue_script(
            'wpgp-admin',
            WPGP_PLUGIN_URL . 'admin/assets/admin.js',
            ['jquery'],
            WPGP_VERSION,
            true
        );

        wp_localize_script(
            'wpgp-admin',
            'wpgpAdmin',
            [
                'ajaxUrl'           => admin_url('admin-ajax.php'),
                'pushNonce'         => wp_create_nonce('wpgp_push_action'),
                'pullNonce'         => wp_create_nonce('wpgp_pull_action'),
                'contentThemesPath' => trailingslashit(WP_CONTENT_DIR) . 'themes/',
                'discoverNonce'     => wp_create_nonce('wpgp_discover_themes'),
                'localThemeSlugs'   => array_values(array_keys(wp_get_themes())),
                'remoteThemeI18n'   => [
                    'invalid'          => __('Enter a valid theme folder name (letters, numbers, hyphens, underscores only).', 'wp-github-push'),
                    'alreadyInstalled' => __('That theme is already installed — enable it under “Themes to sync” above.', 'wp-github-push'),
                    'duplicate'        => __('That slug is already in the list.', 'wp-github-push'),
                ],
            ]
        );
    }

    public static function render(): void {
        WPGP_Security::ensure_admin();
        $settings       = WPGP_Settings::get();
        $notice_type    = sanitize_text_field($_GET['wpgp_notice_type'] ?? '');
        $notice_message = sanitize_text_field($_GET['wpgp_notice_message'] ?? '');
        $has_pat        = '' !== (string) ($settings['github_pat'] ?? '');
        $github_user    = (string) ($settings['github_username'] ?? '');
        ?>
        <div class="wrap">
            <h1><?php esc_html_e('WP GitHub Push', 'wp-github-push'); ?></h1>

            <?php self::render_debug_log(); ?>

            <?php if ($notice_type && $notice_message) : ?>
                <div class="notice notice-<?php echo esc_attr('error' === $notice_type ? 'error' : 'success'); ?> is-dismissible">
                    <p><?php echo esc_html($notice_message); ?></p>
                </div>
            <?php endif; ?>

            <!-- Step 1: Connect GitHub via PAT -->
            <h2><?php esc_html_e('Step 1: Connect GitHub', 'wp-github-push'); ?></h2>
            <?php if ($has_pat && '' !== $github_user) : ?>
                <p style="color:green;">
                    <span class="dashicons dashicons-yes-alt"></span>
                    <?php printf(esc_html__('Connected as %s', 'wp-github-push'), '<strong>' . esc_html($github_user) . '</strong>'); ?>
                </p>
                <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" style="display:inline-block;">
                    <input type="hidden" name="action" value="wpgp_disconnect" />
                    <?php wp_nonce_field('wpgp_disconnect_action', 'wpgp_disconnect_nonce'); ?>
                    <?php submit_button(__('Disconnect', 'wp-github-push'), 'secondary', 'submit', false); ?>
                </form>
            <?php else : ?>
                <p><?php esc_html_e('Enter your GitHub Personal Access Token (needs repo scope).', 'wp-github-push'); ?></p>
                <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                    <input type="hidden" name="action" value="wpgp_connect_pat" />
                    <?php wp_nonce_field('wpgp_connect_pat_action', 'wpgp_connect_pat_nonce'); ?>
                    <p>
                        <input
                            type="password"
                            class="regular-text"
                            name="wpgp_personal_access_token"
                            placeholder="<?php esc_attr_e('ghp_xxxxxxxxxxxxxxxxxxxx', 'wp-github-push'); ?>"
                            autocomplete="off"
                            required
                        />
                        <?php submit_button(__('Connect', 'wp-github-push'), 'primary', 'submit', false); ?>
                    </p>
                </form>
            <?php endif; ?>

            <hr />

            <!-- Step 2: Select Repository and Branch -->
            <h2><?php esc_html_e('Step 2: Repository & Branch', 'wp-github-push'); ?></h2>
            <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                <input type="hidden" name="action" value="wpgp_sync_selection" />
                <?php wp_nonce_field('wpgp_sync_selection_action', 'wpgp_sync_selection_nonce'); ?>
                <table class="form-table" role="presentation">
                    <tr>
                        <th scope="row"><label for="wpgp_repo"><?php esc_html_e('Repository', 'wp-github-push'); ?></label></th>
                        <td>
                            <input type="text" class="regular-text" id="wpgp_repo" name="wpgp_repo" value="<?php echo esc_attr($settings['repo']); ?>" placeholder="owner/repo" />
                            <p class="description"><?php esc_html_e('Format: owner/repo (e.g. acme/my-theme)', 'wp-github-push'); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="wpgp_branch"><?php esc_html_e('Branch', 'wp-github-push'); ?></label></th>
                        <td>
                            <input type="text" class="regular-text" id="wpgp_branch" name="wpgp_branch" value="<?php echo esc_attr($settings['branch']); ?>" placeholder="main" />
                        </td>
                    </tr>
                </table>
                <?php submit_button(__('Save', 'wp-github-push')); ?>
            </form>

            <hr />

            <!-- Step 3: Themes & path filters -->
            <h2><?php esc_html_e('Step 3: Themes & Path Filters', 'wp-github-push'); ?></h2>
            <form method="post" action="options.php">
                <?php settings_fields('wpgp_settings_group'); ?>
                <input type="hidden" name="wpgp_settings[_wpgp_theme_selection]" value="1" />
                <?php
                $theme_sync_scope = (string) ($settings['theme_sync_scope'] ?? 'selected');
                $sync_slugs         = WPGP_Settings::resolve_sync_theme_slugs($settings);
                $themes             = wp_get_themes();
                ksort($themes, SORT_NATURAL | SORT_FLAG_CASE);
                $theme_list = 'all' === $theme_sync_scope
                    ? 'themes/*/'
                    : implode(', ', array_map(static fn ($s) => 'themes/' . $s . '/', $sync_slugs));
                ?>
                <table class="form-table" role="presentation">
                    <tr>
                        <th scope="row"><?php esc_html_e('Theme sync scope', 'wp-github-push'); ?></th>
                        <td>
                            <fieldset>
                                <legend class="screen-reader-text"><span><?php esc_html_e('Theme sync scope', 'wp-github-push'); ?></span></legend>
                                <label style="display:block;margin:0.35em 0;">
                                    <input
                                        type="radio"
                                        name="wpgp_settings[theme_sync_scope]"
                                        value="selected"
                                        <?php checked('selected', $theme_sync_scope); ?>
                                    />
                                    <?php esc_html_e('Selected themes only', 'wp-github-push'); ?>
                                </label>
                                <p class="description" style="margin:0.25em 0 0.75em 1.6em;">
                                    <?php esc_html_e('Push and pull only the checked themes below (plus any remote-only folders you list). If no checkboxes are valid, the active theme and its parent are used.', 'wp-github-push'); ?>
                                </p>
                                <label style="display:block;margin:0.35em 0;">
                                    <input
                                        type="radio"
                                        name="wpgp_settings[theme_sync_scope]"
                                        value="all"
                                        <?php checked('all', $theme_sync_scope); ?>
                                    />
                                    <?php esc_html_e('Entire themes directory', 'wp-github-push'); ?>
                                </label>
                                <p class="description" style="margin:0.25em 0 0 1.6em;">
                                    <?php esc_html_e('Push and pull every file under wp-content/themes (every theme folder). Exclude patterns still apply. The checklist below is ignored for this mode.', 'wp-github-push'); ?>
                                </p>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php esc_html_e('Themes to sync', 'wp-github-push'); ?></th>
                        <td>
                            <fieldset>
                                <legend class="screen-reader-text"><span><?php esc_html_e('Themes to sync', 'wp-github-push'); ?></span></legend>
                                <?php foreach ($themes as $slug => $theme) : ?>
                                    <label style="display:block;margin:0.35em 0;">
                                        <input
                                            type="checkbox"
                                            name="wpgp_settings[sync_theme_slugs][]"
                                            value="<?php echo esc_attr($slug); ?>"
                                            <?php checked(in_array($slug, $sync_slugs, true)); ?>
                                        />
                                        <?php echo esc_html($theme->get('Name')); ?>
                                        <code><?php echo esc_html($slug); ?></code>
                                    </label>
                                <?php endforeach; ?>
                            </fieldset>
                            <p class="description">
                                <?php if ('all' === $theme_sync_scope) : ?>
                                    <?php esc_html_e('Ignored while “Entire themes directory” is selected — all theme folders are included.', 'wp-github-push'); ?>
                                <?php else : ?>
                                    <?php esc_html_e('Push and pull only affect checked themes. If none are valid, the active theme and its parent are used.', 'wp-github-push'); ?>
                                <?php endif; ?>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php esc_html_e('Themes on GitHub (remote)', 'wp-github-push'); ?></th>
                        <td>
                            <button type="button" class="button" id="wpgp-scan-github-themes">
                                <span class="dashicons dashicons-search" style="vertical-align:text-bottom;"></span>
                                <?php esc_html_e('Scan GitHub for themes', 'wp-github-push'); ?>
                            </button>
                            <span id="wpgp-scan-spinner" class="spinner" style="float:none;margin-top:0;"></span>
                            <span id="wpgp-scan-status" style="display:inline-block;margin-left:6px;font-size:13px;"></span>
                            <p style="margin:10px 0 6px;">
                                <label for="wpgp-remote-theme-add-input" class="screen-reader-text"><?php esc_html_e('Add theme folder name', 'wp-github-push'); ?></label>
                                <input
                                    type="text"
                                    id="wpgp-remote-theme-add-input"
                                    class="regular-text"
                                    style="max-width:220px;"
                                    placeholder="<?php esc_attr_e('theme-folder-name', 'wp-github-push'); ?>"
                                    autocomplete="off"
                                />
                                <button type="button" class="button" id="wpgp-remote-theme-add-btn"><?php esc_html_e('Add for sync', 'wp-github-push'); ?></button>
                                <span id="wpgp-remote-add-msg" style="display:block;margin-top:6px;font-size:13px;"></span>
                            </p>
                            <div id="wpgp-remote-themes-list" style="margin-top:8px;">
                                <?php
                                $saved_remote = WPGP_Settings::parse_remote_theme_slug_lines_public((string) ($settings['remote_theme_slugs'] ?? ''));
                                if (!empty($saved_remote)) :
                                    foreach ($saved_remote as $rs) : ?>
                                        <label style="display:block;margin:0.35em 0;">
                                            <input
                                                type="checkbox"
                                                class="wpgp-remote-theme-cb"
                                                name="wpgp_settings[remote_theme_slugs_list][]"
                                                value="<?php echo esc_attr($rs); ?>"
                                                checked
                                            />
                                            <code><?php echo esc_html($rs); ?></code>
                                            <em style="color:#888;"><?php esc_html_e('(not installed locally)', 'wp-github-push'); ?></em>
                                        </label>
                                    <?php endforeach;
                                endif; ?>
                            </div>
                            <textarea class="large-text code" rows="2" id="wpgp_remote_theme_slugs" name="wpgp_settings[remote_theme_slugs]" style="display:none;"><?php echo esc_textarea($settings['remote_theme_slugs']); ?></textarea>
                            <p class="description">
                                <?php esc_html_e('Scan discovers theme folders under themes/ in the repo. If a theme does not appear, type its folder name and click “Add for sync” so push and pull include it. Save settings after changing the list.', 'wp-github-push'); ?>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?php esc_html_e('Push file filtering', 'wp-github-push'); ?></th>
                        <td>
                            <fieldset>
                                <legend class="screen-reader-text"><span><?php esc_html_e('Push file filtering', 'wp-github-push'); ?></span></legend>
                                <label style="display:block;margin:0.35em 0;">
                                    <input
                                        type="radio"
                                        name="wpgp_settings[push_filter_profile]"
                                        value="aligned"
                                        <?php checked('aligned', (string) ($settings['push_filter_profile'] ?? 'aligned')); ?>
                                    />
                                    <?php esc_html_e('Aligned with pull (recommended)', 'wp-github-push'); ?>
                                </label>
                                <p class="description" style="margin:0.25em 0 0.75em 1.6em;">
                                    <?php esc_html_e('Push every file under the selected themes except paths matching your exclude patterns — same rules as pull. No extension allowlist, no automatic skip of minified or vendor folders (use exclude patterns for those).', 'wp-github-push'); ?>
                                </p>
                                <label style="display:block;margin:0.35em 0;">
                                    <input
                                        type="radio"
                                        name="wpgp_settings[push_filter_profile]"
                                        value="strict"
                                        <?php checked('strict', (string) ($settings['push_filter_profile'] ?? 'aligned')); ?>
                                    />
                                    <?php esc_html_e('Strict push (legacy)', 'wp-github-push'); ?>
                                </label>
                                <p class="description" style="margin:0.25em 0 0 1.6em;">
                                    <?php esc_html_e('Only certain extensions, skip minified maps/bundles, skip node_modules/vendor/dist/build, and apply include patterns below when set.', 'wp-github-push'); ?>
                                </p>
                            </fieldset>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="wpgp_include_patterns"><?php esc_html_e('Include Patterns (optional)', 'wp-github-push'); ?></label></th>
                        <td>
                            <textarea class="large-text code" rows="4" id="wpgp_include_patterns" name="wpgp_settings[include_patterns]" placeholder="themes/my-theme/**/*.php"><?php echo esc_textarea($settings['include_patterns']); ?></textarea>
                            <p class="description">
                                <?php esc_html_e('One fnmatch pattern per line, relative to wp-content. Used only for strict push: when set, only matching files are pushed. Pull ignores include patterns so new files from the repo can be downloaded.', 'wp-github-push'); ?>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="wpgp_exclude_patterns"><?php esc_html_e('Exclude Patterns', 'wp-github-push'); ?></label></th>
                        <td>
                            <textarea class="large-text code" rows="6" id="wpgp_exclude_patterns" name="wpgp_settings[exclude_patterns]"><?php echo esc_textarea($settings['exclude_patterns']); ?></textarea>
                            <p class="description">
                                <?php
                                printf(
                                    /* translators: %s: comma-separated path prefixes like themes/foo/ */
                                    esc_html__('One fnmatch pattern per line (wp-content-relative). Typical roots right now: %s', 'wp-github-push'),
                                    '<code>' . esc_html($theme_list) . '</code>'
                                );
                                ?>
                            </p>
                        </td>
                    </tr>
                </table>
                <?php
                foreach (['backend_base_url', 'site_id', 'project_id', 'connection_id', 'hmac_secret', 'github_pat', 'github_username', 'repo', 'branch', 'last_job_id', 'last_push_at', 'last_pull_job_id', 'last_pull_at'] as $hidden_key) :
                    ?>
                    <input type="hidden" name="wpgp_settings[<?php echo esc_attr($hidden_key); ?>]" value="<?php echo esc_attr($settings[$hidden_key]); ?>" />
                <?php endforeach; ?>
                <?php submit_button(__('Save Settings', 'wp-github-push')); ?>
            </form>

            <hr />

            <!-- Step 4: Push and Pull -->
            <h2><?php esc_html_e('Step 4: Push & Pull', 'wp-github-push'); ?></h2>
            <?php if (!$has_pat) : ?>
                <p class="description"><?php esc_html_e('Connect your GitHub PAT above before pushing or pulling.', 'wp-github-push'); ?></p>
            <?php else : ?>
                <form id="wpgp-push-form" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                    <input type="hidden" name="action" value="wpgp_push" />
                    <?php wp_nonce_field('wpgp_push_action', 'wpgp_push_nonce'); ?>
                    <p>
                        <label for="wpgp_commit_message"><?php esc_html_e('Commit Message', 'wp-github-push'); ?></label><br />
                        <input type="text" class="regular-text" id="wpgp_commit_message" name="wpgp_commit_message" placeholder="<?php esc_attr_e('Sync from WordPress', 'wp-github-push'); ?>" />
                    </p>
                    <?php submit_button(__('Push to GitHub', 'wp-github-push'), 'primary', 'submit', false, ['id' => 'wpgp-push-btn']); ?>
                    <span id="wpgp-push-spinner" class="spinner" style="float:none;margin-top:0;"></span>
                </form>

                <form id="wpgp-pull-form" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" style="margin-top:12px;">
                    <input type="hidden" name="action" value="wpgp_pull" />
                    <?php wp_nonce_field('wpgp_pull_action', 'wpgp_pull_nonce'); ?>
                    <?php submit_button(__('Pull from GitHub', 'wp-github-push'), 'secondary', 'submit', false, ['id' => 'wpgp-pull-btn']); ?>
                    <span id="wpgp-pull-spinner" class="spinner" style="float:none;margin-top:0;"></span>
                </form>

                <div id="wpgp-status" style="margin-top:16px;">
                    <p><strong><?php esc_html_e('Last Pushed:', 'wp-github-push'); ?></strong> <?php echo esc_html($settings['last_push_at'] ?: '—'); ?></p>
                    <p><strong><?php esc_html_e('Last Pulled:', 'wp-github-push'); ?></strong> <?php echo esc_html($settings['last_pull_at'] ?: '—'); ?></p>
                    <pre id="wpgp-status-output" style="max-height:260px;overflow:auto;background:#fff;padding:12px;border:1px solid #ddd;display:none;"></pre>
                </div>
            <?php endif; ?>
        </div>
        <?php
    }

    private static function render_debug_log(): void {
        $log = WPGP_API_Client::get_debug_log();
        $count = count($log);
        ?>
        <div id="wpgp-debug-log" style="margin:12px 0 20px;background:#1e1e1e;color:#d4d4d4;border-radius:6px;font-family:monospace;font-size:12px;max-height:420px;overflow:auto;padding:0;">
            <div style="position:sticky;top:0;background:#2d2d2d;padding:8px 14px;display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid #444;z-index:1;">
                <span style="color:#569cd6;font-weight:bold;">API Debug Log (<?php echo (int) $count; ?> calls)</span>
                <button type="button" onclick="if(confirm('Clear all logs?')){jQuery.post(ajaxurl,{action:'wpgp_clear_debug_log',nonce:'<?php echo wp_create_nonce('wpgp_clear_debug_log'); ?>'},function(){location.reload();});}" style="background:#c53030;color:#fff;border:none;padding:3px 10px;border-radius:3px;cursor:pointer;font-size:11px;">Clear</button>
            </div>
            <?php if (empty($log)) : ?>
                <div style="padding:14px;color:#888;">No API calls logged yet.</div>
            <?php else : ?>
                <?php foreach ($log as $i => $entry) : ?>
                    <?php
                    $status = (int) ($entry['status'] ?? 0);
                    $is_ok = $status >= 200 && $status < 300;
                    $badge_bg = $is_ok ? '#2e7d32' : ($status === 0 ? '#888' : '#c53030');
                    ?>
                    <div style="padding:10px 14px;border-bottom:1px solid #333;">
                        <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
                            <span style="background:<?php echo $badge_bg; ?>;color:#fff;padding:1px 8px;border-radius:3px;font-weight:bold;"><?php echo esc_html($entry['method']); ?> <?php echo (int) $entry['status']; ?></span>
                            <span style="color:#dcdcaa;word-break:break-all;"><?php echo esc_html($entry['url']); ?></span>
                            <span style="color:#888;margin-left:auto;white-space:nowrap;"><?php echo esc_html($entry['duration_ms']); ?>ms &middot; <?php echo esc_html($entry['time']); ?></span>
                        </div>
                        <?php if (!empty($entry['request_body'])) : ?>
                            <details style="margin-top:6px;">
                                <summary style="color:#9cdcfe;cursor:pointer;">Request Body</summary>
                                <pre style="margin:4px 0 0;padding:8px;background:#252526;border-radius:3px;overflow-x:auto;color:#ce9178;white-space:pre-wrap;word-break:break-all;"><?php echo esc_html($entry['request_body']); ?></pre>
                            </details>
                        <?php endif; ?>
                        <?php if (!empty($entry['response_body'])) : ?>
                            <details style="margin-top:4px;">
                                <summary style="color:#9cdcfe;cursor:pointer;">Response Body</summary>
                                <pre style="margin:4px 0 0;padding:8px;background:#252526;border-radius:3px;overflow-x:auto;color:#b5cea8;white-space:pre-wrap;word-break:break-all;"><?php echo esc_html($entry['response_body']); ?></pre>
                            </details>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <?php
    }
}

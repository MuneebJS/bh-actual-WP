<?php

defined('ABSPATH') || exit;

final class WPGP_Settings {
    public const OPTION_KEY = 'wpgp_settings';

    /**
     * Default exclude patterns (one per line), shown in settings and used when the option is unset.
     * Paths are relative to wp-content; see WPGP_File_Scanner::parse_user_patterns / fnmatch().
     */
    private static function default_exclude_patterns(): string {
        return implode(
            "\n",
            [
                '*.log',
                '*.cache',
                '*/.git/*',
                '*/node_modules/*',
                '*/vendor/*',
                'uploads/*',
            ]
        );
    }

    public static function init(): void {
        add_action('admin_init', [self::class, 'register']);
    }

    public static function ensure_defaults(): void {
        $defaults = self::defaults();
        $existing = get_option(self::OPTION_KEY);

        if (false === $existing) {
            add_option(self::OPTION_KEY, $defaults, '', 'no');
            return;
        }

        if (!is_array($existing)) {
            update_option(self::OPTION_KEY, $defaults, false);
            return;
        }

        $merged = array_merge($defaults, $existing);
        update_option(self::OPTION_KEY, $merged, false);
    }

    public static function register(): void {
        register_setting(
            'wpgp_settings_group',
            self::OPTION_KEY,
            [
                'type'              => 'array',
                'sanitize_callback' => [self::class, 'sanitize'],
                'default'           => self::defaults(),
            ]
        );
    }

    public static function sanitize($raw): array {
        $existing = get_option(self::OPTION_KEY, []);
        $existing = is_array($existing) ? $existing : [];
        $fallback = array_merge(self::defaults(), $existing);
        $raw = is_array($raw) ? $raw : [];

        return [
            'backend_base_url'   => esc_url_raw($raw['backend_base_url'] ?? $fallback['backend_base_url']),
            'site_id'            => sanitize_text_field($raw['site_id'] ?? $fallback['site_id']),
            'project_id'         => sanitize_text_field(
                $raw['project_id'] ?? ($raw['workspace_id'] ?? $fallback['project_id'])
            ),
            'connection_id'      => sanitize_text_field($raw['connection_id'] ?? $fallback['connection_id']),
            'repo'               => sanitize_text_field($raw['repo'] ?? $fallback['repo']),
            'branch'             => sanitize_text_field($raw['branch'] ?? $fallback['branch']),
            'theme_sync_scope'     => self::sanitize_theme_sync_scope($raw['theme_sync_scope'] ?? $fallback['theme_sync_scope']),
            'sync_theme_slugs'     => self::sanitize_sync_theme_slugs_field($raw, $fallback),
            'remote_theme_slugs'   => self::sanitize_remote_theme_slugs_from_request($raw, $fallback),
            'include_patterns'      => WPGP_Security::sanitize_multiline_text($raw['include_patterns'] ?? $fallback['include_patterns']),
            'exclude_patterns'      => WPGP_Security::sanitize_multiline_text($raw['exclude_patterns'] ?? $fallback['exclude_patterns']),
            'push_filter_profile' => self::sanitize_push_filter_profile($raw['push_filter_profile'] ?? $fallback['push_filter_profile']),
            'hmac_secret'        => sanitize_text_field($raw['hmac_secret'] ?? $fallback['hmac_secret']),
            'github_pat'         => sanitize_text_field($raw['github_pat'] ?? $fallback['github_pat']),
            'github_username'    => sanitize_text_field($raw['github_username'] ?? $fallback['github_username']),
            'last_job_id'        => sanitize_text_field($raw['last_job_id'] ?? $fallback['last_job_id']),
            'last_push_at'       => sanitize_text_field($raw['last_push_at'] ?? $fallback['last_push_at']),
            'last_pull_job_id'   => sanitize_text_field($raw['last_pull_job_id'] ?? $fallback['last_pull_job_id']),
            'last_pull_at'       => sanitize_text_field($raw['last_pull_at'] ?? $fallback['last_pull_at']),
        ];
    }

    public static function get(): array {
        $value = get_option(self::OPTION_KEY, []);
        if (!is_array($value)) {
            return self::defaults();
        }

        $merged = array_merge(self::defaults(), $value);
        // Older installs may lack this key entirely; treat as “never configured” and use defaults.
        if (!array_key_exists('exclude_patterns', $value)) {
            $merged['exclude_patterns'] = self::default_exclude_patterns();
        }
        if (!array_key_exists('include_patterns', $value)) {
            $merged['include_patterns'] = '';
        }
        if (!array_key_exists('sync_theme_slugs', $value)) {
            $merged['sync_theme_slugs'] = [];
        }
        if (!array_key_exists('remote_theme_slugs', $value)) {
            $merged['remote_theme_slugs'] = '';
        }
        if (!array_key_exists('push_filter_profile', $value)) {
            $merged['push_filter_profile'] = 'aligned';
        }
        if (!array_key_exists('theme_sync_scope', $value)) {
            $merged['theme_sync_scope'] = 'selected';
        }

        return $merged;
    }

    /**
     * Theme directory slugs to scan for push and to accept on pull.
     * Checkbox list (installed themes) plus optional remote-only slugs (themes on GitHub not yet in wp-content).
     * Empty checkbox list falls back to active stylesheet + parent template.
     *
     * @return string[]
     */
    /**
     * When true, push/pull include every theme directory under wp-content/themes (still subject to exclude patterns).
     */
    public static function is_full_themes_directory_scope(array $settings): bool {
        return 'all' === (string) ($settings['theme_sync_scope'] ?? 'selected');
    }

    public static function resolve_sync_theme_slugs(array $settings): array {
        $raw = $settings['sync_theme_slugs'] ?? [];
        if (!is_array($raw) || empty($raw)) {
            $base = self::legacy_default_theme_slugs();
        } else {
            $valid = self::validate_theme_slugs_against_wp($raw);
            $base  = !empty($valid) ? $valid : self::legacy_default_theme_slugs();
        }

        $remote = self::parse_remote_theme_slug_lines((string) ($settings['remote_theme_slugs'] ?? ''));

        return array_values(array_unique(array_merge($base, $remote)));
    }

    public static function update(array $new): void {
        $merged = array_merge(self::get(), $new);
        update_option(self::OPTION_KEY, self::sanitize($merged), false);
    }

    private static function defaults(): array {
        return [
            'backend_base_url' => '',
            'site_id'          => '',
            'project_id'       => '',
            'connection_id'    => '',
            'repo'             => '',
            'branch'             => 'main',
            'theme_sync_scope'   => 'selected',
            'sync_theme_slugs'   => [],
            'remote_theme_slugs' => '',
            'include_patterns'      => '',
            'exclude_patterns'      => self::default_exclude_patterns(),
            'push_filter_profile' => 'aligned',
            'hmac_secret'      => '',
            'github_pat'       => '',
            'github_username'  => '',
            'last_job_id'      => '',
            'last_push_at'     => '',
            'last_pull_job_id' => '',
            'last_pull_at'       => '',
        ];
    }

    /**
     * @param array $raw  Sanitize input (e.g. full POST for wpgp_settings).
     * @param array $fallback Merged existing + defaults.
     * @return string[]
     */
    private static function sanitize_sync_theme_slugs_field(array $raw, array $fallback): array {
        if (!empty($raw['_wpgp_theme_selection'])) {
            $posted = isset($raw['sync_theme_slugs']) && is_array($raw['sync_theme_slugs'])
                ? $raw['sync_theme_slugs']
                : [];
            $slugs = self::validate_theme_slugs_against_wp($posted);

            return !empty($slugs) ? $slugs : self::legacy_default_theme_slugs();
        }

        $existing = $raw['sync_theme_slugs'] ?? $fallback['sync_theme_slugs'] ?? [];

        return self::validate_theme_slugs_against_wp(is_array($existing) ? $existing : []);
    }

    /**
     * @return string[]
     */
    private static function legacy_default_theme_slugs(): array {
        if (!function_exists('get_stylesheet') || !function_exists('get_template')) {
            return [];
        }
        $stylesheet = get_stylesheet();
        $template   = get_template();
        $candidates   = $stylesheet === $template ? [$stylesheet] : [$stylesheet, $template];

        return self::validate_theme_slugs_against_wp($candidates);
    }

    /**
     * @param array $slugs Raw slug list.
     * @return string[]
     */
    private static function validate_theme_slugs_against_wp(array $slugs): array {
        if (!function_exists('wp_get_themes')) {
            return [];
        }
        $allowed = array_keys(wp_get_themes());
        $out     = [];
        foreach ($slugs as $slug) {
            $slug = sanitize_file_name((string) $slug);
            if ('' !== $slug && in_array($slug, $allowed, true)) {
                $out[] = $slug;
            }
        }

        return array_values(array_unique($out));
    }

    /**
     * @return string[]
     */
    public static function parse_remote_theme_slug_lines_public(string $raw): array {
        return self::parse_remote_theme_slug_lines($raw);
    }

    /**
     * Theme folder names that exist on GitHub but are not yet installed (not in the checkbox list).
     *
     * @return string[]
     */
    private static function parse_remote_theme_slug_lines(string $raw): array {
        $lines = preg_split('/\r\n|\r|\n/', $raw) ?: [];
        $out   = [];
        foreach ($lines as $line) {
            $line = trim((string) $line);
            if ('' === $line) {
                continue;
            }
            $slug = sanitize_file_name($line);
            if ('' === $slug || false !== strpos($slug, '/') || false !== strpos($slug, '\\')) {
                continue;
            }
            $out[] = $slug;
        }

        return array_values(array_unique($out));
    }

    private static function sanitize_remote_theme_slugs_text($value): string {
        return implode("\n", self::parse_remote_theme_slug_lines(is_string($value) ? $value : ''));
    }

    /**
     * Checkbox list POST (remote_theme_slugs_list[]) is the source of truth when present.
     * Falls back to textarea or existing option when no checkboxes are posted (all unchecked).
     */
    private static function sanitize_remote_theme_slugs_from_request(array $raw, array $fallback): string {
        if (isset($raw['remote_theme_slugs_list']) && is_array($raw['remote_theme_slugs_list'])) {
            $lines = [];
            foreach ($raw['remote_theme_slugs_list'] as $line) {
                $slug = sanitize_file_name((string) $line);
                if ('' === $slug || false !== strpos($slug, '/') || false !== strpos($slug, '\\')) {
                    continue;
                }
                $lines[] = $slug;
            }

            return implode("\n", array_values(array_unique($lines)));
        }

        return self::sanitize_remote_theme_slugs_text($raw['remote_theme_slugs'] ?? $fallback['remote_theme_slugs']);
    }

    /**
     * @param mixed $value Raw posted value.
     */
    private static function sanitize_push_filter_profile($value): string {
        $v = is_string($value) ? $value : '';
        return in_array($v, ['aligned', 'strict'], true) ? $v : 'aligned';
    }

    /**
     * @param mixed $value Raw posted value.
     */
    private static function sanitize_theme_sync_scope($value): string {
        $v = is_string($value) ? $value : '';
        return in_array($v, ['selected', 'all'], true) ? $v : 'selected';
    }
}


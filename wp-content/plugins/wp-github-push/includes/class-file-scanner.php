<?php

defined('ABSPATH') || exit;

final class WPGP_File_Scanner {
    private const MAX_FILE_SIZE_BYTES = 5242880;  // 5 MB per file
    private const MAX_PAYLOAD_BYTES   = 52428800; // 50 MB total

    private const ALLOWED_EXTENSIONS = [
        'php', 'css', 'js', 'jsx', 'ts', 'tsx',
        'html', 'htm', 'json', 'xml',
        'twig', 'mustache', 'phtml', 'tpl',
        'yml', 'yaml', 'sql',
        'pot', 'po', 'htaccess', 'env',
        'lock', 'conf', 'txt', 'md',
    ];

    private const SKIP_DIR_SEGMENTS = [
        'node_modules',
        'vendor',
        '.git',
        '.svn',
        'dist',
        'build',
        '.cache',
        '.tmp',
    ];

    private const SKIP_FILENAMES = [
        '.DS_Store',
        'Thumbs.db',
        'desktop.ini',
    ];

    /**
     * Build a manifest of user-editable files from configured theme directories.
     */
    public static function build_manifest(array $settings): array {
        $roots      = self::resolve_scan_roots($settings);
        $manifest   = [];
        $total_size = 0;
        $strict_push = self::is_strict_push_profile($settings);

        if (empty($roots)) {
            $msg = WPGP_Settings::is_full_themes_directory_scope($settings)
                ? __('The themes directory was not found or is not readable.', 'wp-github-push')
                : __('No valid theme folders are configured for sync. Choose at least one installed theme.', 'wp-github-push');

            return [
                'error'    => new WP_Error('wpgp_no_theme_roots', $msg),
                'manifest' => [],
            ];
        }

        foreach ($roots as $root) {
            // Single-file plugin (e.g. plugins/hello.php)
            if (is_file($root)) {
                $file_info = new SplFileInfo($root);
                $result    = self::process_file($file_info, $settings, $total_size, $strict_push);
                if (null === $result) {
                    continue;
                }
                if (is_wp_error($result)) {
                    return ['error' => $result, 'manifest' => []];
                }
                $total_size += $result['size'];
                $manifest[]  = $result;
                continue;
            }

            if (!is_dir($root)) {
                continue;
            }

            $iterator = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($root, FilesystemIterator::SKIP_DOTS)
            );

            foreach ($iterator as $file_info) {
                if (!$file_info instanceof SplFileInfo || !$file_info->isFile()) {
                    continue;
                }

                $result = self::process_file($file_info, $settings, $total_size, $strict_push);
                if (null === $result) {
                    continue;
                }
                if (is_wp_error($result)) {
                    return ['error' => $result, 'manifest' => []];
                }
                $total_size += $result['size'];
                $manifest[]  = $result;
            }
        }

        usort($manifest, static function (array $a, array $b): int {
            return strcmp((string) ($a['relativePath'] ?? ''), (string) ($b['relativePath'] ?? ''));
        });

        return ['manifest' => $manifest, 'error' => null];
    }

    /**
     * Whether push uses legacy strict filtering (extensions, minified, include patterns) vs pull-aligned rules.
     */
    public static function is_strict_push_profile(array $settings): bool {
        return 'strict' === (string) ($settings['push_filter_profile'] ?? 'aligned');
    }

    /**
     * Path is under themes/{slug}/ for at least one synced theme slug, or any theme folder when scope is “all”.
     */
    public static function path_under_synced_themes(string $relative_path, array $settings): bool {
        if (WPGP_Settings::is_full_themes_directory_scope($settings)) {
            return 1 === preg_match('#^themes/[^/]+/#', $relative_path);
        }

        foreach (WPGP_Settings::resolve_sync_theme_slugs($settings) as $slug) {
            $prefix = 'themes/' . $slug . '/';
            if (0 === strpos($relative_path, $prefix)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Matches one of the configured exclude patterns (wp-content-relative fnmatch lines).
     */
    public static function path_excluded_by_patterns(string $relative_path, array $settings): bool {
        $exclude = self::parse_user_patterns((string) ($settings['exclude_patterns'] ?? ''));
        foreach ($exclude as $pattern) {
            if (fnmatch($pattern, $relative_path)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Same path rules as pull: under a synced theme and not excluded by exclude_patterns.
     */
    public static function path_eligible_pull_style(string $relative_path, array $settings): bool {
        return self::path_under_synced_themes($relative_path, $settings)
            && !self::path_excluded_by_patterns($relative_path, $settings);
    }

    // ------------------------------------------------------------------
    // Resolve which directories to scan
    // ------------------------------------------------------------------

    private static function resolve_scan_roots(array $settings): array {
        $content_dir = trailingslashit(WP_CONTENT_DIR);

        if (WPGP_Settings::is_full_themes_directory_scope($settings)) {
            $themes_root = $content_dir . 'themes';
            if (is_dir($themes_root)) {
                return [$themes_root];
            }

            return [];
        }

        $roots = [];
        $slugs = WPGP_Settings::resolve_sync_theme_slugs($settings);

        foreach ($slugs as $slug) {
            $path = $content_dir . 'themes/' . $slug;
            if (is_dir($path)) {
                $roots[] = $path;
            }
        }

        return array_values(array_unique($roots));
    }

    // ------------------------------------------------------------------
    // Filtering logic
    // ------------------------------------------------------------------

    private static function should_skip_junk_filename(string $basename): bool {
        return in_array($basename, self::SKIP_FILENAMES, true);
    }

    private static function should_skip(
        string $relative_path,
        SplFileInfo $file_info,
        array $include_patterns,
        array $exclude_patterns
    ): bool {
        $basename = $file_info->getBasename();

        if (self::should_skip_junk_filename($basename)) {
            return true;
        }

        // Extension allowlist — reject anything not in the list
        $ext = strtolower($file_info->getExtension());
        if ('' !== $ext && !in_array($ext, self::ALLOWED_EXTENSIONS, true)) {
            return true;
        }
        // Files with no extension that aren't named specifically (e.g. LICENSE, Makefile) — skip
        if ('' === $ext) {
            return true;
        }

        // Skip minified / compiled files by name
        if (self::is_minified($basename)) {
            return true;
        }

        // Skip files inside blacklisted directory segments
        if (self::in_skipped_directory($relative_path)) {
            return true;
        }

        // Optional include whitelist (fnmatch); when set, path must match at least one line
        if (!empty($include_patterns) && !self::path_matches_any_pattern($relative_path, $include_patterns)) {
            return true;
        }

        // User-configured exclude patterns
        foreach ($exclude_patterns as $pattern) {
            if (fnmatch($pattern, $relative_path)) {
                return true;
            }
        }

        return false;
    }

    private static function path_matches_any_pattern(string $relative_path, array $patterns): bool {
        foreach ($patterns as $pattern) {
            if (fnmatch($pattern, $relative_path)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Strict-push include/exclude only (no extension or minified rules). Ignored when push profile is "aligned".
     */
    public static function path_passes_include_exclude(string $relative_path, array $settings): bool {
        $include = self::parse_user_patterns((string) ($settings['include_patterns'] ?? ''));
        $exclude = self::parse_user_patterns((string) ($settings['exclude_patterns'] ?? ''));

        if (!empty($include) && !self::path_matches_any_pattern($relative_path, $include)) {
            return false;
        }

        foreach ($exclude as $pattern) {
            if (fnmatch($pattern, $relative_path)) {
                return false;
            }
        }

        return true;
    }

    private static function is_minified(string $basename): bool {
        $lower   = strtolower($basename);
        $suffixes = ['.min.js', '.min.css', '.bundle.js', '.bundle.css', '.min.map', '.js.map', '.css.map'];
        foreach ($suffixes as $suffix) {
            if (substr($lower, -strlen($suffix)) === $suffix) {
                return true;
            }
        }
        return false;
    }

    private static function in_skipped_directory(string $relative_path): bool {
        $segments = explode('/', $relative_path);
        array_pop($segments); // remove filename
        foreach ($segments as $segment) {
            if (in_array($segment, self::SKIP_DIR_SEGMENTS, true)) {
                return true;
            }
        }
        return false;
    }

    // ------------------------------------------------------------------
    // File processing
    // ------------------------------------------------------------------

    /**
     * Process a single file: filter it, read content, return manifest entry.
     *
     * @return array|WP_Error|null  Manifest entry, WP_Error if payload limit hit, null to skip.
     */
    private static function process_file(
        SplFileInfo $file_info,
        array $settings,
        int $running_total,
        bool $strict_push
    ) {
        $absolute_path = $file_info->getPathname();
        $relative_path = self::to_relative_path($absolute_path);

        if ($strict_push) {
            $include_patterns = self::parse_user_patterns((string) ($settings['include_patterns'] ?? ''));
            $exclude_patterns = self::parse_user_patterns((string) ($settings['exclude_patterns'] ?? ''));
            if (self::should_skip($relative_path, $file_info, $include_patterns, $exclude_patterns)) {
                return null;
            }
        } elseif (!self::path_eligible_pull_style($relative_path, $settings)) {
            return null;
        }

        $size = (int) $file_info->getSize();
        if ($size <= 0 || $size > self::MAX_FILE_SIZE_BYTES) {
            return null;
        }

        $content = file_get_contents($absolute_path);
        if (false === $content) {
            return null;
        }

        if (($running_total + $size) > self::MAX_PAYLOAD_BYTES) {
            return new WP_Error(
                'wpgp_payload_too_large',
                __('Total payload exceeded maximum allowed size.', 'wp-github-push')
            );
        }

        return [
            'relativePath'  => $relative_path,
            'sha256'        => hash('sha256', $content),
            'size'          => $size,
            'modifiedAt'    => gmdate('c', (int) $file_info->getMTime()),
            'contentBase64' => base64_encode($content),
        ];
    }

    // ------------------------------------------------------------------
    // Helpers
    // ------------------------------------------------------------------

    private static function to_relative_path(string $absolute_path): string {
        $wp_content = trailingslashit(WP_CONTENT_DIR);
        $relative   = str_replace($wp_content, '', wp_normalize_path($absolute_path));
        return ltrim($relative, '/');
    }

    public static function parse_user_patterns_public(string $raw): array {
        return self::parse_user_patterns($raw);
    }

    private static function parse_user_patterns(string $raw): array {
        $lines = preg_split('/\r\n|\r|\n/', $raw) ?: [];
        $lines = array_map('trim', $lines);
        return array_values(array_filter($lines, static fn ($line) => '' !== $line));
    }
}

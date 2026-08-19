<?php

if (! function_exists('vite_asset')) {
    /**
     * Return the hashed Vite build URL for a named JavaScript entry.
     * Falls back to the original source file when no build exists yet.
     */
    function vite_asset(string $entry): string
    {
        static $manifest;

        $source = 'assets/custom/' . $entry . '.js';
        $manifestPath = FCPATH . 'build/.vite/manifest.json';

        if ($manifest === null) {
            $manifest = [];

            if (is_file($manifestPath)) {
                $decoded = json_decode((string) file_get_contents($manifestPath), true);
                if (is_array($decoded)) {
                    $manifest = $decoded;
                }
            }
        }

        foreach ($manifest as $item) {
            if (($item['name'] ?? null) === $entry && ! empty($item['file'])) {
                return base_url('build/' . $item['file']);
            }
        }

        $fallbackPath = FCPATH . $source;
        $version = is_file($fallbackPath) ? '?v=' . filemtime($fallbackPath) : '';

        return base_url($source) . $version;
    }
}

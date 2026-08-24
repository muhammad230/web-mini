<?php

namespace App\Helpers;

use App\Models\SiteContent;
use Illuminate\Support\Facades\Cache;

class SiteContentHelper
{
    public static function get(string $section, ?array $default = null): array
    {
        return Cache::remember("site_content_{$section}", now()->addMinutes(5), function () use ($section, $default) {
            $record = SiteContent::where('section', $section)->first();
            if ($record) {
                return $record->content;
            }
            return $default ?? [];
        });
    }

    /**
     * Resolve a CMS image path to a URL, falling back to a bundled asset
     * when the file does not exist on disk (e.g. missing storage symlink,
     * or uploads not present on an ephemeral deploy).
     */
    public static function imageUrl(?string $path, string $fallback = 'images/slider.png'): string
    {
        $path = trim((string) $path);

        if ($path === '' || preg_match('#^(https?:)?//#i', $path)) {
            return asset($path !== '' ? $path : $fallback);
        }

        $relative = preg_replace('#^/?storage/#', '', $path);

        if (is_file(public_path($path)) || is_file(storage_path('app/public/' . $relative))) {
            return asset($path);
        }

        return asset($fallback);
    }

    public static function flush(string $section): void
    {
        Cache::forget("site_content_{$section}");
    }

    public static function flushAll(): void
    {
        $sections = ['hero', 'stats_bar', 'browse_trades', 'how_it_works',
                      'featured_pros', 'testimonials', 'cta_banner',
                      'footer', 'navigation'];
        foreach ($sections as $section) {
            Cache::forget("site_content_{$section}");
        }
    }
}

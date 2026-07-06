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

<?php

use App\Helpers\SiteContentHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $record = DB::table('site_content')->where('section', 'hero')->first();
        if ($record && $record->content) {
            $content = json_decode($record->content, true);
            if (is_array($content) && isset($content['subheading'])) {
                $content['subheading'] = str_replace('vvvv', '', $content['subheading']);
                DB::table('site_content')
                    ->where('section', 'hero')
                    ->update(['content' => json_encode($content)]);

                SiteContentHelper::flush('hero');
            }
        }
    }

    public function down(): void
    {
        // No sensible rollback — data fix only
    }
};

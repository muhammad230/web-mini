<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SiteContent;
use App\Http\Controllers\Admin\SiteContentController;
use App\Models\User;

class SiteContentSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();

        foreach (SiteContentController::DEFAULTS as $section => $content) {
            SiteContent::updateOrCreate(
                ['section' => $section],
                [
                    'content' => $content,
                    'last_updated_by' => $admin?->id,
                ]
            );
        }

        $this->command->info('Default site content seeded successfully.');
    }
}

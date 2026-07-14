<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Creates or resets the admin account.
 * Safe to run multiple times — uses updateOrCreate so it never duplicates.
 *
 * Usage:
 *   php artisan db:seed --class=AdminSeeder
 */
class AdminSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->updateOrInsert(
            ['email' => 'admin@fixly.com'],
            [
                'name'                => 'Muhammad Ali',
                'email'               => 'admin@fixly.com',
                'password'            => Hash::make('password123'),
                'phone'               => '+1234567890',
                'role'                => 'admin',
                'verification_status' => 'verified',
                'available'           => 1,
                'created_at'          => now(),
                'updated_at'          => now(),
            ]
        );

        $this->command->info('Admin account ready: admin@fixly.com / password123');
    }
}

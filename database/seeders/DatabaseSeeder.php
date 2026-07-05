<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        User::factory()->create([
            'name' => 'Zain Admin',
            'email' => 'admin@fixit.com',
            'password' => Hash::make('password123'),
            'phone' => '+1234567890',
            'role' => 'admin',
            'verification_status' => 'verified',
        ]);

        // Create Test Customer
        User::factory()->create([
            'name' => 'Ali Hassan',
            'email' => 'customer@fixit.com',
            'password' => Hash::make('password123'),
            'phone' => '+1234567891',
            'role' => 'customer',
            'verification_status' => 'verified',
        ]);

        // Create Test Professional (Verified)
        User::factory()->create([
            'name' => 'Muhammad Jamil',
            'email' => 'pro@fixit.com',
            'password' => Hash::make('password123'),
            'phone' => '+1234567892',
            'role' => 'professional',
            'trade' => 'Plumbing',
            'location' => 'Karachi',
            'verification_status' => 'verified',
        ]);

        // Create a pending professional for testing approvals
        User::factory()->create([
            'name' => 'Sarah Ahmed',
            'email' => 'sarah@fixit.com',
            'password' => Hash::make('password123'),
            'phone' => '+1234567893',
            'role' => 'professional',
            'trade' => 'Electrical',
            'location' => 'Karachi',
            'verification_status' => 'pending',
        ]);

        // Create some random users
        User::factory(5)->create();
    }
}

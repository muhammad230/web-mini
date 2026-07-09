<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // ── Users ──────────────────────────────────────────────────
        $admin = User::factory()->create([
            'name'                => 'Zain Admin',
            'email'               => 'admin@fixit.com',
            'password'            => Hash::make('password333'),
            'phone'               => '+1234567890',
            'role'                => 'admin',
            'verification_status' => 'verified',
        ]);

        $customer = User::factory()->create([
            'name'                => 'Ali Hassan',
            'email'               => 'customer@fixit.com',
            'password'            => Hash::make('password123'),
            'phone'               => '+1234567891',
            'role'                => 'customer',
            'verification_status' => 'verified',
        ]);

        $pro1 = User::factory()->create([
            'name'                => 'Muhammad Jamil',
            'email'               => 'pro@fixit.com',
            'password'            => Hash::make('password123'),
            'phone'               => '+1234567892',
            'role'                => 'professional',
            'trade'               => 'Plumbing',
            'location'            => 'Karachi',
            'verification_status' => 'verified',
            'available'           => true,
            'bio'                 => 'Licensed plumber with 8+ years of experience in residential and commercial plumbing.',
            'years_experience'    => 8,
            'starting_price'      => 800,
        ]);

        $pro2 = User::factory()->create([
            'name'                => 'Sarah Ahmed',
            'email'               => 'sarah@fixit.com',
            'password'            => Hash::make('password123'),
            'phone'               => '+1234567893',
            'role'                => 'professional',
            'trade'               => 'Electrical',
            'location'            => 'Karachi',
            'verification_status' => 'pending',
        ]);

        User::factory(5)->create();

        // ── Open jobs (pending_match) ──────────────────────────────
        $openJobs = [
            ['customer_id' => $customer->id, 'trade_category' => 'Plumbing',   'description' => 'Leaking pipe under kitchen sink.', 'location' => 'DHA Phase 6, Karachi',     'budget_min' => 800,  'budget_max' => 1500],
            ['customer_id' => $customer->id, 'trade_category' => 'Plumbing',   'description' => 'Bathroom tap replacement needed.',  'location' => 'Clifton Block 3, Karachi', 'budget_min' => 500,  'budget_max' => 1000],
            ['customer_id' => $customer->id, 'trade_category' => 'Plumbing',   'description' => 'Hot water heater installation.',     'location' => 'Gulshan-e-Maymar, Karachi','budget_min' => 1200, 'budget_max' => 2500],
            ['customer_id' => $customer->id, 'trade_category' => 'Electrical', 'description' => 'Ceiling fan installation x2.',       'location' => 'DHA Phase 6, Karachi',     'budget_min' => 1000, 'budget_max' => 1800],
        ];
        $now = now();
        foreach ($openJobs as $job) {
            DB::table('customer_jobs')->insert(array_merge($job, [
                'budget_type' => 'fixed',
                'schedule'    => $now->addDays(rand(1,7))->toDateTimeString(),
                'status'      => 'pending_match',
                'created_at'  => $now->subHours(rand(1, 48)),
                'updated_at'  => $now,
            ]));
        }

        // ── Active jobs assigned to pro1 ───────────────────────────
        $scheduledJobId = DB::table('customer_jobs')->insertGetId([
            'customer_id'     => $customer->id,
            'assigned_pro_id' => $pro1->id,
            'trade_category'  => 'Plumbing',
            'description'     => 'Kitchen pipe burst repair.',
            'location'        => 'DHA Phase 6, Karachi',
            'budget_type'     => 'fixed',
            'budget_min'      => 1000,
            'budget_max'      => 1500,
            'schedule'        => now()->addDay()->format('Y-m-d H:i:s'),
            'status'          => 'scheduled',
            'created_at'      => now()->subDays(2),
            'updated_at'      => now(),
        ]);
        $inProgressJobId = DB::table('customer_jobs')->insertGetId([
            'customer_id'     => $customer->id,
            'assigned_pro_id' => $pro1->id,
            'trade_category'  => 'Plumbing',
            'description'     => 'Bathroom tap replacement.',
            'location'        => 'Clifton Block 3, Karachi',
            'budget_type'     => 'fixed',
            'budget_min'      => 800,
            'budget_max'      => 1200,
            'schedule'        => now()->format('Y-m-d H:i:s'),
            'status'          => 'in_progress',
            'created_at'      => now()->subDays(1),
            'updated_at'      => now(),
        ]);

        // Accepted quotes for active jobs
        DB::table('quotes')->insert([
            ['job_id' => $scheduledJobId,  'pro_id' => $pro1->id, 'amount' => 1200, 'status' => 'accepted', 'created_at' => now(), 'updated_at' => now()],
            ['job_id' => $inProgressJobId, 'pro_id' => $pro1->id, 'amount' => 1000, 'status' => 'accepted', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // ── Completed jobs with quotes + reviews ───────────────────
        $completedJob1 = DB::table('customer_jobs')->insertGetId([
            'customer_id'     => $customer->id,
            'assigned_pro_id' => $pro1->id,
            'trade_category'  => 'Plumbing',
            'description'     => 'Hot water geyser repair.',
            'location'        => 'DHA Phase 6, Karachi',
            'budget_type'     => 'fixed',
            'budget_min'      => 1000,
            'budget_max'      => 1500,
            'schedule'        => now()->subDays(5)->format('Y-m-d H:i:s'),
            'status'          => 'completed',
            'completed_at'    => now()->subDays(4),
            'created_at'      => now()->subDays(7),
            'updated_at'      => now()->subDays(4),
        ]);
        $completedJob2 = DB::table('customer_jobs')->insertGetId([
            'customer_id'     => $customer->id,
            'assigned_pro_id' => $pro1->id,
            'trade_category'  => 'Plumbing',
            'description'     => 'Tap fixing in bathroom.',
            'location'        => 'Clifton Block 3, Karachi',
            'budget_type'     => 'fixed',
            'budget_min'      => 700,
            'budget_max'      => 1000,
            'schedule'        => now()->subDays(10)->format('Y-m-d H:i:s'),
            'status'          => 'completed',
            'completed_at'    => now()->subDays(9),
            'created_at'      => now()->subDays(12),
            'updated_at'      => now()->subDays(9),
        ]);

        // Accepted quotes for completed jobs
        DB::table('quotes')->insert([
            ['job_id' => $completedJob1, 'pro_id' => $pro1->id, 'amount' => 1200, 'status' => 'accepted', 'created_at' => now(), 'updated_at' => now()],
            ['job_id' => $completedJob2, 'pro_id' => $pro1->id, 'amount' => 800,  'status' => 'accepted', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Reviews for completed jobs
        DB::table('reviews')->insert([
            ['job_id' => $completedJob1, 'customer_id' => $customer->id, 'pro_id' => $pro1->id, 'rating' => 5, 'comment' => 'Muhammad fixed our leaking pipe quickly and professionally. Great service!', 'created_at' => now()->subDays(4), 'updated_at' => now()->subDays(4)],
            ['job_id' => $completedJob2, 'customer_id' => $customer->id, 'pro_id' => $pro1->id, 'rating' => 4, 'comment' => 'Good work, arrived on time.',                                            'created_at' => now()->subDays(9), 'updated_at' => now()->subDays(9)],
        ]);

        // Update pro1 total_earnings and avg_rating
        $pro1->total_earnings = 2000;
        $pro1->avg_rating     = 4.50;
        $pro1->save();

        // ── Website content ────────────────────────────────────────
        $this->call(SiteContentSeeder::class);
    }
}

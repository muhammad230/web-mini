<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use App\Models\Conversation;
use App\Models\CustomerJob;
use App\Models\Message;
use App\Models\Notification;
use App\Models\Payment;
use App\Models\PayoutRequest;
use App\Models\Quote;
use App\Models\Review;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SystemAuditTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
        Storage::fake('local');
    }

    // ── 1. PUBLIC WEBSITE AUDIT ───────────────────────────────────────
    public function test_public_pages_load_successfully()
    {
        $pages = [
            '/',
            '/contact',
            '/about',
            '/careers',
            '/press',
            '/resources',
            '/privacy',
            '/terms',
            '/professionals/why-join',
            '/auth/login',
            '/auth/register',
            '/auth/forgot-password',
        ];

        foreach ($pages as $url) {
            $response = $this->get($url);
            $response->assertStatus(200);
        }
    }

    public function test_contact_form_submission_creates_message()
    {
        $response = $this->post(route('contact.submit'), [
            'name'    => 'Audit User',
            'email'   => 'audit@example.com',
            'subject' => 'General Inquiry',
            'message' => 'This is an audit test message.',
        ]);

        $response->assertRedirect(route('contact'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('contact_messages', [
            'email'   => 'audit@example.com',
            'subject' => 'General Inquiry',
        ]);
    }

    public function test_hero_search_sets_session_and_redirects()
    {
        $response = $this->get('/job/search?trade=Plumbing&location=Karachi');
        $response->assertRedirect(route('register', ['role' => 'customer']));
        $this->assertEquals(['trade' => 'Plumbing', 'location' => 'Karachi'], session('pending_job'));
    }

    public function test_pending_job_redirects_customer_to_jobs_create()
    {
        $customer = User::factory()->create([
            'role' => 'customer',
            'verification_status' => 'verified',
        ]);

        $this->withSession(['pending_job' => ['trade' => 'Plumbing', 'location' => 'Karachi']])
            ->actingAs($customer)
            ->get(route('dashboard.customer'))
            ->assertRedirect(route('jobs.create', ['trade' => 'Plumbing', 'location' => 'Karachi']));
    }

    // ── 2. AUTHENTICATION & TEST ACCOUNTS ─────────────────────────────
    public function test_customer_can_login_and_access_dashboard()
    {
        $customer = User::factory()->create([
            'email'    => 'test_cust@fixit.com',
            'password' => Hash::make('password123'),
            'role'     => 'customer',
        ]);

        $response = $this->post(route('login.submit'), [
            'email'    => 'test_cust@fixit.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('dashboard.customer'));
        $this->assertAuthenticatedAs($customer);
    }

    public function test_verified_pro_can_login_and_access_dashboard()
    {
        $pro = User::factory()->create([
            'email'               => 'test_pro@fixly.com',
            'password'            => Hash::make('password123'),
            'role'                => 'professional',
            'verification_status' => 'verified',
            'trade'               => 'Plumbing',
        ]);

        $response = $this->post(route('login.submit'), [
            'email'    => 'test_pro@fixly.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('dashboard.professional'));
        $this->assertAuthenticatedAs($pro);
    }

    public function test_admin_can_login_and_access_admin_dashboard()
    {
        $admin = User::factory()->create([
            'email'    => 'test_admin@fixly.com',
            'password' => Hash::make('password1234'),
            'role'     => 'admin',
        ]);

        $response = $this->post(route('admin.login.submit'), [
            'email'    => 'test_admin@fixly.com',
            'password' => 'password1234',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($admin);
    }

    // ── 3. CUSTOMER DASHBOARD FLOWS ───────────────────────────────────
    public function test_customer_can_post_a_job()
    {
        $customer = User::factory()->create(['role' => 'customer']);

        $response = $this->actingAs($customer)->post(route('dashboard.customer.jobs.store'), [
            'trade_category' => 'Plumbing',
            'description'    => 'Fix water leak in bathroom',
            'location'       => 'Clifton, Karachi',
            'latitude'       => 24.8138,
            'longitude'      => 67.0300,
            'budget_type'    => 'fixed',
            'budget_min'     => 1000,
            'budget_max'     => 2000,
            'schedule'       => now()->addDays(2)->format('Y-m-d H:i:s'),
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('customer_jobs', [
            'customer_id'    => $customer->id,
            'trade_category' => 'Plumbing',
            'status'         => 'pending_match',
        ]);
    }

    private function createJob(array $attributes = []): CustomerJob
    {
        return CustomerJob::create(array_merge([
            'customer_id'    => 1,
            'trade_category' => 'Plumbing',
            'description'    => 'Test job description',
            'location'       => 'Karachi',
            'budget_type'    => 'fixed',
            'budget_min'     => 1000,
            'budget_max'     => 2000,
            'schedule'       => now()->addDay()->format('Y-m-d H:i:s'),
            'status'         => 'pending_match',
        ], $attributes));
    }

    public function test_customer_can_delete_pending_job()
    {
        $customer = User::factory()->create(['role' => 'customer']);
        $job = $this->createJob([
            'customer_id' => $customer->id,
            'status'      => 'pending_match',
        ]);

        $response = $this->actingAs($customer)->delete(route('dashboard.customer.jobs.delete', $job));
        $response->assertRedirect(route('dashboard.customer'));
        $this->assertDatabaseMissing('customer_jobs', ['id' => $job->id]);
    }

    public function test_customer_cannot_delete_other_customer_job()
    {
        $customer1 = User::factory()->create(['role' => 'customer']);
        $customer2 = User::factory()->create(['role' => 'customer']);
        $job = $this->createJob([
            'customer_id' => $customer1->id,
            'status'      => 'pending_match',
        ]);

        $response = $this->actingAs($customer2)->delete(route('dashboard.customer.jobs.delete', $job));
        $response->assertStatus(403);
        $this->assertDatabaseHas('customer_jobs', ['id' => $job->id]);
    }

    public function test_customer_can_cancel_scheduled_job()
    {
        $customer = User::factory()->create(['role' => 'customer']);
        $pro = User::factory()->create(['role' => 'professional']);
        $job = $this->createJob([
            'customer_id'     => $customer->id,
            'assigned_pro_id' => $pro->id,
            'status'          => 'scheduled',
        ]);

        $response = $this->actingAs($customer)->post(route('dashboard.customer.jobs.cancel', $job));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('customer_jobs', [
            'id'     => $job->id,
            'status' => 'cancelled',
        ]);
    }

    public function test_customer_can_reschedule_job()
    {
        $customer = User::factory()->create(['role' => 'customer']);
        $pro = User::factory()->create(['role' => 'professional']);
        $job = $this->createJob([
            'customer_id'     => $customer->id,
            'assigned_pro_id' => $pro->id,
            'status'          => 'scheduled',
            'schedule'        => now()->addDay()->format('Y-m-d H:i:s'),
        ]);

        $newSchedule = now()->addDays(5)->format('Y-m-d H:i:s');
        $response = $this->actingAs($customer)->post(route('dashboard.customer.jobs.reschedule', $job), [
            'schedule' => $newSchedule,
        ]);

        $response->assertSessionHas('success');
        $this->assertEquals($newSchedule, $job->fresh()->schedule);
    }

    public function test_customer_can_accept_quote()
    {
        $customer = User::factory()->create(['role' => 'customer']);
        $pro1 = User::factory()->create(['role' => 'professional']);
        $pro2 = User::factory()->create(['role' => 'professional']);

        $job = $this->createJob([
            'customer_id' => $customer->id,
            'status'      => 'quotes_received',
        ]);

        $quote1 = Quote::create([
            'job_id'  => $job->id,
            'pro_id'  => $pro1->id,
            'amount'  => 1500,
            'status'  => 'pending',
        ]);

        $quote2 = Quote::create([
            'job_id'  => $job->id,
            'pro_id'  => $pro2->id,
            'amount'  => 1800,
            'status'  => 'pending',
        ]);

        $response = $this->actingAs($customer)->post(route('dashboard.customer.quotes.accept', $quote1));
        $response->assertSessionHas('success');

        $this->assertEquals('accepted', $quote1->fresh()->status);
        $this->assertEquals('rejected', $quote2->fresh()->status);
        $this->assertEquals('scheduled', $job->fresh()->status);
        $this->assertEquals($pro1->id, $job->fresh()->assigned_pro_id);
    }

    public function test_customer_can_submit_payment_for_completed_job()
    {
        $customer = User::factory()->create(['role' => 'customer']);
        $pro = User::factory()->create(['role' => 'professional']);

        $job = $this->createJob([
            'customer_id'     => $customer->id,
            'assigned_pro_id' => $pro->id,
            'status'          => 'completed',
        ]);

        Quote::create([
            'job_id' => $job->id,
            'pro_id' => $pro->id,
            'amount' => 2000,
            'status' => 'accepted',
        ]);

        $response = $this->actingAs($customer)->post(route('dashboard.customer.jobs.pay.submit', $job), [
            'payment_method'        => 'cash',
            'transaction_reference' => 'TXN-12345',
        ]);

        $response->assertRedirect(route('dashboard.customer'));
        $this->assertDatabaseHas('payments', [
            'job_id'         => $job->id,
            'amount'         => 2000,
            'status'         => 'pending',
            'payment_method' => 'cash',
        ]);
    }

    public function test_customer_can_leave_review_for_completed_job()
    {
        $customer = User::factory()->create(['role' => 'customer']);
        $pro = User::factory()->create(['role' => 'professional']);

        $job = $this->createJob([
            'customer_id'     => $customer->id,
            'assigned_pro_id' => $pro->id,
            'status'          => 'completed',
        ]);

        $response = $this->actingAs($customer)->post(route('dashboard.customer.jobs.review', $job), [
            'rating'  => 5,
            'comment' => 'Excellent work, very punctual!',
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('reviews', [
            'job_id'      => $job->id,
            'customer_id' => $customer->id,
            'pro_id'      => $pro->id,
            'rating'      => 5,
        ]);
    }

    // ── 4. PROFESSIONAL DASHBOARD FLOWS ───────────────────────────────
    public function test_multiple_pros_can_see_and_quote_same_lead()
    {
        $customer = User::factory()->create(['role' => 'customer']);
        $pro1 = User::factory()->create([
            'role'                => 'professional',
            'verification_status' => 'verified',
            'trade'               => 'Plumbing',
        ]);
        $pro2 = User::factory()->create([
            'role'                => 'professional',
            'verification_status' => 'verified',
            'trade'               => 'Plumbing',
        ]);

        $job = $this->createJob([
            'customer_id'    => $customer->id,
            'trade_category' => 'Plumbing',
            'status'         => 'pending_match',
        ]);

        // Pro 1 sends quote
        $this->actingAs($pro1)->post(route('dashboard.professional.leads.quote', $job->id), [
            'price'   => 1200,
            'message' => 'I can do it today',
        ])->assertSessionHas('success');

        // Pro 2 can also send quote for the same job
        $this->actingAs($pro2)->post(route('dashboard.professional.leads.quote', $job->id), [
            'price'   => 1100,
            'message' => 'Ready to start anytime',
        ])->assertSessionHas('success');

        $this->assertCount(2, Quote::where('job_id', $job->id)->get());
    }

    public function test_pro_can_start_and_complete_job()
    {
        $customer = User::factory()->create(['role' => 'customer']);
        $pro = User::factory()->create([
            'role'                => 'professional',
            'verification_status' => 'verified',
            'trade'               => 'Plumbing',
        ]);

        $job = $this->createJob([
            'customer_id'     => $customer->id,
            'assigned_pro_id' => $pro->id,
            'status'          => 'scheduled',
        ]);

        // Pro starts job
        $this->actingAs($pro)->post(route('dashboard.professional.jobs.start', $job->id))
            ->assertSessionHas('success');
        $this->assertEquals('in_progress', $job->fresh()->status);

        // Pro marks complete
        $this->actingAs($pro)->post(route('dashboard.professional.jobs.complete', $job->id))
            ->assertSessionHas('success');
        $this->assertEquals('completed', $job->fresh()->status);
    }

    public function test_pro_cannot_manage_another_pros_job()
    {
        $customer = User::factory()->create(['role' => 'customer']);
        $pro1 = User::factory()->create(['role' => 'professional', 'verification_status' => 'verified']);
        $pro2 = User::factory()->create(['role' => 'professional', 'verification_status' => 'verified']);

        $job = $this->createJob([
            'customer_id'     => $customer->id,
            'assigned_pro_id' => $pro1->id,
            'status'          => 'scheduled',
        ]);

        $this->actingAs($pro2)->post(route('dashboard.professional.jobs.start', $job->id));
        // Job status should NOT change because it belongs to pro1
        $this->assertEquals('scheduled', $job->fresh()->status);
    }

    // ── 5. ADMIN DASHBOARD FLOWS ──────────────────────────────────────
    public function test_admin_can_approve_and_reject_pro()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $pro = User::factory()->create([
            'role'                => 'professional',
            'verification_status' => 'pending',
        ]);

        $this->actingAs($admin)->post(route('admin.pro.approve', $pro->id))
            ->assertSessionHas('success');
        $this->assertEquals('verified', $pro->fresh()->verification_status);

        $this->actingAs($admin)->post(route('admin.pro.reject', $pro->id))
            ->assertSessionHas('success');
        $this->assertEquals('rejected', $pro->fresh()->verification_status);
    }

    public function test_admin_can_mark_payment_as_paid()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $customer = User::factory()->create(['role' => 'customer']);
        $pro = User::factory()->create(['role' => 'professional']);

        $job = $this->createJob([
            'customer_id'     => $customer->id,
            'assigned_pro_id' => $pro->id,
            'status'          => 'completed',
        ]);

        $payment = Payment::create([
            'job_id'                     => $job->id,
            'customer_id'                => $customer->id,
            'professional_id'            => $pro->id,
            'amount'                     => 2500,
            'platform_fee'               => 250,
            'professional_payout_amount' => 2250,
            'payment_method'             => 'cash',
            'status'                     => 'pending',
        ]);

        $this->actingAs($admin)->post(route('admin.payments.mark-paid', $payment))
            ->assertSessionHas('success');

        $this->assertEquals('paid', $payment->fresh()->status);
        $this->assertEquals(2500, $job->fresh()->amount_paid);
    }

    public function test_admin_settings_update_persists()
    {
        $admin = User::factory()->create([
            'name'  => 'Old Admin Name',
            'email' => 'old_admin@fixly.com',
            'role'  => 'admin',
        ]);

        $this->actingAs($admin)->post(route('admin.settings.update'), [
            'name'  => 'New Admin Name',
            'email' => 'new_admin@fixly.com',
        ])->assertRedirect(route('admin.settings'));

        $fresh = $admin->fresh();
        $this->assertEquals('New Admin Name', $fresh->name);
        $this->assertEquals('new_admin@fixly.com', $fresh->email);
    }

    // ── 6. SECURITY & ROLE MIDDLEWARE ─────────────────────────────────
    public function test_cross_role_access_is_blocked()
    {
        $customer = User::factory()->create(['role' => 'customer']);
        $pro = User::factory()->create(['role' => 'professional', 'verification_status' => 'verified']);

        // Customer cannot access Pro Dashboard
        $this->actingAs($customer)->get(route('dashboard.professional'))
            ->assertRedirect(route('home'));

        // Pro cannot access Customer Dashboard
        $this->actingAs($pro)->get(route('dashboard.customer'))
            ->assertRedirect(route('login'));

        // Customer cannot access Admin Dashboard
        $this->actingAs($customer)->get(route('admin.dashboard'))
            ->assertRedirect(route('home'));

        // Pro cannot access Admin Dashboard
        $this->actingAs($pro)->get(route('admin.dashboard'))
            ->assertRedirect(route('home'));
    }

    // ── 7. EMPTY STATES AUDIT ─────────────────────────────────────────
    public function test_brand_new_customer_empty_states_render_cleanly()
    {
        $customer = User::factory()->create(['role' => 'customer']);

        $response = $this->actingAs($customer)->get(route('dashboard.customer'));
        $response->assertStatus(200);
        $response->assertSee('No active jobs yet');
        $response->assertSee('No quotes received yet');
        $response->assertSee('No upcoming bookings');
        $response->assertSee('No saved pros yet');
    }

    public function test_brand_new_pro_empty_states_render_cleanly()
    {
        $pro = User::factory()->create([
            'role'                => 'professional',
            'verification_status' => 'verified',
            'trade'               => 'Plumbing',
            'location'            => 'Karachi',
        ]);

        $response = $this->actingAs($pro)->get(route('dashboard.professional'));
        $response->assertStatus(200);
        $response->assertSee('Welcome back');
    }
}

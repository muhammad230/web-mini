<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfessionalRegistrationTest extends TestCase
{
    use RefreshDatabase;

    private function professionalPayload(array $overrides = []): array
    {
        return array_merge([
            'role'              => 'professional',
            'name'              => 'Jane Pro',
            'email'             => 'jane@example.com',
            'phone'             => '+15550001111',
            'trade'             => 'Plumbing',
            'location'          => 'Karachi',
            'years_experience'  => 5,
            'password'          => 'password123',
            'password_confirmation' => 'password123',
        ], $overrides);
    }

    public function test_professional_signup_requires_trade_location_experience_id_document_and_phone(): void
    {
        $response = $this->from(route('register'))
            ->post(route('register.submit'), $this->professionalPayload([
                'trade'             => '',
                'location'          => '',
                'years_experience'  => '',
                'phone'             => '',
            ]));

        $response->assertSessionHasErrors([
            'trade',
            'location',
            'years_experience',
            'phone',
        ]);

        $this->assertDatabaseMissing('users', ['email' => 'jane@example.com']);
    }

    public function test_professional_signup_requires_id_document(): void
    {
        $response = $this->from(route('register'))
            ->post(route('register.submit'), $this->professionalPayload());

        $response->assertSessionHasErrors(['id_document']);

        $this->assertDatabaseMissing('users', ['email' => 'jane@example.com']);
    }

    public function test_professional_signup_stores_id_document_and_creates_pending_user(): void
    {
        Storage::fake('local');

        $png = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP8z8BQDwAEhQGAhKmMIQAAAABJRU5ErkJggg==');

        $response = $this->from(route('register'))
            ->post(route('register.submit'), $this->professionalPayload([
                'id_document' => UploadedFile::fake()->createWithContent('id.png', $png),
            ]));

        $response->assertRedirect(route('dashboard.professional'));

        $this->assertDatabaseHas('users', [
            'email'               => 'jane@example.com',
            'role'                => 'professional',
            'verification_status' => 'pending',
            'trade'               => 'Plumbing',
            'location'            => 'Karachi',
            'years_experience'    => 5,
        ]);

        $user = User::where('email', 'jane@example.com')->first();
        $this->assertNotNull($user->id_document_path);
        Storage::disk('local')->assertExists($user->id_document_path);
    }

    public function test_pending_professional_can_log_in_but_dashboard_is_blocked(): void
    {
        $user = User::factory()->create([
            'role'                => 'professional',
            'verification_status' => 'pending',
            'email'               => 'pending@example.com',
            'password'            => 'password123',
        ]);

        $this->post(route('login.submit'), [
            'email'    => 'pending@example.com',
            'password' => 'password123',
        ])->assertRedirect(route('welcome.pending'));

        $this->actingAs($user)
            ->get(route('dashboard.professional'))
            ->assertRedirect(route('welcome.pending'));
    }

    public function test_approved_professional_reaches_dashboard(): void
    {
        $user = User::factory()->create([
            'role'                => 'professional',
            'verification_status' => 'verified',
        ]);

        $this->actingAs($user)
            ->get(route('dashboard.professional'))
            ->assertOk();
    }

    public function test_customer_signup_is_unaffected(): void
    {
        $response = $this->from(route('register'))
            ->post(route('register.submit'), [
                'role'              => 'customer',
                'name'              => 'Jane Customer',
                'email'             => 'customer@example.com',
                'phone'             => '+15550002222',
                'password'          => 'password123',
                'password_confirmation' => 'password123',
            ]);

        $response->assertRedirect(route('dashboard.customer'));

        $this->assertDatabaseHas('users', [
            'email'               => 'customer@example.com',
            'role'                => 'customer',
            'verification_status' => 'verified',
        ]);
    }
}

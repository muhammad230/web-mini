<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TempAdminSettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_full_login_and_profile_update_flow(): void
    {
        $admin = User::factory()->create([
            'name' => 'Old Admin',
            'email' => 'admin-flow@fixly.com',
            'password' => 'password1234',
            'role' => 'admin',
        ]);

        $this->post('/admin/login', [
            'email' => 'admin-flow@fixly.com',
            'password' => 'password1234',
        ])->assertRedirect(route('admin.dashboard'));

        $this->get('/admin/settings')->assertOk();

        $this->post('/admin/settings', [
            'name' => 'New Admin',
            'email' => 'admin-flow-new@fixly.com',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ])->assertRedirect(route('admin.settings'));

        $this->assertSame('New Admin', $admin->fresh()->name);
        $this->assertSame('admin-flow-new@fixly.com', $admin->fresh()->email);
        $this->assertTrue(\Hash::check('newpassword123', $admin->fresh()->password));
    }
}

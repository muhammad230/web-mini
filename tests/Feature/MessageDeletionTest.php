<?php

namespace Tests\Feature;

use App\Models\Conversation;
use App\Models\CustomerJob;
use App\Models\Message;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MessageDeletionTest extends TestCase
{
    use RefreshDatabase;

    private User $customer;
    private User $pro;
    private CustomerJob $job;
    private Conversation $conversation;

    protected function setUp(): void
    {
        parent::setUp();

        $this->customer = User::create([
            'name' => 'Customer', 'email' => 'cust@example.com', 'phone' => '111',
            'password' => 'password', 'role' => 'customer',
        ]);
        $this->pro = User::create([
            'name' => 'Pro', 'email' => 'pro@example.com', 'phone' => '222',
            'password' => 'password', 'role' => 'professional',
        ]);

        $this->job = CustomerJob::create([
            'customer_id' => $this->customer->id,
            'trade_category' => 'Plumbing',
            'description' => 'Fix leak',
            'location' => 'Test City',
            'schedule' => 'Anytime',
            'status' => 'open',
        ]);

        $this->conversation = Conversation::create([
            'job_id' => $this->job->id,
            'customer_id' => $this->customer->id,
            'professional_id' => $this->pro->id,
        ]);
    }

    private function sendMessage(string $text, User $sender, string $role): Message
    {
        return Message::create([
            'conversation_id' => $this->conversation->id,
            'sender_id' => $sender->id,
            'sender_role' => $role,
            'message_text' => $text,
            'is_read' => false,
        ]);
    }

    private function deleteMessage(int $messageId, User $user, string $mode)
    {
        return $this->actingAs($user)->postJson("/messages/{$messageId}/delete", ['mode' => $mode]);
    }

    public function test_delete_for_me_hides_only_from_sender(): void
    {
        $msg = $this->sendMessage('hello', $this->customer, 'customer');

        $this->deleteMessage($msg->id, $this->customer, 'me')->assertOk();

        $msg->refresh();
        $this->assertTrue($msg->deleted_for_sender);
        $this->assertFalse($msg->deleted_for_everyone);

        // Sender no longer sees it on history load
        $response = $this->actingAs($this->customer)
            ->getJson("/messages/api/{$this->conversation->id}/messages");
        $response->assertOk();
        $ids = collect($response->json())->pluck('id')->all();
        $this->assertNotContains($msg->id, $ids);

        // Recipient still sees the original text
        $response = $this->actingAs($this->pro)
            ->getJson("/messages/api/{$this->conversation->id}/messages");
        $this->assertContains($msg->id, collect($response->json())->pluck('id')->all());
        $message = collect($response->json())->firstWhere('id', $msg->id);
        $this->assertSame('hello', $message['message_text']);
    }

    public function test_delete_for_everyone_shows_placeholder_to_both_and_in_real_time_data(): void
    {
        $msg = $this->sendMessage('secret', $this->customer, 'customer');

        $this->deleteMessage($msg->id, $this->customer, 'everyone')->assertOk();

        $msg->refresh();
        $this->assertTrue($msg->deleted_for_everyone);

        foreach ([$this->customer, $this->pro] as $user) {
            $response = $this->actingAs($user)
                ->getJson("/messages/api/{$this->conversation->id}/messages");
            $message = collect($response->json())->firstWhere('id', $msg->id);
            $this->assertSame('This message was deleted', $message['message_text']);
        }
    }

    public function test_delete_for_everyone_rejected_after_window(): void
    {
        $msg = $this->sendMessage('stale', $this->customer, 'customer');
        $msg->forceFill(['created_at' => now()->subMinutes(11)])->save();

        $this->deleteMessage($msg->id, $this->customer, 'everyone')
            ->assertStatus(422);

        $msg->refresh();
        $this->assertFalse($msg->deleted_for_everyone);
    }

    public function test_delete_for_everyone_not_allowed_for_non_sender(): void
    {
        $msg = $this->sendMessage('mine', $this->customer, 'customer');

        $this->deleteMessage($msg->id, $this->pro, 'everyone')->assertStatus(403);

        $msg->refresh();
        $this->assertFalse($msg->deleted_for_everyone);
    }

    public function test_recipient_can_delete_for_me_only(): void
    {
        $msg = $this->sendMessage('from pro', $this->pro, 'professional');

        $this->deleteMessage($msg->id, $this->customer, 'me')->assertOk();

        $msg->refresh();
        $this->assertTrue($msg->deleted_for_recipient);

        // Recipient (customer) no longer sees it
        $response = $this->actingAs($this->customer)
            ->getJson("/messages/api/{$this->conversation->id}/messages");
        $this->assertNotContains($msg->id, collect($response->json())->pluck('id')->all());

        // Sender (pro) still sees the original text
        $response = $this->actingAs($this->pro)
            ->getJson("/messages/api/{$this->conversation->id}/messages");
        $message = collect($response->json())->firstWhere('id', $msg->id);
        $this->assertSame('from pro', $message['message_text']);
    }

    public function test_created_at_uses_utc_zoned_timestamp_so_frontend_window_math_is_correct(): void
    {
        $msg = $this->sendMessage('fresh', $this->customer, 'customer');

        $response = $this->actingAs($this->customer)
            ->getJson("/messages/api/{$this->conversation->id}/messages");
        $response->assertOk();

        $message = collect($response->json())->firstWhere('id', $msg->id);
        $createdAt = $message['created_at'];

        // Must carry an explicit UTC timezone marker so the browser math is zone-independent
        $this->assertMatchesRegularExpression('/Z$|[+-]\d{2}:?\d{2}$/', $createdAt);

        // A just-sent message must appear ~0 minutes old, well inside the 10-minute window
        $ageMinutes = \Illuminate\Support\Carbon::now()->diffInMinutes(\Illuminate\Support\Carbon::parse($createdAt), false);
        $this->assertLessThanOrEqual(1, $ageMinutes);
    }

    public function test_customer_job_detail_page_shows_placeholder_after_delete_for_everyone(): void
    {
        $msg = $this->sendMessage('job page secret', $this->pro, 'professional');

        $this->deleteMessage($msg->id, $this->pro, 'everyone')->assertOk();

        $response = $this->actingAs($this->customer)
            ->get("/dashboard/customer/jobs/{$this->job->id}");
        $response->assertOk();
        $response->assertSee('This message was deleted');
        $response->assertDontSee('job page secret');
    }

    public function test_customer_job_detail_page_hides_recipient_delete_for_me(): void
    {
        $msg = $this->sendMessage('job page private', $this->pro, 'professional');

        $this->deleteMessage($msg->id, $this->customer, 'me')->assertOk();

        $response = $this->actingAs($this->customer)
            ->get("/dashboard/customer/jobs/{$this->job->id}");
        $response->assertOk();
        $response->assertDontSee('job page private');
    }

    public function test_admin_job_detail_page_shows_placeholder_after_delete_for_everyone(): void
    {
        $msg = $this->sendMessage('admin page secret', $this->pro, 'professional');

        $this->deleteMessage($msg->id, $this->pro, 'everyone')->assertOk();

        $admin = User::create([
            'name' => 'Admin', 'email' => 'admin@example.com', 'phone' => '333',
            'password' => 'password', 'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)
            ->get("/admin/jobs/{$this->job->id}");
        $response->assertOk();
        $response->assertSee('This message was deleted');
        $response->assertDontSee('admin page secret');
    }
}
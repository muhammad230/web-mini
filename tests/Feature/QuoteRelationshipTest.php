<?php

namespace Tests\Feature;

use App\Models\CustomerJob;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuoteRelationshipTest extends TestCase
{
    use RefreshDatabase;

    public function test_job_quotes_relationship_uses_the_job_id_foreign_key(): void
    {
        $customer = User::factory()->create();
        $professional = User::factory()->create();

        $job = CustomerJob::create([
            'customer_id' => $customer->id,
            'trade_category' => 'Plumbing',
            'description' => 'Repair a leaking pipe',
            'location' => '123 Main St',
            'budget_type' => 'fixed',
            'budget_min' => 50,
            'budget_max' => 150,
            'schedule' => 'ASAP',
            'status' => 'pending_match',
        ]);

        $acceptedQuote = Quote::create([
            'job_id' => $job->id,
            'pro_id' => $professional->id,
            'amount' => 100.00,
            'message' => 'I can help',
            'status' => 'pending',
        ]);

        $otherQuote = Quote::create([
            'job_id' => $job->id,
            'pro_id' => $professional->id,
            'amount' => 120.00,
            'message' => 'I can help too',
            'status' => 'pending',
        ]);

        $job->quotes()->where('id', '!=', $acceptedQuote->id)->update(['status' => 'rejected']);

        $this->assertSame('rejected', $otherQuote->fresh()->status);
    }
}

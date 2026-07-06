<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customer_jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('assigned_pro_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('trade_category'); // e.g. "Plumbing"
            $table->text('description');
            $table->string('location');
            $table->string('budget_type')->default('fixed'); // fixed, flexible
            $table->decimal('budget_min', 10, 2)->nullable();
            $table->decimal('budget_max', 10, 2)->nullable();
            $table->string('schedule'); // e.g. "ASAP", "2026-07-10 10:00"
            $table->string('status')->default('pending_match'); // pending_match, quotes_received, scheduled, in_progress, completed, cancelled
            $table->decimal('amount_paid', 10, 2)->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_jobs');
    }
};

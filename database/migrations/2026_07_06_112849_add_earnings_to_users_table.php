<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // First, add columns that might be missing (profile_photo, bio, years_experience, starting_price, available)
            if (!Schema::hasColumn('users', 'available')) {
                $table->boolean('available')->default(true)->after('verification_status');
            }
            if (!Schema::hasColumn('users', 'bio')) {
                $table->text('bio')->nullable()->after('available');
            }
            if (!Schema::hasColumn('users', 'years_experience')) {
                $table->integer('years_experience')->nullable()->after('bio');
            }
            if (!Schema::hasColumn('users', 'starting_price')) {
                $table->decimal('starting_price', 10, 2)->nullable()->after('years_experience');
            }
            if (!Schema::hasColumn('users', 'profile_photo')) {
                $table->string('profile_photo')->nullable()->after('starting_price');
            }
            
            // Now add the original columns
            if (!Schema::hasColumn('users', 'total_earnings')) {
                $table->decimal('total_earnings', 12, 2)->default(0)->after('profile_photo');
            }
            if (!Schema::hasColumn('users', 'service_area')) {
                $table->string('service_area')->nullable()->after('location');
            }
            if (!Schema::hasColumn('users', 'trades')) {
                $table->json('trades')->nullable()->after('trade');
            }
            if (!Schema::hasColumn('users', 'avg_rating')) {
                $table->decimal('avg_rating', 3, 2)->default(0)->after('total_earnings');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $columnsToDrop = array_filter([
                Schema::hasColumn('users', 'total_earnings') ? 'total_earnings' : null,
                Schema::hasColumn('users', 'service_area')   ? 'service_area'   : null,
                Schema::hasColumn('users', 'trades')         ? 'trades'         : null,
                Schema::hasColumn('users', 'avg_rating')     ? 'avg_rating'     : null,
                // Also drop the new columns we added in up()
                Schema::hasColumn('users', 'profile_photo')  ? 'profile_photo'  : null,
                Schema::hasColumn('users', 'starting_price') ? 'starting_price' : null,
                Schema::hasColumn('users', 'years_experience') ? 'years_experience' : null,
                Schema::hasColumn('users', 'bio')            ? 'bio'            : null,
                Schema::hasColumn('users', 'available')      ? 'available'      : null,
            ]);
            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }
};

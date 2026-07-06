<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
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
            $table->dropColumn(array_filter([
                Schema::hasColumn('users', 'total_earnings') ? 'total_earnings' : null,
                Schema::hasColumn('users', 'service_area')   ? 'service_area'   : null,
                Schema::hasColumn('users', 'trades')         ? 'trades'         : null,
                Schema::hasColumn('users', 'avg_rating')     ? 'avg_rating'     : null,
            ]));
        });
    }
};

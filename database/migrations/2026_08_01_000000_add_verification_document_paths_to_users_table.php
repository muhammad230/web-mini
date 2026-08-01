<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'id_document_path')) {
                $table->string('id_document_path')->nullable()->after('profile_photo');
            }
            if (!Schema::hasColumn('users', 'selfie_document_path')) {
                $table->string('selfie_document_path')->nullable()->after('id_document_path');
            }
            if (!Schema::hasColumn('users', 'certification_document_path')) {
                $table->string('certification_document_path')->nullable()->after('selfie_document_path');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            foreach (['id_document_path', 'selfie_document_path', 'certification_document_path'] as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};

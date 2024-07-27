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
        Schema::table('semestral_end', function (Blueprint $table) {
            if (!Schema::hasColumn('semestral_end', 'faculty_id')) {
                $table->foreignId('faculty_id')
                    ->nullable()
                    ->constrained('faculty_personal_details', 'faculty_account_id')
                    ->onDelete('cascade');
            }

            if (!Schema::hasColumn('semestral_end', 'admin_id')) {
                $table->foreignId('admin_id')
                    ->nullable()
                    ->constrained('admin_accounts')
                    ->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('semestral_end', function (Blueprint $table) {
            if (Schema::hasColumn('semestral_end', 'faculty_id')) {
                $table->dropForeign(['faculty_id']);
                $table->dropColumn('faculty_id');
            }

            if (Schema::hasColumn('semestral_end', 'admin_id')) {
                $table->dropForeign(['admin_id']);
                $table->dropColumn('admin_id');
            }
        });
    }
};

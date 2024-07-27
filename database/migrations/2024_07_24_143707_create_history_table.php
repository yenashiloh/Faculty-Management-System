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
        Schema::create('history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('faculty_id')
                ->nullable()
                ->constrained('faculty_personal_details', 'faculty_account_id')
                ->onDelete('cascade');

            $table->foreignId('admin_id')
                ->nullable()
                ->constrained('admin_accounts')
                ->onDelete('cascade');

            $table->string('action');
            $table->text('details');
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history');
    }
};
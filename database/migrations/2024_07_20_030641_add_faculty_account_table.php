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
        Schema::create('faculty_account', function (Blueprint $table) {
            $table->bigIncrements('faculty_account_id'); 
            $table->string('email')->unique();
            $table->string('password');
            $table->string('api_token', 80)->nullable()->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->boolean('verify_status')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faculty_account');
    }
};

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
        Schema::create('faculty_personal_details', function (Blueprint $table) {
            $table->id('id_personal_details'); 
            $table->unsignedBigInteger('faculty_account_id'); 
            $table->foreign('faculty_account_id')->references('faculty_account_id')->on('faculty_account')->onDelete('cascade'); 
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->date('birthday');
            $table->enum('sex', ['Male', 'Female']);
            $table->string('department');
            $table->string('id_number')->unique();
            $table->enum('employee_type', ['Part Time', 'Regular']);
            $table->string('phone_number');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faculty_personal_details');
    }
};

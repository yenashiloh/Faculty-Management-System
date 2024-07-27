<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('storage_quota', function (Blueprint $table) {
            $table->id();
            $table->foreignId('faculty_id')
                ->constrained('faculty_personal_details', 'faculty_account_id') 
                ->onDelete('cascade');
            $table->bigInteger('total_quota')->default(100 * 1024 * 1024 * 1024); 
            $table->bigInteger('used_quota')->default(0);
            $table->bigInteger('remaining_quota')->default(100 * 1024 * 1024 * 1024); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('storage_quota');
    }
};

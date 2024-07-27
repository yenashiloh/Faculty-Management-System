<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateYearSemestralFoldersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('year_semestral_folders', function (Blueprint $table) {
            $table->id('year_semestral_folders_id');
            $table->unsignedBigInteger('semestral_id');
            $table->unsignedBigInteger('faculty_id');
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->string('folder_name');
            $table->timestamps();

            $table->foreign('semestral_id')->references('semestral_id')->on('semestral_end')->onDelete('cascade');
            $table->foreign('faculty_id')->references('faculty_account_id')->on('faculty_account')->onDelete('cascade');
            $table->foreign('admin_id')->references('id')->on('admin_accounts')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('year_semestral_folders');
    }
}

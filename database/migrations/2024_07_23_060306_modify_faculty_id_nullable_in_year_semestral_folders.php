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
        Schema::table('year_semestral_folders', function (Blueprint $table) {
            $table->unsignedBigInteger('faculty_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('year_semestral_folders', function (Blueprint $table) {
            $table->unsignedBigInteger('faculty_id')->nullable(false)->change();
        });
    }
};

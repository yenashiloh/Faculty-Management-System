<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVerificationCodeToFacultyAccount extends Migration
{
    public function up()
    {
        Schema::table('faculty_account', function (Blueprint $table) {
            $table->string('verification_code')->nullable()->after('verify_status');
        });
    }

    public function down()
    {
        Schema::table('faculty_account', function (Blueprint $table) {
            $table->dropColumn('verification_code');
        });
    }
}

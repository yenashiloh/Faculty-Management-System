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
        Schema::table('semestral_end', function (Blueprint $table) {
            $table->boolean('trashed')->default(false)->after('file_name');
        });
    }
    
    public function down()
    {
        Schema::table('semestral_end', function (Blueprint $table) {
            $table->dropColumn('trashed');
        });
    }    

};

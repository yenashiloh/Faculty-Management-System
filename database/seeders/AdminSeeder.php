<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        DB::table('admin_accounts')->insert([
            'name' => 'James Nabayra',
            'email' => 'adminfarm@gmail.com',
            'password' => Hash::make('AdminFarm123.'),
        ]);
    }
}
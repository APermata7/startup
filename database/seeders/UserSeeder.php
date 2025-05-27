<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('rahasia1'),
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Lidwina',
                'email' => 'lidwina@gmail.com',
                'password' => Hash::make('rahasia1'),
                'role' => 'karyawan',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}

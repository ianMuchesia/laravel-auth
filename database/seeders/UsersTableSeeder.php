<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('users')->insert([
            [
                'name' => 'Lagbaja Tamedo',
                'email' => 'lagbaja@gmail.com',
                'password' => Hash::make(12345),
                'role' => 'admin',
                'status' => 'active'
            ],


            //Users
            [
                'name' => 'John Doe',
                'email' => 'doe@gmail.com',
                'password' => Hash::make(12345),
                'role' => 'user',
                'status' => 'active'
            ]
        ]);
    }
}

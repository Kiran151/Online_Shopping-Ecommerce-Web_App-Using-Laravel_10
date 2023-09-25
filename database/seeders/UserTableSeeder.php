<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')
            ->insert(
                [
                    [
                        'name' => 'Admin',
                        'username' => 'kiran',
                        'email' => 'kiran1999gopal@gmail.com',
                        'password' => Hash::make('12345678'),
                        'role' => 'admin',
                        'status' => 'active'
                    ],
                    [
                        'name' => 'Vendor',
                        'username' => 'vendor',
                        'email' => 'vendor@gmail.com',
                        'password' => Hash::make('12345678'),
                        'role' => 'vendor',
                        'status' => 'active'
                    ],
                    [
                        'name' => 'User',
                        'username' => 'user',
                        'email' => 'user@gmail.com',
                        'password' => Hash::make('12345678'),
                        'role' => 'user',
                        'status' => 'active'
                    ]
                ],
            );
    }
}
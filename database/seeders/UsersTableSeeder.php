<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insert two fixed users
        DB::table('users')->insert([
            [
                'first_name' => 'Admin',
                'middle_name' => null,
                'last_name' => 'User',
                'username' => 'admin',
                'email' => 'admin@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'phone_number' => null,
                'address' => null,
                'position' => 'admin',
                'status' => 'active',
                'profile_picture' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Test',
                'middle_name' => null,
                'last_name' => 'User',
                'username' => 'testuser',
                'email' => 'test@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'phone_number' => null,
                'address' => null,
                'position' => 'staff',
                'status' => 'active',
                'profile_picture' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Insert a few fake users
        for ($i = 1; $i <= 8; $i++) {
            DB::table('users')->insert([
                'first_name' => 'User' . $i,
                'middle_name' => null,
                'last_name' => 'Seed',
                'username' => 'user' . $i,
                'email' => 'user' . $i . '@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'phone_number' => null,
                'address' => null,
                'position' => 'staff',
                'status' => 'active',
                'profile_picture' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

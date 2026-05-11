<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Detect whether roles table and role_id column exist (safe when running seeds in different orders)
        $rolesExist = Schema::hasTable('roles');
        $usersHaveRoleId = Schema::hasColumn('users', 'role_id');

        $adminRoleId = $rolesExist ? DB::table('roles')->where('name', 'admin')->value('id') : null;
        $accountantRoleId = $rolesExist ? DB::table('roles')->where('name', 'accountant')->value('id') : null;
        $reviewerRoleId = $rolesExist ? DB::table('roles')->where('name', 'reviewer')->value('id') : null;
        $makerRoleId = $rolesExist ? DB::table('roles')->where('name', 'maker')->value('id') : null;

        $makeUser = function (array $data) use ($usersHaveRoleId) {
            if (! $usersHaveRoleId) {
                unset($data['role_id']);
            }
            return $data;
        };

        // Insert or update primary role users (avoid duplicate email errors)
        $primaryUsers = [
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
                'role_id' => $adminRoleId,
                'status' => 'active',
                'profile_picture' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Accountant',
                'middle_name' => null,
                'last_name' => 'User',
                'username' => 'accountant',
                'email' => 'accountant@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'phone_number' => null,
                'address' => null,
                'position' => 'accountant',
                'role_id' => $accountantRoleId,
                'status' => 'active',
                'profile_picture' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Reviewer',
                'middle_name' => null,
                'last_name' => 'User',
                'username' => 'reviewer',
                'email' => 'reviewer@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'phone_number' => null,
                'address' => null,
                'position' => 'reviewer',
                'role_id' => $reviewerRoleId,
                'status' => 'active',
                'profile_picture' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Maker',
                'middle_name' => null,
                'last_name' => 'User',
                'username' => 'maker',
                'email' => 'maker@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'phone_number' => null,
                'address' => null,
                'position' => 'maker',
                'role_id' => $makerRoleId,
                'status' => 'active',
                'profile_picture' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($primaryUsers as $u) {
            $data = $makeUser($u);
            $email = $data['email'];
            $insert = $data;
            unset($insert['email']);

            DB::table('users')->updateOrInsert(['email' => $email], $insert);
        }

        // Insert or update a few demo staff users
        for ($i = 1; $i <= 8; $i++) {
            $u = $makeUser([
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
                'role_id' => null,
                'status' => 'active',
                'profile_picture' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $email = $u['email'];
            $insert = $u;
            unset($insert['email']);
            DB::table('users')->updateOrInsert(['email' => $email], $insert);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FundsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('funds')->insert([
            ['fund_code' => 'fund1', 'fund_name' => 'Funds 1 RO1', 'description' => 'Regular', 'created_at' => now(), 'updated_at' => now()],
            ['fund_code' => 'fund2', 'fund_name' => 'Funds 2', 'description' => 'ARF', 'created_at' => now(), 'updated_at' => now()],
            ['fund_code' => 'fund3', 'fund_name' => 'Funds 3', 'description' => 'Split LPG', 'created_at' => now(), 'updated_at' => now()],
            ['fund_code' => 'fund4', 'fund_name' => 'Funds 4', 'description' => 'Split LP', 'created_at' => now(), 'updated_at' => now()],
            ['fund_code' => 'fund5', 'fund_name' => 'Funds 5', 'description' => 'DAR', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}

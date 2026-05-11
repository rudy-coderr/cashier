<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            ['type_code' => 'appeal_fee', 'type_name' => 'Appeal Fee'],
            ['type_code' => 'bidding_documents', 'type_name' => 'Bidding Documents'],
            ['type_code' => 'certification_photocopy', 'type_name' => 'Certification and Photocopy Fees'],
            ['type_code' => 'filing_fee', 'type_name' => 'Filing Fee and Inspection Cost'],
            ['type_code' => 'fund_transfer', 'type_name' => 'Fund Transfer from DAR C.O.'],
            ['type_code' => 'income_unserviceable', 'type_name' => 'Income from Sale of Unserviceable Property'],
            ['type_code' => 'luc_cash_bond', 'type_name' => 'LUC Cash Bond'],
            ['type_code' => 'refund_overpayment', 'type_name' => 'Refund of Overpayment'],
            ['type_code' => 'refund_lgu', 'type_name' => 'Refund of Transfer from LGUs'],
            ['type_code' => 'settlement_disallowances', 'type_name' => 'Settlement of Notice of Disallowances'],
        ];

        $now = now();
        foreach ($types as $t) {
            $t['created_at'] = $now;
            $t['updated_at'] = $now;
            DB::table('transaction_types')->insert($t);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Transaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Transaction::truncate();
        Schema::enableForeignKeyConstraints();

        $data = [
            [
                'data_rekening_id' => '1',
                'payment_via' => 'Bank',
                'deposit_date' => '2024-01-01',
                'payment_amount' => 90000000,
            ],
            [
                'data_rekening_id' => '2',
                'payment_via' => 'Bendahara',
                'deposit_date' => '2024-01-01',
                'payment_amount' => 50000000,
            ],


        ];

        foreach ($data as $value) {
            Transaction::insert($value);
        }
    }
}

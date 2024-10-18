<?php

namespace Database\Seeders;

use App\Models\Target;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class TargetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Target::truncate();
        Schema::enableForeignKeyConstraints();

        $data = [
            [
                'data_rekening_id' => '1',
                'target' => 80500000,
                'validity_period_start' => '2024-01-01',
                'validity_period_end' => '2024-12-31',
            ],
            [
                'data_rekening_id' => '2',
                'target' => 40500000,
                'validity_period_start' => '2024-01-01',
                'validity_period_end' => '2024-12-31',
            ],
            [
                'data_rekening_id' => '3',
                'target' => 90500000,
                'validity_period_start' => '2024-01-01',
                'validity_period_end' => '2024-12-31',
            ],

        ];

        foreach ($data as $value) {
            Target::insert($value);
        }
    }
}

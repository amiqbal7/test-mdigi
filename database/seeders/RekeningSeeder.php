<?php

namespace Database\Seeders;

use App\Models\Rekening;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class RekeningSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Rekening::truncate();
        Schema::enableForeignKeyConstraints();

        $data = [
            [
                'rekening_code' => 'DFKFO096666',
                'rekening_name' => 'Pajak Kendaraan'
            ],
            [
                'rekening_code' => 'DFKFO096669',
                'rekening_name' => 'Pajak Hotel Bintang 1'
            ],
            [
                'rekening_code' => 'DFKFO0967656',
                'rekening_name' => 'Pajak Hotel bintang 2'
            ],

        ];

        foreach ($data as $value) {
            Rekening::insert($value);
        }
    }
}

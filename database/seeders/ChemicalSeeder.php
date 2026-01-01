<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ChemicalSeeder extends Seeder
{
    public function run()
    {
        DB::table('chemicals')->insert([
            [
                'name' => 'Foam (Budo)',
                'chemical_type' => 'Foam',
                'manufacture_date' => Carbon::parse('2024-01-01'),
                'expiry_date' => Carbon::parse('2025-01-01'),
                'quantity' => 100,
                'unit' => 'L',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'CO2',
                'chemical_type' => 'Gas',
                'manufacture_date' => Carbon::parse('2024-01-01'),
                'expiry_date' => Carbon::parse('2025-01-01'),
                'quantity' => 50,
                'unit' => 'Cylinder',
                'created_at' => now(),
                'updated_at' => now(),
            ],
             [
                'name' => 'DCP Powder',
                'chemical_type' => 'Powder',
                'manufacture_date' => Carbon::parse('2024-01-01'),
                'expiry_date' => Carbon::parse('2025-01-01'),
                'quantity' => 200,
                'unit' => 'Kg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

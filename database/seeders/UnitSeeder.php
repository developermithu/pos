<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1 kg = 2.205 pound

        $units = [
            [
                'name' => 'Kilogram',
                'short_name' => 'kg',
                'operator' => '*',
                'operation_value' => 1,
            ],
            [
                'name' => 'Gram',
                'short_name' => 'gm',
                'unit_id' => 1,
                'operator' => '/',
                'operation_value' => 1000,
            ],
            [
                'name' => 'Pound',
                'short_name' => 'lb',
                'unit_id' => 1,
                'operator' => '*',
                'operation_value' => 0.454,
            ],
            [
                'name' => 'Piece',
                'short_name' => 'pc',
                'operator' => '*',
                'operation_value' => 1,
            ],
            [
                'name' => 'Dozen',
                'short_name' => 'Dozen',
                'unit_id' => 4,
                'operator' => '*',
                'operation_value' => 12,
            ],
        ];

        foreach ($units as $unit) {
            Unit::updateOrCreate($unit);
        }
    }
}

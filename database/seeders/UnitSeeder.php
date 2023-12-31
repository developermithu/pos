<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $units = [
            [
                'name' => 'Kilogram',
                'short_name' => 'kg',
            ],
            [
                'name' => 'Gram',
                'short_name' => 'gm',
            ],
            [
                'name' => 'Piece',
                'short_name' => 'pc',
            ],
            [
                'name' => 'Liter',
                'short_name' => 'l',
            ]
        ];

        foreach ($units as $unit) {
            Unit::updateOrCreate($unit);
        }
    }
}

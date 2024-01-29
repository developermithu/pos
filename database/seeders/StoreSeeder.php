<?php

namespace Database\Seeders;

use App\Models\Store;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stores = [
            [
                'name' => 'Store 1',
                'location' => 'Location 1',
            ],
            [
                'name' => 'Store 2',
                'location' => 'Location 2',
            ],
            [
                'name' => 'Store 3',
                'location' => 'Location 3',
            ],
            [
                'name' => 'Store 4',
                'location' => 'Location 4',
            ],
            [
                'name' => 'Store 5',
                'location' => 'Location 5',
            ],
        ];

        foreach ($stores as $store) {
            Store::updateOrCreate($store);
        }
    }
}

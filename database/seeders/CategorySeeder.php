<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'ইলেকট্রনিক্স'],
            ['name' => 'বোতল'],
            ['name' => 'সোতা'],
            ['name' => 'Others'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate($category);
        }
    }
}

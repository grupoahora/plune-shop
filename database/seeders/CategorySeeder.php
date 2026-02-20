<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Champús', 'icon' => 'spa', 'sort_order' => 1],
            ['name' => 'Acondicionadores', 'icon' => 'water_drop', 'sort_order' => 2],
            ['name' => 'Cremas de Peinar', 'icon' => 'brush', 'sort_order' => 3],
            ['name' => 'Tratamientos', 'icon' => 'eco', 'sort_order' => 4],
        ];

        DB::table('categories')->insert($categories);
    }
}

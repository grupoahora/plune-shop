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
        for ($i = 0; $i < 1; $i++) {
            $categories = [
                ['name' => 'Champús'.$i, 'icon' => 'Flower2', 'sort_order' => 1],
                ['name' => 'Acondicionadores'.$i, 'icon' => 'Droplets', 'sort_order' => 2],
                ['name' => 'Cremas de Peinar'.$i, 'icon' => 'Waves', 'sort_order' => 3],
                ['name' => 'Tratamientos'.$i, 'icon' => 'Leaf', 'sort_order' => 4],
            ];

            DB::table('categories')->insert($categories);
        }
    }
}

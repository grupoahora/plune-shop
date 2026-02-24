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
        for ($i=0; $i < 1000; $i++) { 
            $categories = [
                ['name' => 'Champús'.$i, 'icon' => 'spa', 'sort_order' => 1],
                ['name' => 'Acondicionadores'.$i, 'icon' => 'water_drop', 'sort_order' => 2],
                ['name' => 'Cremas de Peinar'.$i, 'icon' => 'brush', 'sort_order' => 3],
                ['name' => 'Tratamientos'.$i, 'icon' => 'eco', 'sort_order' => 4],
            ];
            # code...
            DB::table('categories')->insert($categories);
        }
    }
}

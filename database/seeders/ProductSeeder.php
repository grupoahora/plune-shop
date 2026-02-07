<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Champoo Árbol de Té',
                'description' => 'Ideal para cuero cabelludo graso y con caspa. Limpia profundamente y refresca.',
                'price_sale' => 25000,
                'product_code' => 'PLU-CHA-TEA',
                'status' => 1,
                'discount_value' => null,
                'discount_type' => null,
            ],
            [
                'name' => 'Champoo Romero',
                'description' => 'Estimula el crecimiento del cabello y fortalece la raíz.',
                'price_sale' => 25000,
                'product_code' => 'PLU-CHA-ROM',
                'status' => 1,
                'discount_value' => null,
                'discount_type' => null,
            ],
            [
                'name' => 'Champoo Jamaica',
                'description' => 'Aporta brillo, suavidad y vitalidad al cabello.',
                'price_sale' => 25000,
                'product_code' => 'PLU-CHA-JAM',
                'status' => 1,
                'discount_value' => null,
                'discount_type' => null,
            ],
            [
                'name' => 'Crema de Peinar Sólida',
                'description' => 'Nutre, define y controla el frizz de forma natural.',
                'price_sale' => 22000,
                'product_code' => 'PLU-CRE-SOL',
                'status' => 1,
                'discount_value' => null,
                'discount_type' => null,
            ],
            [
                'name' => 'Crema de Peinar Preparada',
                'description' => 'Crema lista para usar que hidrata y facilita el peinado.',
                'price_sale' => 20000,
                'product_code' => 'PLU-CRE-PRE',
                'status' => 1,
                'discount_value' => null,
                'discount_type' => null,
            ],
            [
                'name' => 'Acondicionador Almendras',
                'description' => 'Suaviza, hidrata y ayuda a desenredar sin generar caspa.',
                'price_sale' => 23000,
                'product_code' => 'PLU-ACO-ALM',
                'status' => 1,
                'discount_value' => null,
                'discount_type' => null,
            ],
            [
                'name' => 'Acondicionador Neutro',
                'description' => 'Ideal para piel sensible, niños y cueros cabelludos delicados.',
                'price_sale' => 23000,
                'product_code' => 'PLU-ACO-NEU',
                'status' => 1,
                'discount_value' => null,
                'discount_type' => null,
            ],
            [
                'name' => 'Tratamiento Capilar Sólido',
                'description' => 'Repara, fortalece y nutre profundamente el cabello.',
                'price_sale' => 28000,
                'product_code' => 'PLU-TRA-SOL',
                'status' => 1,
                'discount_value' => null,
                'discount_type' => null,
            ],
            [
                'name' => 'Tratamiento Capilar Preparado',
                'description' => 'Tratamiento intensivo listo para usar.',
                'price_sale' => 26000,
                'product_code' => 'PLU-TRA-PRE',
                'status' => 1,
                'discount_value' => null,
                'discount_type' => null,
            ],
        ];

        DB::table('products')->insert($products);
    }
}

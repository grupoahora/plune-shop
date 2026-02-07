<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $products = Product::all();

        if ($users->isEmpty() || $products->isEmpty()) {
            $this->command->info('No hay usuarios o productos para crear órdenes. Por favor, ejecuta UserSeeder y ProductSeeder primero.');
            return;
        }

        foreach ($users as $user) {
            // Crear entre 1 y 5 órdenes para cada usuario
            $numberOfOrders = rand(1, 5);
            Order::factory()->count($numberOfOrders)->create([
                'user_id' => $user->id,
                'amount' => 0,
                'status' => 'pending',
            ])->each(function ($order) use ($products) {
                // Para cada orden, crear entre 1 y 3 OrderItems
                $numberOfOrderItems = rand(1, 3);
                $orderItems = OrderItem::factory()->count($numberOfOrderItems)->create([
                    'order_id' => $order->id,
                    'product_id' => $products->random()->id,
                    'quantity' => rand(1, 5), // Cantidad aleatoria de productos
                    'price' => $products->random()->price_sale, // Usar el precio de venta del producto
                ]);

                // Calcular el monto total de la orden
                $totalAmount = 0;
                foreach ($orderItems as $item) {
                    $totalAmount += $item->quantity * $item->price;
                }

                $order->amount = $totalAmount;
                $order->save();
            });
        }
    }
}

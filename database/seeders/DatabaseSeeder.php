<?php

namespace Database\Seeders;

use App\Models\User;
use App\Support\Auth\RoleHelper;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
     /*    User::factory(10)->create(); */

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        $this->call([
            RoleSeeder::class,
        ]);

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
        ])->assignRole(RoleHelper::ADMIN);

        User::factory()->create([
            'name' => 'Cliente',
            'email' => 'cliente@example.com',
        ])->assignRole(RoleHelper::CLIENTE);
        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
            OrderSeeder::class,
        ]);
    }
}

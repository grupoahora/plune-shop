<?php

namespace Database\Seeders;

use App\Support\Auth\RoleHelper;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::firstOrCreate(['name' => RoleHelper::ADMIN]);
        Role::firstOrCreate(['name' => RoleHelper::CLIENTE]);
    }
}

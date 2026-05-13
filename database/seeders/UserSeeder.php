<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create(['name' => 'admin', 'opd' => 'Diskominfo', 'email' => 'sevandwiproject@gmail.com','status' => 'active', 'role' => 'admin','phone_number' => '085747131691', 'password' => 'admin2026']);
        User::create(['name' => 'staff', 'opd' => 'Diskominfo', 'email' => 'staff@gmail.com','status' => 'active', 'role' => 'staff','phone_number' => '081234567890', 'password' => 'staff']);
        User::create(['name' => 'customer', 'opd' => 'Diskominfo', 'email' => 'customer@gmail.com','status' => 'active', 'role' => 'customer','phone_number' => '081987654321', 'password' => 'customer']);
    }
}

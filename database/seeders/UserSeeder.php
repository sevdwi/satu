<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Catatan: kolom 'opd' (string) sudah dihapus dari tabel users karena
     * redundan dengan opd_id/opd_induk_id (lihat AUDIT-KODE-SATU.md 6.2/9.2).
     * Seeder ini sengaja tidak mengisi opd_id/opd_induk_id (nullable) karena
     * belum ada OpdIndukSeeder/OpdSeeder — kalau perlu data opd nyata untuk
     * testing, seed Opd_Induk & Opd dulu lalu isi kedua kolom itu di sini.
     */
    public function run(): void
    {
        User::create(['name' => 'admin', 'email' => 'sevandwiproject@gmail.com', 'status' => 'active', 'role' => 'admin', 'phone_number' => '085747131691', 'password' => 'admin2026']);
        User::create(['name' => 'staff', 'email' => 'staff@gmail.com', 'status' => 'active', 'role' => 'staff', 'phone_number' => '081234567890', 'password' => 'staff']);
        User::create(['name' => 'customer', 'email' => 'customer@gmail.com', 'status' => 'active', 'role' => 'customer', 'phone_number' => '081987654321', 'password' => 'customer']);
    }
}

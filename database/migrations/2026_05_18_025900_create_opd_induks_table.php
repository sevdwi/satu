<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Tabel ini sebelumnya tidak punya file migrasi sama sekali meski sudah
     * dipakai di produksi (lihat AUDIT-KODE-SATU.md Bagian 6.1) — model
     * Opd_Induk mematikan timestamps, jadi kolom created_at/updated_at
     * sengaja tidak disertakan di sini.
     */
    public function up(): void
    {
        Schema::create('opd_induks', function (Blueprint $table) {
            $table->id();
            $table->string('kode_instansi');
            $table->string('instansi');
            $table->string('singkatan_instansi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opd_induks');
    }
};

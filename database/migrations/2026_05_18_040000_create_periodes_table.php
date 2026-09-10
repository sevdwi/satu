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
     * Periode mematikan timestamps, jadi kolom created_at/updated_at
     * sengaja tidak disertakan di sini.
     */
    public function up(): void
    {
        Schema::create('periodes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('opd_id')
                ->nullable()
                ->constrained('opds')
                ->nullOnDelete();
            $table->year('tahun');
            $table->tinyInteger('tahap')->nullable();
            $table->enum('status', ['buka', 'tutup']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('periodes');
    }
};

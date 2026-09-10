<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * users dibuat sebelum opds/opd_induks ada, jadi kolom relasinya
     * ditambahkan di sini setelah kedua tabel itu tersedia (lihat
     * AUDIT-KODE-SATU.md Bagian 6.2/9.2 — kolom 'opd' string lama sudah
     * tidak dipakai di produksi, digantikan opd_id/opd_induk_id).
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('opd_id')
                ->nullable()
                ->after('name')
                ->constrained('opds');
            $table->foreignId('opd_induk_id')
                ->nullable()
                ->after('opd_id')
                ->constrained('opd_induks');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('opd_induk_id');
            $table->dropConstrainedForeignId('opd_id');
        });
    }
};

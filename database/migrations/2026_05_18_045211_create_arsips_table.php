<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    { 
        Schema::create('arsips', function (Blueprint $table) {
            $table->id();

            $table->string('judul');
            $table->text('deskripsi')->nullable();

            $table->string('file')->nullable();
            $table->year('tahun')->nullable();

            // =========================
            // RELASI
            // =========================

            $table->foreignId('periode_id')
                ->nullable()
                ->constrained('periodes');

            $table->date('tanggal')->nullable();
            $table->date('tanggal_musnah')->nullable();

            $table->foreignId('master_kode_id')
                ->nullable()
                ->constrained('master_kodes')
                ->nullOnDelete();

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('opd_id')
                ->nullable()
                ->constrained('opds')
                ->nullOnDelete();

            $table->foreignId('opd_induk_id')
                ->constrained('opd_induks');

            // dus_arsip_id/rak_arsip_id sengaja TANPA foreign key constraint —
            // mengikuti apa yang sudah berjalan di produksi (index saja),
            // karena kedua tabel itu baru dibuat setelah arsips.
            $table->unsignedBigInteger('dus_arsip_id')->nullable()->index();
            $table->unsignedBigInteger('rak_arsip_id')->nullable()->index();

            // =========================
            // FIELD LAIN
            // =========================

            $table->integer('aktif')->nullable();
            $table->integer('inaktif')->nullable();
            $table->string('nomor')->nullable();
            $table->enum('status', ['verify', 'input', 'draft'])->nullable();

            // Menggantikan kolom 'pemusnahan' (varchar) lama yang dipakai untuk
            // dua arti sekaligus (keterangan + tanggal) — lihat Audit 4.2/9.1.
            $table->enum('nasib_akhir', ['musnah', 'permanen'])->nullable();

            $table->string('korektor')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('arsips');
    }
};

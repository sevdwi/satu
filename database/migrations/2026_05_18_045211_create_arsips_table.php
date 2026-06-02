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
            $table->date('tanggal')->nullable();

            // =========================
            // RELASI BENAR
            // =========================

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

            // =========================
            // FIELD LAIN
            // =========================

            $table->string('retensi')->nullable();
            $table->string('nomor')->nullable();

            $table->string('status')->nullable();

            $table->string('korektor')->nullable();

            $table->string('retensiinaktif')->nullable();

            $table->date('pemusnahan')->nullable();

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

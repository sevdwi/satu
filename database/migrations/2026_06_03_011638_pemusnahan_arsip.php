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
        Schema::create('pemusnahan_arsips', function (Blueprint $table) {
            $table->id();

            $table->string('judul');
            $table->text('deskripsi')->nullable();

            $table->string('file')->nullable();
            $table->date('tanggal')->nullable();

            // =========================
            // RELASI BENAR
            // =========================

            $table->string('master_kode_id')->nullable(); 

            $table->string('created_by')->nullable(); 

            $table->string('opd_id')->nullable();   

            // =========================
            // FIELD LAIN
            // ========================= 
            $table->string('nomor')->nullable();

            $table->string('status')->nullable();

            $table->string('korektor')->nullable(); 

            $table->date('pemusnahan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemusnahan_arsips');
        //
    }
};

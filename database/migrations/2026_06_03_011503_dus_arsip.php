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
        Schema::create('dus_arsips', function (Blueprint $table) {
            $table->id(); 
            $table->string('nomor_dus')->nullable(); 
            $table->foreignId('rak_arsip_id')
                ->constrained('rak_arsips');
            $table->foreignId('opd_id')
                ->nullable()
                ->constrained('opds')
                ->nullOnDelete();
            $table->foreignId('opd_induk_id')
                ->nullable()
                ->constrained('opd_induks');
            $table->string('qrcode')->default('');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dus_arsips');
    }
};

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
        Schema::create('rak_arsips', function (Blueprint $table) {
            $table->id(); 
            $table->string('nomor_rak'); 
            $table->foreignId('opd_id')
                ->nullable()
                ->constrained('opds')
                ->nullOnDelete();
            $table->foreignId('opd_induk_id')
                ->nullable()
                ->constrained('opd_induks');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rak_arsips');
    }
};

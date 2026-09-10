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
            $table->foreignId('id_arsip')->nullable()->constrained('arsips')->nullOnDelete();
            $table->date('pemusnahan')->nullable();
            $table->string('no_ba')->nullable();
            $table->string('file_ba')->nullable();
            $table->foreignId('master_kode_id')->nullable()->constrained('master_kodes')->nullOnDelete();
            $table->foreignId('opd_id')->nullable()->constrained('opds')->nullOnDelete();
            $table->string('korektor')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemusnahan_arsips');
    }
};

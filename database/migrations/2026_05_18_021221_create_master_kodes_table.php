<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{ 
    /**
     * Run the migrations.
     *
     * Model MasterKode mematikan timestamps ($timestamps = false), jadi
     * kolom created_at/updated_at sengaja tidak disertakan (sebelumnya ada
     * di skema tapi selalu NULL — lihat AUDIT-KODE-SATU.md Bagian 9.2).
     */
    public function up(): void
    {
        Schema::create('master_kodes', function (Blueprint $table) {

            $table->id();

            $table->string('kode')->unique();

            $table->boolean('is_parent')->default(false);

            $table->foreignId('parent_id')
                ->nullable()
                ->constrained('master_kodes')
                ->nullOnDelete();

            $table->integer('level')->default(1);

            $table->string('nama');

            $table->integer('aktif')->nullable();
            $table->integer('inaktif')->nullable();

            $table->text('keterangan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_kodes');
    }
};

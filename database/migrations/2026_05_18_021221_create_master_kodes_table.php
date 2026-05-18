<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{ 
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

            $table->text('keterangan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('master_kodes');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('krs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')
                  ->constrained('mahasiswa')
                  ->cascadeOnDelete();
            $table->string('tahun_akademik', 9);
            $table->enum('semester', ['Ganjil', 'Genap']);
            $table->enum('status', ['draft', 'diajukan', 'disetujui', 'ditolak'])
                  ->default('draft');
            $table->timestamps();
            
            // Kombinasi unique agar mahasiswa tidak memiliki dua KRS pada semester yang sama[cite: 6]
            $table->unique(['mahasiswa_id', 'tahun_akademik', 'semester']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('krs');
    }
};
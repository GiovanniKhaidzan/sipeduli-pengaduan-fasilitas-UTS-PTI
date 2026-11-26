<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabel lokasis — menyimpan lokasi fasilitas kampus (gedung + ruangan).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lokasis', function (Blueprint $table) {
            $table->id();
            $table->string('nama_gedung', 100);   // Contoh: Gedung A, Lab Komputer
            $table->string('nama_ruangan', 100);  // Contoh: Ruang 301, Lantai 2
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lokasis');
    }
};

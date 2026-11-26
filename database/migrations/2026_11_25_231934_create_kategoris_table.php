<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabel kategoris — menyimpan kategori jenis kerusakan fasilitas.
 * Contoh: AC, Listrik, Jaringan/WiFi, Furnitur, Kebersihan.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kategoris', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100)->unique(); // Nama kategori harus unik
            $table->text('deskripsi')->nullable();  // Deskripsi opsional
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kategoris');
    }
};

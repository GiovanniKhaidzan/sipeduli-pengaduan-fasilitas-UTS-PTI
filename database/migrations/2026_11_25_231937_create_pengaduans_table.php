<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabel pengaduans — inti aplikasi, menyimpan laporan kerusakan fasilitas.
 * Relasi: belongsTo users, kategoris, lokasis.
 * Cascade: tanggapan ikut terhapus jika pengaduan dihapus.
 * Restrict: kategori/lokasi tidak bisa dihapus jika masih dipakai.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengaduans', function (Blueprint $table) {
            $table->id();

            // Foreign key ke users (pelapor/mahasiswa)
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->restrictOnDelete(); // User tidak bisa dihapus jika punya pengaduan

            // Foreign key ke kategoris
            $table->foreignId('kategori_id')
                  ->constrained('kategoris')
                  ->restrictOnDelete(); // Kategori tidak bisa dihapus jika masih dipakai

            // Foreign key ke lokasis
            $table->foreignId('lokasi_id')
                  ->constrained('lokasis')
                  ->restrictOnDelete(); // Lokasi tidak bisa dihapus jika masih dipakai

            $table->string('judul', 150);           // Judul singkat pengaduan
            $table->text('deskripsi');              // Deskripsi detail masalah
            $table->string('foto')->nullable();     // Path foto (opsional)

            // Status pengaduan dengan nilai yang terbatas
            // menunggu → diproses → selesai / ditolak
            $table->string('status')->default('menunggu');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaduans');
    }
};

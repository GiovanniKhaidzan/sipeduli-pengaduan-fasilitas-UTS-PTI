<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabel tanggapans — tanggapan petugas/admin terhadap pengaduan.
 * Cascade: ikut terhapus jika pengaduannya dihapus (cascadeOnDelete).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tanggapans', function (Blueprint $table) {
            $table->id();

            // Foreign key ke pengaduans — cascade: tanggapan ikut terhapus
            $table->foreignId('pengaduan_id')
                  ->constrained('pengaduans')
                  ->cascadeOnDelete();

            // Foreign key ke users (petugas/admin yang menanggapi)
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->restrictOnDelete();

            $table->text('isi'); // Isi tanggapan dari petugas/admin
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tanggapans');
    }
};

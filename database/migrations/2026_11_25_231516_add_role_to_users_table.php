<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration untuk menambah kolom role ke tabel users.
 * Role menentukan hak akses: admin, petugas, atau mahasiswa.
 * Default mahasiswa agar akun yang daftar lewat register tidak bisa jadi admin.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Tambah kolom role setelah kolom email
            // Nilai yang diizinkan: admin, petugas, mahasiswa
            $table->string('role')->default('mahasiswa')->after('email');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};

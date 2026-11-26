<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Seeder untuk membuat akun-akun awal SIPEDULI.
 * Akun admin dan petugas tidak bisa dibuat lewat form register,
 * jadi dibuat di sini dengan role yang diatur langsung (force fill).
 *
 * Jalankan dengan: php artisan db:seed atau php artisan migrate:fresh --seed
 */
class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ===== ADMIN =====
        // Hak akses penuh: CRUD kategori, lokasi, semua pengaduan, semua tanggapan
        User::create([
            'name'     => 'Admin SIPEDULI',
            'email'    => 'admin@sipeduli.test',
            'password' => Hash::make('admin123'),
        ])->forceFill(['role' => 'admin'])->save();

        // ===== PETUGAS =====
        // Bisa lihat semua pengaduan, tambah/ubah tanggapan, ubah status
        User::create([
            'name'     => 'Petugas Fasilitas',
            'email'    => 'petugas@sipeduli.test',
            'password' => Hash::make('petugas123'),
        ])->forceFill(['role' => 'petugas'])->save();

        // ===== MAHASISWA 1 =====
        // Hanya bisa buat dan lihat pengaduan miliknya sendiri
        User::create([
            'name'     => 'Budi Santoso',
            'email'    => 'mahasiswa1@sipeduli.test',
            'password' => Hash::make('mahasiswa123'),
        ])->forceFill(['role' => 'mahasiswa'])->save();

        // ===== MAHASISWA 2 =====
        User::create([
            'name'     => 'Siti Rahayu',
            'email'    => 'mahasiswa2@sipeduli.test',
            'password' => Hash::make('mahasiswa123'),
        ])->forceFill(['role' => 'mahasiswa'])->save();
    }
}

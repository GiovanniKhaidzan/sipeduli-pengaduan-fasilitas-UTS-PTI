<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * DatabaseSeeder — titik masuk semua seeder.
 * Urutan penting: User → Kategori → Lokasi → Pengaduan (ada FK).
 */
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,     // akun admin, petugas, mahasiswa
            KategoriSeeder::class, // kategori jenis kerusakan
            LokasiSeeder::class,   // gedung & ruangan kampus
            PengaduanSeeder::class,// contoh pengaduan + tanggapan
        ]);
    }
}

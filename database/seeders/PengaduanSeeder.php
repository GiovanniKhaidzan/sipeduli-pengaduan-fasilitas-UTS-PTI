<?php

namespace Database\Seeders;

use App\Models\Pengaduan;
use App\Models\Tanggapan;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Seeder PengaduanSeeder — mengisi data contoh pengaduan dan tanggapan.
 */
class PengaduanSeeder extends Seeder
{
    public function run(): void
    {
        $mahasiswa1 = User::where('email', 'mahasiswa1@sipeduli.test')->first();
        $mahasiswa2 = User::where('email', 'mahasiswa2@sipeduli.test')->first();
        $petugas    = User::where('email', 'petugas@sipeduli.test')->first();

        // Pengaduan 1 — sudah selesai
        $p1 = Pengaduan::create([
            'user_id'     => $mahasiswa1->id,
            'kategori_id' => 1, // AC
            'lokasi_id'   => 3, // Gedung A Ruang 301
            'judul'       => 'AC Ruang 301 Tidak Dingin',
            'deskripsi'   => 'AC di ruang 301 sudah tidak dingin sejak 3 hari yang lalu. Suhu ruangan sangat panas sehingga mengganggu proses belajar.',
            'foto'        => null,
        ]);
        $p1->forceFill(['status' => 'selesai'])->save();

        Tanggapan::create([
            'pengaduan_id' => $p1->id,
            'user_id'      => $petugas->id,
            'isi'          => 'Sudah kami cek dan perbaiki. Freon AC telah diisi ulang. Silahkan dicek kembali.',
        ]);

        // Pengaduan 2 — sedang diproses
        $p2 = Pengaduan::create([
            'user_id'     => $mahasiswa1->id,
            'kategori_id' => 2, // Listrik
            'lokasi_id'   => 4, // Gedung B Ruang 102
            'judul'       => 'Lampu Lorong Lantai 2 Gedung B Mati',
            'deskripsi'   => 'Lampu di lorong lantai 2 Gedung B sudah mati sejak seminggu lalu. Sangat gelap terutama saat malam hari.',
            'foto'        => null,
        ]);
        $p2->forceFill(['status' => 'diproses'])->save();

        Tanggapan::create([
            'pengaduan_id' => $p2->id,
            'user_id'      => $petugas->id,
            'isi'          => 'Laporan diterima. Kami sedang menunggu pengiriman lampu pengganti dari gudang. Estimasi 2-3 hari kerja.',
        ]);

        // Pengaduan 3 — masih menunggu
        Pengaduan::create([
            'user_id'     => $mahasiswa2->id,
            'kategori_id' => 3, // WiFi
            'lokasi_id'   => 7, // Lab Komputer 1
            'judul'       => 'WiFi Lab Komputer 1 Sangat Lambat',
            'deskripsi'   => 'Koneksi WiFi di Lab Komputer 1 sangat lambat, hampir tidak bisa digunakan untuk browsing. Sudah berlangsung selama 2 minggu.',
            'foto'        => null,
        ]);

        // Pengaduan 4 — masih menunggu
        Pengaduan::create([
            'user_id'     => $mahasiswa2->id,
            'kategori_id' => 4, // Furnitur
            'lokasi_id'   => 2, // Gedung A Ruang 201
            'judul'       => 'Kursi Ruang 201 Banyak yang Patah',
            'deskripsi'   => 'Terdapat sekitar 5 kursi di ruang 201 yang patah kakinya sehingga tidak bisa digunakan. Mohon segera diganti.',
            'foto'        => null,
        ]);
    }
}

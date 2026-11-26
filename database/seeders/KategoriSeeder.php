<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

/**
 * Seeder Kategori — mengisi data awal kategori jenis kerusakan fasilitas.
 */
class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $kategoris = [
            ['nama' => 'AC / Pendingin Ruangan', 'deskripsi' => 'Kerusakan atau gangguan pada AC dan sistem pendingin ruangan'],
            ['nama' => 'Listrik & Lampu',        'deskripsi' => 'Masalah kelistrikan, lampu mati, atau stop kontak rusak'],
            ['nama' => 'Jaringan / WiFi',         'deskripsi' => 'Koneksi internet lambat, WiFi tidak terdeteksi, atau jaringan bermasalah'],
            ['nama' => 'Furnitur',                'deskripsi' => 'Meja, kursi, lemari, atau perabot kampus yang rusak atau perlu diganti'],
            ['nama' => 'Kebersihan',              'deskripsi' => 'Kebersihan ruangan, toilet, atau area kampus yang perlu perhatian'],
            ['nama' => 'Proyektor / LCD',         'deskripsi' => 'Proyektor rusak, gambar buram, atau perangkat presentasi bermasalah'],
            ['nama' => 'Lain-lain',               'deskripsi' => 'Kerusakan fasilitas lain yang tidak termasuk kategori di atas'],
        ];

        foreach ($kategoris as $data) {
            Kategori::create($data);
        }
    }
}

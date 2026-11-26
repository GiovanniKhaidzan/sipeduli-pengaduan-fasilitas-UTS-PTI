<?php

namespace Database\Seeders;

use App\Models\Lokasi;
use Illuminate\Database\Seeder;

/**
 * Seeder Lokasi — mengisi data awal lokasi/ruangan di kampus.
 */
class LokasiSeeder extends Seeder
{
    public function run(): void
    {
        $lokasis = [
            ['nama_gedung' => 'Gedung A',       'nama_ruangan' => 'Ruang 101'],
            ['nama_gedung' => 'Gedung A',       'nama_ruangan' => 'Ruang 201'],
            ['nama_gedung' => 'Gedung A',       'nama_ruangan' => 'Ruang 301'],
            ['nama_gedung' => 'Gedung B',       'nama_ruangan' => 'Ruang 102'],
            ['nama_gedung' => 'Gedung B',       'nama_ruangan' => 'Ruang 202'],
            ['nama_gedung' => 'Gedung B',       'nama_ruangan' => 'Aula Utama'],
            ['nama_gedung' => 'Gedung C',       'nama_ruangan' => 'Lab Komputer 1'],
            ['nama_gedung' => 'Gedung C',       'nama_ruangan' => 'Lab Komputer 2'],
            ['nama_gedung' => 'Gedung C',       'nama_ruangan' => 'Ruang Seminar'],
            ['nama_gedung' => 'Perpustakaan',   'nama_ruangan' => 'Lantai 1'],
            ['nama_gedung' => 'Perpustakaan',   'nama_ruangan' => 'Lantai 2'],
            ['nama_gedung' => 'Kantin Kampus',  'nama_ruangan' => 'Area Makan'],
            ['nama_gedung' => 'Toilet Umum',    'nama_ruangan' => 'Gedung A Lantai 1'],
            ['nama_gedung' => 'Toilet Umum',    'nama_ruangan' => 'Gedung B Lantai 2'],
        ];

        foreach ($lokasis as $data) {
            Lokasi::create($data);
        }
    }
}

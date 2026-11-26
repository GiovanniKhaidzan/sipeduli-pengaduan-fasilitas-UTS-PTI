<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model Kategori — kategori jenis kerusakan fasilitas.
 * Relasi: satu kategori bisa punya banyak pengaduan (hasMany).
 */
class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategoris';

    // Kolom yang boleh diisi massal
    protected $fillable = ['nama', 'deskripsi'];

    /**
     * Relasi: Kategori memiliki banyak Pengaduan.
     * Digunakan untuk cek apakah kategori masih dipakai sebelum dihapus.
     */
    public function pengaduans()
    {
        return $this->hasMany(Pengaduan::class, 'kategori_id');
    }
}

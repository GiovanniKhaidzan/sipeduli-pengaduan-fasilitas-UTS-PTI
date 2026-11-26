<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model Lokasi — lokasi fasilitas kampus (gedung + ruangan).
 * Relasi: satu lokasi bisa punya banyak pengaduan (hasMany).
 */
class Lokasi extends Model
{
    use HasFactory;

    protected $table = 'lokasis';

    // Kolom yang boleh diisi massal
    protected $fillable = ['nama_gedung', 'nama_ruangan'];

    /**
     * Relasi: Lokasi memiliki banyak Pengaduan.
     */
    public function pengaduans()
    {
        return $this->hasMany(Pengaduan::class, 'lokasi_id');
    }

    /**
     * Helper: tampilkan nama lengkap lokasi (gedung + ruangan).
     */
    public function getNamaLengkapAttribute(): string
    {
        return $this->nama_gedung . ' — ' . $this->nama_ruangan;
    }
}

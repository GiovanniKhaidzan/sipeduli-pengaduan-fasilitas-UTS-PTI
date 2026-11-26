<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model Tanggapan — respons petugas/admin terhadap pengaduan.
 *
 * Relasi:
 * - belongsTo Pengaduan
 * - belongsTo User (petugas/admin yang menanggapi)
 */
class Tanggapan extends Model
{
    use HasFactory;

    protected $table = 'tanggapans';

    // Kolom yang boleh diisi massal
    protected $fillable = [
        'pengaduan_id',
        'user_id',
        'isi',
    ];

    /** Cast tipe data kolom */
    protected function casts(): array
    {
        return [
            'pengaduan_id' => 'integer',
            'user_id'      => 'integer',
        ];
    }

    // ===== RELASI =====

    /**
     * Relasi: Tanggapan milik satu Pengaduan.
     */
    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class, 'pengaduan_id');
    }

    /**
     * Relasi: Tanggapan dibuat oleh satu User (petugas/admin).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

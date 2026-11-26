<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model Pengaduan — laporan kerusakan fasilitas dari mahasiswa.
 *
 * Relasi:
 * - belongsTo User    (pelapor)
 * - belongsTo Kategori
 * - belongsTo Lokasi
 * - hasMany Tanggapan (cascade delete sudah diatur di migration)
 */
class Pengaduan extends Model
{
    use HasFactory;

    protected $table = 'pengaduans';

    // Kolom yang boleh diisi massal
    // 'status' tidak di-fillable agar tidak diubah sembarangan lewat form biasa
    protected $fillable = [
        'user_id',
        'kategori_id',
        'lokasi_id',
        'judul',
        'deskripsi',
        'foto',
    ];

    /** Cast tipe data kolom */
    protected function casts(): array
    {
        return [
            'user_id'     => 'integer',
            'kategori_id' => 'integer',
            'lokasi_id'   => 'integer',
        ];
    }

    // Nilai status yang diizinkan (digunakan untuk validasi)
    public const STATUS_LIST = ['menunggu', 'diproses', 'selesai', 'ditolak'];

    // ===== RELASI =====

    /**
     * Relasi: Pengaduan dimiliki oleh satu User (pelapor).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi: Pengaduan memiliki satu Kategori.
     */
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    /**
     * Relasi: Pengaduan memiliki satu Lokasi.
     */
    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'lokasi_id');
    }

    /**
     * Relasi: Pengaduan memiliki banyak Tanggapan.
     */
    public function tanggapans()
    {
        return $this->hasMany(Tanggapan::class, 'pengaduan_id');
    }

    // ===== HELPER =====

    /** Cek apakah status masih menunggu (boleh diubah/dihapus mahasiswa) */
    public function isMenunggu(): bool
    {
        return $this->status === 'menunggu';
    }

    /** Kembalikan kelas badge Bootstrap sesuai status */
    public function getBadgeClassAttribute(): string
    {
        return match($this->status) {
            'menunggu' => 'badge-menunggu',
            'diproses' => 'badge-diproses',
            'selesai'  => 'badge-selesai',
            'ditolak'  => 'badge-ditolak',
            default    => 'bg-secondary',
        };
    }

    /** Label status bersih dalam bahasa Indonesia */
    public function getLabelStatusAttribute(): string
    {
        return match($this->status) {
            'menunggu' => 'Menunggu',
            'diproses' => 'Diproses',
            'selesai'  => 'Selesai',
            'ditolak'  => 'Ditolak',
            default    => ucfirst($this->status),
        };
    }
}

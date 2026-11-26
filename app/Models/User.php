<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Model User — pengguna aplikasi SIPEDULI.
 * Memiliki 3 peran: admin, petugas, mahasiswa.
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Kolom yang boleh diisi massal (mass assignment).
     * PENTING: 'role' TIDAK dimasukkan di sini agar tidak bisa diisi dari form register.
     * Role diatur di sisi server (controller/seeder).
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        // 'role' sengaja tidak di-fillable untuk keamanan
    ];

    /**
     * Kolom yang disembunyikan saat serialisasi (misalnya ke JSON).
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Cast tipe data kolom.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    // ===== HELPER METHODS ROLE =====

    /** Cek apakah user adalah admin */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /** Cek apakah user adalah petugas */
    public function isPetugas(): bool
    {
        return $this->role === 'petugas';
    }

    /** Cek apakah user adalah mahasiswa */
    public function isMahasiswa(): bool
    {
        return $this->role === 'mahasiswa';
    }

    /** Cek apakah user adalah admin atau petugas */
    public function isStaff(): bool
    {
        return in_array($this->role, ['admin', 'petugas']);
    }
}

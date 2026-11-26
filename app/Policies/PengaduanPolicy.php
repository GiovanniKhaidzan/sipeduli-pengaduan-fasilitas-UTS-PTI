<?php

namespace App\Policies;

use App\Models\Pengaduan;
use App\Models\User;

/**
 * PengaduanPolicy — aturan siapa yang boleh melakukan apa pada pengaduan.
 *
 * Aturan:
 * - viewAny : semua yang login
 * - view    : pemilik, petugas, admin
 * - create  : semua yang login
 * - update  : hanya pemilik DAN status masih 'menunggu'
 * - delete  : admin ATAU pemilik DAN status masih 'menunggu'
 */
class PengaduanPolicy
{
    /** Siapa yang boleh lihat daftar pengaduan? Semua yang sudah login. */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /** Siapa yang boleh lihat detail pengaduan? Pemilik, petugas, atau admin. */
    public function view(User $user, Pengaduan $pengaduan): bool
    {
        // Admin dan petugas bisa lihat semua
        if ($user->isStaff()) {
            return true;
        }

        // Mahasiswa hanya bisa lihat miliknya sendiri
        return (int) $user->id === (int) $pengaduan->user_id;
    }

    /** Siapa yang boleh buat pengaduan baru? Semua yang login. */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Siapa yang boleh edit pengaduan?
     * Hanya pemilik (mahasiswa) dan hanya jika status masih 'menunggu'.
     * Petugas/admin tidak edit pengaduan — mereka update status & tambah tanggapan.
     */
    public function update(User $user, Pengaduan $pengaduan): bool
    {
        return (int) $user->id === (int) $pengaduan->user_id
            && $pengaduan->status === 'menunggu';
    }

    /**
     * Siapa yang boleh hapus pengaduan?
     * - Admin boleh menghapus pengaduan apa saja (untuk moderasi / hapus data).
     * - Mahasiswa hanya boleh menghapus pengaduan miliknya sendiri dan hanya jika status masih 'menunggu'.
     */
    public function delete(User $user, Pengaduan $pengaduan): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return (int) $user->id === (int) $pengaduan->user_id
            && $pengaduan->status === 'menunggu';
    }
}

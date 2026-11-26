<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

/**
 * KategoriController — CRUD kategori jenis kerusakan fasilitas.
 * Hanya bisa diakses oleh admin (dijaga RoleMiddleware di route).
 */
class KategoriController extends Controller
{
    /** Daftar semua kategori dengan pagination */
    public function index()
    {
        // Eager load jumlah pengaduan per kategori, urutkan terbaru
        $kategoris = Kategori::withCount('pengaduans')
                              ->orderBy('nama')
                              ->paginate(10);

        return view('kategori.index', compact('kategoris'));
    }

    /** Form tambah kategori baru */
    public function create()
    {
        return view('kategori.create');
    }

    /** Simpan kategori baru ke database */
    public function store(Request $request)
    {
        // Validasi input — nama harus unik di tabel kategoris
        $request->validate([
            'nama'      => 'required|string|max:100|unique:kategoris,nama',
            'deskripsi' => 'nullable|string|max:500',
        ], [
            'nama.required' => 'Nama kategori wajib diisi.',
            'nama.unique'   => 'Nama kategori sudah ada, gunakan nama lain.',
            'nama.max'      => 'Nama kategori maksimal 100 karakter.',
        ]);

        $kategori = Kategori::create($request->only('nama', 'deskripsi'));

        return redirect()->route('kategori.index')
                         ->with('success', 'Kategori "' . $kategori->nama . '" berhasil ditambahkan.');
    }

    /** Form edit kategori */
    public function edit(Kategori $kategori)
    {
        return view('kategori.edit', compact('kategori'));
    }

    /** Simpan perubahan kategori */
    public function update(Request $request, Kategori $kategori)
    {
        // Validasi — nama unik kecuali milik kategori ini sendiri
        $request->validate([
            'nama'      => 'required|string|max:100|unique:kategoris,nama,' . $kategori->id,
            'deskripsi' => 'nullable|string|max:500',
        ], [
            'nama.required' => 'Nama kategori wajib diisi.',
            'nama.unique'   => 'Nama kategori sudah ada, gunakan nama lain.',
            'nama.max'      => 'Nama kategori maksimal 100 karakter.',
        ]);

        $kategori->update($request->only('nama', 'deskripsi'));

        return redirect()->route('kategori.index')
                         ->with('success', 'Kategori "' . $kategori->nama . '" berhasil diperbarui.');
    }

    /** Hapus kategori — dicegah jika masih dipakai pengaduan */
    public function destroy(Kategori $kategori)
    {
        // Cek apakah kategori masih dipakai pengaduan
        if ($kategori->pengaduans()->exists()) {
            return redirect()->route('kategori.index')
                             ->with('error', 'Kategori "' . $kategori->nama . '" tidak dapat dihapus karena masih digunakan oleh ' . $kategori->pengaduans()->count() . ' pengaduan.');
        }

        $nama = $kategori->nama;
        $kategori->delete();

        return redirect()->route('kategori.index')
                         ->with('success', 'Kategori "' . $nama . '" berhasil dihapus.');
    }

    /** show() tidak dipakai — kategori tidak perlu halaman detail sendiri */
    public function show(Kategori $kategori)
    {
        return redirect()->route('kategori.index');
    }
}

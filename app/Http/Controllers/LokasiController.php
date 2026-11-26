<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use Illuminate\Http\Request;

/**
 * LokasiController — CRUD lokasi gedung & ruangan kampus.
 * Hanya bisa diakses oleh admin (dijaga RoleMiddleware di route).
 */
class LokasiController extends Controller
{
    /** Daftar semua lokasi dengan pagination */
    public function index()
    {
        $lokasis = Lokasi::withCount('pengaduans')
                         ->orderBy('nama_gedung')
                         ->orderBy('nama_ruangan')
                         ->paginate(10);

        return view('lokasi.index', compact('lokasis'));
    }

    /** Form tambah lokasi baru */
    public function create()
    {
        return view('lokasi.create');
    }

    /** Simpan lokasi baru ke database */
    public function store(Request $request)
    {
        $request->validate([
            'nama_gedung'  => 'required|string|max:100',
            'nama_ruangan' => 'required|string|max:100',
        ], [
            'nama_gedung.required'  => 'Nama gedung wajib diisi.',
            'nama_ruangan.required' => 'Nama ruangan wajib diisi.',
        ]);

        $lokasi = Lokasi::create($request->only('nama_gedung', 'nama_ruangan'));

        return redirect()->route('lokasi.index')
                         ->with('success', 'Lokasi "' . $lokasi->nama_gedung . ' - ' . $lokasi->nama_ruangan . '" berhasil ditambahkan.');
    }

    /** Form edit lokasi */
    public function edit(Lokasi $lokasi)
    {
        return view('lokasi.edit', compact('lokasi'));
    }

    /** Simpan perubahan lokasi */
    public function update(Request $request, Lokasi $lokasi)
    {
        $request->validate([
            'nama_gedung'  => 'required|string|max:100',
            'nama_ruangan' => 'required|string|max:100',
        ], [
            'nama_gedung.required'  => 'Nama gedung wajib diisi.',
            'nama_ruangan.required' => 'Nama ruangan wajib diisi.',
        ]);

        $lokasi->update($request->only('nama_gedung', 'nama_ruangan'));

        return redirect()->route('lokasi.index')
                         ->with('success', 'Lokasi "' . $lokasi->nama_gedung . ' - ' . $lokasi->nama_ruangan . '" berhasil diperbarui.');
    }

    /** Hapus lokasi — dicegah jika masih dipakai pengaduan */
    public function destroy(Lokasi $lokasi)
    {
        if ($lokasi->pengaduans()->exists()) {
            return redirect()->route('lokasi.index')
                             ->with('error', 'Lokasi "' . $lokasi->nama_gedung . ' - ' . $lokasi->nama_ruangan . '" tidak dapat dihapus karena masih digunakan oleh ' . $lokasi->pengaduans()->count() . ' pengaduan.');
        }

        $nama = $lokasi->nama_gedung . ' - ' . $lokasi->nama_ruangan;
        $lokasi->delete();

        return redirect()->route('lokasi.index')
                         ->with('success', 'Lokasi "' . $nama . '" berhasil dihapus.');
    }

    public function show(Lokasi $lokasi)
    {
        return redirect()->route('lokasi.index');
    }
}

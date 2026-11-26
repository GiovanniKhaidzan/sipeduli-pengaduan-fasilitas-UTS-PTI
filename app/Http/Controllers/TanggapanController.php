<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\Tanggapan;
use Illuminate\Http\Request;

/**
 * TanggapanController — CRUD tanggapan di dalam pengaduan.
 *
 * Hanya admin dan petugas yang bisa memberi tanggapan.
 * Edit/hapus: hanya pembuat tanggapan atau admin.
 */
class TanggapanController extends Controller
{
    /** Simpan tanggapan baru untuk suatu pengaduan */
    public function store(Request $request, Pengaduan $pengaduan)
    {
        // Validasi isi tanggapan
        $request->validate([
            'isi' => 'required|string|min:5|max:2000',
        ], [
            'isi.required' => 'Isi tanggapan wajib diisi.',
            'isi.min'      => 'Tanggapan minimal 5 karakter.',
            'isi.max'      => 'Tanggapan maksimal 2000 karakter.',
        ]);

        // Buat tanggapan — user_id dari user yang login (admin/petugas)
        $pengaduan->tanggapans()->create([
            'isi'     => $request->isi,
            'user_id' => auth()->id(),
        ]);

        // Jika status pengaduan masih 'menunggu', otomatis ubah ke 'diproses'
        if ($pengaduan->status === 'menunggu') {
            $pengaduan->status = 'diproses';
            $pengaduan->save();
        }

        return redirect()->route('pengaduan.show', $pengaduan)
                         ->with('success', 'Tanggapan berhasil dikirim.');
    }

    /** Form edit tanggapan */
    public function edit(Pengaduan $pengaduan, Tanggapan $tanggapan)
    {
        // Pastikan tanggapan memang milik pengaduan ini
        abort_unless((int) $tanggapan->pengaduan_id === (int) $pengaduan->id, 404);

        // Hanya pembuat tanggapan atau admin yang bisa edit
        $user = auth()->user();
        abort_unless((int) $user->id === (int) $tanggapan->user_id || $user->isAdmin(), 403, 'Kamu tidak berhak mengedit tanggapan ini.');

        return view('tanggapan.edit', compact('pengaduan', 'tanggapan'));
    }

    /** Simpan perubahan tanggapan */
    public function update(Request $request, Pengaduan $pengaduan, Tanggapan $tanggapan)
    {
        abort_unless((int) $tanggapan->pengaduan_id === (int) $pengaduan->id, 404);

        $user = auth()->user();
        abort_unless((int) $user->id === (int) $tanggapan->user_id || $user->isAdmin(), 403, 'Kamu tidak berhak mengedit tanggapan ini.');

        $request->validate([
            'isi' => 'required|string|min:5|max:2000',
        ], [
            'isi.required' => 'Isi tanggapan wajib diisi.',
            'isi.min'      => 'Tanggapan minimal 5 karakter.',
        ]);

        $tanggapan->update(['isi' => $request->isi]);

        return redirect()->route('pengaduan.show', $pengaduan)
                         ->with('success', 'Tanggapan berhasil diperbarui.');
    }

    /** Hapus tanggapan */
    public function destroy(Pengaduan $pengaduan, Tanggapan $tanggapan)
    {
        abort_unless((int) $tanggapan->pengaduan_id === (int) $pengaduan->id, 404);

        $user = auth()->user();
        abort_unless((int) $user->id === (int) $tanggapan->user_id || $user->isAdmin(), 403, 'Kamu tidak berhak menghapus tanggapan ini.');

        $tanggapan->delete();

        return redirect()->route('pengaduan.show', $pengaduan)
                         ->with('success', 'Tanggapan berhasil dihapus.');
    }
}

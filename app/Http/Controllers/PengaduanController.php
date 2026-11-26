<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Lokasi;
use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * PengaduanController — CRUD pengaduan fasilitas kampus.
 *
 * - Mahasiswa: hanya bisa lihat/buat/edit/hapus miliknya (saat status menunggu)
 * - Petugas/Admin: bisa lihat semua pengaduan
 * Otorisasi lewat PengaduanPolicy (authorize()).
 */
class PengaduanController extends Controller
{
    /** Daftar pengaduan — mahasiswa hanya lihat miliknya, petugas/admin lihat semua */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Pengaduan::class);

        $user = auth()->user();

        if ($user->isStaff()) {
            // Petugas & admin: lihat semua pengaduan, eager load relasi
            $query = Pengaduan::with(['user', 'kategori', 'lokasi']);
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }
            $pengaduans = $query->latest()->paginate(10);
        } else {
            // Mahasiswa: hanya miliknya sendiri
            $query = Pengaduan::with(['kategori', 'lokasi'])->where('user_id', $user->id);
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }
            $pengaduans = $query->latest()->paginate(10);
        }

        return view('pengaduan.index', compact('pengaduans'));
    }

    /** Form buat pengaduan baru */
    public function create()
    {
        $this->authorize('create', Pengaduan::class);

        // Ambil semua kategori dan lokasi untuk dropdown form
        $kategoris = Kategori::orderBy('nama')->get();
        $lokasis   = Lokasi::orderBy('nama_gedung')->orderBy('nama_ruangan')->get();

        return view('pengaduan.create', compact('kategoris', 'lokasis'));
    }

    /** Simpan pengaduan baru ke database */
    public function store(Request $request)
    {
        $this->authorize('create', Pengaduan::class);

        $request->validate([
            'judul'       => 'required|string|max:150',
            'deskripsi'   => 'required|string|min:10',
            'kategori_id' => 'required|exists:kategoris,id',
            'lokasi_id'   => 'required|exists:lokasis,id',
            'foto'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'judul.required'       => 'Judul pengaduan wajib diisi.',
            'judul.max'            => 'Judul maksimal 150 karakter.',
            'deskripsi.required'   => 'Deskripsi pengaduan wajib diisi.',
            'deskripsi.min'        => 'Deskripsi minimal 10 karakter.',
            'kategori_id.required' => 'Kategori wajib dipilih.',
            'kategori_id.exists'   => 'Kategori tidak valid.',
            'lokasi_id.required'   => 'Lokasi wajib dipilih.',
            'lokasi_id.exists'     => 'Lokasi tidak valid.',
            'foto.image'           => 'File harus berupa gambar.',
            'foto.mimes'           => 'Format foto harus jpg, jpeg, atau png.',
            'foto.max'             => 'Ukuran foto maksimal 2 MB.',
        ]);

        // Handle upload foto (opsional)
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            // Simpan ke storage/app/public/foto-pengaduan
            $fotoPath = $request->file('foto')->store('foto-pengaduan', 'public');
        }

        // Buat pengaduan — user_id dari user yang login, status default 'menunggu'
        $pengaduan = new Pengaduan($request->only('judul', 'deskripsi', 'kategori_id', 'lokasi_id'));
        $pengaduan->user_id = auth()->id();
        $pengaduan->foto    = $fotoPath;
        $pengaduan->save();

        return redirect()->route('pengaduan.show', $pengaduan)
                         ->with('success', 'Pengaduan berhasil dikirim! Kami akan segera menanggapi.');
    }

    /** Detail pengaduan beserta tanggapan */
    public function show(Pengaduan $pengaduan)
    {
        $this->authorize('view', $pengaduan);

        // Eager load semua relasi yang dibutuhkan di halaman detail
        $pengaduan->load(['user', 'kategori', 'lokasi', 'tanggapans.user']);

        return view('pengaduan.show', compact('pengaduan'));
    }

    /** Form edit pengaduan */
    public function edit(Pengaduan $pengaduan)
    {
        $this->authorize('update', $pengaduan);

        $kategoris = Kategori::orderBy('nama')->get();
        $lokasis   = Lokasi::orderBy('nama_gedung')->orderBy('nama_ruangan')->get();

        return view('pengaduan.edit', compact('pengaduan', 'kategoris', 'lokasis'));
    }

    /** Simpan perubahan pengaduan */
    public function update(Request $request, Pengaduan $pengaduan)
    {
        $this->authorize('update', $pengaduan);

        $request->validate([
            'judul'       => 'required|string|max:150',
            'deskripsi'   => 'required|string|min:10',
            'kategori_id' => 'required|exists:kategoris,id',
            'lokasi_id'   => 'required|exists:lokasis,id',
            'foto'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'judul.required'       => 'Judul pengaduan wajib diisi.',
            'deskripsi.required'   => 'Deskripsi wajib diisi.',
            'deskripsi.min'        => 'Deskripsi minimal 10 karakter.',
            'kategori_id.required' => 'Kategori wajib dipilih.',
            'lokasi_id.required'   => 'Lokasi wajib dipilih.',
            'foto.image'           => 'File harus berupa gambar.',
            'foto.mimes'           => 'Format foto harus jpg, jpeg, atau png.',
            'foto.max'             => 'Ukuran foto maksimal 2 MB.',
        ]);

        // Jika ada foto baru, hapus foto lama & simpan yang baru
        if ($request->hasFile('foto')) {
            if ($pengaduan->foto) {
                Storage::disk('public')->delete($pengaduan->foto);
            }
            $pengaduan->foto = $request->file('foto')->store('foto-pengaduan', 'public');
        }

        $pengaduan->fill($request->only('judul', 'deskripsi', 'kategori_id', 'lokasi_id'));
        $pengaduan->save();

        return redirect()->route('pengaduan.show', $pengaduan)
                         ->with('success', 'Pengaduan berhasil diperbarui.');
    }

    /** Hapus pengaduan */
    public function destroy(Pengaduan $pengaduan)
    {
        $this->authorize('delete', $pengaduan);

        $judul = $pengaduan->judul;

        // Hapus foto jika ada
        if ($pengaduan->foto) {
            Storage::disk('public')->delete($pengaduan->foto);
        }

        $pengaduan->delete(); // Tanggapan ikut terhapus (cascade)

        return redirect()->route('pengaduan.index')
                         ->with('success', 'Pengaduan "' . $judul . '" berhasil dihapus.');
    }

    /** Update status pengaduan — hanya admin dan petugas */
    public function updateStatus(Request $request, Pengaduan $pengaduan)
    {
        $user = auth()->user();
        abort_unless($user->isStaff(), 403, 'Hanya petugas atau admin yang dapat mengubah status.');

        $request->validate([
            'status' => 'required|in:' . implode(',', Pengaduan::STATUS_LIST),
        ], [
            'status.required' => 'Status wajib dipilih.',
            'status.in'       => 'Pilihan status tidak valid.',
        ]);

        $pengaduan->status = $request->status;
        $pengaduan->save();

        return redirect()->route('pengaduan.show', $pengaduan)
                         ->with('success', 'Status pengaduan berhasil diperbarui menjadi ' . ucfirst($request->status) . '.');
    }
}

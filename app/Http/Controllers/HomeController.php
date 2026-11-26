<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\Kategori;
use App\Models\Lokasi;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = auth()->user();

        // Query pengaduan sesuai role: staf (admin/petugas) lihat semua, mahasiswa lihat miliknya
        $query = $user->isStaff() ? Pengaduan::query() : Pengaduan::where('user_id', $user->id);

        $stats = [
            'total'    => (clone $query)->count(),
            'menunggu' => (clone $query)->where('status', 'menunggu')->count(),
            'diproses' => (clone $query)->where('status', 'diproses')->count(),
            'selesai'  => (clone $query)->where('status', 'selesai')->count(),
            'ditolak'  => (clone $query)->where('status', 'ditolak')->count(),
        ];

        // 5 Pengaduan terbaru
        $recentPengaduans = (clone $query)->with(['kategori', 'lokasi', 'user'])
                                          ->latest()
                                          ->take(5)
                                          ->get();

        // Data master untuk admin
        $extraStats = [];
        if ($user->isAdmin()) {
            $extraStats = [
                'total_kategori' => Kategori::count(),
                'total_lokasi'   => Lokasi::count(),
            ];
        }

        return view('home', compact('stats', 'recentPengaduans', 'extraStats'));
    }
}

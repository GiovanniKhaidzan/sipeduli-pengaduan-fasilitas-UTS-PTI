@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container">

    {{-- Header Halaman --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h4 class="fw-bold mb-1" style="letter-spacing:-0.02em;">Dashboard</h4>
            <p class="text-muted mb-0" style="font-size:0.9rem;">
                Selamat datang, <span class="fw-semibold text-dark">{{ Auth::user()->name }}</span>
                &middot;
                <span class="badge bg-light text-secondary border fw-medium" style="text-transform:capitalize;">
                    {{ Auth::user()->role }}
                </span>
            </p>
        </div>

        <div class="d-flex align-items-center gap-2">
            @if(Auth::user()->isMahasiswa())
                <a href="{{ route('pengaduan.create') }}" class="btn btn-primary">
                    + Buat Pengaduan
                </a>
            @endif
            <a href="{{ route('pengaduan.index') }}" class="btn btn-outline-secondary">
                Lihat Daftar Pengaduan
            </a>
        </div>
    </div>

    {{-- Ringkasan Statistik --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md">
            <a href="{{ route('pengaduan.index') }}" class="text-decoration-none">
                <div class="card stat-link-card h-100">
                    <div class="card-body">
                        <div class="text-muted small fw-medium mb-1">Total Laporan</div>
                        <div class="fs-3 fw-bold text-dark">{{ $stats['total'] }}</div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-6 col-md">
            <a href="{{ route('pengaduan.index', ['status' => 'menunggu']) }}" class="text-decoration-none">
                <div class="card stat-link-card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-2 text-muted small fw-medium mb-1">
                            <span class="rounded-circle d-inline-block" style="width:8px;height:8px;background:#d97706;"></span>
                            Menunggu
                        </div>
                        <div class="fs-3 fw-bold text-dark">{{ $stats['menunggu'] }}</div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-6 col-md">
            <a href="{{ route('pengaduan.index', ['status' => 'diproses']) }}" class="text-decoration-none">
                <div class="card stat-link-card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-2 text-muted small fw-medium mb-1">
                            <span class="rounded-circle d-inline-block" style="width:8px;height:8px;background:#2563eb;"></span>
                            Diproses
                        </div>
                        <div class="fs-3 fw-bold text-dark">{{ $stats['diproses'] }}</div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-6 col-md">
            <a href="{{ route('pengaduan.index', ['status' => 'selesai']) }}" class="text-decoration-none">
                <div class="card stat-link-card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-2 text-muted small fw-medium mb-1">
                            <span class="rounded-circle d-inline-block" style="width:8px;height:8px;background:#059669;"></span>
                            Selesai
                        </div>
                        <div class="fs-3 fw-bold text-dark">{{ $stats['selesai'] }}</div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-12 col-md">
            <a href="{{ route('pengaduan.index', ['status' => 'ditolak']) }}" class="text-decoration-none">
                <div class="card stat-link-card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-2 text-muted small fw-medium mb-1">
                            <span class="rounded-circle d-inline-block" style="width:8px;height:8px;background:#dc2626;"></span>
                            Ditolak
                        </div>
                        <div class="fs-3 fw-bold text-dark">{{ $stats['ditolak'] }}</div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    {{-- Akses Cepat Master Data untuk Admin --}}
    @if(Auth::user()->isAdmin())
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <div class="card stat-link-card h-100">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="fw-semibold">Master Kategori</div>
                            <div class="text-muted small">{{ $extraStats['total_kategori'] ?? 0 }} kategori terdaftar</div>
                        </div>
                        <a href="{{ route('kategori.index') }}" class="btn btn-sm btn-outline-primary">Kelola</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card stat-link-card h-100">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="fw-semibold">Master Lokasi</div>
                            <div class="text-muted small">{{ $extraStats['total_lokasi'] ?? 0 }} gedung &amp; ruangan</div>
                        </div>
                        <a href="{{ route('lokasi.index') }}" class="btn btn-sm btn-outline-primary">Kelola</a>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Tabel Pengaduan Terbaru --}}
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Pengaduan Terbaru</span>
            <a href="{{ route('pengaduan.index') }}" class="text-decoration-none small fw-semibold">Lihat Semua &rarr;</a>
        </div>
        <div class="card-body p-0">
            @if($recentPengaduans->isEmpty())
                <div class="text-center py-5 text-muted">
                    <p class="mb-2">Belum ada pengaduan yang tercatat.</p>
                    @if(Auth::user()->isMahasiswa())
                        <a href="{{ route('pengaduan.create') }}" class="btn btn-sm btn-primary">Buat Pengaduan Pertama</a>
                    @endif
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Judul</th>
                                @if(Auth::user()->isStaff())
                                    <th>Pelapor</th>
                                @endif
                                <th>Kategori</th>
                                <th>Lokasi</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentPengaduans as $rp)
                            <tr>
                                <td class="fw-medium">{{ Str::limit($rp->judul, 45) }}</td>
                                @if(Auth::user()->isStaff())
                                    <td class="text-muted small">{{ $rp->user->name }}</td>
                                @endif
                                <td><span class="badge bg-light text-dark border fw-normal">{{ $rp->kategori->nama }}</span></td>
                                <td class="text-muted small">{{ $rp->lokasi->nama_gedung }} &mdash; {{ $rp->lokasi->nama_ruangan }}</td>
                                <td><span class="badge-status {{ $rp->badge_class }}">{{ $rp->label_status }}</span></td>
                                <td class="text-muted small">{{ $rp->created_at->format('d/m/Y') }}</td>
                                <td class="text-end">
                                    <a href="{{ route('pengaduan.show', $rp) }}" class="btn btn-sm btn-outline-secondary">Detail</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    {{-- Keterangan Status Ringkas --}}
    <div class="card">
        <div class="card-body py-3">
            <div class="row g-3 small text-muted">
                <div class="col-md-3">
                    <span class="badge-status badge-menunggu me-1">Menunggu</span>
                    Laporan baru masuk, belum ditinjau petugas.
                </div>
                <div class="col-md-3">
                    <span class="badge-status badge-diproses me-1">Diproses</span>
                    Sedang diverifikasi atau dalam tahap perbaikan.
                </div>
                <div class="col-md-3">
                    <span class="badge-status badge-selesai me-1">Selesai</span>
                    Perbaikan telah selesai dilakukan.
                </div>
                <div class="col-md-3">
                    <span class="badge-status badge-ditolak me-1">Ditolak</span>
                    Laporan tidak valid atau di luar cakupan fasilitas.
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

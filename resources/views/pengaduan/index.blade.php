@extends('layouts.app')

@section('title', 'Daftar Pengaduan')

@section('content')
<div class="container">

    {{-- Header Halaman --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
        <div>
            <h4 class="fw-bold mb-1">Daftar Pengaduan</h4>
            <p class="text-muted mb-0 small">
                @if(Auth::user()->isStaff())
                    Seluruh pengaduan fasilitas yang masuk ke sistem
                @else
                    Riwayat pengaduan yang Anda ajukan
                @endif
            </p>
        </div>
        @if(Auth::user()->isMahasiswa())
            <a href="{{ route('pengaduan.create') }}" class="btn btn-primary">
                + Buat Pengaduan
            </a>
        @endif
    </div>

    {{-- Filter Status --}}
    <div class="d-flex align-items-center gap-2 flex-wrap mb-3">
        <span class="text-muted small me-1">Filter:</span>
        @foreach(['', 'menunggu', 'diproses', 'selesai', 'ditolak'] as $s)
            @php
                $isActive = request('status') === $s || (request('status') === null && $s === '');
            @endphp
            <a href="{{ route('pengaduan.index', $s ? ['status' => $s] : []) }}"
               class="btn btn-sm {{ $isActive ? 'btn-primary' : 'btn-outline-secondary bg-white' }}">
                {{ $s === '' ? 'Semua' : ucfirst($s) }}
            </a>
        @endforeach
    </div>

    {{-- Tabel Pengaduan --}}
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>{{ Auth::user()->isStaff() ? 'Semua Pengaduan' : 'Pengaduan Saya' }}</span>
            <span class="text-muted small">Total: {{ $pengaduans->total() }}</span>
        </div>
        <div class="card-body p-0">
            @if($pengaduans->isEmpty())
                <div class="text-center py-5 text-muted">
                    <p class="mb-2">
                        @if(request('status'))
                            Tidak ada pengaduan dengan status "{{ ucfirst(request('status')) }}".
                        @elseif(Auth::user()->isMahasiswa())
                            Anda belum pernah membuat pengaduan.
                        @else
                            Belum ada pengaduan yang masuk.
                        @endif
                    </p>
                    @if(Auth::user()->isMahasiswa() && !request('status'))
                        <a href="{{ route('pengaduan.create') }}" class="btn btn-sm btn-primary">Buat Pengaduan</a>
                    @elseif(request('status'))
                        <a href="{{ route('pengaduan.index') }}" class="btn btn-sm btn-outline-secondary">Reset Filter</a>
                    @endif
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th style="width:45px">#</th>
                                @if(Auth::user()->isStaff())
                                    <th>Pelapor</th>
                                @endif
                                <th>Judul</th>
                                <th>Kategori</th>
                                <th>Lokasi</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th class="text-end" style="width:200px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pengaduans as $i => $p)
                            <tr>
                                <td class="text-muted">{{ $pengaduans->firstItem() + $i }}</td>

                                @if(Auth::user()->isStaff())
                                <td>
                                    <div class="fw-medium small">{{ $p->user->name }}</div>
                                    <div class="text-muted" style="font-size:0.75rem;">{{ $p->user->email }}</div>
                                </td>
                                @endif

                                <td>
                                    <div class="fw-medium">{{ Str::limit($p->judul, 45) }}</div>
                                    @if($p->foto)
                                        <span class="text-muted" style="font-size:0.75rem;">Lampiran foto</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border fw-normal">{{ $p->kategori->nama }}</span>
                                </td>
                                <td class="small">
                                    <div>{{ $p->lokasi->nama_gedung }}</div>
                                    <div class="text-muted">{{ $p->lokasi->nama_ruangan }}</div>
                                </td>
                                <td>
                                    <span class="badge-status {{ $p->badge_class }}">{{ $p->label_status }}</span>
                                </td>
                                <td class="text-muted small">
                                    {{ $p->created_at->format('d/m/Y') }}
                                </td>
                                <td class="text-end">
                                    <div class="d-inline-flex gap-1">
                                        <a href="{{ route('pengaduan.show', $p) }}"
                                           class="btn btn-sm btn-outline-secondary">Detail</a>

                                        @can('update', $p)
                                            <a href="{{ route('pengaduan.edit', $p) }}"
                                               class="btn btn-sm btn-outline-primary">Edit</a>
                                        @endcan

                                        @can('delete', $p)
                                            <form action="{{ route('pengaduan.destroy', $p) }}" method="POST"
                                                  data-confirm="Hapus pengaduan &quot;{{ Str::limit($p->judul, 40) }}&quot;? Semua tanggapan terkait juga akan terhapus."
                                                  data-confirm-title="Konfirmasi Hapus Pengaduan">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($pengaduans->hasPages())
                    <div class="card-footer bg-white border-top py-3">
                        {{ $pengaduans->appends(request()->query())->links() }}
                    </div>
                @endif
            @endif
        </div>
    </div>

</div>
@endsection

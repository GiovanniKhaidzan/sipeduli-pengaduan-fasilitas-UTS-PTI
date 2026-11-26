@extends('layouts.app')
@section('title', 'Kelola Lokasi')

@section('content')
<div class="container">

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
        <div>
            <h4 class="fw-bold mb-1">Kelola Lokasi</h4>
            <p class="text-muted mb-0 small">Daftar gedung dan ruangan kampus</p>
        </div>
        <a href="{{ route('lokasi.create') }}" class="btn btn-primary">
            + Tambah Lokasi
        </a>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th style="width:50px">#</th>
                            <th>Nama Gedung</th>
                            <th>Nama Ruangan</th>
                            <th class="text-center" style="width:140px">Jml Pengaduan</th>
                            <th class="text-end" style="width:160px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lokasis as $lokasi)
                        <tr>
                            <td class="text-muted">{{ $loop->iteration + ($lokasis->currentPage() - 1) * $lokasis->perPage() }}</td>
                            <td class="fw-semibold">{{ $lokasi->nama_gedung }}</td>
                            <td class="text-secondary">{{ $lokasi->nama_ruangan }}</td>
                            <td class="text-center">
                                <span class="badge bg-light text-dark border">{{ $lokasi->pengaduans_count }}</span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('lokasi.edit', $lokasi) }}"
                                   class="btn btn-sm btn-outline-secondary me-1">Edit</a>

                                <form action="{{ route('lokasi.destroy', $lokasi) }}"
                                      method="POST" class="d-inline"
                                      data-confirm="Hapus lokasi &quot;{{ $lokasi->nama_gedung }} - {{ $lokasi->nama_ruangan }}&quot;?"
                                      data-confirm-title="Konfirmasi Hapus Lokasi">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                Belum ada lokasi. <a href="{{ route('lokasi.create') }}">Tambah sekarang</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if($lokasis->hasPages())
        <div class="mt-3">
            {{ $lokasis->links() }}
        </div>
    @endif

</div>
@endsection

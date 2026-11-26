@extends('layouts.app')
@section('title', 'Kelola Kategori')

@section('content')
<div class="container">

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
        <div>
            <h4 class="fw-bold mb-1">Kelola Kategori</h4>
            <p class="text-muted mb-0 small">Daftar kategori jenis kerusakan fasilitas kampus</p>
        </div>
        <a href="{{ route('kategori.create') }}" class="btn btn-primary">
            + Tambah Kategori
        </a>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th style="width:50px">#</th>
                            <th>Nama Kategori</th>
                            <th>Deskripsi</th>
                            <th class="text-center" style="width:140px">Jml Pengaduan</th>
                            <th class="text-end" style="width:160px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kategoris as $kategori)
                        <tr>
                            <td class="text-muted">{{ $loop->iteration + ($kategoris->currentPage() - 1) * $kategoris->perPage() }}</td>
                            <td class="fw-semibold">{{ $kategori->nama }}</td>
                            <td class="text-muted small">{{ $kategori->deskripsi ?? '-' }}</td>
                            <td class="text-center">
                                <span class="badge bg-light text-dark border">{{ $kategori->pengaduans_count }}</span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('kategori.edit', $kategori) }}"
                                   class="btn btn-sm btn-outline-secondary me-1">Edit</a>

                                <form action="{{ route('kategori.destroy', $kategori) }}"
                                      method="POST" class="d-inline"
                                      data-confirm="Hapus kategori &quot;{{ $kategori->nama }}&quot;?"
                                      data-confirm-title="Konfirmasi Hapus Kategori">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                Belum ada kategori. <a href="{{ route('kategori.create') }}">Tambah sekarang</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if($kategoris->hasPages())
        <div class="mt-3">
            {{ $kategoris->links() }}
        </div>
    @endif

</div>
@endsection

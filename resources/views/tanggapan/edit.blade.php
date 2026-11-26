@extends('layouts.app')

@section('title', 'Edit Tanggapan')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb small">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('pengaduan.index') }}">Pengaduan</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('pengaduan.show', $pengaduan) }}">Detail</a></li>
                    <li class="breadcrumb-item active">Edit Tanggapan</li>
                </ol>
            </nav>

            <div class="card">
                <div class="card-header">Edit Tanggapan</div>
                <div class="card-body">

                    <div class="alert alert-light border d-flex justify-content-between align-items-center mb-4 small">
                        <div>
                            <span class="text-muted">Pengaduan:</span>
                            <strong class="ms-1">{{ $pengaduan->judul }}</strong>
                        </div>
                        <span class="badge-status {{ $pengaduan->badge_class }}">{{ $pengaduan->label_status }}</span>
                    </div>

                    <form action="{{ route('pengaduan.tanggapan.update', [$pengaduan, $tanggapan]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="isi" class="form-label">Isi Tanggapan <span class="text-danger">*</span></label>
                            <textarea id="isi" name="isi" rows="5"
                                      class="form-control @error('isi') is-invalid @enderror">{{ old('isi', $tanggapan->isi) }}</textarea>
                            @error('isi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                            <a href="{{ route('pengaduan.show', $pengaduan) }}" class="btn btn-outline-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

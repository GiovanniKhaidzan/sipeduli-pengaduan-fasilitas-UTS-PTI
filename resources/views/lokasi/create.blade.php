@extends('layouts.app')
@section('title', 'Tambah Lokasi')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7">

            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb small">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('lokasi.index') }}">Lokasi</a></li>
                    <li class="breadcrumb-item active">Tambah Baru</li>
                </ol>
            </nav>

            <div class="card">
                <div class="card-header">Tambah Lokasi Baru</div>
                <div class="card-body">
                    <form action="{{ route('lokasi.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="nama_gedung" class="form-label">Nama Gedung <span class="text-danger">*</span></label>
                            <input type="text" id="nama_gedung" name="nama_gedung"
                                   class="form-control @error('nama_gedung') is-invalid @enderror"
                                   value="{{ old('nama_gedung') }}"
                                   placeholder="Contoh: Gedung A, Lab Komputer, Perpustakaan"
                                   maxlength="100">
                            @error('nama_gedung')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="nama_ruangan" class="form-label">Nama Ruangan <span class="text-danger">*</span></label>
                            <input type="text" id="nama_ruangan" name="nama_ruangan"
                                   class="form-control @error('nama_ruangan') is-invalid @enderror"
                                   value="{{ old('nama_ruangan') }}"
                                   placeholder="Contoh: Ruang 301, Lantai 2, Aula Utama"
                                   maxlength="100">
                            @error('nama_ruangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                            <a href="{{ route('lokasi.index') }}" class="btn btn-outline-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan Lokasi</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

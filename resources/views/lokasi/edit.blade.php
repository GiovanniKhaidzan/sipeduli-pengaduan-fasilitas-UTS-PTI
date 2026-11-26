@extends('layouts.app')
@section('title', 'Edit Lokasi')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7">

            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb small">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('lokasi.index') }}">Lokasi</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </nav>

            <div class="card">
                <div class="card-header">Edit Lokasi</div>
                <div class="card-body">
                    <form action="{{ route('lokasi.update', $lokasi) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="nama_gedung" class="form-label">Nama Gedung <span class="text-danger">*</span></label>
                            <input type="text" id="nama_gedung" name="nama_gedung"
                                   class="form-control @error('nama_gedung') is-invalid @enderror"
                                   value="{{ old('nama_gedung', $lokasi->nama_gedung) }}"
                                   maxlength="100">
                            @error('nama_gedung')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="nama_ruangan" class="form-label">Nama Ruangan <span class="text-danger">*</span></label>
                            <input type="text" id="nama_ruangan" name="nama_ruangan"
                                   class="form-control @error('nama_ruangan') is-invalid @enderror"
                                   value="{{ old('nama_ruangan', $lokasi->nama_ruangan) }}"
                                   maxlength="100">
                            @error('nama_ruangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                            <a href="{{ route('lokasi.index') }}" class="btn btn-outline-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

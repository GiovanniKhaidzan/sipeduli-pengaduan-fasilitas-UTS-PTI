@extends('layouts.app')

@section('title', 'Edit Pengaduan')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb small">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('pengaduan.index') }}">Pengaduan</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('pengaduan.show', $pengaduan) }}">Detail</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </nav>

            <div class="card">
                <div class="card-header">Edit Pengaduan</div>
                <div class="card-body">

                    <div class="alert alert-warning small mb-4">
                        Pengaduan hanya dapat diubah selama masih berstatus <strong>Menunggu</strong>.
                    </div>

                    <form action="{{ route('pengaduan.update', $pengaduan) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul Pengaduan <span class="text-danger">*</span></label>
                            <input type="text" id="judul" name="judul"
                                   class="form-control @error('judul') is-invalid @enderror"
                                   value="{{ old('judul', $pengaduan->judul) }}"
                                   maxlength="150">
                            @error('judul')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="kategori_id" class="form-label">Kategori <span class="text-danger">*</span></label>
                                <select id="kategori_id" name="kategori_id"
                                        class="form-select @error('kategori_id') is-invalid @enderror">
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($kategoris as $k)
                                        <option value="{{ $k->id }}"
                                            {{ old('kategori_id', $pengaduan->kategori_id) == $k->id ? 'selected' : '' }}>
                                            {{ $k->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kategori_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="lokasi_id" class="form-label">Lokasi <span class="text-danger">*</span></label>
                                <select id="lokasi_id" name="lokasi_id"
                                        class="form-select @error('lokasi_id') is-invalid @enderror">
                                    <option value="">-- Pilih Lokasi --</option>
                                    @foreach($lokasis as $l)
                                        <option value="{{ $l->id }}"
                                            {{ old('lokasi_id', $pengaduan->lokasi_id) == $l->id ? 'selected' : '' }}>
                                            {{ $l->nama_gedung }} &mdash; {{ $l->nama_ruangan }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('lokasi_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi Masalah <span class="text-danger">*</span></label>
                            <textarea id="deskripsi" name="deskripsi" rows="5"
                                      class="form-control @error('deskripsi') is-invalid @enderror">{{ old('deskripsi', $pengaduan->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="foto" class="form-label">Foto Pendukung</label>

                            @if($pengaduan->foto)
                                <div class="mb-2">
                                    <div class="text-muted small mb-1">Foto saat ini:</div>
                                    <img src="{{ Storage::url($pengaduan->foto) }}" alt="Foto pengaduan"
                                         class="img-thumbnail" style="max-width:200px;">
                                </div>
                            @endif

                            <input type="file" id="foto" name="foto"
                                   class="form-control @error('foto') is-invalid @enderror"
                                   accept="image/jpg,image/jpeg,image/png">
                            <div class="form-text">
                                {{ $pengaduan->foto ? 'Unggah foto baru jika ingin mengganti foto saat ini. ' : '' }}Format JPG, JPEG, PNG maks 2 MB.
                            </div>
                            @error('foto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div id="foto-preview" class="mt-2 d-none">
                                <div class="text-muted small mb-1">Preview foto baru:</div>
                                <img id="preview-img" src="" alt="Preview" class="img-thumbnail" style="max-width:200px;">
                            </div>
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

@push('scripts')
<script>
    document.getElementById('foto').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(ev) {
                document.getElementById('preview-img').src = ev.target.result;
                document.getElementById('foto-preview').classList.remove('d-none');
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush

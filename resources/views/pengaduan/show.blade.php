@extends('layouts.app')

@section('title', 'Detail Pengaduan')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-9">

            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb small">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('pengaduan.index') }}">Pengaduan</a></li>
                    <li class="breadcrumb-item active">Detail #{{ $pengaduan->id }}</li>
                </ol>
            </nav>

            {{-- Detail Pengaduan --}}
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Detail Pengaduan</span>
                    <span class="badge-status {{ $pengaduan->badge_class }}">{{ $pengaduan->label_status }}</span>
                </div>
                <div class="card-body">

                    <h5 class="fw-bold mb-3">{{ $pengaduan->judul }}</h5>

                    <div class="row g-3 mb-4">
                        <div class="col-sm-6 col-md-3">
                            <div class="p-3 rounded border bg-light h-100">
                                <div class="text-muted small text-uppercase fw-semibold" style="font-size:0.7rem;">Pelapor</div>
                                <div class="fw-semibold mt-1 small">{{ $pengaduan->user->name }}</div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="p-3 rounded border bg-light h-100">
                                <div class="text-muted small text-uppercase fw-semibold" style="font-size:0.7rem;">Kategori</div>
                                <div class="fw-semibold mt-1 small">{{ $pengaduan->kategori->nama }}</div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="p-3 rounded border bg-light h-100">
                                <div class="text-muted small text-uppercase fw-semibold" style="font-size:0.7rem;">Lokasi</div>
                                <div class="fw-semibold mt-1 small">
                                    {{ $pengaduan->lokasi->nama_gedung }}
                                    <div class="text-muted fw-normal">{{ $pengaduan->lokasi->nama_ruangan }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="p-3 rounded border bg-light h-100">
                                <div class="text-muted small text-uppercase fw-semibold" style="font-size:0.7rem;">Tanggal Lapor</div>
                                <div class="fw-semibold mt-1 small">
                                    {{ $pengaduan->created_at->format('d M Y') }}
                                    <div class="text-muted fw-normal">{{ $pengaduan->created_at->format('H:i') }} WIB</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="text-muted small text-uppercase fw-semibold mb-2" style="font-size:0.72rem;">Deskripsi Masalah</div>
                        <div class="p-3 rounded border bg-light" style="line-height:1.65;">
                            {{ $pengaduan->deskripsi }}
                        </div>
                    </div>

                    @if($pengaduan->foto)
                        <div class="mb-4">
                            <div class="text-muted small text-uppercase fw-semibold mb-2" style="font-size:0.72rem;">Foto Pendukung</div>
                            <a href="{{ Storage::url($pengaduan->foto) }}" target="_blank" title="Klik untuk memperbesar">
                                <img src="{{ Storage::url($pengaduan->foto) }}" alt="Foto pengaduan"
                                     class="img-thumbnail" style="max-height:380px;">
                            </a>
                            <div class="form-text">Klik gambar untuk membuka ukuran penuh di tab baru.</div>
                        </div>
                    @endif

                    <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                        <a href="{{ route('pengaduan.index') }}" class="btn btn-outline-secondary btn-sm">
                            &larr; Kembali ke Daftar
                        </a>
                        <div class="d-flex gap-2">
                            @can('update', $pengaduan)
                                <a href="{{ route('pengaduan.edit', $pengaduan) }}" class="btn btn-outline-primary btn-sm">
                                    Edit Pengaduan
                                </a>
                            @endcan

                            @can('delete', $pengaduan)
                                <form action="{{ route('pengaduan.destroy', $pengaduan) }}" method="POST"
                                      data-confirm="Hapus pengaduan &quot;{{ Str::limit($pengaduan->judul, 40) }}&quot;? Semua tanggapan terkait juga akan terhapus permanen."
                                      data-confirm-title="Konfirmasi Hapus Pengaduan">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm">Hapus Pengaduan</button>
                                </form>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>

            {{-- Update Status (Admin & Petugas) --}}
            @if(Auth::user()->isStaff())
            <div class="card mb-4">
                <div class="card-header">Ubah Status Pengaduan</div>
                <div class="card-body">
                    <form action="{{ route('pengaduan.status', $pengaduan) }}" method="POST"
                          class="row g-2 align-items-end">
                        @csrf
                        @method('PATCH')
                        <div class="col-sm-8 col-md-9">
                            <label for="status" class="form-label">Status Penanganan</label>
                            <select id="status" name="status" class="form-select">
                                @foreach(\App\Models\Pengaduan::STATUS_LIST as $s)
                                    <option value="{{ $s }}" {{ $pengaduan->status === $s ? 'selected' : '' }}>
                                        {{ ucfirst($s) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-4 col-md-3 d-grid">
                            <button type="submit" class="btn btn-primary">Simpan Status</button>
                        </div>
                    </form>
                </div>
            </div>
            @endif

            {{-- Daftar Tanggapan --}}
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Tanggapan Petugas</span>
                    <span class="badge bg-light text-dark border">{{ $pengaduan->tanggapans->count() }}</span>
                </div>
                <div class="card-body">
                    @if($pengaduan->tanggapans->isEmpty())
                        <div class="text-center py-4 text-muted small">
                            Belum ada tanggapan untuk pengaduan ini.
                        </div>
                    @else
                        @foreach($pengaduan->tanggapans as $t)
                        <div class="d-flex gap-3 {{ !$loop->last ? 'pb-3 mb-3 border-bottom' : '' }}">
                            <div class="rounded-circle bg-light border text-secondary fw-bold d-flex align-items-center justify-content-center flex-shrink-0"
                                 style="width:36px;height:36px;font-size:0.85rem;">
                                {{ strtoupper(substr($t->user->name, 0, 1)) }}
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start gap-2">
                                    <div>
                                        <span class="fw-semibold small">{{ $t->user->name }}</span>
                                        <span class="badge bg-light text-secondary border ms-1" style="font-size:0.7rem;text-transform:capitalize;">
                                            {{ $t->user->role }}
                                        </span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <small class="text-muted">{{ $t->created_at->format('d/m/Y H:i') }}</small>

                                        @if((int) Auth::user()->id === (int) $t->user_id || Auth::user()->isAdmin())
                                            <a href="{{ route('pengaduan.tanggapan.edit', [$pengaduan, $t]) }}"
                                               class="btn btn-sm btn-outline-secondary py-0 px-2" style="font-size:0.75rem;">
                                                Edit
                                            </a>
                                            <form action="{{ route('pengaduan.tanggapan.destroy', [$pengaduan, $t]) }}"
                                                  method="POST"
                                                  data-confirm="Hapus tanggapan ini?"
                                                  data-confirm-title="Konfirmasi Hapus Tanggapan">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger py-0 px-2" style="font-size:0.75rem;">
                                                    Hapus
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                                <div class="mt-2 small text-dark" style="line-height:1.6;">
                                    {{ $t->isi }}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>

            {{-- Form Tambah Tanggapan (Admin & Petugas) --}}
            @if(Auth::user()->isStaff())
            <div class="card">
                <div class="card-header">Tambah Tanggapan</div>
                <div class="card-body">
                    <form action="{{ route('pengaduan.tanggapan.store', $pengaduan) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="isi" class="form-label">Isi Tanggapan <span class="text-danger">*</span></label>
                            <textarea id="isi" name="isi" rows="4"
                                      class="form-control @error('isi') is-invalid @enderror"
                                      placeholder="Tulis tindak lanjut atau keterangan perbaikan...">{{ old('isi') }}</textarea>
                            @error('isi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Kirim Tanggapan</button>
                        </div>
                    </form>
                </div>
            </div>
            @endif

        </div>
    </div>
</div>
@endsection

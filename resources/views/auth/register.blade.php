@extends('layouts.app')

@section('title', 'Daftar Akun')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 78vh;">
        <div class="col-md-6 col-lg-5">

            <div class="mb-4 text-center">
                <h4 class="fw-bold mb-1">Daftar Akun Mahasiswa</h4>
                <p class="text-muted small mb-0">Buat akun untuk mulai melaporkan fasilitas kampus</p>
            </div>

            <div class="card">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input id="name" type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   name="name" value="{{ old('name') }}"
                                   placeholder="Masukkan nama lengkap"
                                   required autocomplete="name" autofocus>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Alamat Email</label>
                            <input id="email" type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   name="email" value="{{ old('email') }}"
                                   placeholder="nama@kampus.ac.id"
                                   required autocomplete="email">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input id="password" type="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   name="password"
                                   placeholder="Minimal 8 karakter"
                                   required autocomplete="new-password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password-confirm" class="form-label">Konfirmasi Password</label>
                            <input id="password-confirm" type="password"
                                   class="form-control"
                                   name="password_confirmation"
                                   placeholder="Ulangi password"
                                   required autocomplete="new-password">
                        </div>

                        <div class="alert alert-light border small text-muted mb-4">
                            Akun yang didaftarkan melalui formulir ini otomatis memiliki peran sebagai <strong>Mahasiswa</strong>.
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Daftar Sekarang</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="text-center mt-3 small">
                <span class="text-muted">Sudah punya akun?</span>
                <a href="{{ route('login') }}" class="fw-semibold text-decoration-none ms-1">Masuk di sini</a>
            </div>

        </div>
    </div>
</div>
@endsection

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIPEDULI &mdash; Sistem Pengaduan Fasilitas Kampus</title>
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Inter:400,500,600,700" rel="stylesheet">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #f8fafc;
            color: #0f172a;
            -webkit-font-smoothing: antialiased;
        }
        .navbar-landing {
            background-color: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 0.85rem 0;
        }
        .brand-mark {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            background-color: #1d4ed8;
            color: #ffffff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.875rem;
        }
        .preview-card {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(15, 23, 42, 0.05);
        }
        .status-pill {
            font-size: 0.72rem;
            font-weight: 600;
            padding: 0.25rem 0.6rem;
            border-radius: 9999px;
            white-space: nowrap;
        }
        .pill-menunggu { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
        .pill-diproses { background: #dbeafe; color: #1e40af; border: 1px solid #bfdbfe; }
        .pill-selesai  { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
        .feature-box {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 1.5rem;
            height: 100%;
        }
    </style>
</head>
<body>

    {{-- Navbar --}}
    <nav class="navbar navbar-expand-md navbar-landing">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center gap-2 text-dark" href="{{ url('/') }}">
                <span class="brand-mark">S</span>
                <span>SIPEDULI</span>
            </a>
            <div class="ms-auto d-flex align-items-center gap-2">
                @guest
                    @if (Route::has('login'))
                        <a class="btn btn-outline-secondary btn-sm" href="{{ route('login') }}">Masuk</a>
                    @endif
                    @if (Route::has('register'))
                        <a class="btn btn-primary btn-sm" href="{{ route('register') }}">Daftar</a>
                    @endif
                @else
                    <a class="btn btn-primary btn-sm" href="{{ route('home') }}">Buka Dashboard</a>
                @endguest
            </div>
        </div>
    </nav>

    {{-- Hero --}}
    <section class="py-5">
        <div class="container py-md-4">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle mb-3 px-3 py-2 fw-semibold">
                        Portal Layanan Fasilitas Kampus
                    </span>
                    <h1 class="display-5 fw-bold mb-3" style="letter-spacing:-0.03em;line-height:1.15;">
                        Pelaporan Kerusakan Fasilitas Kampus yang Terstruktur
                    </h1>
                    <p class="text-secondary fs-6 mb-4" style="line-height:1.7;">
                        SIPEDULI mempermudah mahasiswa melaporkan kerusakan sarana prasarana kampus secara terpusat.
                        Petugas dapat memverifikasi, memperbarui status penanganan, dan memberikan tanggapan secara transparan.
                    </p>
                    <div class="d-flex flex-wrap gap-2">
                        @guest
                            <a href="{{ route('register') }}" class="btn btn-primary px-4 py-2 fw-medium">
                                Daftar Mahasiswa
                            </a>
                            <a href="{{ route('login') }}" class="btn btn-outline-secondary px-4 py-2 fw-medium">
                                Masuk ke Akun
                            </a>
                        @else
                            <a href="{{ route('home') }}" class="btn btn-primary px-4 py-2 fw-medium">
                                Masuk ke Dashboard
                            </a>
                        @endguest
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="preview-card p-4">
                        <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                            <span class="fw-semibold small text-secondary text-uppercase" style="letter-spacing:0.04em;">
                                Contoh Alur Status Laporan
                            </span>
                            <span class="small text-muted">Real-time</span>
                        </div>

                        <div class="d-flex flex-column gap-3">
                            <div class="d-flex justify-content-between align-items-center p-3 rounded border bg-light">
                                <div>
                                    <div class="fw-semibold small">AC Ruang 301 Tidak Dingin</div>
                                    <div class="text-muted" style="font-size:0.78rem;">Gedung A &middot; Pendingin Ruangan</div>
                                </div>
                                <span class="status-pill pill-menunggu">Menunggu</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center p-3 rounded border bg-light">
                                <div>
                                    <div class="fw-semibold small">Lampu Lorong Lantai 2 Mati</div>
                                    <div class="text-muted" style="font-size:0.78rem;">Gedung B &middot; Listrik &amp; Lampu</div>
                                </div>
                                <span class="status-pill pill-diproses">Diproses</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center p-3 rounded border bg-light">
                                <div>
                                    <div class="fw-semibold small">WiFi Lab Komputer 1 Lambat</div>
                                    <div class="text-muted" style="font-size:0.78rem;">Gedung C &middot; Jaringan / WiFi</div>
                                </div>
                                <span class="status-pill pill-selesai">Selesai</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Fitur Utama --}}
            <div class="row g-4 mt-5">
                <div class="col-md-4">
                    <div class="feature-box">
                        <h6 class="fw-bold mb-2">Pelaporan Terarah</h6>
                        <p class="text-secondary small mb-0">
                            Setiap laporan terhubung ke kategori dan lokasi gedung/ruangan yang jelas serta dapat disertai bukti foto.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-box">
                        <h6 class="fw-bold mb-2">Transparansi Status</h6>
                        <p class="text-secondary small mb-0">
                            Pantau perkembangan laporan mulai dari Menunggu, Diproses, hingga Selesai beserta tanggapan resmi petugas.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-box">
                        <h6 class="fw-bold mb-2">Kontrol Akses Berbasis Peran</h6>
                        <p class="text-secondary small mb-0">
                            Pemisahan hak akses antara Mahasiswa, Petugas, dan Administrator untuk menjaga integritas data.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="border-top bg-white py-3 mt-5">
        <div class="container text-center text-muted small">
            &copy; {{ date('Y') }} <strong>SIPEDULI</strong> &mdash; Sistem Pengaduan Fasilitas Kampus
        </div>
    </footer>

</body>
</html>

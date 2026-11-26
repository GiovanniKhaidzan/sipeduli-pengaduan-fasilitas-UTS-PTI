<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Sistem Pengaduan Fasilitas Kampus') — {{ config('app.name', 'SIPEDULI') }}</title>

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Inter:400,500,600,700" rel="stylesheet">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        :root {
            --sp-bg: #f6f8fa;
            --sp-surface: #ffffff;
            --sp-border: #e5e7eb;
            --sp-text: #111827;
            --sp-muted: #6b7280;
            --sp-primary: #1d4ed8;
            --sp-primary-hover: #1e40af;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: var(--sp-bg);
            color: var(--sp-text);
            -webkit-font-smoothing: antialiased;
        }

        /* ===== NAVBAR CLEAN ===== */
        .navbar-sipeduli {
            background-color: var(--sp-surface);
            border-bottom: 1px solid var(--sp-border);
            padding: 0.65rem 0;
        }

        .navbar-sipeduli .navbar-brand {
            font-weight: 700;
            font-size: 1.125rem;
            letter-spacing: -0.02em;
            color: var(--sp-text);
        }

        .brand-mark {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            background-color: var(--sp-primary);
            color: #ffffff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.875rem;
        }

        .navbar-sipeduli .nav-link {
            color: var(--sp-muted);
            font-weight: 500;
            font-size: 0.9rem;
            padding: 0.45rem 0.85rem;
            border-radius: 6px;
            transition: color 0.15s ease, background-color 0.15s ease;
        }

        .navbar-sipeduli .nav-link:hover {
            color: var(--sp-text);
            background-color: #f3f4f6;
        }

        .navbar-sipeduli .nav-link.active {
            color: var(--sp-primary);
            background-color: #eff6ff;
            font-weight: 600;
        }

        /* ===== LAYOUT ===== */
        main.app-main {
            min-height: calc(100vh - 128px);
            padding: 1.75rem 0 2.5rem;
        }

        /* ===== CARD ===== */
        .card {
            background-color: var(--sp-surface);
            border: 1px solid var(--sp-border);
            border-radius: 10px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
        }

        .card-header {
            background-color: var(--sp-surface);
            color: var(--sp-text);
            font-weight: 600;
            font-size: 0.95rem;
            border-bottom: 1px solid var(--sp-border);
            border-radius: 10px 10px 0 0 !important;
            padding: 0.9rem 1.25rem;
        }

        .card-body {
            padding: 1.25rem;
        }

        /* ===== BUTTONS ===== */
        .btn {
            border-radius: 7px;
            font-weight: 500;
            font-size: 0.875rem;
            padding: 0.48rem 0.95rem;
        }

        .btn-sm {
            border-radius: 6px;
            font-size: 0.8rem;
            padding: 0.3rem 0.65rem;
        }

        .btn-primary {
            background-color: var(--sp-primary);
            border-color: var(--sp-primary);
        }

        .btn-primary:hover, .btn-primary:focus {
            background-color: var(--sp-primary-hover);
            border-color: var(--sp-primary-hover);
        }

        /* ===== FORM CONTROLS ===== */
        .form-label {
            font-weight: 500;
            font-size: 0.875rem;
            color: #374151;
            margin-bottom: 0.4rem;
        }

        .form-control, .form-select {
            border-radius: 7px;
            padding: 0.55rem 0.8rem;
            border: 1px solid #d1d5db;
            font-size: 0.9rem;
            color: var(--sp-text);
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--sp-primary);
            box-shadow: 0 0 0 3px rgba(29, 78, 216, 0.12);
        }

        /* ===== ALERTS ===== */
        .alert {
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 500;
            padding: 0.85rem 1rem;
        }

        /* ===== STATUS BADGES (SOFT PILLS) ===== */
        .badge-status {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            font-weight: 600;
            font-size: 0.75rem;
            padding: 0.3rem 0.65rem;
            border-radius: 9999px;
        }

        .badge-menunggu {
            background-color: #fef3c7 !important;
            color: #92400e !important;
            border: 1px solid #fde68a;
        }
        .badge-diproses {
            background-color: #dbeafe !important;
            color: #1e40af !important;
            border: 1px solid #bfdbfe;
        }
        .badge-selesai {
            background-color: #d1fae5 !important;
            color: #065f46 !important;
            border: 1px solid #a7f3d0;
        }
        .badge-ditolak {
            background-color: #fee2e2 !important;
            color: #991b1b !important;
            border: 1px solid #fecaca;
        }

        /* ===== TABLE ===== */
        .table > :not(caption) > * > * {
            padding: 0.8rem 1rem;
            vertical-align: middle;
            border-bottom-color: var(--sp-border);
        }

        .table thead th {
            background-color: #f9fafb;
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            color: var(--sp-muted);
            border-bottom: 1px solid var(--sp-border);
        }

        /* ===== STAT CARDS ===== */
        .stat-link-card {
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
        }

        .stat-link-card:hover {
            border-color: #cbd5e1;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        /* ===== FOOTER ===== */
        footer.app-footer {
            background-color: var(--sp-surface);
            border-top: 1px solid var(--sp-border);
            padding: 1rem 0;
            text-align: center;
            color: var(--sp-muted);
            font-size: 0.825rem;
        }
    </style>

    @stack('styles')
</head>
<body>
<div id="app">

    {{-- ===== NAVBAR ===== --}}
    <nav class="navbar navbar-expand-md navbar-sipeduli sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ url('/') }}">
                <span class="brand-mark">S</span>
                <span>SIPEDULI</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-label="Toggle navigasi">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarMain">
                {{-- Navigasi Utama --}}
                <ul class="navbar-nav me-auto ms-md-4 gap-1">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                                Dashboard
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('pengaduan.*') ? 'active' : '' }}" href="{{ route('pengaduan.index') }}">
                                Pengaduan
                            </a>
                        </li>

                        @if(Auth::user()->isAdmin())
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('kategori.*') ? 'active' : '' }}" href="{{ route('kategori.index') }}">
                                    Kategori
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('lokasi.*') ? 'active' : '' }}" href="{{ route('lokasi.index') }}">
                                    Lokasi
                                </a>
                            </li>
                        @endif
                    @endauth
                </ul>

                {{-- Menu Kanan: Profil & Tombol Keluar --}}
                <ul class="navbar-nav ms-auto align-items-md-center gap-2 mt-2 mt-md-0">
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Masuk</a>
                            </li>
                        @endif
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="btn btn-primary btn-sm" href="{{ route('register') }}">Daftar</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item d-flex align-items-center gap-2 me-md-2">
                            <span class="rounded-circle bg-light border text-secondary fw-semibold d-inline-flex align-items-center justify-content-center"
                                  style="width:32px;height:32px;font-size:0.8rem;">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </span>
                            <div class="lh-sm">
                                <div class="fw-semibold" style="font-size:0.85rem;">{{ Auth::user()->name }}</div>
                                <div class="text-muted" style="font-size:0.72rem;text-transform:capitalize;">{{ Auth::user()->role }}</div>
                            </div>
                        </li>

                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger btn-sm d-inline-flex align-items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    Keluar
                                </button>
                            </form>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    {{-- ===== KONTEN UTAMA ===== --}}
    <main class="app-main">
        <div class="container">
            {{-- Alert otomatis untuk setiap proses CRUD, login, logout, dan validasi --}}
            @include('partials.alerts')
        </div>

        @yield('content')
    </main>

    {{-- ===== FOOTER ===== --}}
    <footer class="app-footer">
        <div class="container">
            &copy; {{ date('Y') }} <strong>SIPEDULI</strong> &mdash; Sistem Pengaduan Fasilitas Kampus
        </div>
    </footer>

</div>

{{-- ===== MODAL KONFIRMASI HAPUS (ALERT SEBELUM HAPUS CRUD) ===== --}}
<div class="modal fade" id="confirmActionModal" tabindex="-1" aria-labelledby="confirmActionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" style="max-width:420px;">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom-0 pb-0">
                <h6 class="modal-title fw-bold text-danger" id="confirmActionModalLabel">Konfirmasi Penghapusan</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body py-3">
                <p class="mb-0 text-secondary" id="confirmActionMessage" style="font-size:0.9rem;">
                    Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.
                </p>
            </div>
            <div class="modal-footer border-top-0 pt-0">
                <button type="button" class="btn btn-light border btn-sm" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger btn-sm" id="confirmActionBtn">Ya, Hapus</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Handler modal konfirmasi terpusat untuk form dengan atribut data-confirm
    document.addEventListener('DOMContentLoaded', function () {
        let pendingForm = null;
        const modalEl = document.getElementById('confirmActionModal');
        const titleEl = document.getElementById('confirmActionModalLabel');
        const msgEl   = document.getElementById('confirmActionMessage');
        const btnEl   = document.getElementById('confirmActionBtn');

        document.addEventListener('submit', function (e) {
            const form = e.target;
            if (!form.dataset.confirm || form.dataset.confirmed === 'true') {
                return;
            }

            e.preventDefault();
            pendingForm = form;

            titleEl.textContent = form.dataset.confirmTitle || 'Konfirmasi Penghapusan';
            msgEl.textContent   = form.dataset.confirm;
            btnEl.textContent   = form.dataset.confirmBtn || 'Ya, Hapus';

            if (window.bootstrap && window.bootstrap.Modal) {
                window.bootstrap.Modal.getOrCreateInstance(modalEl).show();
            } else if (window.confirm(form.dataset.confirm)) {
                form.dataset.confirmed = 'true';
                form.submit();
            }
        });

        if (btnEl) {
            btnEl.addEventListener('click', function () {
                if (pendingForm) {
                    pendingForm.dataset.confirmed = 'true';
                    pendingForm.submit();
                }
            });
        }

        // Auto-tutup alert sukses/info setelah 5 detik agar tampilan tetap rapi
        setTimeout(function () {
            document.querySelectorAll('.alert-success, .alert-info').forEach(function (alertEl) {
                if (window.bootstrap && window.bootstrap.Alert) {
                    window.bootstrap.Alert.getOrCreateInstance(alertEl).close();
                }
            });
        }, 5000);
    });
</script>

@stack('scripts')
</body>
</html>

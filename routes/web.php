<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\TanggapanController;

// ===== HALAMAN PUBLIK =====
Route::get('/', function () {
    return view('welcome');
});

// ===== AUTH ROUTES (login, register, logout, dll) =====
Auth::routes();

// ===== SEMUA ROUTE YANG BUTUH LOGIN =====
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // ===== KHUSUS ADMIN =====
    // Hanya admin yang bisa kelola Kategori dan Lokasi
    Route::middleware('role:admin')->group(function () {
        Route::resource('kategori', KategoriController::class);
        Route::resource('lokasi', LokasiController::class);
    });

    // ===== CRUD PENGADUAN =====
    Route::resource('pengaduan', PengaduanController::class);

    // ===== KHUSUS ADMIN & PETUGAS (Update Status) =====
    Route::patch('pengaduan/{pengaduan}/status', [PengaduanController::class, 'updateStatus'])
        ->name('pengaduan.status')
        ->middleware('role:admin,petugas');

    // ===== TANGGAPAN (Nested Resource) =====
    Route::resource('pengaduan.tanggapan', TanggapanController::class)
        ->only(['store', 'edit', 'update', 'destroy'])
        ->middleware('role:admin,petugas');

});

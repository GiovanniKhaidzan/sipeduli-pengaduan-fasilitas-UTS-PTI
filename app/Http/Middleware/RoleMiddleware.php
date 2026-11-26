<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware untuk membatasi akses berdasarkan peran (role) pengguna.
 * Cara pakai di route: middleware('role:admin') atau middleware('role:admin,petugas')
 */
class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Pastikan pengguna sudah login
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Periksa apakah role pengguna ada dalam daftar role yang diizinkan
        if (!in_array(auth()->user()->role, $roles)) {
            // Jika tidak punya hak akses, kembalikan 403 Forbidden
            abort(403, 'Kamu tidak memiliki hak akses ke halaman ini.');
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Halaman tujuan setelah login berhasil.
     */
    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Tampilkan alert selamat datang setelah berhasil login.
     */
    protected function authenticated(Request $request, $user)
    {
        session()->flash('success', 'Berhasil masuk. Selamat datang, ' . $user->name . '.');
    }

    /**
     * Tampilkan alert setelah logout berhasil.
     */
    protected function loggedOut(Request $request)
    {
        return redirect()->route('login')
                         ->with('info', 'Anda telah keluar dari akun.');
    }
}

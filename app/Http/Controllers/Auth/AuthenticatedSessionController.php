<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Menampilkan halaman login.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Menangani permintaan autentikasi.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        /**
         * LOGIKA REDIRECT BERDASARKAN ROLE
         * Kita pastikan pengecekan role dilakukan secara ketat.
         */
        $user = Auth::user();

        // Redirect admin users to the admin dashboard (case-insensitive role matching)
        if (isset($user->role) && strcasecmp($user->role, 'admin') === 0) {
            return redirect()->route('admin.dashboard');
        }

        // Untuk user biasa, gunakan intended agar jika mereka klik HPP/Checker
        // sebelum login, mereka langsung balik ke fitur tersebut.
        return redirect()->intended(route('welcome', absolute: false));
    }

    /**
     * Menghancurkan sesi autentikasi (Logout).
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
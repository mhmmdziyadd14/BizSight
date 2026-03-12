<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAppApproved
{
    /**
     * Menangani permintaan masuk.
     * Memastikan user sudah di-approve admin atau memiliki role admin.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            // Izinkan Admin lewat tanpa cek approval
            if (auth()->user()->role === 'admin') {
                return $next($request);
            }

            // Cek approval untuk user biasa
            if (!auth()->user()->is_approved) {
                return response()->view('errors.waiting_approval');
            }
        }

        return $next($request);
    }
    public function index()
    {
        // Proteksi tambahan: Jika bukan admin, tendang balik
        if (auth()->user()->role !== 'admin') {
            return redirect('/dashboard');
        }

        $users = \App\Models\User::where('role', 'user')->get();
        $calculations = \App\Models\BusinessCalculation::with('user')->latest()->get();

        return view('admin.dashboard', compact('users', 'calculations'));
    }
}
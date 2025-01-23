<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        // Cek apakah user sudah login dan memiliki role yang sesuai
        if (Auth::check()) {
            if (Auth::user()->role !== $role) {
                // Jika role tidak sesuai, arahkan ke halaman utama atau error
                return redirect('/')->with('error', 'Akses ditolak. Anda tidak memiliki izin untuk mengakses halaman ini.');
            }
        } else {
            // Jika belum login, arahkan ke halaman login
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        return $next($request);
    }
}

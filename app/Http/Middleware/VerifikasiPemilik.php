<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class VerifikasiPemilik
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 1) {
            if (Auth::user()->status_verifikasi === 'menunggu') {
                Auth::logout();
                return redirect('/login')->withErrors([
                    'verifikasi' => 'Akun Anda belum diverifikasi oleh admin.',
                ]);
            }
            if (Auth::user()->status_verifikasi === 'ditolak') {
                Auth::logout();
                return redirect('/login')->withErrors([
                    'verifikasi' => 'Akun Anda telah ditolak oleh admin.',
                ]);
            }
        }

        return $next($request);
    }
}


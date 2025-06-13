<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Support\Facades\Auth;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $user = Auth::user();

        // Cegah login jika pemilik belum disetujui
        if ($user->role == 1 && $user->status_verifikasi !== 'disetujui') {
            Auth::logout();

            return redirect()->route('login')->withErrors([
                'email' => 'Akun Anda belum diverifikasi oleh admin.',
            ]);
        }

        // Redirect sesuai role
        if ($user->role == '0') {
            return redirect()->route('admin');
        } elseif ($user->role == '1') {
            return redirect()->route('pemilik');
        } else {
            return redirect()->route('dashboard');
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // Tampilkan form register pemilik
    public function showRegisterPemilik()
    {
        return view('auth.register_pemilik');
    }

    // Proses pendaftaran pemilik
    public function registerPemilik(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
            'nik' => 'required|string|max:20',
            'alamat' => 'required|string',
            'foto_ktp' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Simpan foto KTP
        $fotoKTP = $request->file('foto_ktp')->store('ktp', 'public');

        // Ambil nama filenya saja (tanpa folder public/foto_ktp)
        $filename = basename($fotoKTP);


        // Buat user baru
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => '1', // pemilik
            'nik' => $request->nik,
            'alamat' => $request->alamat,
            'foto_ktp' => $filename,
            'status_verifikasi' => 'menunggu'
        ]);

        return redirect()->route('login')->with('success', 'Pendaftaran berhasil. Tunggu verifikasi dari admin.');
    }
}


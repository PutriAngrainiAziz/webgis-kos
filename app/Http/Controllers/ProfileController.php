<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function show()
    {
        return view('pengguna.profile.profile');
    }
    
    public function edit()
    {
        $user = Auth::user();

        // Mapping angka ke nama role
        $roleMap = [
            0 => 'admin',
            1 => 'pemilik',
            2 => 'pengguna',
        ];

        $roleName = $roleMap[$user->role] ?? 'unknown';

        switch ($roleName) {
            case 'admin':
                return view('admin.profile.edit', compact('user', 'roleName'));
            case 'pemilik':
                return view('pemilik.profile.edit', compact('user', 'roleName'));
            case 'pengguna':
                return view('pengguna.profile.edit', compact('user', 'roleName'));
            default:
                abort(403);
        }
    }


    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Kalau kamu tambahkan password di validasi:
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // Arahkan ke route edit sesuai role
        $redirectRoute = match ((int)$user->role) {
            0 => 'profile.edit.admin',
            1 => 'profile.edit.pemilik',
            2 => 'profile.edit.user',
            default => 'home', // fallback kalau role tidak dikenal
        };

        return Redirect::route($redirectRoute)->with('success', 'Profil berhasil diperbarui');

    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}

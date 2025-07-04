<?php

namespace App\Http\Controllers\Pengguna;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Kos;

class PenggunaMainController extends Controller
{
    public function index(){
        return view('pengguna.dashboard');
    }

    public function tambahFavorit($id)
    {
        /** @var User $user */
        $user = auth()->user();
        $user->favoritKos()->syncWithoutDetaching([$id]);
        return back()->with('success', 'Kos ditambahkan ke favorit.');
    }

    public function hapusFavorit($id)
    {
        /** @var User $user */
        $user = auth()->user();
        $user->favoritKos()->detach($id);
        return back()->with('success', 'Kos dihapus dari favorit.');
    }

    public function daftarFavorit()
    {
        $user = auth()->user();
        $kosFavorit = $user->favoritKos; // relasi many-to-many
        return view('pengguna.favorit', compact('kosFavorit'));
    }

}

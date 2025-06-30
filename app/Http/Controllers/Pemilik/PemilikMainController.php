<?php

namespace App\Http\Controllers\Pemilik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kos;
use Illuminate\Support\Facades\Auth;

class PemilikMainController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $kosList = Kos::where('user_id', $userId)->get();
        $totalKos = $kosList->count();
        $kosAktif = $kosList->where('status', 'aktif')->count();
        $kosNonaktif = $kosList->where('status', 'nonaktif')->count();
        $kosTerverifikasi = $kosList->where('status_verifikasi', 'disetujui')->count();
        $kosBelumTerverifikasi = $kosList->where('status_verifikasi', 'menunggu')->count();

        return view('pemilik.dashboard', compact('kosList', 'totalKos', 'kosAktif', 'kosNonaktif', 'kosTerverifikasi', 'kosBelumTerverifikasi'));
    }
}

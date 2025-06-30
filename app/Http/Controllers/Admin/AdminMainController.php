<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Kos;

use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminMainController extends Controller
{
    public function index()
    {
        $totalPemilik = User::where('role', 1)->count();
        $totalPengguna = User::where('role', 2)->count();
        $totalKos = Kos::count();
        $totalKosAktif = Kos::where('status', 'aktif')->count();
        $totalKosNonaktif = Kos::where('status', 'nonaktif')->count();
        $totalKosTerverifikasi = Kos::where('status_verifikasi', 'disetujui')->count();
        $totalKosBelumTerverifikasi = Kos::where('status_verifikasi', 'menunggu')->count();

        $kosList = Kos::all();

        return view('admin.admin', compact(
            'totalKos',
            'totalKosAktif',
            'totalKosNonaktif',
            'totalKosTerverifikasi',
            'totalKosBelumTerverifikasi',
            'totalPemilik',
            'totalPengguna',
            'kosList'
        ));
    }


    public function daftarKos()
    {
        $kosList = Kos::with('user')->get();
        return view('admin.daftar_kos', compact('kosList'));
    }

    public function daftarPengguna()
    {
        $pengguna = User::where('role', 2)->get();
        return view('admin.daftar_pengguna', compact('pengguna'));
    }

    public function verifikasiPemilik()
    {
        $pemiliks = User::where('role', 1)->where('status_verifikasi', 'menunggu')->get();
        return view('admin.verifikasi_pemilik', compact('pemiliks'));
    }

    public function setujuiPemilik($id)
    {
        $pemilik = User::findOrFail($id);
        $pemilik->status_verifikasi = 'disetujui';
        $pemilik->save();

        return redirect()->back()->with('success', 'Pemilik berhasil disetujui.');
    }


    public function tolakPemilik($id)
    {
        $pemilik = User::findOrFail($id);
        $pemilik->status_verifikasi = 'ditolak';
        $pemilik->save();

        return redirect()->back()->with('success', 'Pemilik berhasil ditolak.');
    }

    public function daftarPemilikDisetujui()
    {
        $pemiliks = User::where('role', 1)->where('status_verifikasi', 'disetujui')->get();
        return view('admin.daftar_pemilik_disetujui', compact('pemiliks'));
    }

    public function hapusPemilik($id)
    {
        $pemilik = User::where('role', 1)->where('status_verifikasi', 'disetujui')->findOrFail($id);

        // Hapus file KTP dari storage jika ada
        if ($pemilik->foto_ktp && Storage::exists('public/ktp/' . $pemilik->foto_ktp)) {
            Storage::delete('public/ktp/' . $pemilik->foto_ktp);
        }

        // Hapus data dari database
        $pemilik->delete();

        return redirect()->back()->with('success', 'Pemilik berhasil dihapus.');
    }



    public function hapusPengguna($id)
    {
        $user = User::where('role', 2)->findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'Pengguna berhasil dihapus.');
    }
}

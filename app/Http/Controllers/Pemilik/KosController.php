<?php

namespace App\Http\Controllers\Pemilik;

use App\Models\Kos;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class KosController extends Controller
{
    /**
     * Tampilan Utama
     */
    public function petaKos()
    {
        $kosList = Kos::where('status', 'aktif')
                        ->where('status_verifikasi', 'disetujui')
                        ->get();
        return view('welcome', compact('kosList'));
    }

    /**
     * Display a listing of the resource.
     */
    public function peta_kos()
    {
        $userId = Auth::id();

        $kosList = Kos::where('user_id', $userId)->get();
        $totalKos = $kosList->count();
        $kosAktif = $kosList->where('status', 'aktif')->count();
        $kosNonaktif = $kosList->where('status', 'nonaktif')->count();

        return view('pemilik.kelolakos.peta_kos', compact('kosList', 'totalKos', 'kosAktif', 'kosNonaktif'));
    }

    public function daftar_kos(Request $request)
    {
        $keyword = $request->input('keyword');
        $query = Kos::where('user_id', Auth::id());

        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('nama_kos', 'like', "%{$keyword}%")
                ->orWhere('alamat', 'like', "%{$keyword}%")
                ->orWhere('harga_sewa', 'like', "%{$keyword}%")
                ->orWhere('tipe_kamar', 'like', "%{$keyword}%")
                ->orWhere('fasilitas', 'like', "%{$keyword}%")
                ->orWhere('nomor_kontak', 'like', "%{$keyword}%");
            });
        }

        $data_kos = $query->get();

        return view('pemilik.kelolakos.tampil_kos', compact('data_kos', 'keyword'));
    }




    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pemilik.kelolakos.tambah_kos');
    }

    // public function tambah_kos()
    // {
    //     return view('pemilik.kelolakos.tambah_kos'); // atau nama view yang sesuai
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_kos' => 'required|string',
            'alamat' => 'required|string',
            'harga_sewa' => 'required|integer|min:0',
            'tipe_kamar' => 'required|string',
            'fasilitas' => 'nullable|string',
            'nomor_kontak' => 'required|string',
            'status' => 'required|in:aktif,nonaktif',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'foto' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('foto_kos', 'public');  // simpan di storage/app/public/foto_kos
            $data['foto'] = basename($path); // ambil nama file saja tanpa folder
        }

        $data['user_id'] = Auth::id();
        $data['status_verifikasi'] = 'menunggu';

        Kos::create($data);


        return redirect()->route('kelolakos.tampil_kos')
        ->with('success', 'Kos berhasil ditambahkan dan menunggu verifikasi admin.');
    }



    /**
     * Display the specified resource.
     */
    public function show(Kos $kos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kos $kos)
    {
        return view('pemilik.kelolakos.edit_kos', compact('kos'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, Kos $kos)
    {
        // Validasi input
        $request->validate([
            'nama_kos' => 'required|string',
            'alamat' => 'required|string',
            'harga_sewa' => 'required|integer|min:0',
            'tipe_kamar' => 'required|string',
            'fasilitas' => 'nullable|string',
            'nomor_kontak' => 'required|string',
            'status' => 'required|in:aktif,nonaktif',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'foto' => 'nullable|image|max:2048',
        ]);

        // Siapkan data untuk update
        $data = $request->only([
            'nama_kos',
            'alamat',
            'harga_sewa',
            'tipe_kamar',
            'fasilitas',
            'nomor_kontak',
            'status',
            'latitude',
            'longitude',
        ]);

        // Jika ada foto baru, simpan dan update path foto
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('public/foto_kos');
            $data['foto'] = str_replace('public/', '', $path);
        }


        // Update data kos sekaligus
        $kos->update($data);

        return redirect()->route('kelolakos.tampil_kos')->with('success', 'Kos berhasil diperbarui!');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kos $kos)
    {
        if ($kos->user_id !== Auth::id()) {
            abort(403, 'Anda tidak punya akses untuk menghapus kos ini.');
        }
        $kos->delete();

        return redirect()->route('kelolakos.tampil_kos')->with('success', 'Kos berhasil dihapus!');
    }


    public function ubahStatus(Kos $kos)
    {
        if ($kos->user_id != Auth::id()) {
            abort(403); // Mencegah akses kos milik orang lain
        }

        $kos->status = $kos->status === 'aktif' ? 'nonaktif' : 'aktif';
        $kos->save();

        return back()->with('success', 'Status kos berhasil diubah.');
    }

    /**
     * Detail Kos Selengkapnya
     */
    public function detailKos($id)
    {
        $kos = Kos::findOrFail($id); // pastikan model Kos sudah di-import
        return view('detail_kos', compact('kos'));
    }

    public function verifikasiKos()
    {
        $kosMenunggu = Kos::where('status_verifikasi', 'menunggu')->get();
        return view('admin.kos.verifikasi', compact('kosMenunggu'));
    }

    public function verifikasiKosdiSetujui($id)
    {
        Kos::where('id', $id)->update(['status_verifikasi' => 'disetujui']);
        return back()->with('success', 'Kos disetujui.');
    }

    public function verifikasiKosTolak($id)
    {
        Kos::where('id', $id)->update(['status_verifikasi' => 'ditolak']);
        return back()->with('success', 'Kos ditolak.');
    }
}

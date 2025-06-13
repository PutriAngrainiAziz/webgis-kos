@extends('pemilik.layouts.layout')

@section('css')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
    crossorigin="" />
@endsection

@section('tampil_kos')
<div class="container">
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
        <!-- Ringkasan -->
        <div class="card bg-light px-3 py-2 mb-2 d-flex flex-wrap gap-2" style="min-width:250px;">
            <span><strong>Total Kos:</strong> {{ $data_kos->count() }}</span>
            <span><strong>Aktif:</strong> {{ $data_kos->where('status', 'aktif')->count() }}</span>
            <span><strong>Nonaktif:</strong> {{ $data_kos->where('status', 'nonaktif')->count() }}</span>
        </div>

        <!-- Tombol Aksi -->
        <div class="d-flex flex-column align-items-end ms-auto">
            <div class="mb-3 d-flex gap-3">
                <a href="{{ route('kelolakos.peta_kos') }}" title="Lihat Peta Kos">
                    <img src="{{ asset('pemilik_asset/icon/petaicon.svg') }}" alt="Peta" style="width: 80px; height: 80px; cursor: pointer;">
                </a>

                <a href="{{ route('kelolakos.tambah_kos') }}" title="Tambah Data" class="btn btn-primary align-self-center">
                    <img src="{{ asset('pemilik_asset/icon/tambah.svg') }}" alt="Tambah" style="width: 30px; height: 30px; cursor: pointer;">
                    <span><strong>Tambah</strong></span>
                </a>
            </div>
            <!-- Form Pencarian -->
            <form action="{{ route('kelolakos.tampil_kos') }}" method="GET" class="d-flex">
                <input type="text" name="keyword" class="form-control rounded-start" placeholder="Cari kos..." value="{{ request('keyword') }}">
                <button type="submit" class="btn btn-outline-secondary rounded-end">Cari</button>
            </form>
        </div>
        </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Kos</th>
                <th>Alamat</th>
                <th>Harga Sewa</th>
                <th>Tipe Kamar</th>
                <th>Kontak</th>
                <th>Foto</th>
                <th>Status</th>
                <th>Status Verifikasi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data_kos as $kos)
            <tr>
                <td>{{ $kos->nama_kos }}</td>
                <td>{{ $kos->alamat }}</td>
                <td>Rp{{ number_format($kos->harga_sewa, 0, ',', '.') }}</td>
                <td>{{ ucfirst($kos->tipe_kamar) }}</td>
                <td>{{ $kos->nomor_kontak }}</td>
                <td>
                    @if($kos->foto)
                    <img src="{{ asset('storage/foto_kos/' . $kos->foto) }}" width="100" alt="Gambar tidak tersedia">
                    @else
                    Tidak ada foto
                    @endif
                </td>
                <td>
                    <form action="{{ route('kelolakos.ubah_status', $kos->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="badge bg-{{ $kos->status == 'aktif' ? 'success' : 'danger' }}" style="border: none; border-radius:5px; ">
                            {{ ucfirst($kos->status) }}
                        </button>
                    </form>
                </td>
                <td>{{ $kos->status_verifikasi }}</td>
                <td>
                    <div class="d-flex gap-2">
                        <!-- Edit -->
                        <a href="{{ route('kelolakos.edit_kos', $kos->id) }}" title="Edit" class="text-warning">
                            <i class="bi bi-pencil-square fs-5"></i>
                        </a>

                        <!-- Hapus -->
                        <form action="{{ route('kelolakos.destroy', $kos->id) }}" method="POST" onsubmit="return confirm('Yakin hapus kos ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" title="Hapus" class="btn p-0 border-0 bg-transparent text-danger">
                                <i class="bi bi-trash fs-5"></i>
                            </button>
                        </form>
                    </div>

                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center">
                    @if(request()->has('keyword') && request()->get('keyword') != '')
                        Tidak ditemukan kos dengan kata kunci: "<strong>{{ request()->get('keyword') }}</strong>"
                    @else
                        Belum ada kos yang ditambahkan.
                    @endif
                </td>
            </tr>
            @endforelse

        </tbody>
    </table>
</div>
@endsection

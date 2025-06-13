@extends('admin.layouts.layout')

@section('admin_page_title')
    Daftar Kos
@endsection

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4 fw-semibold text-primary d-flex align-items-center" style="gap: 10px;">
            <i class="bi bi-house-door-fill" style="font-size: 1.5rem;"></i>
            Data Kos
        </h2>


        <div class="table-responsive">
            <table class="table table-bordered table-hover text-center align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Kos</th>
                        <th>Alamat</th>
                        <th>Harga Sewa</th>
                        <th>Tipe</th>
                        <th>Fasilitas</th>
                        <th>Nomor Kontak</th>
                        <th>Status</th>
                        <th>Foto</th>
                        <th>Pemilik</th>
                        <th>Status Verifikasi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kosList as $index => $kos)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $kos->nama_kos }}</td>
                            <td>{{ $kos->alamat }}</td>
                            <td>Rp{{ number_format($kos->harga_sewa, 0, ',', '.') }}</td>
                            <td>{{ $kos->tipe_kamar }}</td>
                            <td>{{ $kos->fasilitas ?? '-' }}</td>
                            <td>{{ $kos->nomor_kontak }}</td>
                            <td>
                                <span class="badge bg-{{ $kos->status === 'aktif' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($kos->status) }}
                                </span>
                            </td>
                            <td>
                                @if($kos->foto)
                                    <img src="{{ asset('storage/foto_kos/' . $kos->foto) }}" width="100" class="img-fluid rounded" alt="Foto Kos">
                                @else
                                    <span class="text-muted">Tidak ada foto</span>
                                @endif
                            </td>
                            <td>{{ $kos->user->name ?? '-' }}</td>
                            <td>{{ $kos->status_verifikasi }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

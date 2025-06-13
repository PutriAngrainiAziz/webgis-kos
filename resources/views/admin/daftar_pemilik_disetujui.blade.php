@extends('admin.layouts.layout')

@section('admin_page_title')
    Daftar Pemilik Disetujui
@endsection

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4 fw-bold text-success d-flex align-items-center" style="gap: 10px;">
            <i class="bi bi-patch-check-fill" style="font-size: 1.5rem;"></i>
            Data Pemilik Kos Terverifikasi
        </h2>


        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-striped text-center align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>NIK</th>
                        <th>Alamat</th>
                        <th>Foto KTP</th>
                        <th>Status Verifikasi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pemiliks as $index => $pemilik)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $pemilik->name }}</td>
                            <td>{{ $pemilik->email }}</td>
                            <td>{{ $pemilik->nik }}</td>
                            <td>{{ $pemilik->alamat }}</td>
                            <td>
                                @if($pemilik->foto_ktp)
                                    <img src="{{ asset('storage/ktp/' . $pemilik->foto_ktp) }}" width="100">
                                @else
                                    Tidak ada
                                @endif
                            </td>
                            <td><span class="badge bg-success">{{ ucfirst($pemilik->status_verifikasi) }}</span></td>
                            <td>
                                <form method="POST" action="{{ route('admin.pemilik.destroy', $pemilik->id) }}" onsubmit="return confirm('Yakin ingin menghapus pemilik ini?')" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

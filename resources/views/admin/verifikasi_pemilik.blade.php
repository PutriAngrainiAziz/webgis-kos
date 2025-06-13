@extends('admin.layouts.layout')

@section('admin_page_title')
    Verifikasi Pemilik
@endsection

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 fw-bold text-warning d-flex align-items-center" style="gap: 10px;">
        <i class="bi bi-shield-exclamation" style="font-size: 1.5rem;"></i>
        Verifikasi Pemilik Kos
    </h2>


    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>NIK</th>
                    <th>Alamat</th>
                    <th>Foto KTP</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pemiliks as $pemilik)
                    <tr>
                        <td>{{ $pemilik->name }}</td>
                        <td>{{ $pemilik->email }}</td>
                        <td>{{ $pemilik->nik }}</td>
                        <td>{{ $pemilik->alamat }}</td>
                        <td class="text-center">
                            @if($pemilik->foto_ktp)
                                <img src="{{ asset('storage/ktp/' . $pemilik->foto_ktp) }}" width="100" class="img-thumbnail" alt="KTP {{ $pemilik->name }}">
                            @else
                                <span class="text-muted">Tidak ada foto</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <span class="badge bg-warning text-dark">{{ ucfirst($pemilik->status_verifikasi) }}</span>
                        </td>
                        <td class="text-center">
                            <form method="POST" action="{{ route('admin.verifikasi.pemilik.setujui', $pemilik->id) }}" style="display:inline-block;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-success" title="Setujui">
                                    <i class="bi bi-check-circle"></i> Setujui
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.verifikasi.pemilik.tolak', $pemilik->id) }}" style="display:inline-block;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin tolak akun ini?')" title="Tolak">
                                    <i class="bi bi-x-circle"></i> Tolak
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">Belum ada pemilik yang menunggu verifikasi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

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
                            <div class="d-flex justify-content-center gap-2">
                                <form method="POST" action="{{ route('admin.verifikasi.pemilik.setujui', $pemilik->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-success" title="Setujui">
                                        <i class="bi bi-check-circle"></i> Setujui
                                    </button>
                                </form>
                                <form id="form-tolak-{{ $pemilik->id }}" action="{{ route('admin.verifikasi.pemilik.tolak', $pemilik->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="button" class="btn btn-sm btn-danger btn-tolak" data-id="{{ $pemilik->id }}">
                                        <i class="bi bi-x-circle"></i> Tolak
                                    </button>
                                </form>
                            </div>
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

@push('javascript')

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.btn-tolak').forEach(function(button) {
        button.addEventListener('click', function () {
            const id = this.dataset.id;

            Swal.fire({
                title: 'Tolak Akun?',
                text: 'Yakin ingin menolak pemilik kos ini? Aksi ini tidak dapat dibatalkan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e3342f',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Tolak',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form-tolak-' + id).submit();
                }
            });
        });
    });
});
</script>


@endpush


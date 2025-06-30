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
                                <!-- Form Hapus Tersembunyi -->
                                <form id="form-hapus-{{ $pemilik->id }}" action="{{ route('admin.pemilik.destroy', $pemilik->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger btn-hapus" data-id="{{ $pemilik->id }}">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('javascript')
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.btn-hapus').forEach(function(button) {
        button.addEventListener('click', function () {
            const id = this.dataset.id;

            Swal.fire({
                title: 'Hapus Data?',
                text: "Data pemilik kos akan dihapus permanen.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e3342f',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form-hapus-' + id).submit();
                }
            });
        });
    });
});
</script>

@endpush

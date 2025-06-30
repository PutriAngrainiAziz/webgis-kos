@extends('pemilik.layouts.layout')

@section('pemilik_page_title')
    Daftar Kos Pemilik
@endsection

@section('tampil_kos')
    <div class="container py-3 mb-4">
        <div class="row g-3 mb-2">
            <!-- Ringkasan Kos -->
            <div class="col-12 col-md-4">
            <div class="card px-3 py-3 bg-white shadow-sm">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center text-center gap-3">
                    <div>
                        <div class="text-muted small">Total Kos</div>
                        <div class="fs-5 fw-bold text-dark">{{ $data_kos->count() }}</div>
                    </div>
                    <div>
                        <div class="text-muted small">Aktif</div>
                        <div class="fs-5 fw-bold text-success">{{ $data_kos->where('status', 'aktif')->count() }}</div>
                    </div>
                    <div>
                        <div class="text-muted small">Nonaktif</div>
                        <div class="fs-5 fw-bold text-danger">{{ $data_kos->where('status', 'nonaktif')->count() }}</div>
                    </div>
                </div>
        </div>
    </div>
        <!-- Aksi & Form -->
    <div class="col-12 col-md-8">
            <div class="d-flex flex-column gap-2">
                <!-- Mobile Search Button -->
                <div class="d-md-none mb-2">
                    <div class="d-flex justify-content-end align-items-center gap-2">
                        <button id="searchToggle" class="btn p-0 border-0 text-primary" style="font-size: 1.3rem;">
                            <i class="bi bi-search"></i>
                        </button>
                        <form id="mobileSearchForm" action="{{ route('kelolakos.tampil_kos') }}" method="GET" class="d-none">
                            <input type="text" name="keyword" class="form-control form-control-sm" placeholder="Cari kos..." value="{{ request('keyword') }}" style="width: 150px;">
                        </form>
                    </div>
                </div>
                <!-- Desktop Search -->
                <div class="d-none d-md-flex justify-content-end mb-3">
                    <form action="{{ route('kelolakos.tampil_kos') }}" method="GET" style="width: 100%; max-width: 250px;">
                        <div class="input-group shadow-sm">
                            <input type="text" name="keyword" class="form-control no-rounded" placeholder="Cari kos..." value="{{ request('keyword') }}">
                            <button type="submit" class="btn btn-outline-primary no-rounded">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
                <div class="d-flex flex-wrap justify-content-md-end justify-content-between gap-2">
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-info">
                        <i class="bi bi-geo-alt-fill me-1"></i> Peta Kos
                    </a>

                    <a href="{{ route('kelolakos.tambah_kos') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle-fill me-1"></i> Tambah Kos
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Responsive -->
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Nama Kos</th>
                    <th>Alamat</th>
                    <th>Harga</th>
                    <th>Tipe</th>
                    <th>Kontak</th>
                    <th>Foto</th>
                    <th>Status</th>
                    <th>Verifikasi</th>
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
                        <img src="{{ asset('storage/foto_kos/' . $kos->foto) }}" width="60" class="img-thumbnail">
                        @else
                        <small>Tidak ada</small>
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('kelolakos.ubah_status', $kos->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="badge bg-{{ $kos->status == 'aktif' ? 'success' : 'danger' }} border-0">
                                {{ ucfirst($kos->status) }}
                            </button>
                        </form>
                    </td>
                    <td>{{ $kos->status_verifikasi }}</td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('kelolakos.edit_kos', $kos->id) }}" class="text-warning" title="Edit">
                                <i class="bi bi-pencil-square fs-5"></i>
                            </a>
                            <form action="{{ route('kelolakos.destroy', $kos->id) }}" method="POST" class="form-delete d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-sm border-0 bg-transparent text-danger btn-delete" title="Hapus">
                                    <i class="bi bi-trash fs-5"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center">
                        @if(request('keyword'))
                            Tidak ditemukan kos dengan kata kunci: "<strong>{{ request('keyword') }}</strong>"
                        @else
                            Belum ada kos yang ditambahkan.
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('javascript')
<script>
    const toggleBtn = document.getElementById('searchToggle');
    const searchForm = document.getElementById('mobileSearchForm');

    toggleBtn?.addEventListener('click', function() {
        searchForm.classList.toggle('d-none');
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.btn-delete');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const form = this.closest('form');

                Swal.fire({
                    title: 'Yakin ingin menghapus kos ini?',
                    text: "Tindakan ini tidak bisa dibatalkan.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus',
                    cancelButtonText: 'Batal',
                    customClass: {
                        popup: 'swal-responsive-popup'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>
@endpush


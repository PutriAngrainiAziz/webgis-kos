@extends('admin.layouts.layout')

@section('admin_page_title')
    Verifikasi Kos
@endsection

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
         <h2 class="mt-2 fw-bold text-warning d-flex align-items-center" style="gap: 10px;">
            <i class="bi bi-shield-exclamation" style="font-size: 1.5rem;"></i>
            Verifikasi Kos
        </h2>
    </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>Nama Kos</th>
                            <th>Alamat</th>
                            <th>Harga</th>
                            <th>Pemilik</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kosMenunggu as $kos)
                        <tr>
                            <td>{{ $kos->nama_kos }}</td>
                            <td>{{ $kos->alamat }}</td>
                            <td>Rp {{ number_format($kos->harga_sewa) }}</td>
                            <td>{{ $kos->user->name ?? '-' }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <form action="{{ url('/admin/verifikasi-kos/' . $kos->id . '/setujui') }}" method="POST">
                                        @csrf
                                        <button class="btn btn-success btn-sm" title="Setujui">
                                            <i class="bi bi-check-circle"></i> Setujui
                                        </button>
                                    </form>
                                    <form id="form-tolak-{{ $kos->id }}" action="{{ url('/admin/verifikasi-kos/' . $kos->id . '/tolak') }}" method="POST" style="display:inline">
                                        @csrf
                                        <button type="button" class="btn btn-danger btn-sm" title="Tolak" onclick="confirmTolak('{{ $kos->id }}')">
                                            <i class="bi bi-x-circle"></i> Tolak
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Tidak ada kos yang menunggu verifikasi.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection


@push('javascript')
<script>
  function confirmTolak(id) {
    Swal.fire({
      title: 'Yakin ingin menolak kos ini?',
      text: "Tindakan ini tidak dapat dibatalkan!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#6c757d',
      confirmButtonText: 'Ya, Tolak!',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        document.getElementById('form-tolak-' + id).submit();
      }
    });
  }
</script>

@endpush


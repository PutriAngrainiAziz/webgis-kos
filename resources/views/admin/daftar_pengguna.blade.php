@extends('admin.layouts.layout')

@section('admin_page_title')
    Daftar Pengguna
@endsection

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4 fw-semibold text-dark d-flex align-items-center" style="gap: 10px;">
            <i class="bi bi-people-fill" style="font-size: 1.5rem;"></i>
            Daftar Akun Pengguna
        </h2>
        <div class="table-responsive">
            <table class="table table-bordered table-hover text-center align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pengguna as $index => $user)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <form id="form-hapus-{{ $user->id }}" action="{{ route('admin.pengguna.destroy', $user->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger" onclick="confirmHapus('{{ $user->id }}')">
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
  function confirmHapus(id) {
    Swal.fire({
      title: 'Hapus Pengguna?',
      text: "Data yang dihapus tidak bisa dikembalikan.",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#6c757d',
      confirmButtonText: 'Ya, Hapus',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        document.getElementById('form-hapus-' + id).submit();
      }
    });
  }
</script>
@endpush

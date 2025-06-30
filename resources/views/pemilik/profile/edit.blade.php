@extends('pemilik.layouts.layout')
@section('pemilik_page_title')
    Profile Pemilik
@endsection

@section('content')
<div class="container mt-4">
    <h3>Profil {{ ucfirst($roleName) }}</h3>
    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('PATCH')

        <div class="mb-3">
            <label for="name" class="form-label">Nama</label>
            <input name="name" type="text" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input name="email" type="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>

    <hr>

    <form id="delete-account-form" method="POST" action="{{ route('profile.destroy') }}">
        @csrf
        @method('DELETE')

        <div class="mb-3">
            <label for="password" class="form-label">Konfirmasi Password</label>
            <input name="password" type="password" class="form-control" required>
        </div>

        <button type="button" id="confirm-delete" class="btn btn-danger">Hapus Akun</button>
    </form>
</div>
@endsection

@push('javascript')
<script>
    document.getElementById('confirm-delete').addEventListener('click', function () {
        Swal.fire({
            title: 'Hapus Akun?',
            text: "Akun Anda akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-account-form').submit();
            }
        });
    });
</script>
@if ($errors->userDeletion->any())
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal Menghapus Akun',
            text: '{{ $errors->userDeletion->first() }}',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
    </script>
    @endif
@endpush

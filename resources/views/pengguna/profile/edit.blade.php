@extends('pengguna.layouts.layout')

@section('user_title')
    Edit Profile
@endsection

@section('content')

<div id="profile" class="profile-page">
    <div class="profile-title">Profil {{ ucfirst($roleName) }}</div>

    {{-- FORM UPDATE PROFIL --}}
    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('PATCH')

        <div class="mb-3">
            <label class="form-label" for="name">Nama Lengkap</label>
            <input id="name" name="name" type="text" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label" for="email">Email</label>
            <input id="email" name="email" type="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>

    <hr>

    {{-- FORM HAPUS AKUN --}}
    <form method="POST" action="{{ route('profile.destroy') }}" id="delete-account-form">
        @csrf
        @method('DELETE')

        <div class="mb-3">
            <label class="form-label" for="password">Konfirmasi Password</label>
            <input id="password" name="password" type="password" class="form-control" placeholder="Masukkan password Anda" required>
            <small class="confirm-text">Untuk menghapus akun secara permanen, konfirmasi dengan password Anda.</small>
        </div>

        <button type="button" class="btn btn-danger mt-3" id="confirm-delete">Hapus Akun</button>
    </form>
</div>
@endsection

@push('javascript')
<script>
    document.getElementById('confirm-delete').addEventListener('click', function () {
        Swal.fire({
            title: 'Yakin ingin menghapus akun?',
            text: "Tindakan ini tidak bisa dibatalkan!",
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
            position: 'center',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
    </script>
@endif
@endpush

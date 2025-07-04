@extends('pengguna.layouts.layout')

@section('content')
<style>
    .profile-page {
        max-width: 800px;
        margin: 120px auto 40px;
        padding: 40px;
        border-radius: 20px;
        background: #f9f9f9;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.07);
    }

    .profile-title {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 30px;
        color: #333;
        border-bottom: 2px solid #ddd;
        padding-bottom: 15px;
    }

    .form-label {
        font-weight: 500;
        margin-bottom: 5px;
        color: #444;
    }

    .form-control {
        border-radius: 12px;
        padding: 10px 14px;
        font-size: 15px;
        border: 1px solid #ccc;
    }

    .btn-primary, .btn-danger {
        border-radius: 10px;
        padding: 10px 20px;
        font-weight: 600;
        transition: 0.3s;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .btn-danger:hover {
        background-color: #bb2d3b;
    }

    .section-space {
        margin-top: 40px;
    }

    .confirm-text {
        font-size: 0.9rem;
        color: #777;
    }

    hr {
        margin: 50px 0 30px;
    }
</style>

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
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
    </script>
@endif
@endpush

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Daftar Sebagai Pemilik</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <link href="{{ asset('home_asset/css/register_pemilik.css') }}" rel="stylesheet">

</head>
<body>

  <div class="form-container">
    <h2 class="section-title">Daftar sebagai Pemilik Kos</h2>

    <form action="{{ route('register.pemilik') }}" method="POST" enctype="multipart/form-data" autocomplete="on">
        @csrf

        <div class="form-group">
            {{-- <label for="name">Nama Lengkap</label> --}}
            <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Nama Lengkap" required autocomplete="name">
            @error('name')
            <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            {{-- <label for="email">Email</label> --}}
            <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="Email" required autocomplete="email">
            @error('email')
            <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            {{-- <label for="password">Password</label> --}}
            <input type="password" name="password" id="password" placeholder="Password" required autocomplete="new-password">
            @error('password')
            <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            {{-- <label for="password_confirmation">Konfirmasi Password</label> --}}
            <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password" required autocomplete="new-password">
            @error('password_confirmation')
            <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            {{-- <label for="nik">NIK</label> --}}
            <input type="text" name="nik" id="nik" value="{{ old('nik') }}" placeholder="Nomor Induk Kependudukan (NIK)" required autocomplete="off">
            @error('nik')
            <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            {{-- <label for="alamat">Alamat Lengkap</label> --}}
            <input type="text" name="alamat" id="alamat" value="{{ old('alamat') }}" placeholder="Alamat Lengkap" required autocomplete="street-address">
            @error('alamat')
            <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group file">
            <label for="foto_ktp">Upload Foto KTP</label>
            <input type="file" name="foto_ktp" id="foto_ktp" accept="image/*" required>
            @error('foto_ktp')
            <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit">Daftar</button>
        </form>

  </div>

</body>
</html>

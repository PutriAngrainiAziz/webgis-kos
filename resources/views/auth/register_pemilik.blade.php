<x-guest-layout>
<head>
  <title>Daftar Pemilik Kos</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Fonts & Icons -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,600,700,800,900" rel="stylesheet">
  <link href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" rel="stylesheet">
  
  <link href="{{ asset('home_asset/css/register_pemilik.css') }}" rel="stylesheet">
</head>

<body>
  <div class="register-section">
    <div class="container">
      <div class="register-card mx-auto">
        <h4 class="mb-4 pb-2 text-center">Daftar Pemilik Kos</h4>
        <div class="center-wrap">
          <form method="POST" action="{{ route('register.pemilik') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
              <input type="text" name="name" class="form-style" placeholder="Nama Lengkap" value="{{ old('name') }}" required>
              <i class="input-icon uil uil-user"></i>
            </div>
            @error('name') <div class="error-message">{{ $message }}</div> @enderror

            <div class="form-group">
              <input type="email" name="email" class="form-style" placeholder="Email" value="{{ old('email') }}" required>
              <i class="input-icon uil uil-at"></i>
            </div>
            @error('email') <div class="error-message">{{ $message }}</div> @enderror

            <div class="form-group">
              <input type="password" name="password" class="form-style" placeholder="Password" required>
              <i class="input-icon uil uil-lock-alt"></i>
            </div>
            @error('password') <div class="error-message">{{ $message }}</div> @enderror

            <div class="form-group">
              <input type="password" name="password_confirmation" class="form-style" placeholder="Konfirmasi Password" required>
              <i class="input-icon uil uil-lock-alt"></i>
            </div>
            @error('password_confirmation') <div class="error-message">{{ $message }}</div> @enderror

            <div class="form-group">
              <input type="text" name="nik" class="form-style" placeholder="NIK" value="{{ old('nik') }}" required>
              <i class="input-icon uil uil-card-atm"></i>
            </div>
            @error('nik') <div class="error-message">{{ $message }}</div> @enderror

            <div class="form-group">
              <input type="text" name="alamat" class="form-style" placeholder="Alamat Lengkap" value="{{ old('alamat') }}" required>
              <i class="input-icon uil uil-map-marker"></i>
            </div>
            @error('alamat') <div class="error-message">{{ $message }}</div> @enderror

            <div class="form-group">
              <label for="foto_ktp">Upload Foto KTP</label>
              <input type="file" name="foto_ktp" class="form-style-file" accept="image/*" required>
            </div>
            @error('foto_ktp') <div class="error-message">{{ $message }}</div> @enderror

            <button type="submit" class="btn mt-4">Daftar</button>

            <p class="mt-3 text-center">
              <a href="{{ route('login') }}" class="link">Sudah punya akun? Masuk di sini</a>
            </p>

          </form>
        </div>
      </div>
    </div>
  </div>
</body>
</x-guest-layout>

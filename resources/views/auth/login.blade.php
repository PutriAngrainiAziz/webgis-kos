<x-guest-layout>
    <head>
        <title>Login</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Fonts & Icon -->
        <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,600,700,800,900" rel="stylesheet">

        <!-- SweetAlert -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- Custom CSS -->
        <link rel="stylesheet" href="{{ asset('css/auth-style.css') }}">
    </head>

    <body>
        <div class="section">
            <div class="container">
                <div class="row full-height justify-content-center">
                    <div class="col-12 text-center align-self-center py-5">
                        <div class="section pb-5 pt-5 pt-sm-2 text-center">
                            <h6 class="mb-0 pb-3"><span>Log In</span><span>Sign Up</span></h6>
                            <input class="checkbox" type="checkbox" id="reg-log" name="reg-log" />
                            <label for="reg-log"></label>
                            <div class="card-3d-wrap mx-auto">
                                <div class="card-3d-wrapper">

                                    <!-- LOGIN -->
                                    <div class="card-front">
                                        <div class="center-wrap">
                                            <form method="POST" action="{{ route('login') }}">
                                                @csrf
                                                <h4 class="mb-4 pb-3">Log In</h4>
                                                <div class="form-group">
                                                    <input type="email" name="email" class="form-style" placeholder="Your Email" required autofocus value="{{ old('email') }}">
                                                    <i class="input-icon uil uil-at"></i>
                                                </div>
                                                @error('email')
                                                    <div class="error-message">{{ $message }}</div>
                                                @enderror
                                                <div class="form-group mt-2">
                                                    <input type="password" name="password" class="form-style" placeholder="Your Password" required>
                                                    <i class="input-icon uil uil-lock-alt"></i>
                                                </div>
                                                @error('password')
                                                    <div class="error-message">{{ $message }}</div>
                                                @enderror
                                                <button type="submit" class="btn mt-4">Submit</button>
                                                <p class="mb-0 mt-4 text-center">
                                                    <a href="{{ route('password.request') }}" class="link">Forgot your password?</a>
                                                </p>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- SIGN UP (optional untuk kembangkan register pengguna) -->
                                    {{-- <div class="card-back">
                                        <div class="center-wrap">
                                            <div class="section text-center">
                                                <h4 class="mb-4 pb-3">Sign Up</h4>
                                                <div class="form-group">
                                                    <input type="text" name="logname" class="form-style" placeholder="Your Full Name" id="logname" autocomplete="off">
                                                    <i class="input-icon uil uil-user"></i>
                                                </div>
                                                <div class="form-group mt-2">
                                                    <input type="email" name="logemail" class="form-style" placeholder="Your Email" id="logemail" autocomplete="off">
                                                    <i class="input-icon uil uil-at"></i>
                                                </div>
                                                <div class="form-group mt-2">
                                                    <input type="password" name="logpass" class="form-style" placeholder="Your Password" id="logpass" autocomplete="off">
                                                    <i class="input-icon uil uil-lock-alt"></i>
                                                </div>
                                                <a href="#" class="btn mt-4">submit</a>
                                            </div>
                                        </div>
                                    </div> --}}

                                    <div class="card-back">
                                        <div class="center-wrap">
                                            <h4 class="mb-4 pb-3">Sign Up</h4>
                                            <p class="mt-3 text-center" style="color:#fff;">
                                                 @if (Route::has('register'))
                                                    <a href="{{ url('/register-pemilik') }}" class="register-btn">Register Sebagai Pemilik Disini!</a>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if ($errors->has('verifikasi'))
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Akses Ditolak',
                        text: '{{ $errors->first('verifikasi') }}',
                        confirmButtonText: 'OK'
                    });
                });
            </script>
        @endif
    </body>
</x-guest-layout>

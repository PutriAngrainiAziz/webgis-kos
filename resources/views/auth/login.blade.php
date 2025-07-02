<x-guest-layout>
    <head>
        <title>Login Stylish</title>
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

                                    <!-- SIGN UP DUMMY (optional untuk dikembangkan) -->
                                    <div class="card-back">
                                        <div class="center-wrap">
                                            <h4 class="mb-4 pb-3">Sign Up</h4>
                                            <p style="color:#fff;">Fitur belum tersedia.</p>
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

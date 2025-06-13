<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>@yield('home_page_title')</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicons -->
    <link href="home_asset/img/favicon.png" rel="icon">
    <link href="home_asset/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="home_asset/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="home_asset/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="home_asset/vendor/aos/aos.css" rel="stylesheet">
    <link href="home_asset/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="home_asset/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <!-- Leaflet Search CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-search@2.9.9/dist/leaflet-search.min.css" />

    <!-- Marker Cluster CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster/dist/MarkerCluster.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster/dist/MarkerCluster.Default.css" />

    <!-- Main CSS File -->
    <link href="{{asset('home_asset/css/main.css')}}" rel="stylesheet">

    <!-- Tailwind CSS via Vite -->
    {{-- @vite('resources/css/app.css') --}}

    @yield('css')

</head>

<body class="index-page">

    <header id="header" class="header d-flex align-items-center fixed-top">
        <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

            <a href="index.html" class="logo d-flex align-items-center">
                <!-- Uncomment the line below if you also wish to use an image logo -->
                <!-- <img src="assets/img/logo-2.png" alt=""> -->
                <h1 class="sitename">KOS^_^</h1>
            </a>

            <nav id="navmenu" class="navmenu d-flex align-items-center justify-content-between w-100">
                <ul class="d-flex align-items-center mb-0">
                    <li><a href="#hero" class="active">Home</a></li>
                    <li><a href="#peta">Peta</a></li>
                    <li><a href="#kos">Kos</a></li>
                </ul>

                @if (Route::has('login'))
                <div class="auth-buttons ms-4 d-flex align-items-center">
                    @auth
                    <a href="{{ url('/dashboard') }}" class="btn btn-outline-dark me-2">
                        Dashboard
                    </a>
                    @else
                    <a href="{{ route('login') }}" class="btn btn-outline-dark me-2">
                        Log in
                    </a>

                    @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn btn-dark">
                        Register
                    </a>
                    @endif
                    @endauth
                </div>
                @endif

                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>

        </div>
    </header>


    <main class="main">
        @yield('home_layout')
        @yield('detail_kos')
    </main>

    <section class="py-5 bg-white text-center shadow-lg" style="box-shadow: 0 -4px 10px rgba(0, 255, 115, 0.114);">
        <div class="container">
            <div class="p-4 p-md-5 rounded shadow-sm bg-light">
                <h2 class="mb-3 fw-bold text-primary">Tertarik Menyewakan Kos Anda?</h2>
                <p class="lead mb-4 text-secondary">
                    Gabung sebagai pemilik dan kelola kos Anda dengan mudah melalui platform kami.
                </p>
                <a href="{{ url('/register-pemilik') }}" class="btn btn-primary btn-lg px-4 py-2 rounded-pill shadow-sm">
                    Daftar Sebagai Pemilik Kos
                </a>
            </div>
        </div>
    </section>




    <footer id="footer" class="footer dark-background">

        <div class="container">
            <div class="row gy-3">
                <div class="col-lg-3 col-md-6 d-flex">
                    <i class="bi bi-geo-alt icon"></i>
                    <div class="address">
                        <h4>Address</h4>
                        <p>Universitas Halu Oleo</p>
                        <p>Indonesia, Sulawesi Tenggara</p>
                        <p></p>
                    </div>

                </div>

                <div class="col-lg-3 col-md-6 d-flex">
                    <i class="bi bi-telephone icon"></i>
                    <div>
                        <h4>Contact</h4>
                        <p>
                            <strong>Phone:</strong> <span>+62 822 6225 8075</span><br>
                            <strong>Email:</strong> <span>sigkoskosan@gmail.com</span><br>
                        </p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 d-flex">
                    <i class="bi bi-clock icon"></i>
                    <div>
                        <h4>Detail</h4>
                        <p>
                            <strong>Tugas:</strong> <span>Sistem Informasi Geografis</span><br>
                            <strong>Tujuan</strong>: <span>Memenuhi UAS</span>
                        </p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h4>Follow Us</h4>
                    <div class="social-links d-flex">
                        <a href="#" class="twitter"><i class="bi bi-twitter-x"></i></a>
                        <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>

            </div>
        </div>

        <div class="container copyright text-center mt-4">
            <p>© <span>SIG</span> <strong class="px-1 sitename">Kos-kosan</strong> <span>Kambu, Kendari</span></p>
            <div class="credits">
                Designed by <a href="#">Kelompok haa</a>
            </div>
        </div>

    </footer>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="home_asset/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="home_asset/vendor/php-email-form/validate.js"></script>
    <script src="home_asset/vendor/aos/aos.js"></script>
    <script src="home_asset/vendor/typed.js/typed.umd.js"></script>
    <script src="home_asset/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="home_asset/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
    <script src="home_asset/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="home_asset/vendor/swiper/swiper-bundle.min.js"></script>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <!-- Leaflet Search JS -->
    <script src="https://unpkg.com/leaflet-control-search@2.9.9/dist/leaflet-search.min.js"></script>
    <!-- JS marker cluster -->
    <script src="https://unpkg.com/leaflet.markercluster/dist/leaflet.markercluster.js"></script>

    <!-- Main JS File -->
    <script src="{{asset('home_asset/js/main.js')}}"></script>
    @stack('javascript')

</body>

</html>

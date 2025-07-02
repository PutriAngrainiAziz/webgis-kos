<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('home_page_title')</title>

    <!-- Vendor CSS Files -->
    <link href="{{ asset('home_asset/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('home_asset/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('home_asset/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('home_asset/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('home_asset/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-search@2.9.9/dist/leaflet-search.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster/dist/MarkerCluster.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster/dist/MarkerCluster.Default.css" />
    <!-- Leaflet Routing Machine -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.fullscreen/Control.FullScreen.css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />




    <!-- Main CSS File -->
    <link href="{{ asset('home_asset/css/main.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('home_asset/css/detailkos.css') }}">

    @yield('css')
</head>

<body class="index-page">
    {{-- <header id="header" class="header fixed-top d-flex align-items-center"> --}}
    <header id="header" class="header {{ Request::is('/') ? 'home-header' : (Request::is('detailkos/*') ? 'detail-header' : 'default-header') }} fixed-top d-flex align-items-center">

        <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

            <!-- Logo tetap terlihat di semua ukuran layar -->
            <a href="{{ url('/') }}#hero" class="logo d-flex align-items-center">
                <h1 class="sitename m-0">KOS^_^</h1>
            </a>

            <!-- Tombol toggle hanya terlihat di mobile -->
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>


            <!-- Menu navigasi -->
            <nav id="navmenu" class="navmenu">
                <ul class="nav-links list-unstyled mb-2">
                    <li><a href="{{ url('/') }}#hero">Home</a></li>
                    <li><a href="{{ url('/') }}#peta">Peta</a></li>
                    <li><a href="{{ url('/') }}#kos">Kos</a></li>

                    @auth
                        <li><a href="{{ url('/user/dashboard') }}">Dashboard</a></li>
                    @else
                        <li><a href="{{ route('login') }}" class="login-btn">Log in</a></li>
                        @if (Route::has('register'))
                            <li><a href="{{ url('/register-pemilik') }}" class="register-btn">Register</a></li>
                        @endif
                    @endauth
                </ul>
            </nav>
        </div>
    </header>


    <main class="main">
        @yield('home_layout')
        @yield('detail_kos')
    </main>

    <footer id="footer" class="footer bg-dark text-light pt-5">
        <div class="container">
            <div class="row gy-3">
                <div class="col-lg-3 col-md-6">
                    <h5><i class="bi bi-geo-alt"></i> Address</h5>
                    <p>Universitas Halu Oleo<br>Indonesia, Sulawesi Tenggara</p>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h5><i class="bi bi-telephone"></i> Contact</h5>
                    <p><strong>Phone:</strong> +62 822 6225 8075<br><strong>Email:</strong> sigkoskosan@gmail.com</p>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h5><i class="bi bi-clock"></i> Detail</h5>
                    <p><strong>Tugas:</strong> Sistem Informasi Geografis<br><strong>Tujuan:</strong> Memenuhi UAS</p>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h5>Follow Us</h5>
                    <div class="social-links d-flex">
                        <a href="#" class="me-2"><i class="bi bi-twitter-x"></i></a>
                        <a href="#" class="me-2"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="me-2"><i class="bi bi-instagram"></i></a>
                        <a href="#"><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <p class="mb-0">&copy; <strong>SIG Kos-kosan</strong> - Kambu, Kendari</p>
                <small>Designed by <a href="#" class="text-light">Kelompok haa</a></small>
            </div>
        </div>
    </footer>

    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center">
        <i class="bi bi-arrow-up-short"></i>
    </a>

    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="{{ asset('home_asset/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('home_asset/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('home_asset/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('home_asset/vendor/typed.js/typed.umd.js') }}"></script>
    <script src="{{ asset('home_asset/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('home_asset/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('home_asset/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('home_asset/vendor/swiper/swiper-bundle.min.js') }}"></script>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-control-search@2.9.9/dist/leaflet-search.min.js"></script>
    <script src="https://unpkg.com/leaflet.markercluster/dist/leaflet.markercluster.js"></script>

    <script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>
    <script src="https://unpkg.com/leaflet.fullscreen/Control.FullScreen.js"></script>

    <!-- Main JS File -->
    <script src="{{ asset('home_asset/js/main.js') }}"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggle = document.querySelector('.mobile-nav-toggle');
        const navMenu = document.getElementById('navmenu');
        const closeBtn = document.querySelector('.close-btn');

        toggle.addEventListener('click', function () {
            navMenu.classList.toggle('active');
        });

        if (closeBtn) {
            closeBtn.addEventListener('click', function () {
                navMenu.classList.remove('active');
            });
        }

        // Opsional: klik di luar menu akan menutupnya
        document.addEventListener('click', function (e) {
            if (!navMenu.contains(e.target) && !toggle.contains(e.target)) {
                navMenu.classList.remove('active');
            }
        });
    });
</script>




    @stack('javascript')
</body>

</html>

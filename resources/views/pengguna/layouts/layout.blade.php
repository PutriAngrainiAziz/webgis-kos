<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('user_title')</title>

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
    <link rel="stylesheet" href="{{ asset('home_asset/css/favorit.css') }}">

    @yield('css')
</head>

<body class="index-page">
    <header id="header" class="header
    {{ Request::is('user/dashboard') ? 'home-header' : (Request::is('user/detailkos/*') || Request::is('user/favorit') || Request::is('user/profile') || Request::is('user/profile/edit') ? 'detail-header' : 'default-header') }}
    fixed-top d-flex align-items-center">

        <div class="container-fluid container-xl d-flex align-items-center justify-content-between">
            <a href="{{ url('/user/dashboard') }}#dashboard" class="logo d-flex align-items-center">
                <h1 class="sitename m-0">KOS^_^</h1>
            </a>

            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>

            <nav id="navmenu" class="navmenu">
                <ul class="nav-links list-unstyled mb-2">
                    <li><a href="{{ url('/user/dashboard') }}#dashboard">Home</a></li>
                    <li><a href="{{ url('/user/dashboard') }}#peta">Peta</a></li>
                    <li><a href="{{ url('/user/dashboard') }}#kos">Kos</a></li>
                    <li><a href="{{ route('favorit.index') }}#favorit">Favorit Saya</a></li>
                    {{-- <li class="nav-item dropdown">
                        <!-- Tombol Dropdown -->
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}" alt="Avatar" class="rounded-circle me-2" width="32" height="32">
                            <span class="d-none d-md-inline text-white text-truncate" style="max-width: 150px;">{{ Auth::user()->name }}</span>
                        </a>

                        <!-- Dropdown Menu -->
                        <ul class="dropdown-menu dropdown-menu-end shadow" style="min-width: 180px;">
                            <li>
                                <a class="dropdown-item text-dark" href="{{ route('profile.show') }}">
                                    Profil
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item text-dark d-flex align-items-center" type="submit">
                                        <i class="me-2" data-feather="log-out"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li> --}}
                    <!-- DESKTOP: Dropdown Profil -->
                    <li class="nav-item dropdown d-none d-md-block">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}" alt="Avatar" class="rounded-circle me-2" width="32" height="32">
                            <span class="text-white text-truncate" style="max-width: 150px;">{{ Auth::user()->name }}</span>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end shadow" style="min-width: 180px;">
                            <li><a class="dropdown-item" href="{{ route('profile.show') }}">Profil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item text-dark d-flex align-items-center" type="submit">
                                        <i class="me-2" data-feather="log-out"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>

                    <!-- MOBILE -->
                    <li class="d-md-none">
                        <a href="{{ route('profile.show') }}" class="menu-link">Profil</a>
                    </li>
                    <li class="d-md-none">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="menu-link logout-btn">Logout</button>
                        </form>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="main">
        @yield('content')
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

            <div class="container copyright text-center mt-4">
            <p>© <span>Copyright</span> <strong class="px-1 sitename">Imperial</strong> <span>All Rights Reserved</span></p>
            <div class="credits">
                <!-- All the links in the footer should remain intact. -->
                <!-- You can delete the links only if you've purchased the pro version. -->
                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
                Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
            </div>
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

            // klik di luar menu akan menutupnya
            document.addEventListener('click', function (e) {
                if (!navMenu.contains(e.target) && !toggle.contains(e.target)) {
                    navMenu.classList.remove('active');
                }
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: @json(session('success')),
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });
        });
    </script>
    @endif

    @if(session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: @json(session('error')),
                confirmButtonColor: '#d33',
                confirmButtonText: 'Tutup'
            });
        });
    </script>
    @endif
    @stack('javascript')
</body>

</html>

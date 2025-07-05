@extends('pengguna.layouts.layout')

@section('user_title')
Dashboard User
@endsection
@php
    use Illuminate\Support\Str;
@endphp
@section('content')
<!-- Hero Section -->
<section id="dashboard" class="hero dark-background">

    <video class="hero-bg position-absolute top-0 start-0 w-100 h-100 object-fit-cover" autoplay muted loop playsinline>
        <source src="/home_asset/video/Kendari.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <div class="container text-center position-relative z-2" data-aos="zoom-in" data-aos-delay="500">
        @auth
            <h1 class="text-white">Haii {{ Auth::user()->name }} ^_^</h1>
        @endauth

        <h2 class="text-white">|| Jelajahi Peta Kec. Kambu ||</h2>
    </div>

</section>
<!-- /Hero Section -->

<!-- About Section -->
<section id="peta" class="about section">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>Peta</h2>
        <p>Berikut peta yang menunjukkan persebaran kos-kosan yang ada di Kecamatan Kambu</p>
    </div><!-- End Section Title -->

    <div class="container">
        <div class="filter-container">
            <input type="text" id="search" placeholder="Cari nama/alamat kos..." />

            <select id="tipe">
                <option value="">Semua Tipe</option>
                <option value="kos putra">Kos Putra</option>
                <option value="kos putri">Kos Putri</option>
                <option value="kos campur">Kos Campur</option>
            </select>

            <select id="harga">
                <option value="">Semua Harga</option>
                <option value="1">Di bawah 500rb</option>
                <option value="2">500rb - 1jt</option>
                <option value="3">Di atas 1jt</option>
            </select>

            <button id="applyFilter"><i class="fa fa-search"></i> Terapkan Filter</button>
            <button id="resetFilter" class="reset-btn"><i class="fa fa-undo"></i> Reset</button>
        </div>



        <div class="row gy-4" id="map" style="height: 400px;">
        </div>
    </div>

</section><!-- /About Section -->


<!-- Features Section -->
<section id="kos" class="features section">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>Kos</h2>
        <p>Kos-Kosan Kecamatan Kambu</p>
    </div><!-- End Section Title -->

    {{-- <div class="container">
        <div class="d-flex overflow-auto gap-3 pb-3">
            @foreach($kosList as $kos)
                <div class="card shadow-sm d-flex flex-column position-relative"
                    style="min-width: 270px; max-width: 270px; border-radius: 12px; overflow: hidden;">
                    <!-- Favorit Icon -->
                    @php
                        $sudahFavorit = Auth::user()->favoritKos->contains($kos->id);
                    @endphp
                    <form action="{{ route($sudahFavorit ? 'kos.unfavorit' : 'kos.favorit', $kos->id) }}"
                        method="POST" class="favorit-form">
                        @csrf
                        <button type="submit" class="favorit-icon">
                            <i class="bi {{ $sudahFavorit ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                        </button>
                    </form>



                    <!-- Gambar -->
                    <img
                        src="{{ asset('storage/foto_kos/' . $kos->foto) }}"
                        alt="{{ $kos->nama_kos }}"
                        style="
                            width: 100%;
                            height: 180px;
                            object-fit: cover;
                            object-position: center;
                        "
                    >

                    <!-- Konten -->
                    <div class="p-3 d-flex flex-column flex-grow-1">
                        <div class="flex-grow-1">
                            <h5 class="mb-1">{{ Str::title($kos->nama_kos) }}</h5>
                            <a href="#" style="color: #0d6efd; font-size: 0.9em;">
                                {{ $kos->tipe_kamar }}
                            </a>
                            <p style="font-size: 0.85em;">
                                Harga: Rp {{ number_format($kos->harga_sewa, 0, ',', '.') }} / bln
                                <br>
                                Kontak: {{ $kos->nomor_kontak }}
                            </p>
                        </div>

                        <!-- Tombol -->
                        <a href="{{ url('user/detailkos/'.$kos->id) }}"
                            class="btn btn-sm btn-outline-primary mt-2">
                            Selengkapnya
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

    </div> --}}
        <div class="container">
        @if($kosList->isEmpty())
            <div class="text-center p-5">
                <img src="{{ asset('home_asset/penggunaasset/no_result.png') }}" alt="Tidak ada kos" style="width: 120px; opacity: 0.7;" class="mb-3">
                <h5 class="text-muted">Belum ada data kos tersedia</h5>
                <p class="text-secondary">Coba lagi nanti atau hubungi admin untuk info lebih lanjut.</p>
            </div>
        @else
            <div class="d-flex overflow-auto gap-3 pb-3">
                @foreach($kosList as $kos)
                    <div class="card shadow-sm d-flex flex-column"
                        style="min-width: 270px; max-width: 270px; border-radius: 12px; overflow: hidden;">
                        <!-- Gambar -->
                        <img
                            src="{{ asset('storage/foto_kos/' . $kos->foto) }}"
                            alt="{{ $kos->nama_kos }}"
                            style="width: 100%; height: 180px; object-fit: cover; object-position: center;"
                        >
                        <!-- Konten -->
                        <div class="p-3 d-flex flex-column flex-grow-1">
                            <div class="flex-grow-1">
                                <h5 class="mb-1">{{ Str::title($kos->nama_kos) }}</h5>
                                <a href="#" style="color: #0d6efd; font-size: 0.9em;">
                                    {{ $kos->tipe_kamar }}
                                </a>
                                <p style="font-size: 0.85em;">
                                    Harga: Rp {{ number_format($kos->harga_sewa, 0, ',', '.') }} / bln<br>
                                    Kontak: {{ $kos->nomor_kontak }}
                                </p>
                            </div>
                            <a href="{{ url('detailkos/'.$kos->id) }}"
                                class="btn btn-sm btn-outline-primary mt-2">
                                Selengkapnya
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

</section><!-- /Features Section -->

<section class="cta-section">
    <div class="container-cta">
        <h2 class="cta-title">Tertarik Menyewakan Kos Milik Anda?</h2>
        <p class="cta-subtitle">Gabung sebagai pemilik dan kelola kos Anda dengan mudah melalui platform kami.</p>
        <a href="{{ url('/register-pemilik') }}" class="cta-button">
            Daftar Sebagai Pemilik Kos
        </a>
    </div>
</section>


@endsection


@push('javascript')
<script>
    var osm = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    })

    var Stadia_AlidadeSatellite = L.tileLayer('https://tiles.stadiamaps.com/tiles/alidade_satellite/{z}/{x}/{y}{r}.{ext}', {
        minZoom: 0,
        maxZoom: 20,
        attribution: '&copy; CNES, Distribution Airbus DS, © Airbus DS, © PlanetObserver (Contains Copernicus Data) | &copy; <a href="https://www.stadiamaps.com/" target="_blank">Stadia Maps</a> &copy; <a href="https://openmaptiles.org/" target="_blank">OpenMapTiles</a> &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        ext: 'jpg'
    });

    var Esri_WorldStreetMap = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Street_Map/MapServer/tile/{z}/{y}/{x}', {
        attribution: 'Tiles &copy; Esri &mdash; Source: Esri, DeLorme, NAVTEQ, USGS, Intermap, iPC, NRCAN, Esri Japan, METI, Esri China (Hong Kong), Esri (Thailand), TomTom, 2012'
    });

    var MtbMap = L.tileLayer('http://tile.mtbmap.cz/mtbmap_tiles/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &amp; USGS'
    });

    const keckambu = L.layerGroup();
    const masjid = L.layerGroup();
    const universitas = L.layerGroup();


    var map = L.map('map', {
        center: [-4.020705809212554, 122.52818392075301],
        zoom: 13,
        fullscreenControl: true,
        layers: [osm]
    })

    map.on('enterFullscreen', function(){
        console.log('Masuk Fullscreen');
    });

    map.on('exitFullscreen', function(){
        console.log('Keluar dari Fullscreen');
    });



    var kosList = @json($kosList);
    var kosCluster = L.markerClusterGroup();

    let kosMarkers = [];

    function tampilkanMarkerKos(filteredList) {
        kosCluster.clearLayers();
        kosMarkers = [];

        filteredList.forEach(kos => {
            let iconUrl;
            if (kos.tipe_kamar.toLowerCase() === 'kos putra') {
                iconUrl = '/iconMarkers/koscowo.svg';
            } else if (kos.tipe_kamar.toLowerCase() === 'kos putri') {
                iconUrl = '/iconMarkers/koscewe.svg';
            } else {
                iconUrl = '/iconMarkers/koscampur.svg';
            }

            var customIcon = L.icon({
                iconUrl: iconUrl,
                iconSize: [32, 32],
                iconAnchor: [16, 32],
                popupAnchor: [0, -32]
            });

            map.createPane('paneKos');
            map.getPane('paneKos').style.zIndex = 650;

            let marker = L.marker([kos.latitude, kos.longitude], {
                icon: customIcon,
                pane: 'paneKos'
            }).bindPopup(`
                <div style="width: 250px; min-height: 280px;"> <!-- min-height boleh -->
                    <a href="/detailkos/${kos.id}" style="text-decoration: none; color: inherit;">
                        <img src="/storage/foto_kos/${kos.foto}" style="width: 100%; height: 140px; object-fit: cover; border-radius: 8px; margin-bottom: 10px;">

                        <strong>${kos.nama_kos.toLowerCase().replace(/\b\w/g, c => c.toUpperCase())}</strong><br>
                        <strong>Alamat:</strong> ${kos.alamat}<br>
                        <strong> Harga:</strong> Rp ${parseInt(kos.harga_sewa).toLocaleString()}<br>
                        <strong>Tipe:</strong> ${kos.tipe_kamar}<br>
                        <strong>Fasilitas:</strong> ${kos.fasilitas}<br>
                    </a>
                </div>
            `);

            kosCluster.addLayer(marker);
            kosMarkers.push(marker);
        });

        map.addLayer(kosCluster);

        if (filteredList.length === 1) {
            // Zoom satu titik
            map.flyTo([filteredList[0].latitude, filteredList[0].longitude], 16, {
                animate: true,
                duration: 1
            });
        } else if (filteredList.length > 1) {
            // Zoom semua titik yang terpenuhi
            let bounds = L.latLngBounds(filteredList.map(k => [k.latitude, k.longitude]));
            map.fitBounds(bounds, {
                padding: [50, 50]
            });
        } else {
            // Tidak ada hasil
            console.log("Tidak ditemukan kos yang cocok");
        }
    }

    function filterKos() {
        const keyword = document.getElementById('search').value.toLowerCase();
        const tipe = document.getElementById('tipe').value;
        const harga = document.getElementById('harga').value;

        const hasilFilter = kosList.filter(kos => {
            const cocokNama = kos.nama_kos.toLowerCase().includes(keyword) || (kos.alamat?.toLowerCase().includes(keyword) || '');
            const cocokTipe = tipe === "" || kos.tipe_kamar.toLowerCase() === tipe;
            const cocokHarga = (() => {
                const h = kos.harga_sewa;
                if (harga === "1") return h < 500000;
                if (harga === "2") return h >= 500000 && h <= 1000000;
                if (harga === "3") return h > 1000000;
                return true;
            })();
            return cocokNama && cocokTipe && cocokHarga;
        });

        tampilkanMarkerKos(hasilFilter);
    }

    function resetFilter() {
        document.getElementById('search').value = "";
        document.getElementById('tipe').value = "";
        document.getElementById('harga').value = "";
        tampilkanMarkerKos(kosList);
    }

    // Event listeners
    document.getElementById('applyFilter').addEventListener('click', filterKos);
    document.getElementById('search').addEventListener('input', filterKos);
    document.getElementById('resetFilter').addEventListener('click', resetFilter);

    // Tampilkan awal
    tampilkanMarkerKos(kosList);

    //Kec. Kambu
    fetch('/geojson/keckambu.geojson')
        .then(res => res.json())
        .then(data => {
            L.geoJSON(data, {
                style: function (feature) {
                    let warna;
                    switch (feature.properties.NAME_4) {
                        case 'Kambu':
                            warna = 'blue';
                            break;
                        case 'Lalolara':
                            warna = 'darkred';
                            break;
                        case 'Padaleu':
                            warna = 'green';
                            break;
                        case 'Mokoau':
                            warna = 'yellow';
                            break;
                        default:
                            warna = 'black';
                    }
                    return {
                        color: warna,
                        weight: 2,
                        fillOpacity: 0
                    };
                },
                onEachFeature: function (feature, layer) {
                    layer.bindPopup(`<b>${feature.properties.NAME_4}</b>`);
                }
            }).addTo(keckambu);
        });

    //Masjid
    var iconMasjid = L.icon({
    iconUrl: "{{ asset('iconMarkers/tempatIbadah_4.png') }}"
    });

    fetch('/geojson/tmptibadah.geojson')
        .then(res => res.json())
        .then(data => {
            L.geoJSON(data, {
                pointToLayer: function (feature, latlng) {
                    return L.marker(latlng, { icon: iconMasjid });
                },
                onEachFeature: function (feature, layer) {
                    if (feature.properties && feature.properties["Nama Masji"]) {
                        layer.bindPopup(`<b>${feature.properties["Nama Masji"]}`);
                    }
                }
            }).addTo(masjid);
        });

    //Universitas
    var iconUniv = L.icon({
    iconUrl: "{{ asset('iconMarkers/universitas_3.png') }}"
    });

    fetch('/geojson/universitas.geojson')
        .then(res => res.json())
        .then(data => {
            L.geoJSON(data, {
                pointToLayer: function (feature, latlng) {
                    return L.marker(latlng, { icon: iconUniv });
                },
                onEachFeature: function (feature, layer) {
                    if (feature.properties && feature.properties["Nama Unive"]) {
                        layer.bindPopup(`<b>${feature.properties["Nama Unive"]}`);
                    }
                }
            }).addTo(universitas);
        });


    const baseLayers = {
        'Open Street Map': osm,
        'Stadia Alidade': Stadia_AlidadeSatellite,
        'Esri World': Esri_WorldStreetMap,
        'MtbMap': MtbMap
    }

    const overlayers = {
        'Kos': kosCluster,
        'Masjid': masjid,
        'Universitas': universitas,
        'Batas Kec. Kambu': keckambu
    }

    const layerControl = L.control.layers(baseLayers, overlayers).addTo(map)


    //icon user_location
    var iconUserLocation = L.icon({
        iconUrl: "{{ asset('iconMarkers/lokasisaatini.svg') }}",
        iconSize: [32, 32],
        iconAnchor: [16, 32],
        popupAnchor: [0, -32]
    });

    // Kontrol kustom
    L.Control.MyLocation = L.Control.extend({
        onAdd: function (map) {
            let btn = L.DomUtil.create('button');
            btn.title = 'Tampilkan Lokasi Anda';
            btn.innerHTML = `<img src="{{ asset('iconMarkers/my-location-svgrepo-com.svg') }}" style="width: 24px;">`;

            btn.className = 'leaflet-bar leaflet-control leaflet-control-custom';

            // Handle klik
            L.DomEvent.on(btn, 'click', function () {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        function (position) {
                            var lat = position.coords.latitude;
                            var lng = position.coords.longitude;

                            var userMarker = L.marker([lat, lng], { icon: iconUserLocation }).addTo(map)
                                .bindPopup("Lokasi Anda Sekarang").openPopup();

                            map.setView([lat, lng], 15);
                        },
                        function () {
                            alert("Gagal mendapatkan lokasi Anda.");
                        }
                    );
                } else {
                    alert("Browser Anda tidak mendukung Geolocation.");
                }
            });

            return btn;
        },
        onRemove: function (map) {
            // opsional cleanup
        }
    });

    // Tambahkan ke peta, posisinya sama dengan zoom (top left)
    L.control.myLocation = function (opts) {
        return new L.Control.MyLocation(opts);
    }

    L.control.myLocation({ position: 'topleft' }).addTo(map);

</script>

@endpush

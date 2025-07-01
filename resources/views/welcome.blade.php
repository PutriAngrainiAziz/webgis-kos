@extends('layouts.layout')

@section('home_page_title')
Home Page
@endsection
@php
    use Illuminate\Support\Str;
@endphp
@section('home_layout')
<!-- Hero Section -->
<section id="hero" class="hero dark-background">

    <video class="hero-bg position-absolute top-0 start-0 w-100 h-100 object-fit-cover" autoplay muted loop playsinline>
        <source src="home_asset/video/Kendari.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <div class="container text-center position-relative z-2" data-aos="zoom-in" data-aos-delay="500">
        <h1 class="text-white">Selamat Datang di KOS ^_^</h1>
        <h2 class="text-white">|| Kec. Kambu, Kendari ||</h2>
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

    <div class="container">
    <div class="d-flex overflow-auto gap-3 pb-3">
        @foreach($kosList as $kos)
            <div class="card shadow-sm" style="min-width: 270px; max-width: 270px; border-radius: 12px; overflow: hidden;">
                <img src="{{ asset('storage/foto_kos/' . $kos->foto) }}" alt="{{ $kos->nama_kos }}" style="width: 100%; height: 180px; object-fit: cover;">
                <div class="p-3 d-flex flex-column justify-content-between" style="height: 100%;">
                    <div>
                        <h5 class="mb-1">{{ Str::title($kos->nama_kos) }}</h5>
                        <a href="#" style="color: #0d6efd; font-size: 0.9em;">{{ $kos->tipe_kamar }}</a>
                        <p style="font-size: 0.85em;">
                            Harga: Rp {{ number_format($kos->harga_sewa, 0, ',', '.') }} / bln
                            <br>
                            Kontak: {{ $kos->nomor_kontak }}
                        </p>
                    </div>
                    <a href="{{ url('detailkos/'.$kos->id) }}" class="btn btn-sm btn-outline-primary mt-2">Selengkapnya</a>
                </div>
            </div>
        @endforeach
    </div>
</div>
</section><!-- /Features Section -->

<section class="py-4 py-md-5 bg-white text-center shadow-sm">
    <div class="container">
        <div class="p-3 p-md-5 bg-light rounded-4 shadow-sm mx-auto" style="max-width: 720px;">
            <h2 class="fw-bold text-primary mb-3 fs-4 fs-md-2">
                Tertarik Menyewakan Kos Milik Anda?
            </h2>
            <p class="text-secondary mb-4 fs-6 fs-md-5">
                Gabung sebagai pemilik dan kelola kos Anda dengan mudah melalui platform kami.
            </p>
            <a href="{{ url('/register-pemilik') }}" class="btn btn-primary btn-sm btn-md-lg px-4 py-2 rounded-pill shadow">
                Daftar Sebagai Pemilik Kos
            </a>
        </div>
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
        layers: [osm]
    })


    var kosList = @json($kosList);
    var kosCluster = L.markerClusterGroup();

    kosList.forEach(kos => {
        let iconUrl;
        if (kos.tipe_kamar.toLowerCase() === 'kos putra') {
            iconUrl = 'iconMarkers/koscowo.svg';
        } else if (kos.tipe_kamar.toLowerCase() === 'kos putri') {
            iconUrl = 'iconMarkers/koscewe.svg';
        } else {
            iconUrl = 'iconMarkers/koscampur.svg';
        }

        // Buat custom icon
        var customIcon = L.icon({
            iconUrl: iconUrl,
            iconSize: [32, 32],
            iconAnchor: [16, 32],
            popupAnchor: [0, -32]
        });

        map.createPane('paneKos');
        map.getPane('paneKos').style.zIndex = 650;

        // Tambahkan marker dengan icon yang sesuai
        let marker = L.marker([kos.latitude, kos.longitude], { icon: customIcon,  pane: 'paneKos' })
            .bindPopup(`
                <div style="max-width:250px">
                    <img src="/storage/foto_kos/${kos.foto}" style="width:100%; height:auto; border-radius:8px; margin-bottom:5px;">
                    <strong>${kos.nama_kos.charAt(0).toUpperCase() + kos.nama_kos.slice(1)}</strong><br>
                    Alamat : ${kos.alamat}<br>
                    Harga Sewa : Rp ${parseInt(kos.harga_sewa).toLocaleString()}<br>
                    Tipe Kamar : ${kos.tipe_kamar}<br>
                    Fasilitas : ${kos.fasilitas}<br>
                    Kontak : ${kos.nomor_kontak}
                </div>
            `);
        kosCluster.addLayer(marker);
    });

    map.addLayer(kosCluster);

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

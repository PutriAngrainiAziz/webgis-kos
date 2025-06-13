@extends('pemilik.layouts.layout')

@section('pemilik_page_title')
    Dashboard Pemilik Kos
@endsection

@section('css')
<style>
    #map {
        height: 500px;
        width: 100%;
    }
</style>
@endsection

@section('pemilik_layout')
<div class="row mb-5 text-center">
    <div class="col">
        <div class="card bg-primary text-white shadow rounded-3 py-1">
            <div class="card-body">
                <i class="bi bi-building fs-2 mb-2"></i>
                <h6>Total Kos</h6>
                <h3>{{ $totalKos }}</h3>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card bg-success text-white shadow rounded-3 py-1">
            <div class="card-body">
                <i class="bi bi-check-circle-fill fs-2 mb-2"></i>
                <h6>Kos Aktif</h6>
                <h3>{{ $kosAktif }}</h3>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card bg-secondary text-white shadow rounded-3 py-1">
            <div class="card-body">
                <i class="bi bi-slash-circle-fill fs-2 mb-2"></i>
                <h6>Kos Nonaktif</h6>
                <h3>{{ $kosNonaktif }}</h3>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card bg-info text-white shadow rounded-3 py-1">
            <div class="card-body">
                <i class="bi bi-patch-check-fill fs-2 mb-2"></i>
                <h6>Terverifikasi</h6>
                <h3>{{ $kosTerverifikasi }}</h3>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card bg-warning text-white shadow rounded-3 py-1">
            <div class="card-body">
                <i class="bi bi-hourglass-split fs-2 mb-2"></i>
                <h6>Belum di Verifikasi</h6>
                <h3>{{ $kosBelumTerverifikasi }}</h3>
            </div>
        </div>
    </div>
</div>


<div id="map"></div>
@endsection

@push('javascript')
{{-- <script>
    const map = L.map('map').setView([-4.0, 122.5], 13); // Koordinat awal Kendari misalnya

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap'
    }).addTo(map);

    const iconAktif = L.icon({
        iconUrl: '/iconMarkers/aktif.svg',
        iconSize: [120, 120]
    });

    const iconNonaktif = L.icon({
        iconUrl: '/iconMarkers/nonaktif.svg',
        iconSize: [120, 120]
    });

    const kosData = @json($kosList);

    kosData.forEach(kos => {
        if (kos.latitude && kos.longitude) {
            const markerIcon = kos.status === 'aktif' ? iconAktif : iconNonaktif;
            L.marker([kos.latitude, kos.longitude], { icon: markerIcon })
                .addTo(map)
                .bindPopup(`
    <strong>${kos.nama_kos}</strong><br>
    Alamat: ${kos.alamat}<br>
    Harga Sewa: Rp${kos.harga_sewa}<br>
    Tipe Kamar: ${kos.tipe_kamar}<br>
    Fasilitas: ${kos.fasilitas || '-'}<br>
    Kontak: ${kos.nomor_kontak}<br>
    Foto: <br><img src="/storage/foto_kos/${kos.foto}" alt="Foto Kos" width="150"><br>
`);

        }
    });
</script> --}}

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
    // const pendidikan = L.layerGroup();


    var map = L.map('map', {
        center: [-4.020705809212554, 122.52818392075301],
        zoom: 13,
        layers: [osm]
    })


    var kosList = @json($kosList);
    var kosCluster = L.markerClusterGroup();

    kosList.forEach(kos => {
        // Tentukan icon berdasarkan tipe_kamar
        let iconUrl;
        if (kos.status.toLowerCase() === 'aktif') {
            iconUrl = '/iconMarkers/aktif.svg';
        } else {
            iconUrl = '/iconMarkers/nonaktif.svg'; // default atau tipe 'Campur'
        }

        // Buat custom icon
        var customIcon = L.icon({
            iconUrl: iconUrl,
            iconSize: [120, 120], // bisa kamu sesuaikan
            iconAnchor: [16, 32], // titik bawah icon
            popupAnchor: [0, -32] // posisi popup relatif terhadap icon
        });

        // Tambahkan marker dengan icon yang sesuai
        let marker = L.marker([kos.latitude, kos.longitude], { icon: customIcon })
            .bindPopup(`
                <div style="max-width:250px">
                    <img src="/storage/foto_kos/${kos.foto}" style="width:100%; height:auto; border-radius:8px; margin-bottom:5px;">
                    <strong>${kos.nama_kos.charAt(0).toUpperCase() + kos.nama_kos.slice(1)}</strong><br>
                    Alamat : ${kos.alamat}<br>
                    Harga Sewa : Rp ${parseInt(kos.harga_sewa).toLocaleString()}<br>
                    Tipe Kamar : ${kos.tipe_kamar}<br>
                    Fasilitas : ${kos.fasilitas}<br>
                    Kontak : ${kos.nomor_kontak}<br>
                    Status Verifikasi : ${kos.status_verifikasi}
                </div>
            `);
        kosCluster.addLayer(marker);
    });

    map.addLayer(kosCluster);



    fetch('/geojson/keckambu.geojson')
        .then(res => res.json())
        .then(data => {
            L.geoJSON(data, {
                style: {
                    color: 'red'
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


    const baseLayers = {
        'Open Street Map': osm,
        'Stadia Alidade': Stadia_AlidadeSatellite,
        'Esri World': Esri_WorldStreetMap,
        'MtbMap': MtbMap
    }

    const overlayers = {
        'keckambu': keckambu,
        'masjid': masjid,
        // 'pendidikan': pendidikan,
        'Kos': kosCluster
    }

    const layerControl = L.control.layers(baseLayers, overlayers).addTo(map)


    //icon user_location
    var iconUserLocation = L.icon({
        iconUrl: "{{ asset('iconMarkers/lokasisaatini.svg') }}",
        iconSize: [120, 120],
        iconAnchor: [20, 40],
        popupAnchor: [0, -40]
    });

    // Kontrol kustom
    L.Control.MyLocation = L.Control.extend({
        onAdd: function (map) {
            let btn = L.DomUtil.create('button');
            btn.title = 'Tampilkan Lokasi Anda';
            btn.innerHTML = `<img src="{{ asset('iconMarkers/my-location-svgrepo-com.svg') }}" style="width: 24px;">`;

            // Tambahkan class CSS agar bisa diatur tampilannya
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
            // optional cleanup
        }
    });

    // Tambahkan ke peta, posisinya sama dengan zoom (top left)
    L.control.myLocation = function (opts) {
        return new L.Control.MyLocation(opts);
    }

    L.control.myLocation({ position: 'topleft' }).addTo(map);

</script>

@endpush


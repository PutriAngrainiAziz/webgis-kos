@extends('admin.layouts.layout')

@section('admin_page_title')
    Admin Page
@endsection


@section('admin_layout')
<div class="row text-center justify-content-center flex-wrap gap-2">
    <div class="col-lg-1 col-md-2 stat-box">
        <div class="stat-icon text-primary"><i class="bi bi-building"></i></div>
        <h6>Total Kos</h6>
        <h3>{{ $totalKos }}</h3>
    </div>

    <div class="col-lg-1 col-md-2 stat-box">
        <div class="stat-icon text-success"><i class="bi bi-check-circle-fill"></i></div>
        <h6>Kos Aktif</h6>
        <h3>{{ $totalKosAktif }}</h3>
    </div>

    <div class="col-lg-1 col-md-2 stat-box">
        <div class="stat-icon text-secondary"><i class="bi bi-slash-circle-fill"></i></div>
        <h6>Nonaktif</h6>
        <h3>{{ $totalKosNonaktif }}</h3>
    </div>

    <div class="col-lg-1 col-md-2 stat-box">
        <div class="stat-icon text-primary"><i class="bi bi-patch-check-fill"></i></div>
        <h6>Terverifikasi</h6>
        <h3>{{ $totalKosTerverifikasi }}</h3>
    </div>

    <div class="col-lg-1 col-md-2 stat-box">
        <div class="stat-icon text-warning"><i class="bi bi-hourglass-split"></i></div>
        <h6>Belum Verif</h6>
        <h3>{{ $totalKosBelumTerverifikasi }}</h3>
    </div>

    <div class="col-lg-1 col-md-2 stat-box">
        <div class="stat-icon text-info"><i class="bi bi-person-badge"></i></div>
        <h6>Pemilik</h6>
        <h3>{{ $totalPemilik }}</h3>
    </div>

    <div class="col-lg-1 col-md-2 stat-box">
        <div class="stat-icon text-secondary"><i class="bi bi-person"></i></div>
        <h6>Pengguna</h6>
        <h3>{{ $totalPengguna }}</h3>
    </div>
</div>

<div class="mt-5">
    <div id="map" style="height: 400px; border-radius: 10px;"></div>
</div>
@endsection


@push('javascript')
{{-- <script>
    var map = L.map('map').setView([-3.9817, 122.5100], 13); // Sesuaikan dengan lokasi kamu

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
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
    const markers = L.markerClusterGroup();

    kosData.forEach(kos => {
        if (kos.latitude && kos.longitude) {
            const markerIcon = kos.status === 'aktif' ? iconAktif : iconNonaktif;

            const marker = L.marker([kos.latitude, kos.longitude], { icon: markerIcon })
                .bindPopup(`
                    <strong>${kos.nama_kos}</strong><br>
                    Alamat: ${kos.alamat}<br>
                    Harga Sewa: Rp${kos.harga_sewa}<br>
                    Tipe Kamar: ${kos.tipe_kamar}<br>
                    Fasilitas: ${kos.fasilitas || '-'}<br>
                    Kontak: ${kos.nomor_kontak}<br>
                    Foto:<br><img src="/storage/foto_kos/${kos.foto}" alt="Foto Kos" width="150">
                `);

            markers.addLayer(marker);
        }
    });

    map.addLayer(markers); // Tambahkan semua marker ke peta

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
        if (kos.status_verifikasi.toLowerCase() === 'disetujui') {
            iconUrl = '/iconMarkers/aktif.svg';
        } else if (kos.status_verifikasi.toLowerCase() === 'ditolak') {
            iconUrl = '/iconMarkers/toolak.svg';
        } else {
            iconUrl = '/iconMarkers/menunggu.svg'; // default menunggu
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
                    Status : ${kos.status}
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


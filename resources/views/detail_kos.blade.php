<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Kos - {{ $kos->nama_kos }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('home_asset/css/detailkos.css') }}">
</head>
<body>

<div class="container">
    {{-- <a href="{{ url()->previous() }}" class="btn-back">←</a> --}}
    <div class="image-section">
        <img src="{{ asset('storage/foto_kos/' . $kos->foto) }}" alt="Foto Kos {{ $kos->nama_kos }}">
    </div>

    <div class="info-section">
        <h2>{{ $kos->nama_kos }}</h2>

        <div class="detail"><strong>Alamat:</strong> {{ $kos->alamat }}</div>
        <div class="detail"><strong>Tipe Kamar:</strong> {{ $kos->tipe_kamar }}</div>
        <div class="detail"><strong>Harga Sewa:</strong> Rp {{ number_format($kos->harga_sewa, 0, ',', '.') }} / bulan</div>
        <div class="detail"><strong>Fasilitas:</strong> {{ $kos->fasilitas }}</div>
        <div class="detail"><strong>Nomor Kontak:</strong> {{ $kos->nomor_kontak }}</div>
    </div>
</div>

<div id="map" style="height: 350px; margin: 40px; border-radius: 12px;"></div>

</body>
</html>

<!-- Leaflet CSS & JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        var map = L.map('map').setView([{{ $kos->latitude }}, {{ $kos->longitude }}], 16);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        L.marker([{{ $kos->latitude }}, {{ $kos->longitude }}])
            .addTo(map)
            .bindPopup("<b>{{ $kos->nama_kos }}</b>")
            .openPopup();

        // Icon Lokasi User
        var iconUserLocation = L.icon({
            iconUrl: "{{ asset('iconMarkers/lokasisaatini.svg') }}",
            iconSize: [40, 40],
            iconAnchor: [20, 40],
            popupAnchor: [0, -40]
        });

        // Custom Button Control
        L.Control.MyLocation = L.Control.extend({
            onAdd: function (map) {
                let btn = L.DomUtil.create('button');
                btn.title = 'Tampilkan Lokasi Anda';
                btn.innerHTML = `<img src="{{ asset('iconMarkers/my-location-svgrepo-com.svg') }}" style="width: 24px;">`;
                btn.className = 'leaflet-bar leaflet-control leaflet-control-custom';

                L.DomEvent.on(btn, 'click', function () {
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(
                            function (position) {
                                var lat = position.coords.latitude;
                                var lng = position.coords.longitude;

                                L.marker([lat, lng], { icon: iconUserLocation })
                                    .addTo(map)
                                    .bindPopup("Lokasi Anda Sekarang")
                                    .openPopup();

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
            onRemove: function (map) {}
        });

        L.control.myLocation = function (opts) {
            return new L.Control.MyLocation(opts);
        }

        L.control.myLocation({ position: 'topleft' }).addTo(map);
    });
</script>

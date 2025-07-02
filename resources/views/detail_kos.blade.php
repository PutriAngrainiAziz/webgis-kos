@extends('layouts.layout')

@section('home_page_title')
Detail Kos - {{ $kos->nama_kos }}
@endsection

@section('detail_kos')
<div id="kos" class="kos-detail-container">
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

<div id="map"></div>
<div id="route-info" style="margin: 10px; font-weight: bold; background: #f3f3f3; padding: 10px; border-radius: 8px;">Tampilkan Lokasi Saya untuk Melihat Rute ke Kos!</div>



<script>
    document.addEventListener("DOMContentLoaded", function () {
        // BASE LAYERS
        var osm = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap contributors'
        });

        var Stadia_AlidadeSatellite = L.tileLayer('https://tiles.stadiamaps.com/tiles/alidade_satellite/{z}/{x}/{y}{r}.jpg', {
            minZoom: 0,
            maxZoom: 20,
            attribution: '&copy; CNES, Airbus DS | <a href="https://www.stadiamaps.com/">Stadia Maps</a>'
        });

        var Esri_WorldStreetMap = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Street_Map/MapServer/tile/{z}/{y}/{x}', {
            attribution: 'Tiles &copy; Esri'
        });

        var MtbMap = L.tileLayer('http://tile.mtbmap.cz/mtbmap_tiles/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors &amp; USGS'
        });

        // OVERLAY GROUP
        const kos = L.layerGroup();
        const keckambu = L.layerGroup();
        const masjid = L.layerGroup();
        const universitas = L.layerGroup();

        // INISIALIASI MAP
        var map = L.map('map', {
            center: [{{ $kos->latitude }}, {{ $kos->longitude }}],
            zoom: 15,
            fullscreenControl: true,
            layers: [osm, kos]
        });

        map.on('enterFullscreen', function(){
            console.log('Masuk Fullscreen');
        });

        map.on('exitFullscreen', function(){
            console.log('Keluar dari Fullscreen');
        });

        // MARKER KOS
        L.marker([{{ $kos->latitude }}, {{ $kos->longitude }}])
            .addTo(kos)
            .bindPopup("<b>{{ $kos->nama_kos }}</b>")
            .openPopup();

        // KECAMATAN KAMBU
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

        // MASJID
        var iconMasjid = L.icon({
            iconUrl: "{{ asset('iconMarkers/tempatIbadah_4.png') }}",
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
                            layer.bindPopup(`<b>${feature.properties["Nama Masji"]}</b>`);
                        }
                    }
                }).addTo(masjid);
            });

        // UNIVERSITAS
        var iconUniv = L.icon({
            iconUrl: "{{ asset('iconMarkers/universitas_3.png') }}",
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
                            layer.bindPopup(`<b>${feature.properties["Nama Unive"]}</b>`);
                        }
                    }
                }).addTo(universitas);
            });

        // LAYER CONTROL
        const baseLayers = {
            'Open Street Map': osm,
            'Stadia Satellite': Stadia_AlidadeSatellite,
            'Esri World': Esri_WorldStreetMap,
            'MTB Map': MtbMap
        };

        const overlays = {
            'Kos': kos,
            'Masjid': masjid,
            'Universitas': universitas,
            'Batas Kec. Kambu': keckambu
        };

        L.control.layers(baseLayers, overlays).addTo(map);


        //Rute
        let userToKosRoute;
        function showRouteToKos(userLat, userLng) {
            if (userToKosRoute) {
                map.removeControl(userToKosRoute);
            }

            L.marker([userLat, userLng], { icon: iconUserLocation })
                .addTo(map)
                .bindPopup("<b>Lokasi Sekarang</b>")
                .openPopup();

            // Routing control
            userToKosRoute = L.Routing.control({
                waypoints: [
                    L.latLng(userLat, userLng),
                    L.latLng({{ $kos->latitude }}, {{ $kos->longitude }})
                ],
                routeWhileDragging: false,
                show: false,
                addWaypoints: false,
                createMarker: function () { return null; }
            }).addTo(map);

            // Tampilkan jarak & waktu tempuh
            userToKosRoute.on('routesfound', function (e) {
                const route = e.routes[0];
                const distance = (route.summary.totalDistance / 1000).toFixed(2);
                const time = Math.ceil(route.summary.totalTime / 60);

                document.getElementById('route-info').innerHTML = `
                    <div style="
                        background: linear-gradient(to right, #e0f7fa, #f1f8e9);
                        padding: 15px;
                        border-radius: 12px;
                        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                        font-family: 'Segoe UI', sans-serif;
                        font-size: 16px;
                        color: #333;
                        line-height: 1.6;
                    ">
                        <div><i class="bi bi-geo-alt-fill" style="color: #0d6efd;"></i> <strong>Jarak Tempuh:</strong> ${distance} km</div>
                        <div><i class="bi bi-clock-fill" style="color: #198754;"></i> <strong>Perkiraan Waktu Tempuh:</strong> ${time} menit</div>
                    </div>
                `;

            });
        }

        // USER LOCATION BUTTON
        var iconUserLocation = L.icon({
            iconUrl: "{{ asset('iconMarkers/lokasisaatini.svg') }}",
            iconSize: [50, 50],
            iconAnchor: [20, 41],
            popupAnchor: [0, -35]
        });

        L.Control.MyLocation = L.Control.extend({
            onAdd: function () {
                let btn = L.DomUtil.create('button');
                btn.title = 'Tampilkan Lokasi Anda';
                btn.innerHTML = `<img src="{{ asset('iconMarkers/my-location-svgrepo-com.svg') }}" style="width: 24px;">`;
                btn.className = 'leaflet-bar leaflet-control leaflet-control-custom';

                L.DomEvent.on(btn, 'click', function () {
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(
                            function (position) {
                                const { latitude, longitude } = position.coords;

                                map.setView([latitude, longitude], 15);
                                showRouteToKos(latitude, longitude);
                            },
                            function () {
                                alert("Gagal mendapatkan lokasi Anda.");
                            }
                        );
                    } else {
                        alert("Browser tidak mendukung Geolocation.");
                    }
                });

                return btn;
            }
        });

        L.control.myLocation = function (opts) {
            return new L.Control.MyLocation(opts);
        }

        L.control.myLocation({ position: 'topleft' }).addTo(map);
    });
</script>


@endsection

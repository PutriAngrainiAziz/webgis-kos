@extends('pemilik.layouts.layout')

@section('pemilik_page_title')
    Dashboard Pemilik Kos
@endsection



@section('pemilik_layout')
<div class="container-fluid">
    <div class="container py-3">
        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-5 g-3">
            <div class="col">
                <div class="p-2 bg-primary text-white rounded shadow-sm">
                    <i class="bi bi-building fs-3"></i>
                    <div class="fw-semibold">Total Kos</div>
                    <div class="fs-5">{{ $totalKos }}</div>
                </div>
            </div>
            <div class="col">
                <div class="p-2 bg-success text-white rounded shadow-sm">
                    <i class="bi bi-check-circle-fill fs-3"></i>
                    <div class="fw-semibold">Kos Aktif</div>
                    <div class="fs-5">{{ $kosAktif }}</div>
                </div>
            </div>
            <div class="col">
                <div class="p-2 bg-secondary text-white rounded shadow-sm">
                    <i class="bi bi-slash-circle-fill fs-3"></i>
                    <div class="fw-semibold">Kos Nonaktif</div>
                    <div class="fs-5">{{ $kosNonaktif }}</div>
                </div>
            </div>
            <div class="col">
                <div class="p-2 bg-info text-white rounded shadow-sm">
                    <i class="bi bi-patch-check-fill fs-3"></i>
                    <div class="fw-semibold">Terverifikasi</div>
                    <div class="fs-5">{{ $kosTerverifikasi }}</div>
                </div>
            </div>
            <div class="col">
                <div class="p-2 bg-warning text-white rounded shadow-sm">
                    <i class="bi bi-hourglass-split fs-3"></i>
                    <div class="fw-semibold">Non Terverifikasi</div>
                    <div class="fs-5">{{ $kosBelumTerverifikasi }}</div>
                </div>
            </div>
        </div>
    </div>

    <div id="map"></div>
</div>
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
        if (kos.status.toLowerCase() === 'aktif') {
            iconUrl = '/iconMarkers/aktif.svg';
        } else {
            iconUrl = '/iconMarkers/nonaktif.svg';
        }

        // Buat custom icon
        var customIcon = L.icon({
            iconUrl: iconUrl,
            iconSize: [32, 32],
            iconAnchor: [16, 32],
            popupAnchor: [0, -32]
        });

        // Tambahkan marker dengan icon yang sesuai
        let marker = L.marker([kos.latitude, kos.longitude], { icon: customIcon })
            .bindPopup(`
                <div style="max-width:200px; max-height:240px; overflow-y:auto; font-size: 13px; line-height:1.4;">
                    <img src="/storage/foto_kos/${kos.foto}"style="width: 100%; height: 120px; object-fit: cover; border-radius: 6px; margin-bottom: 6px;">
                    <div><strong>${kos.nama_kos}</strong></div>
                    <div><strong>Alamat:</strong> ${kos.alamat}</div>
                    <div><strong>Harga Sewa:</strong> Rp ${parseInt(kos.harga_sewa).toLocaleString()}</div>
                    <div><strong>Tipe Kamar:</strong> ${kos.tipe_kamar}</div>
                    <div><strong>Fasilitas:</strong> ${kos.fasilitas}</div>
                    <div><strong>Kontak:</strong> ${kos.nomor_kontak}</div>
                    <div><strong>Status Verifikasi:</strong> ${kos.status_verifikasi}</div>
                </div>
            `)

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
        'keckambu': keckambu,
        'masjid': masjid,
        'universitas': universitas,
        'Kos': kosCluster
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



@extends('pemilik.layouts.layout')

@section('css')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
    crossorigin="" />
<style>
    #map {
        height: 500px;
        width: 100%;
    }
</style>
@endsection

@section('peta_kos')
<div class="row mb-3">
    <div class="col-md-4">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h5 class="card-title text-white">Total Kos</h5>
                <p class="card-text">{{ $totalKos }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h5 class="card-title text-white">Kos Aktif</h5>
                <p class="card-text">{{ $kosAktif }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-danger">
            <div class="card-body">
                <h5 class="card-title text-white">Kos Nonaktif</h5>
                <p class="card-text">{{ $kosNonaktif }}</p>
            </div>
        </div>
    </div>
</div>

<div id="map"></div>

@endsection

@push('javascript')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
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
</script>

@endpush

@extends('pemilik.layouts.layout')

@section('pemilik_page_title')
    Pemilik Tambah Kos
@endsection

@section('tambah_kos')

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="form-container">
                <div class="card-header form-title fs-8 fw-bold">
                    <i class="bi bi-house-door-fill me-2"></i> Tambah Data Kos Baru
                </div>

                <form action="{{ route('kos.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label for="nama_kos" class="form-label">Nama Kos</label>
                            <input type="text" class="form-control" id="nama_kos" name="nama_kos" placeholder="Contoh: Kos Mawar" required>
                        </div>

                        <div class="col-md-6">
                            <label for="alamat" class="form-label">Alamat Lengkap</label>
                            <input type="text" class="form-control" id="alamat" name="alamat" required>
                        </div>

                        <div class="col-md-6">
                            <label for="harga_sewa" class="form-label">Harga Sewa (per bulan)</label>
                            <input type="number" class="form-control" id="harga_sewa" name="harga_sewa" placeholder="Contoh: 750000" required min="0" step="1">
                        </div>

                        <div class="col-md-6">
                            <label for="tipe_kamar" class="form-label">Tipe Kamar</label>
                            <select name="tipe_kamar" id="tipe_kamar" class="form-select" required>
                                <option value="">-- Pilih Tipe Kamar --</option>
                                <option value="Kos Campur">Kos Campur</option>
                                <option value="Kos Putri">Kos Putri</option>
                                <option value="Kos Putra">Kos Putra</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="fasilitas" class="form-label">Fasilitas</label>
                            <textarea name="fasilitas" id="fasilitas" class="form-control" rows="3" placeholder="Contoh: WiFi, AC, Kamar Mandi Dalam"></textarea>
                        </div>

                        <div class="col-md-6">
                            <label for="nomor_kontak" class="form-label">Nomor Kontak</label>
                            <input type="tel" class="form-control" id="nomor_kontak" name="nomor_kontak"
                                pattern="[0-9]{10,13}"
                                title="Masukkan nomor 10 sampai 13 digit angka tanpa spasi atau tanda lain"
                                required
                                oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                        </div>


                        <div class="col-md-6">
                            <label for="status" class="form-label">Status Kos</label>
                            <select name="status" id="status" class="form-select" required>
                                <option value="aktif" selected>Aktif</option>
                                <option value="nonaktif">Nonaktif</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="foto" class="form-label">Foto Kos</label>
                            <input type="file" class="form-control" name="foto" id="foto" accept="image/*">
                        </div>

                        {{-- <div class="col-12">
                            <label class="form-label">Pilih Lokasi Kos di Peta</label>
                            <div id="map" style="height: 250px; max-height: 50vh;" class="rounded shadow-sm mt-2"></div>
                            <input type="hidden" id="latitude" name="latitude" required>
                            <input type="hidden" id="longitude" name="longitude" required>
                        </div> --}}
                        <label class="form-label">Pilih Lokasi Kos di Peta</label>
                        <div id="map" style="height: 250px;" class="rounded shadow-sm mt-2"></div>

                        <div class="row mt-2">
                        <div class="col-md-6">
                            <label>Latitude</label>
                            <input type="text" class="form-control" id="latitude" name="latitude" required>
                        </div>
                        <div class="col-md-6">
                            <label>Longitude</label>
                            <input type="text" class="form-control" id="longitude" name="longitude" required>
                        </div>
                        </div>

                        <button type="submit" class="btn btn-save w-100">
                            <i class="bi bi-save-fill me-1"></i> Simpan Data Kos
                        </button>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('javascript')


<script>
    const map = L.map('map').setView([-4.01, 122.52], 13);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

    let marker;

    map.on('click', function(e) {
        const {
            lat,
            lng
        } = e.latlng;
        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;

        if (marker) map.removeLayer(marker);
        marker = L.marker([lat, lng]).addTo(map);
    });
</script>

<!-- Pastikan Leaflet sudah ter-load -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>

<script>
    let map = L.map('map').setView([-3.9828, 122.5189], 13); // Koordinat Kendari default
    let marker;

    // Tampilkan peta
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: 'Leaflet &copy; OpenStreetMap',
    }).addTo(map);

    // Fungsi untuk set marker di peta
    function setMarker(lat, lng) {
        if (marker) {
            marker.setLatLng([lat, lng]);
        } else {
            marker = L.marker([lat, lng], { draggable: true }).addTo(map);
            marker.on('dragend', function (e) {
                let pos = e.target.getLatLng();
                document.getElementById('latitude').value = pos.lat;
                document.getElementById('longitude').value = pos.lng;
            });
        }
        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;
    }

    // Saat klik di peta
    map.on('click', function (e) {
        setMarker(e.latlng.lat, e.latlng.lng);
    });

    // Update marker saat isi input manual
    document.getElementById('latitude').addEventListener('input', function () {
        updateMarkerFromInput();
    });
    document.getElementById('longitude').addEventListener('input', function () {
        updateMarkerFromInput();
    });

    function updateMarkerFromInput() {
        let lat = parseFloat(document.getElementById('latitude').value);
        let lng = parseFloat(document.getElementById('longitude').value);
        if (!isNaN(lat) && !isNaN(lng)) {
            setMarker(lat, lng);
            map.setView([lat, lng], 15);
        }
    }
</script>

@endpush

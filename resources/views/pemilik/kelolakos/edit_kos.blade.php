@extends('pemilik.layouts.layout')
@section('pemilik_page_title')
    Pemilik Edit Kos
@endsection

@section('edit_kos')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-primary text-white text-center fs-4 fw-bold rounded-top-4">
                    <i class="bi bi-pencil-square me-2"></i>Edit Data Kos
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('kelolakos.update', $kos->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nama_kos" class="form-label">Nama Kos</label>
                                <input type="text" class="form-control" id="nama_kos" name="nama_kos" required
                                    value="{{ old('nama_kos', $kos->nama_kos) }}">
                            </div>
                            <div class="col-md-6">
                                <label for="alamat" class="form-label">Alamat Lengkap</label>
                                <input type="text" class="form-control" id="alamat" name="alamat" required
                                    value="{{ old('alamat', $kos->alamat) }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="harga_sewa" class="form-label">Harga Sewa (per bulan)</label>
                                <input type="number" class="form-control" id="harga_sewa" name="harga_sewa" required min="0" step="1"
                                    value="{{ old('harga_sewa', $kos->harga_sewa) }}">
                            </div>
                            <div class="col-md-6">
                                <label for="tipe_kamar" class="form-label">Tipe Kamar</label>
                                <select name="tipe_kamar" id="tipe_kamar" class="form-select" required>
                                    <option value="">-- Pilih Tipe Kamar --</option>
                                    <option value="Kos Campur" {{ old('tipe_kamar', $kos->tipe_kamar) == 'Kos Campur' ? 'selected' : '' }}>Kos Campur</option>
                                    <option value="Kos Putri" {{ old('tipe_kamar', $kos->tipe_kamar) == 'Kos Putri' ? 'selected' : '' }}>Kos Putri</option>
                                    <option value="Kos Putra" {{ old('tipe_kamar', $kos->tipe_kamar) == 'Kos Putra' ? 'selected' : '' }}>Kos Putra</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="fasilitas" class="form-label">Fasilitas</label>
                            <textarea name="fasilitas" id="fasilitas" class="form-control" rows="3">{{ old('fasilitas', $kos->fasilitas) }}</textarea>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nomor_kontak" class="form-label">Nomor Kontak</label>
                                <input type="text" class="form-control" id="nomor_kontak" name="nomor_kontak" required
                                    value="{{ old('nomor_kontak', $kos->nomor_kontak) }}">
                            </div>
                            <div class="col-md-6">
                                <label for="status" class="form-label">Status Kos</label>
                                <select name="status" id="status" class="form-select" required>
                                    <option value="aktif" {{ $kos->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="nonaktif" {{ $kos->status == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Pilih Lokasi Kos di Peta</label>
                            <div id="map" style="height: 300px; border: 2px solid #ccc; border-radius: 10px;"></div>
                            <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude', $kos->latitude) }}" required>
                            <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude', $kos->longitude) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="foto" class="form-label">Foto Kos (biarkan kosong jika tidak ingin mengubah)</label>
                            <input type="file" class="form-control" name="foto" id="foto">
                            @if ($kos->foto)
                                <div class="mt-2">
                                    <p class="mb-1">Foto Sekarang:</p>
                                    <img src="{{ asset('storage/foto_kos/' . $kos->foto) }}" alt="Foto Kos" class="img-fluid rounded" width="200">
                                </div>
                            @endif
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary rounded shadow-sm">
                                <i class="bi bi-arrow-repeat me-1"></i> Update Kos
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

@push('javascript')
<script>
    const map = L.map('map').setView([{{ old('latitude', $kos->latitude) ?? -4.01 }}, {{ old('longitude', $kos->longitude) ?? 122.52 }}], 13);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

    let marker;

    if("{{ old('latitude', $kos->latitude) }}" && "{{ old('longitude', $kos->longitude) }}"){
        marker = L.marker([{{ old('latitude', $kos->latitude) }}, {{ old('longitude', $kos->longitude) }}]).addTo(map);
    }

    map.on('click', function(e) {
        const { lat, lng } = e.latlng;
        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;

        if (marker) map.removeLayer(marker);
        marker = L.marker([lat, lng]).addTo(map);
    });
</script>
@endpush

@extends('admin.layouts.layout')

@section('css')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
    crossorigin="" />

<style>
    #map {
        height: 400px;
    }
</style>
@endsection

@section('peta_layout')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Markers</div>
                <div class="card-body">
                    <div id="map"></div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@push('javascript')
<!-- Make sure you put this AFTER Leaflet's CSS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
    crossorigin=""></script>

<script>
    const map = L.map('map').setView([-4.020705809212554, 122.52818392075301], 13);

    const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    var iconMarkers = L.icon({
        iconUrl: "{{ asset('iconMarkers/icon.png')}}",
        iconSize:[50, 50],
    });

    var marker = L.marker([-4.005065769685005, 122.51419467703386],{
        icon:iconMarkers,
        draggable:true
    })
        .bindPopup('Tampilan pesan')
        .addTo(map);
</script>
@endpush

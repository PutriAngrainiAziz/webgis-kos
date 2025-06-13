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
                <div class="card-header">Layer Control</div>
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

    var map = L.map('map', {
        center:[-4.020705809212554, 122.52818392075301],
        zoom:5,
        layers:[osm]
    })

    var iconMarkers = L.icon({
        iconUrl: "{{ asset('iconMarkers/icon.png')}}",
        iconSize: [50, 50],
    });

    var marker = L.marker([-4.005065769685005, 122.51419467703386], {
            icon: iconMarkers,
            draggable: true
        })
        .bindPopup('Tampilan pesan')
        .addTo(map);

        var baseMaps = {
            'Open Street Map':osm,
            'Stadia Alidade':Stadia_AlidadeSatellite,
            'Esri World':Esri_WorldStreetMap,
            'MtbMap':MtbMap
        }

        var overlayers = {
            'Marker':marker
        }

        L.control.layers(baseMaps,overlayers).addTo(map)
</script>
@endpush

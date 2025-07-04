@extends('pemilik.layouts.layout')
@section('pemilik_page_title')
    Profile Pemilik
@endsection

@section('content')
<div id="profile" class="container" style="padding-bottom:10px;">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card border-0 shadow-lg">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <img src="{{ asset('home_asset/penggunaasset/profile.svg') }}" class="img-fluid rounded-circle" width="100" height="100" alt="Foto Profil">
                        <h4 class="mt-3 mb-1">{{ Auth::user()->name }}</h4>
                        <p class="text-muted">{{ Auth::user()->email }}</p>
                    </div>

                    <hr class="my-4">

                    <div class="row mb-3">
                        <div class="col-sm-4 fw-bold">Nama Lengkap</div>
                        <div class="col-sm-8">{{ Auth::user()->name }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-4 fw-bold">Email</div>
                        <div class="col-sm-8">{{ Auth::user()->email }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-4 fw-bold">Nomor Telepon</div>
                        <div class="col-sm-8">{{ Auth::user()->no_telp ?? '-' }}</div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-sm-4 fw-bold">Alamat</div>
                        <div class="col-sm-8">{{ Auth::user()->alamat ?? '-' }}</div>
                    </div>

                    <div class="text-center">
                        <a href="{{ route('profile.edit.pemilik') }}" class="btn btn-primary px-4">
                            <i class="bi bi-pencil-square me-1"></i> Edit Profil
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

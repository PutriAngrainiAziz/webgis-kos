@extends('pengguna.layouts.layout')

@section('content')
<div id="favorit" class="container py-4">

    @if ($kosFavorit->isEmpty())
        <p class="text-muted">Belum ada kos favorit.</p>
    @else
        <div class="d-flex overflow-auto gap-4 pb-3 favorit-container">
            @foreach ($kosFavorit as $kos)
                <div class="card kos-card shadow-sm d-flex flex-column position-relative">

                    <div class="kos-image-wrapper">
                        <img
                            src="{{ asset('storage/foto_kos/' . $kos->foto) }}"
                            alt="{{ $kos->nama_kos }}"
                        >

                        @auth
                            @php
                                $sudahFavorit = auth()->user()->favoritKos->contains($kos->id);
                            @endphp
                            <form action="{{ route($sudahFavorit ? 'kos.unfavorit' : 'kos.favorit', $kos->id) }}"
                                  method="POST" class="favorit-form">
                                @csrf
                                <button type="submit" class="favorit-icon">
                                    <i class="bi {{ $sudahFavorit ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                                </button>
                            </form>
                        @endauth
                    </div>

                    <div class="p-3 d-flex flex-column flex-grow-1 kos-info">
                        <div class="flex-grow-1">
                            <h5>{{ Str::title($kos->nama_kos) }}</h5>
                            <span>{{ $kos->tipe_kamar }}</span>
                            <p class="mt-2">
                                Harga: <strong>Rp {{ number_format($kos->harga_sewa, 0, ',', '.') }}</strong> / bulan<br>
                                Kontak: {{ $kos->nomor_kontak }}
                            </p>
                        </div>

                        <a href="{{ url('user/detailkos/'.$kos->id) }}"
                            class="btn btn-sm btn-outline-primary mt-3">
                            Selengkapnya
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

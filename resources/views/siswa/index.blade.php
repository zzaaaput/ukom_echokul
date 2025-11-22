@extends('layouts/template')

@section('title', 'Dashboard Siswa')

@section('content')
<div>
    <div id="ekstraCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
        <button type="button" data-bs-target="#ekstraCarousel" data-bs-slide-to="0" class="active"></button>
        <button type="button" data-bs-target="#ekstraCarousel" data-bs-slide-to="1"></button>
        <button type="button" data-bs-target="#ekstraCarousel" data-bs-slide-to="2"></button>
        </div>

        <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="{{ asset('storage/images/smkn1-5.png') }}" class="d-block w-100" alt="Slide 1" style="height: 600px; object-fit: cover;">
        </div>
        <div class="carousel-item">
            <img src="{{ asset('storage/images/smkn1-2.png') }}" class="d-block w-100" alt="Slide 2" style="height: 600px; object-fit: cover;">
        </div>
        <div class="carousel-item">
            <img src="{{ asset('storage/images/smkn1-3.png') }}" class="d-block w-100" alt="Slide 3" style="height: 600px; object-fit: cover;">
        </div>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#ekstraCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#ekstraCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
        </button>
    </div>

    <section class="py-5">
        <div class="container">
        <div class="row text-center g-4">

        <div class="col-md-4">
            <div class="card text-white border-0 shadow-lg rounded-4 py-5" style="background-color: #001f3f;">
            <div class="card-body">
                <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
                <i class="bi bi-bullseye display-3 mb-3"></i>
                <h5 class="fw-bold">VISI MISI</h5>
                <a href="#" class="btn btn-light mt-3">Selengkapnya</a>
            </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-white border-0 shadow-lg rounded-4 py-5" style="background-color: #001f3f;">
            <div class="card-body">
                <i class="bi bi-person-fill display-3 mb-3"></i>
                <h5 class="fw-bold">KEPALA SEKOLAH</h5>
                <a href="#" class="btn btn-light mt-3">Selengkapnya</a>
            </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-white border-0 shadow-lg rounded-4 py-5" style="background-color: #001f3f;">
            <div class="card-body">
                <i class="bi bi-building-fill display-3 mb-3"></i>
                <h5 class="fw-bold">TENTANG SEKOLAH</h5>
                <a href="#" class="btn btn-light mt-3">Selengkapnya</a>
            </div>
            </div>
        </div>

        </div>
        </div>
    </section>

    <section class="container-fluid py-5" style="background-color: #001f3f;">
        <div class="container">
        <h3 class="text-center mb-4 fw-bold text-white">Pengumuman & Acara Sekolah</h3>

        <div class="row g-4">
            @forelse($pengumuman as $row)
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm h-100 hover-card">
                    <div class="position-relative overflow-hidden" style="height: 220px;">
                        @if($row->foto)
                            <img src="{{ asset('storage/' . str_replace('storage/', '', $row->foto)) }}" 
                                 class="card-img-top w-100 h-100" style="object-fit: cover;">
                        @else
                            <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-primary bg-gradient">
                                <i class="bi bi-megaphone text-white" style="font-size: 4rem; opacity:.4"></i>
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                        <h5 class="card-title fw-bold">{{ $row->judul_pengumuman }}</h5>
                        <small class="text-muted">
                            <i class="bi bi-calendar3 me-1"></i>
                            {{ \Carbon\Carbon::parse($row->tanggal)->format('d F Y') }}
                        </small>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="bi bi-inbox text-muted" style="font-size:4rem;"></i>
                        <h4 class="text-muted mt-3">Belum Ada Pengumuman</h4>
                    </div>
                </div>
            </div>
            @endforelse
        </div>

        <div class="mt-5 d-flex justify-content-center">
            {{ $pengumuman->withQueryString()->links() }}
        </div>

        <div class="text-center mt-2">
            <a href="{{ route('pengumuman.index') }}" class="btn btn-outline-light btn-sm px-4">
            Lihat Pengumuman Lainnya
            </a>
        </div>
        </div>
    </section>

    <section class="container my-5">
        <h3 class="text-center mb-4 fw-bold">Pembina Ekstrakurikuler</h3>

        @if($pembinas->isEmpty())
            <p class="text-center text-muted">Belum ada data pembina ekstrakurikuler.</p>
        @else
            <div id="carouselPembina" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
                <div class="carousel-inner">
                    @foreach ($pembinas->chunk(3) as $index => $chunk)
                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                            <div class="row justify-content-center">
                                @foreach ($chunk as $pembina)
                                    @php
                                        $fotoPath = $pembina->pembina && $pembina->pembina->foto
                                            ? asset($pembina->pembina->foto)
                                            : asset('storage/images/default-user.png');
                                    @endphp

                                    <div class="col-md-4 text-center mb-4">
                                        <img src="{{ $fotoPath }}"
                                            class="rounded-circle mx-auto d-block shadow"
                                            alt="{{ $pembina->pembina->nama_lengkap ?? 'Pembina' }}"
                                            style="width: 300px; height: 300px; object-fit: cover;">
                                        <p class="mt-3 mb-0 fw-semibold">
                                            {{ $pembina->pembina->nama_lengkap ?? 'Nama Pembina Tidak Diketahui' }}
                                        </p>
                                        <p class="text-muted">
                                            {{ $pembina->nama_ekstrakurikuler }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Tombol Navigasi --}}
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselPembina" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon rounded-circle p-2" style="background-color: #001f3f;"></span>
                    <span class="visually-hidden">Sebelumnya</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselPembina" data-bs-slide="next">
                    <span class="carousel-control-next-icon rounded-circle p-2" style="background-color: #001f3f;"></span>
                    <span class="visually-hidden">Selanjutnya</span>
                </button>
            </div>
        @endif
    </section>

    <button id="goTopBtn" title="Go To Up"></button>

        <style>
        .card:hover {
        transform: translateY(-8px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        #goTopBtn {
        position: fixed;
        bottom: 30px;
        right: 30px;
        z-index: 99;
        background-color: #2f3539;
        color: white;
        border: none;
        width: 50px;
        height: 50px;
        border-radius: 10px;
        cursor: pointer;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        display: none;
        transition: all 0.3s ease;
        }

        #goTopBtn:hover {
        background-color: #444;
        transform: translateY(-3px);
        }

        #goTopBtn::before {
        content: "↑";
        font-size: 20px;
        }

        #goTopBtn:hover::after {
        content: "Go to top";
        position: absolute;
        bottom: 60px;
        right: 0;
        background: #333;
        color: #fff;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        white-space: nowrap;
        }
    </style>

    <script>
        var goTopBtn = document.getElementById("goTopBtn");

        window.addEventListener("scroll", () => {
        if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
            goTopBtn.style.display = "block";
        } else {
            goTopBtn.style.display = "none";
        }
        });

        goTopBtn.addEventListener("click", () => {
        window.scrollTo({
            top: 0,
            behavior: "smooth"
        });
        });
    </script>
</div>

@endsection
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
            @for ($i = 1; $i <= 3; $i++)
            <div class="col-md-4">
                <div class="card shadow h-100 border-0">
                <img src="{{ asset('storage/images/pengumuman' . $i . '.png') }}" class="card-img-top" alt="Event {{ $i }}">
                <div class="card-body text-center">
                    <h5 class="card-title fw-bold" style="color: #001f3f;">Judul Pengumuman {{ $i }}</h5>
                    <p class="card-text text-dark">Deskripsi singkat pengumuman atau acara sekolah.</p>
                    <a href="#" class="btn btn-sm text-white" style="background-color: #001f3f;">Lihat Selengkapnya</a>
                </div>
                </div>
            </div>
            @endfor
        </div>

        <div class="text-center mt-4">
            <a href="#" class="btn btn-outline-light btn-sm px-4">
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

<!-- <div>
    <div class="bg-primary text-white py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="display-4 fw-bold mb-3">Selamat Datang, {{ Auth::user()->name ?? 'Siswa' }}!</h1>
                    <p class="lead mb-0">Dashboard Ekstrakurikuler SMKN 1</p>
                </div>
                <div class="col-md-4 text-end">
                    <div class="bg-white text-primary rounded-3 p-4 d-inline-block">
                        <h2 class="display-6 fw-bold mb-0">{{ date('d') }}</h2>
                        <p class="mb-0">{{ date('F Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center p-4">
                            <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                <i class="bi bi-calendar-check fs-1 text-primary"></i>
                            </div>
                            <h3 class="fw-bold mb-2">{{ $totalKehadiran ?? 0 }}</h3>
                            <p class="text-muted mb-0">Total Kehadiran</p>
                        </div>
                    </div>
                </div>
    
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center p-4">
                            <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                <i class="bi bi-list-check fs-1 text-success"></i>
                            </div>
                            <h3 class="fw-bold mb-2">{{ $ekstrakurikulerAktif ?? 0 }}</h3>
                            <p class="text-muted mb-0">Ekstrakurikuler Aktif</p>
                        </div>
                    </div>
                </div>
    
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center p-4">
                            <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                <i class="bi bi-trophy fs-1 text-warning"></i>
                            </div>
                            <h3 class="fw-bold mb-2">{{ $totalPrestasi ?? 0 }}</h3>
                            <p class="text-muted mb-0">Prestasi</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <section class="py-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold">Ekstrakurikuler Saya</h3>
                <a href="{{ route('ekstrakurikuler.index') }}" class="btn btn-outline-primary">Lihat Semua</a>
            </div>
    
            @if(isset($ekstrakurikuler) && $ekstrakurikuler->isNotEmpty())
                <div class="row g-4">
                    @foreach($ekstrakurikuler as $ekstra)
                        <div class="col-md-6 col-lg-4">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body">
                                    <div class="d-flex align-items-start mb-3">
                                        <div class="bg-primary bg-opacity-10 rounded p-3 me-3">
                                            <i class="bi bi-bookmark-fill fs-4 text-primary"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h5 class="fw-bold mb-1">{{ $ekstra->nama_ekstrakurikuler }}</h5>
                                            <p class="text-muted small mb-0">{{ $ekstra->kategori ?? 'Umum' }}</p>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <p class="small text-muted mb-2">
                                            <i class="bi bi-person me-1"></i>
                                            Pembina: {{ $ekstra->pembina->nama_lengkap ?? 'Belum ada pembina' }}
                                        </p>
                                        <p class="small text-muted mb-0">
                                            <i class="bi bi-clock me-1"></i>
                                            Jadwal: {{ $ekstra->jadwal ?? 'Belum dijadwalkan' }}
                                        </p>
                                    </div>
    
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('siswa.ekstrakurikuler.show', $ekstra->id) }}" class="btn btn-primary btn-sm">Detail</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="bi bi-inbox fs-1 text-muted mb-3 d-block"></i>
                        <p class="text-muted mb-3">Anda belum terdaftar di ekstrakurikuler manapun</p>
                        <a href="#" class="btn btn-primary">Daftar Ekstrakurikuler</a>
                    </div>
                </div>
            @endif
        </div>
    </section>
    
    <section class="py-5 bg-light">
        <div class="container">
            <h3 class="fw-bold mb-4">Jadwal Kegiatan Mendatang</h3>
    
            @if(isset($jadwalKegiatan) && $jadwalKegiatan->isNotEmpty())
                <div class="card border-0 shadow-sm">
                    <div class="list-group list-group-flush">
                        @foreach($jadwalKegiatan->take(5) as $jadwal)
                            <div class="list-group-item">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <div class="bg-primary text-white rounded text-center p-2" style="min-width: 70px;">
                                            <div class="fw-bold">{{ $jadwal->tanggal ? date('d', strtotime($jadwal->tanggal)) : '-' }}</div>
                                            <div class="small">{{ $jadwal->tanggal ? date('M', strtotime($jadwal->tanggal)) : '-' }}</div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <h6 class="fw-bold mb-1">{{ $jadwal->nama_kegiatan }}</h6>
                                        <p class="text-muted small mb-0">
                                            <i class="bi bi-bookmark me-1"></i>{{ $jadwal->ekstrakurikuler->nama_ekstrakurikuler ?? '-' }}
                                            <span class="mx-2">|</span>
                                            <i class="bi bi-clock me-1"></i>{{ $jadwal->waktu ?? '-' }}
                                        </p>
                                    </div>
                                    <div class="col-auto">
                                        <span class="badge bg-primary">{{ $jadwal->status ?? 'Terjadwal' }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="bi bi-calendar-x fs-1 text-muted mb-3 d-block"></i>
                        <p class="text-muted mb-0">Belum ada jadwal kegiatan</p>
                    </div>
                </div>
            @endif
        </div>
    </section>
    
    <section class="py-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold">Pengumuman Terbaru</h3>
                <a href="#" class="btn btn-outline-primary">Lihat Semua</a>
            </div>
    
            @if(isset($pengumuman) && $pengumuman->isNotEmpty())
                <div class="row g-4">
                    @foreach($pengumuman->take(3) as $item)
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm h-100">
                                @if($item->gambar)
                                    <img src="{{ asset($item->gambar) }}" class="card-img-top" alt="{{ $item->judul }}" style="height: 200px; object-fit: cover;">
                                @endif
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <span class="badge bg-primary">{{ $item->kategori ?? 'Pengumuman' }}</span>
                                        <small class="text-muted">{{ $item->created_at ? $item->created_at->diffForHumans() : '-' }}</small>
                                    </div>
                                    <h5 class="card-title fw-bold">{{ $item->judul }}</h5>
                                    <p class="card-text text-muted">{{ Str::limit($item->deskripsi, 100) }}</p>
                                    <a href="{{ route('siswa.pengumuman.show', $item->id) }}" class="btn btn-outline-primary btn-sm">Baca Selengkapnya</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="bi bi-megaphone fs-1 text-muted mb-3 d-block"></i>
                        <p class="text-muted mb-0">Belum ada pengumuman</p>
                    </div>
                </div>
            @endif
        </div>
    </section>
</div> -->
@endsection
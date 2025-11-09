@extends('layouts/template')

@section('title', 'Beranda')

@section('content')

  {{-- Content Utama --}}
  <div id="ekstraCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#ekstraCarousel" data-bs-slide-to="0" class="active"></button>
      <button type="button" data-bs-target="#ekstraCarousel" data-bs-slide-to="1"></button>
      <button type="button" data-bs-target="#ekstraCarousel" data-bs-slide-to="2"></button>
    </div>

    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="{{ asset('build/assets/images/smkn1-5.png') }}" class="d-block w-100" alt="Slide 1" style="height: 600px; object-fit: cover;">
      </div>
      <div class="carousel-item">
        <img src="{{ asset('build/assets/images/smkn1-2.png') }}" class="d-block w-100" alt="Slide 2" style="height: 600px; object-fit: cover;">
      </div>
      <div class="carousel-item">
        <img src="{{ asset('build/assets/images/smkn1-3.png') }}" class="d-block w-100" alt="Slide 3" style="height: 600px; object-fit: cover;">
      </div>
    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#ekstraCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#ekstraCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon"></span>
    </button>
  </div>

  {{-- Informasi Singkat --}}
  <section class="py-5">
    <div class="container">
      <div class="row text-center g-4">

      <!-- Visi Misi -->
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

      <!-- Kepala Sekolah -->
      <div class="col-md-4">
        <div class="card text-white border-0 shadow-lg rounded-4 py-5" style="background-color: #001f3f;">
          <div class="card-body">
            <i class="bi bi-person-fill display-3 mb-3"></i>
            <h5 class="fw-bold">KEPALA SEKOLAH</h5>
            <a href="#" class="btn btn-light mt-3">Selengkapnya</a>
          </div>
        </div>
      </div>

      <!-- Tentang Sekolah -->
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

  {{-- Pengumuman Sekolah --}}
  <section class="container-fluid py-5" style="background-color: #001f3f;">
    <div class="container">
      <h3 class="text-center mb-4 fw-bold text-white">Pengumuman & Acara Sekolah</h3>

      <div class="row g-4">
        @for ($i = 1; $i <= 3; $i++)
          <div class="col-md-4">
            <div class="card shadow h-100 border-0">
              <img src="{{ asset('build/assets/images/pengumuman' . $i . '.png') }}" class="card-img-top" alt="Event {{ $i }}">
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

  {{-- Pembina Ekstrakurikuler --}}
  <section class="container my-5">
    <h3 class="text-center mb-4 fw-bold">Pembina Ekstrakurikuler</h3>

    <div id="carouselPembina" class="carousel slide" data-bs-ride="carousel" data-bs-interval="2500">
      <div class="carousel-inner">

        {{-- Slide 1 --}}
        <div class="carousel-item active">
          <div class="row justify-content-center">
            @for ($i = 1; $i <= 3; $i++)
              <div class="col-md-4 text-center">
                <img src="{{ asset('build/assets/images/pengumuman' . $i . '.png') }}" 
                  class="rounded-circle pembina-img mx-auto d-block" 
                  alt="Pembina {{ $i }}"
                  style="width: 350px; height: 350px;">
                <p class="mt-3 mb-0 fw-semibold">Drs. Pembina {{ $i }}</p>
                <p class="text-muted">Pelatih Ekskul {{ $i }}</p>
              </div>
            @endfor
          </div>
        </div>

        {{-- Slide 2 --}}
        <div class="carousel-item">
          <div class="row justify-content-center">
            @for ($i = 4; $i <= 6; $i++)
              <div class="col-md-4 text-center">
                <img src="{{ asset('build/assets/images/pengumuman' . $i . '.png') }}" 
                    class="rounded-circle pembina-img mx-auto d-block" 
                    alt="Pembina {{ $i }}"
                    style="width: 350px; height: 350px;">
                <p class="mt-3 mb-0 fw-semibold">Drs. Pembina {{ $i }}</p>
                <p class="text-muted">Pelatih Ekskul {{ $i }}</p>
              </div>
            @endfor
          </div>
        </div>

      </div>

      {{-- Tombol navigasi --}}
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselPembina" data-bs-slide="prev">
        <span class="carousel-control-prev-icon rounded-circle p-2" style="background-color: #001f3f;"></span>
        <span class="visually-hidden">Sebelumnya</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselPembina" data-bs-slide="next">
        <span class="carousel-control-next-icon rounded-circle p-2" style="background-color: #001f3f;"></span>
        <span class="visually-hidden">Selanjutnya</span>
      </button>
    </div>
  </section>


@endsection
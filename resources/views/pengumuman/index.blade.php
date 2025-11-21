@extends('layouts.template')

@section('content')
<div class="container py-2">
    @if(Auth::check() && in_array(Auth::user()->role, ['admin', 'siswa', 'pembina']))

        <!-- FILTER & SEARCH -->
        <div class="row mb-4">
            <div class="col-lg-8 mx-auto">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <form method="GET" action="{{ route('pengumuman.index') }}" id="filterForm">
                            <div class="row g-3">

                                <!-- Search -->
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-text bg-white border-end-0">
                                            <i class="bi bi-search text-muted"></i>
                                        </span>
                                        <input type="text" 
                                            name="search" 
                                            class="form-control border-start-0" 
                                            placeholder="Cari judul pengumuman..."
                                            value="{{ request('search') }}">
                                    </div>
                                </div>

                                <!-- Filter Tanggal -->
                                <div class="col-md-6">
                                    <input type="date" 
                                        name="tanggal" 
                                        class="form-control"
                                        value="{{ request('tanggal') }}"
                                        onchange="document.getElementById('filterForm').submit()">
                                </div>

                            </div>

                            <!-- Quick Filter -->
                            <div class="mt-3 d-flex flex-wrap gap-2">
                                <span class="text-muted small">Cepat:</span>

                                <a href="{{ route('pengumuman.index') }}" 
                                    class="badge bg-secondary text-decoration-none py-2 px-3">
                                    <i class="bi bi-arrow-clockwise me-1"></i>Reset Filter
                                </a>

                                <a href="{{ route('pengumuman.index', ['tanggal' => today()->format('Y-m-d')]) }}" 
                                    class="badge bg-primary text-decoration-none py-2 px-3">
                                    <i class="bi bi-calendar-event me-1"></i>Hari Ini
                                </a>

                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- STATISTIK -->
        <div class="row mb-5 g-4">
            <div class="col-md-6">
                <div class="card-body text-center p-4">
                    <h3 class="fw-bold text-primary">{{ $pengumuman->total() }}</h3>
                    <p class="text-muted mb-0">Total Pengumuman</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card-body text-center p-4">
                    <h3 class="fw-bold text-success">
                        {{ $pengumuman->where('tanggal', today()->format('Y-m-d'))->count() }}
                    </h3>
                    <p class="text-muted mb-0">Pengumuman Hari Ini</p>
                </div>
            </div>
        </div>

        <!-- LIST CARD -->
        <div class="row g-4">
            @forelse($pengumuman as $row)
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm h-100 hover-card">

                    <!-- Gambarnya -->
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

                    <div class="card-body d-flex flex-column">

                        <!-- Judul -->
                        <h5 class="card-title fw-bold mb-3">{{ $row->judul_pengumuman }}</h5>

                        <!-- Info -->
                        <div class="mb-3 flex-grow-1">
                            <div class="d-flex text-muted mb-2">
                                <i class="bi bi-calendar3 me-2 text-primary"></i>
                                <small>{{ \Carbon\Carbon::parse($row->tanggal)->format('d F Y') }}</small>
                            </div>
                        </div>

                        <!-- Tombol -->
                        <button class="btn btn-primary w-100"
                            data-bs-toggle="modal"
                            data-bs-target="#modalDetailPengumuman{{ $row->id }}">
                            <i class="bi bi-eye me-2"></i>Detail
                        </button>

                    </div>
                </div>
            </div>

            <!-- MODAL DETAIL -->
            <div class="modal fade" id="modalDetailPengumuman{{ $row->id }}">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content border-0 shadow-lg rounded-4">
                        <!-- Header -->
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title"><i class="bi bi-info-circle me-2"></i>{{ $row->judul_pengumuman }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <!-- Body -->
                        <div class="modal-body p-4">
                            <div class="row g-4">
                                <!-- Kolom Kiri: Foto -->
                                <div class="col-md-6 text-center">
                                    @if($row->foto)
                                        <img src="{{ asset('storage/' . str_replace('storage/', '', $row->foto)) }}"
                                             class="img-fluid rounded shadow"
                                             style="max-width: 100%; height: 280px; object-fit: cover; border: 3px solid #f8f9fa;">
                                    @else
                                        <div class="d-flex align-items-center justify-content-center bg-light rounded" style="height: 280px;">
                                            <div class="text-center">
                                                <i class="bi bi-image text-muted" style="font-size: 4rem;"></i>
                                                <p class="mt-2 text-muted">Tidak ada foto</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <!-- Kolom Kanan: Isi Pengumuman -->
                                <div class="col-md-6">
                                    <h6 class="fw-bold text-primary mb-3">📝 Isi Pengumuman</h6>
                                    <div class="bg-white border rounded p-3">
                                        <p class="mb-0" style="white-space: pre-line; line-height: 1.7; font-size: 1rem;">
                                            {{ $row->isi }}
                                        </p>
                                    </div>

                                    <!-- Informasi Tanggal -->
                                    <div class="mt-4 p-3 bg-light rounded">
                                        <h6 class="fw-bold text-primary mb-2">📅 Tanggal Pengumuman</h6>
                                        <span class="badge bg-primary px-3 py-2">{{ \Carbon\Carbon::parse($row->tanggal)->format('d M Y') }}</span>
                                    </div>

                                    <!-- Waktu Dibuat -->
                                    <div class="mt-3 small text-muted">
                                        <i class="bi bi-clock me-1"></i> Dibuat: {{ optional($row->created_at)->format('d M Y, H:i') }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="modal-footer bg-light">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="bi bi-x-circle me-1"></i>Tutup
                            </button>
                        </div>
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

    @else
        <!-- TAMPILAN UNTUK TAMU (GUEST) -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="bi bi-megaphone text-primary" style="font-size:4rem;"></i>
                        <h3 class="mt-3">Pengumuman Terbaru</h3>
                    </div>
                </div>
            </div>
        </div>

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
    @endif
</div>

<style>
.hover-card{transition:.3s;}
.hover-card:hover{transform:translateY(-10px);box-shadow:0 10px 30px rgba(0,0,0,.15)!important;}
</style>
@endsection

@extends('layouts.app')
@section('content')
@if(Auth::user()->role === 'admin' || Auth::user()->role === 'siswa')

    <div class="container py-2">

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

                                <!-- Filter Ekskul -->
                                <div class="col-md-3">
                                    <select name="ekskul" class="form-select" onchange="document.getElementById('filterForm').submit()">
                                        <option value="">Semua Ekskul</option>
                                        @foreach($ekskul as $e)
                                            <option value="{{ $e->id }}" {{ request('ekskul') == $e->id ? 'selected' : '' }}>
                                                {{ $e->nama_ekstrakurikuler }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Filter Tanggal -->
                                <div class="col-md-3">
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
            <div class="col-md-4">
                <div class="card-body text-center p-4">
                    <h3 class="fw-bold text-primary">{{ $pengumuman->total() }}</h3>
                    <p class="text-muted mb-0">Total Pengumuman</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-body text-center p-4">
                    <h3 class="fw-bold text-success">
                        {{ $pengumuman->where('tanggal', today()->format('Y-m-d'))->count() }}
                    </h3>
                    <p class="text-muted mb-0">Pengumuman Hari Ini</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-body text-center p-4">
                    <h3 class="fw-bold text-warning">{{ $ekskul->count() }}</h3>
                    <p class="text-muted mb-0">Ekstrakurikuler</p>
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
                        @if($row->foto && file_exists(storage_path('app/public/'.$row->foto)))
                            <img src="{{ asset('storage/'.$row->foto) }}" 
                                class="card-img-top w-100 h-100" style="object-fit: cover;">
                        @else
                        <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-primary bg-gradient">
                            <i class="bi bi-megaphone text-white" style="font-size: 4rem; opacity:.4"></i>
                        </div>
                        @endif
                    </div>

                    <div class="card-body d-flex flex-column">

                        <!-- Ekskul -->
                        <div class="mb-2">
                            <span class="badge bg-primary rounded-pill">
                                {{ $row->ekstrakurikuler->nama_ekstrakurikuler ?? '-' }}
                            </span>
                        </div>

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
                <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content border-0 shadow-lg">

                        <div class="position-relative" style="height:250px;overflow:hidden;">
                            @if($row->foto && file_exists(storage_path('app/public/'.$row->foto)))
                                <img src="{{ asset('storage/'.$row->foto) }}" 
                                    class="w-100 h-100" style="object-fit:cover;filter:brightness(.7);">
                            @else
                                <div class="w-100 h-100 bg-primary bg-gradient"></div>
                            @endif

                            <div class="position-absolute bottom-0 p-4 w-100"
                                style="background:linear-gradient(to top,rgba(0,0,0,.8),transparent)">
                                <h3 class="text-white fw-bold mb-0">{{ $row->judul_pengumuman }}</h3>
                            </div>
                        </div>

                        <div class="modal-body p-4">
                            <!-- Deskripsi -->
                            @if($row->isi)
                            <div class="mb-4">
                                <h5 class="fw-bold mb-3">
                                    <i class="bi bi-card-text text-primary me-2"></i>Isi Pengumuman
                                </h5>
                                <div class="bg-light rounded p-3">
                                    <p class="mb-0" style="white-space:pre-line;">{{ $row->isi }}</p>
                                </div>
                            </div>
                            @endif
                        </div>

                        <div class="modal-footer bg-light">
                            <button class="btn btn-secondary" data-bs-dismiss="modal">
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

    </div>

<style>
.hover-card{transition:.3s;}
.hover-card:hover{transform:translateY(-10px);box-shadow:0 10px 30px rgba(0,0,0,.15)!important;}
</style>


@endsection
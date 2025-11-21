@extends('layouts.template')

@section('title', 'Dashboard Pembina')

@section('content')
    <div class="py-2 row mb-4">
        <p class="mb-0 opacity-75">
            <i class="bi bi-calendar3 me-2"></i>{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM YYYY') }}
        </p>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100 hover-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-3 bg-primary bg-opacity-10 p-3 me-3">
                            <i class="bi bi-collection-fill fs-2 text-primary"></i>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted mb-1 small">Ekstrakurikuler</p>
                            <h3 class="fw-bold mb-0">{{ $totalEkskul }}</h3>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-top">
                        <small class="text-muted">
                            <i class="bi bi-arrow-up text-success me-1"></i>
                            Yang Anda bina
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100 hover-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-3 bg-success bg-opacity-10 p-3 me-3">
                            <i class="bi bi-trophy-fill fs-2 text-success"></i>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted mb-1 small">Total Perlombaan</p>
                            <h3 class="fw-bold mb-0">{{ $totalPerlombaan }}</h3>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-top">
                        <small class="text-muted">
                            <i class="bi bi-calendar-check text-success me-1"></i>
                            Semua tahun
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100 hover-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-3 bg-warning bg-opacity-10 p-3 me-3">
                            <i class="bi bi-calendar-event fs-2 text-warning"></i>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted mb-1 small">Tahun Ini</p>
                            <h3 class="fw-bold mb-0">{{ $perlombaanTahunIni }}</h3>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-top">
                        <small class="text-muted">
                            <i class="bi bi-graph-up text-warning me-1"></i>
                            {{ \Carbon\Carbon::now()->year }}
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Anggota -->
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100 hover-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-3 bg-info bg-opacity-10 p-3 me-3">
                            <i class="bi bi-people-fill fs-2 text-info"></i>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted mb-1 small">Total Anggota</p>
                            <h3 class="fw-bold mb-0">{{ $totalAnggota }}</h3>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-top">
                        <small class="text-muted">
                            <i class="bi bi-person-check text-info me-1"></i>
                            Anggota aktif
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-4 pb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0">
                            <i class="bi bi-mortarboard text-primary me-2"></i>Ekstrakurikuler Saya
                        </h5>
                        <span class="badge bg-primary rounded-pill">{{ $ekstrakurikulerList->count() }}</span>
                    </div>
                </div>
                <div class="card-body">
                    @forelse($ekstrakurikulerList as $ekskul)
                    <div class="d-flex align-items-center p-3 mb-3 bg-light rounded-3">
                        <div class="me-3">
                            @if($ekskul->foto && file_exists(public_path($ekskul->foto)))
                                <img src="{{ asset($ekskul->foto) }}" 
                                     class="rounded" 
                                     style="width: 60px; height: 60px; object-fit: cover;"
                                     alt="{{ $ekskul->nama_ekstrakurikuler }}">
                            @else
                                <div class="rounded bg-gradient d-flex align-items-center justify-content-center"
                                     style="width: 60px; height: 60px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                    <i class="bi bi-mortarboard text-white fs-4"></i>
                                </div>
                            @endif
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1 fw-semibold">{{ $ekskul->nama_ekstrakurikuler }}</h6>
                            <small class="text-muted">
                                <i class="bi bi-person-check me-1"></i>
                                Ketua: {{ $ekskul->ketua->nama_lengkap ?? 'Belum ada' }}
                            </small>
                        </div>
                        <div>
                            <a href="{{ route('ekstrakurikuler.index') }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye"></i>
                            </a>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4">
                        <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                        <p class="text-muted mt-2 mb-0">Belum ada ekstrakurikuler yang dibina</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Perlombaan Terbaru -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-4 pb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0">
                            <i class="bi bi-trophy text-success me-2"></i>Perlombaan Terbaru
                        </h5>
                    </div>
                </div>
                <div class="card-body">
                    @forelse($perlombaanTerbaru as $perlombaan)
                    <div class="d-flex align-items-start p-3 mb-3 border rounded-3">
                        <div class="me-3">
                            @if($perlombaan->foto && file_exists(storage_path('app/public/' . $perlombaan->foto)))
                                <img src="{{ asset('storage/' . $perlombaan->foto) }}" 
                                     class="rounded" 
                                     style="width: 60px; height: 60px; object-fit: cover;"
                                     alt="{{ $perlombaan->nama_perlombaan }}">
                            @else
                                <div class="rounded d-flex align-items-center justify-content-center"
                                     style="width: 60px; height: 60px; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                                    <i class="bi bi-trophy text-white fs-4"></i>
                                </div>
                            @endif
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1 fw-semibold">{{ $perlombaan->nama_perlombaan }}</h6>
                            <p class="mb-2 small text-muted">
                                <i class="bi bi-calendar3 me-1"></i>
                                {{ \Carbon\Carbon::parse($perlombaan->tanggal)->format('d M Y') }}
                            </p>
                            <span class="badge bg-primary bg-opacity-10 text-primary">
                                {{ $perlombaan->tingkat ?? 'Umum' }}
                            </span>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4">
                        <i class="bi bi-trophy text-muted" style="font-size: 3rem;"></i>
                        <p class="text-muted mt-2 mb-0">Belum ada data perlombaan</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="card-title fw-bold mb-4">
                        <i class="bi bi-lightning-fill text-warning me-2"></i>Quick Actions
                    </h5>
                    <div class="row g-4">
                        <div class="col-md-4">
                            <a href="{{ route('pembina.perlombaan.index') }}" class="text-decoration-none">
                                <div class="d-flex align-items-center p-4 bg-light rounded-3 shadow-sm hover-action" style="transition: transform 0.2s;">
                                    <div class="rounded-circle bg-primary p-3 me-3">
                                        <i class="bi bi-trophy text-white fs-4"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1 fw-bold text-dark">Kelola Perlombaan</h6>
                                        <small class="text-secondary">Tambah & edit data</small>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{ route('pembina.anggota.index') }}" class="text-decoration-none">
                                <div class="d-flex align-items-center p-4 bg-light rounded-3 shadow-sm hover-action" style="transition: transform 0.2s;">
                                    <div class="rounded-circle bg-success p-3 me-3">
                                        <i class="bi bi-people text-white fs-4"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1 fw-bold text-dark">Data Anggota</h6>
                                        <small class="text-secondary">Lihat & kelola anggota</small>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{ route('pembina.penilaian.index') }}" class="text-decoration-none">
                                <div class="d-flex align-items-center p-4 bg-light rounded-3 shadow-sm hover-action" style="transition: transform 0.2s;">
                                    <div class="rounded-circle bg-warning p-3 me-3">
                                        <i class="bi bi-info-circle text-white fs-4"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1 fw-bold text-dark">Tambah Penilaian</h6>
                                        <small class="text-secondary">Kelola Nilai Anggota</small>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{ route('pembina.anggota.index') }}" class="text-decoration-none">
                                <div class="d-flex align-items-center p-4 bg-light rounded-3 shadow-sm hover-action" style="transition: transform 0.2s;">
                                    <div class="rounded-circle bg-danger p-3 me-3">
                                        <i class="bi bi-card-checklist text-white fs-4"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1 fw-bold text-dark">Data Pendaftaran</h6>
                                        <small class="text-secondary">Kelola pendaftaran</small>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{ route('pembina.anggota.index') }}" class="text-decoration-none">
                                <div class="d-flex align-items-center p-4 bg-light rounded-3 shadow-sm hover-action" style="transition: transform 0.2s;">
                                    <div class="rounded-circle bg-info p-3 me-3">
                                        <i class="bi bi-check2-square text-white fs-4"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1 fw-bold text-dark">Kehadiran Anggota</h6>
                                        <small class="text-secondary">Lihat keaktifan anggota</small>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{ route('pembina.anggota.index') }}" class="text-decoration-none">
                                <div class="d-flex align-items-center p-4 bg-light rounded-3 shadow-sm hover-action" style="transition: transform 0.2s;">
                                    <div class="rounded-circle bg-purple p-3 me-3">
                                        <i class="bi bi-calendar-event text-white fs-4"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1 fw-bold text-dark">Kegiatan</h6>
                                        <small class="text-secondary">Tambah kegiatan</small>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{ route('admin.pengumuman.index') }}" class="text-decoration-none">
                                <div class="d-flex align-items-center p-4 bg-light rounded-3 shadow-sm hover-action" style="transition: transform 0.2s;">
                                    <div class="rounded-circle bg-secondary p-3 me-3">
                                        <i class="bi bi-megaphone text-white fs-4"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1 fw-bold text-dark">Pengumuman</h6>
                                        <small class="text-secondary">Lihat dan kelola pengumuman</small>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mt-2">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pt-4 pb-3">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-bar-chart text-primary me-2"></i>Statistik Tingkat Perlombaan
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @php
                            $tingkatStats = [
                                ['name' => 'Sekolah', 'count' => $tingkatSekolah ?? 0, 'icon' => 'building', 'color' => 'primary'],
                                ['name' => 'Kecamatan', 'count' => $tingkatKecamatan ?? 0, 'icon' => 'map', 'color' => 'success'],
                                ['name' => 'Kabupaten', 'count' => $tingkatKabupaten ?? 0, 'icon' => 'geo-alt', 'color' => 'info'],
                                ['name' => 'Provinsi', 'count' => $tingkatProvinsi ?? 0, 'icon' => 'flag', 'color' => 'warning'],
                                ['name' => 'Nasional', 'count' => $tingkatNasional ?? 0, 'icon' => 'star', 'color' => 'danger'],
                                ['name' => 'Internasional', 'count' => $tingkatInternasional ?? 0, 'icon' => 'globe', 'color' => 'dark']
                            ];
                        @endphp

                        @foreach($tingkatStats as $stat)
                        <div class="col-md-4">
                            <div class="p-3 border rounded-3 h-100">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <i class="bi bi-{{ $stat['icon'] }} fs-4 text-{{ $stat['color'] }}"></i>
                                    <h4 class="fw-bold mb-0 text-{{ $stat['color'] }}">{{ $stat['count'] }}</h4>
                                </div>
                                <p class="mb-0 small text-muted">{{ $stat['name'] }}</p>
                                <div class="progress mt-2" style="height: 4px;">
                                    <div class="progress-bar bg-{{ $stat['color'] }}" 
                                         style="width: {{ $totalPerlombaan > 0 ? ($stat['count'] / $totalPerlombaan * 100) : 0 }}%"></div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-4 pb-3">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-lightbulb text-warning me-2"></i>Tips & Info
                    </h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-primary border-0 mb-3">
                        <h6 class="fw-bold mb-2">
                            <i class="bi bi-info-circle me-2"></i>Dokumentasi Penting
                        </h6>
                        <p class="small mb-0">Pastikan setiap perlombaan memiliki foto dan deskripsi lengkap untuk arsip digital.</p>
                    </div>

                    <div class="alert alert-success border-0 mb-3">
                        <h6 class="fw-bold mb-2">
                            <i class="bi bi-star me-2"></i>Pencapaian
                        </h6>
                        <p class="small mb-0">Update data prestasi secara berkala untuk meningkatkan motivasi anggota.</p>
                    </div>

                    <div class="alert alert-warning border-0 mb-0">
                        <h6 class="fw-bold mb-2">
                            <i class="bi bi-calendar-check me-2"></i>Reminder
                        </h6>
                        <p class="small mb-0">Koordinasi dengan ketua untuk persiapan perlombaan mendatang.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

<style>
.hover-card {
    transition: all 0.3s ease;
}

.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
}

.hover-action {
    transition: all 0.3s ease;
    cursor: pointer;
}

.hover-action:hover {
    transform: translateX(5px);
    background-color: #e9ecef !important;
}

.bg-gradient {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
</style>

@endsection
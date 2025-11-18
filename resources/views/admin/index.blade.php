@extends('layouts/template')

@section('title', 'admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <main class="col-12">

            <div class="row mb-4 pt-3 pb-2">
                <div class="col-lg-6 col-md-12 mb-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title mb-0"><i class="fas fa-users"></i> Statistik </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <div class="card text-center shadow-sm border-0 animate__animated animate__fadeInUp">
                                        <div class="card-body">
                                            <i class="fas fa-users text-primary" style="font-size: 2rem;"></i>
                                            <h5 class="card-title">Total Siswa</h5>
                                            <p class="card-text display-4 fw-bold">{{ $totalSiswa ?? '1,234' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-12 mb-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-success text-white">
                            <h5 class="card-title mb-0"><i class="fas fa-trophy"></i>Perlombaan</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <div class="card text-center shadow-sm border-0 animate__animated animate__fadeInUp animate__delay-2s">
                                        <div class="card-body">
                                            <i class="fas fa-trophy text-primary" style="font-size: 2rem;"></i>
                                            <h5 class="card-title">Prestasi</h5>
                                            <p class="card-text display-4 fw-bold">{{ $prestasi ?? '89' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-lg-6 col-md-12 mb-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0"><i class="fas fa-chart-bar"></i> Partisipasi Bulanan</h5>
                            <button class="btn btn-light btn-sm" onclick="updateChart()">Refresh</button>
                        </div>
                        <div class="card-body">
                            <canvas id="participationChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-12 mb-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-success text-white">
                            <h5 class="card-title mb-0"><i class="fas fa-tasks"></i> Kegiatan</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label">Open House</label>
                                    <span class="badge bg-primary">75%</span>
                                </div>
                                <div class="progress mb-2">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 75%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <small class="text-muted">Belum seluruhnya</small>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label">Maulid Nabi</label>
                                    <span class="badge bg-warning">50%</span>
                                </div>
                                <div class="progress mb-2">
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <small class="text-muted">Perlu promosi lebih</small>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label">Kompetisi Debat</label>
                                    <span class="badge bg-success">90%</span>
                                </div>
                                <div class="progress mb-2">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 90%;" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <small class="text-muted">Hampir selesai</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-info text-white">
                            <h5 class="card-title mb-0"><i class="fas fa-star"></i> Pretasi Bulan Ini</h5>
                        </div>
                        <div class="card-body">
                            <div id="performersCarousel" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <div class="row text-center">
                                            <div class="col-md-4">
                                                <img src="https://via.placeholder.com/100" class="rounded-circle mb-2" alt="Performer 1">
                                                <h6>Ahmad Zizan (Pembina)</h6>
                                                <p class="text-muted">Irma - Juara 1 Pidato</p>
                                            </div>
                                            <div class="col-md-4">
                                                <img src="https://via.placeholder.com/100" class="rounded-circle mb-2" alt="Performer 2">
                                                <h6>Cut Kamila (Siswa)</h6>
                                                <p class="text-muted">Irma - Juara 1 Kaligrafi</p>
                                            </div>
                                            <div class="col-md-4">
                                                <img src="https://via.placeholder.com/100" class="rounded-circle mb-2" alt="Performer 3">
                                                <h6>Anisa Tri (Pembina)</h6>
                                                <p class="text-muted">Literasi - Best Speaker</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="carousel-item">
                                        <div class="row text-center">
                                            <div class="col-md-4">
                                                <img src="https://via.placeholder.com/100" class="rounded-circle mb-2" alt="Performer 4">
                                                <h6>Ratna Mutu (Siswa)</h6>
                                                <p class="text-muted">Futsal - Best Kipper</p>
                                            </div>
                                            <div class="col-md-4">
                                                <img src="https://via.placeholder.com/100" class="rounded-circle mb-2" alt="Performer 5">
                                                <h6>Farhan (Ketua)</h6>
                                                <p class="text-muted">Paskibra - Danton Terbaik</p>
                                            </div>
                                            <div class="col-md-4">
                                                <img src="https://via.placeholder.com/100" class="rounded-circle mb-2" alt="Performer 6">
                                                <h6>Diana Putri (Siswa)</h6>
                                                <p class="text-muted">Tari - Penampilan Terbaik</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#performersCarousel" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#performersCarousel" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-12 mb-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-info text-white">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-bolt"></i> Quick Actions
                            </h5>
                        </div>

                        <div class="card-body">
                            <div class="row">

                                <!-- Admin -->
                                <div class="col-lg-6 col-md-6 col-12 mb-3">
                                    <div class="card bg-light border-0 h-100">
                                        <div class="card-body text-center">
                                            <i class="fas fa-crown text-warning fs-1"></i>
                                            <h6 class="mt-2">Admin</h6>
                                            <p class="display-6 fw-bold">{{ $totalAdmin ?? '5' }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Pembina -->
                                <div class="col-lg-6 col-md-6 col-12 mb-3">
                                    <div class="card bg-light border-0 h-100">
                                        <div class="card-body text-center">
                                            <i class="fas fa-chalkboard-teacher text-info fs-1"></i>
                                            <h6 class="mt-2">Pembina</h6>
                                            <p class="display-6 fw-bold">{{ $totalPembina ?? '20' }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Ketua -->
                                <div class="col-lg-6 col-md-6 col-12 mb-3">
                                    <div class="card bg-light border-0 h-100">
                                        <div class="card-body text-center">
                                            <i class="fas fa-user-tie text-success fs-1"></i>
                                            <h6 class="mt-2">Ketua</h6>
                                            <p class="display-6 fw-bold">{{ $totalKetua ?? '15' }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Siswa -->
                                <div class="col-lg-6 col-md-6 col-12 mb-3">
                                    <div class="card bg-light border-0 h-100">
                                        <div class="card-body text-center">
                                            <i class="fas fa-graduation-cap text-primary fs-1"></i>
                                            <h6 class="mt-2">Siswa</h6>
                                            <p class="display-6 fw-bold">{{ $totalSiswaRole ?? '1,194' }}</p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-12 mb-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-warning text-dark">
                            <h5 class="card-title mb-0"><i class="fas fa-bell"></i> Notifikasi Terbaru</h5>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info alert-dismissible fade show" role="alert">
                                <i class="fas fa-info-circle"></i> User baru dengan role Pembina ditambahkan. <small class="text-muted">1 jam lalu</small>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-triangle"></i> Kegiatan Basket membutuhkan lebih banyak siswa. <small class="text-muted">2 hari lalu</small>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle"></i> Prestasi baru diraih oleh Ketua Debat. <small class="text-muted">3 hari lalu</small>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

@endsection
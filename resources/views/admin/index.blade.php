@extends('layouts/template')

@section('title', 'admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <main class="col-12">
            <div class="row mb-4 pt-3 pb-2">
                <div class="col-lg-6 col-md-12 mb-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-info text-white">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-bolt"></i> Quick Actions
                            </h5>
                        </div>

                        <div class="card-body">
                            <div class="row">

                                <div class="col-lg-6 col-md-6 col-12 mb-3">
                                    <div class="card bg-light border-0 h-100">
                                        <div class="card-body text-center">
                                            <i class="fas fa-crown text-warning fs-1"></i>
                                            <h6 class="mt-2">Admin</h6>
                                            <p class="display-6 fw-bold">{{ $totalAdmin ?? '5' }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6 col-12 mb-3">
                                    <div class="card bg-light border-0 h-100">
                                        <div class="card-body text-center">
                                            <i class="fas fa-chalkboard-teacher text-info fs-1"></i>
                                            <h6 class="mt-2">Pembina</h6>
                                            <p class="display-6 fw-bold">{{ $totalPembina ?? '20' }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6 col-12 mb-3">
                                    <div class="card bg-light border-0 h-100">
                                        <div class="card-body text-center">
                                            <i class="fas fa-user-tie text-success fs-1"></i>
                                            <h6 class="mt-2">Ketua</h6>
                                            <p class="display-6 fw-bold">{{ $totalKetua ?? '15' }}</p>
                                        </div>
                                    </div>
                                </div>

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
@extends('layouts.template')

@section('title', 'Dashboard Ketua')

@section('content')
    <p class=" py-2 mb-2 opacity-75">
        <i class="bi bi-calendar3 me-2"></i>{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM YYYY') }}
    </p>

    <div class="row g-4 mb-4">
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100 hover-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-3 bg-danger bg-opacity-10 p-3 me-3">
                            <i class="bi bi-mortarboard-fill fs-2 text-danger"></i>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted mb-1 small">Ekstrakurikuler</p>
                            <h3 class="fw-bold mb-0">{{ $ekstrakurikuler->nama_ekstrakurikuler ?? '-' }}</h3>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-top">
                        <small class="text-muted">
                            <i class="bi bi-shield-check text-danger me-1"></i>
                            Yang Anda pimpin
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100 hover-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-3 bg-primary bg-opacity-10 p-3 me-3">
                            <i class="bi bi-people-fill fs-2 text-primary"></i>
                        </div>
                        <div class="flex-grow-1">
                            <p class="text-muted mb-1 small">Total Anggota</p>
                            <h3 class="fw-bold mb-0">{{ $totalAnggota }}</h3>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-top">
                        <small class="text-muted">
                            <i class="bi bi-person-plus text-primary me-1"></i>
                            Anggota aktif
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
                            <i class="bi bi-award text-success me-1"></i>
                            Semua kompetisi
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
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h4 class="fw-bold mt-4">Pendaftaran Baru</h4>

                    <table class="table table-bordered mt-3">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Siswa</th>
                                <th>Ekskul</th>
                                <th>Tanggal Daftar</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($pendaftaranList as $p)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $p->user->nama_lengkap }}</td>
                                <td>{{ $p->ekstrakurikuler->nama_ekstrakurikuler }}</td>
                                <td>{{ $p->tanggal_daftar }}</td>
                                <td>
                                    @if ($p->status == 'menunggu')
                                        <span class="badge bg-warning">Menunggu</span>
                                    @elseif ($p->status == 'disetujui')
                                        <span class="badge bg-success">Disetujui</span>
                                    @else
                                        <span class="badge bg-danger">Ditolak</span>
                                    @endif
                                </td>
                                
                                <td>
                                    @if ($p->status == 'menunggu')

                                        <!-- APPROVE -->
                                        <form action="{{ route('pendaftaran.approve', $p->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                        </form>

                                        <!-- REJECT -->
                                        <form action="{{ route('pendaftaran.reject', $p->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                                        </form>

                                    @else
                                        <small>-</small>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">
                                    Belum ada pendaftaran.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

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
                            <i class="bi bi-mortarboard text-danger me-2"></i>Ekstrakurikuler Saya
                        </h5>
                    </div>
                </div>
                <div class="card-body">
                    @if($ekstrakurikuler)
                    <div class="text-center mb-4">
                        @if($ekstrakurikuler->foto && file_exists(public_path($ekstrakurikuler->foto)))
                            <img src="{{ asset($ekstrakurikuler->foto) }}" 
                                 class="img-fluid rounded shadow-sm" 
                                 style="max-height: 200px; width: 100%; object-fit: cover;"
                                 alt="{{ $ekstrakurikuler->nama_ekstrakurikuler }}">
                        @else
                            <div class="rounded d-flex align-items-center justify-content-center mx-auto"
                                 style="height: 200px; width: 100%; max-width: 400px; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                                <i class="bi bi-mortarboard text-white" style="font-size: 5rem;"></i>
                            </div>
                        @endif
                    </div>

                    <div class="bg-light rounded p-4">
                        <h5 class="fw-bold mb-3">{{ $ekstrakurikuler->nama_ekstrakurikuler }}</h5>
                        
                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-person-badge text-primary fs-4 me-2"></i>
                                    <div>
                                        <small class="text-muted d-block">Pembina</small>
                                        <strong class="small">{{ $ekstrakurikuler->pembina->nama_lengkap ?? 'Belum ada' }}</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-people text-success fs-4 me-2"></i>
                                    <div>
                                        <small class="text-muted d-block">Anggota</small>
                                        <strong class="small">{{ $totalAnggota }} Orang</strong>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted d-block mb-1">Deskripsi:</small>
                            <p class="small mb-0">{{ $ekstrakurikuler->deskripsi ?? 'Tidak ada deskripsi' }}</p>
                        </div>
                    </div>
                    @else
                    <div class="text-center py-4">
                        <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                        <p class="text-muted mt-2 mb-0">Anda belum menjadi ketua ekstrakurikuler</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

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
                    <div class="d-flex align-items-start p-3 mb-3 border rounded-3 hover-perlombaan">
                        <div class="me-3">
                            @if($perlombaan->foto && file_exists(storage_path('app/public/' . $perlombaan->foto)))
                                <img src="{{ asset('storage/' . $perlombaan->foto) }}" 
                                     class="rounded" 
                                     style="width: 70px; height: 70px; object-fit: cover;"
                                     alt="{{ $perlombaan->nama_perlombaan }}">
                            @else
                                <div class="rounded d-flex align-items-center justify-content-center"
                                     style="width: 70px; height: 70px; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                                    <i class="bi bi-trophy text-white fs-4"></i>
                                </div>
                            @endif
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1 fw-semibold">{{ $perlombaan->nama_perlombaan }}</h6>
                            <div class="mb-2">
                                <small class="text-muted d-block">
                                    <i class="bi bi-calendar3 me-1"></i>
                                    {{ \Carbon\Carbon::parse($perlombaan->tanggal)->format('d M Y') }}
                                </small>
                                <small class="text-muted">
                                    <i class="bi bi-geo-alt me-1"></i>
                                    {{ $perlombaan->tempat ?? '-' }}
                                </small>
                            </div>
                            <div class="d-flex gap-2">
                                <span class="badge bg-danger bg-opacity-10 text-danger">
                                    <i class="bi bi-award me-1"></i>{{ $perlombaan->tingkat ?? 'Umum' }}
                                </span>
                            </div>
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

.hover-perlombaan {
    transition: all 0.3s ease;
}

.hover-perlombaan:hover {
    transform: scale(1.02);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.hover-stat {
    transition: all 0.3s ease;
}

.hover-stat:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}

.bg-gradient {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}
</style>

@endsection
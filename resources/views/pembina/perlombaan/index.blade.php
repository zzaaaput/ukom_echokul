@extends('layouts.template')

@section('title', 'Perlombaan')

@section('content')
@if(Auth::check() && in_array(Auth::user()->role, ['pembina', 'ketua']))
<div class="container-fluid bg-light min-vh-100 py-5">
    <div class="container">

        <!-- Header Section -->
        <div class="bg-white rounded-4 shadow-sm p-4 mb-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                <div>
                    <h2 class="fw-bold mb-2">Data Perlombaan</h2>
                    <p class="text-muted mb-0">
                        <i class="bi bi-trophy-fill me-2"></i>
                        Kelola perlombaan ekstrakurikuler
                    </p>
                </div>

                <button class="btn btn-primary btn-lg px-4"
                    data-bs-toggle="modal"
                    data-bs-target="#modalTambah">
                    <i class="bi bi-plus-circle me-2"></i>Tambah Perlombaan
                </button>
            </div>
        </div>

        <!-- Search Section -->
        <div class="bg-white rounded-4 shadow-sm p-4 mb-4">
            <form method="GET" action="{{ route('pembina.perlombaan.index') }}">
                <label for="search" class="form-label fw-semibold small">
                    <i class="bi bi-search text-primary me-1"></i>Pencarian
                </label>
                <div class="input-group">
                    <span class="input-group-text bg-white">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input type="text"
                        name="search"
                        id="search"
                        class="form-control"
                        placeholder="Cari ekstrakurikuler / nama / tahun / tempat..."
                        value="{{ request('search') }}"
                        onchange="this.form.submit()">
                    @if(request('search'))
                    <a href="{{ route('pembina.perlombaan.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x-lg"></i>
                    </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Table Section -->
        <div class="bg-white rounded-4 shadow-sm overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-primary bg-opacity-10">
                        <tr>
                            <th class="py-3 ps-4 fw-semibold text-primary">No</th>
                            <th class="py-3 fw-semibold text-primary">Ekstrakurikuler</th>
                            <th class="py-3 fw-semibold text-primary">Nama Perlombaan</th>
                            <th class="py-3 fw-semibold text-primary">Tanggal</th>
                            <th class="py-3 fw-semibold text-primary">Tempat</th>
                            <th class="py-3 fw-semibold text-primary">Tingkat</th>
                            <th class="py-3 fw-semibold text-primary">Tahun Ajaran</th>
                            <th class="py-3 fw-semibold text-primary">Foto</th>
                            <th class="text-center py-3 fw-semibold text-primary">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($perlombaan as $index => $row)
                        <tr>
                            <td class="ps-4 fw-semibold">{{ $perlombaan->firstItem() + $index }}</td>
                            <td>{{ $row->ekstrakurikuler->nama_ekstrakurikuler ?? '-' }}</td>
                            <td class="fw-bold">{{ $row->nama_perlombaan }}</td>
                            <td>
                                <span class="badge bg-info bg-opacity-10 text-info px-3 py-2">
                                    <i class="bi bi-calendar3 me-1"></i>
                                    {{ \Carbon\Carbon::parse($row->tanggal)->format('d M Y') }}
                                </span>
                            </td>
                            <td>{{ $row->tempat ?? '-' }}</td>
                            <td>
                                <span class="badge bg-success bg-opacity-10 text-success px-3 py-2">
                                    {{ $row->tingkat ?? '-' }}
                                </span>
                            </td>
                            <td>{{ $row->tahun_ajaran ?? '-' }}</td>
                            <td>
                                @if($row->foto && file_exists(storage_path('app/public/' . $row->foto)))
                                <img src="{{ asset('storage/' . $row->foto) }}"
                                    class="rounded-3 shadow-sm border border-2 border-primary"
                                    style="width:70px; height:70px; object-fit:cover;">
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex flex-wrap justify-content-center gap-2">
                                    <button class="btn btn-sm btn-primary"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalDetail{{ $row->id }}">
                                        <i class="bi bi-eye me-1"></i> Detail
                                    </button>

                                    <button class="btn btn-sm btn-warning"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalEdit{{ $row->id }}">
                                        <i class="bi bi-pencil-square me-1"></i> Edit
                                    </button>

                                    <button class="btn btn-sm btn-danger"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalHapus{{ $row->id }}">
                                        <i class="bi bi-trash me-1"></i> Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>

                        {{-- ==================== MODAL DETAIL ==================== --}}
                        <div class="modal fade" id="modalDetail{{ $row->id }}" tabindex="-1">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content border-0 shadow-lg rounded-4">
                                    <div class="modal-header bg-primary text-white border-0 p-4">
                                        <div>
                                            <h5 class="modal-title fw-bold mb-1">Detail Perlombaan</h5>
                                            <small class="opacity-75">Informasi lengkap perlombaan ekstrakurikuler</small>
                                        </div>
                                        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body p-4">
                                        <div class="row g-4">
                                            <div class="col-md-7">
                                                <div class="bg-light rounded-3 p-4">
                                                    <div class="mb-3">
                                                        <label class="text-muted small fw-semibold mb-2 d-block">
                                                            <i class="bi bi-trophy-fill text-primary me-1"></i> Ekstrakurikuler
                                                        </label>
                                                        <p class="fw-bold mb-0">{{ $row->ekstrakurikuler->nama_ekstrakurikuler ?? '-' }}</p>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="text-muted small fw-semibold mb-2 d-block">
                                                            <i class="bi bi-award text-primary me-1"></i> Nama Perlombaan
                                                        </label>
                                                        <p class="fw-bold mb-0">{{ $row->nama_perlombaan }}</p>
                                                    </div>

                                                    <div class="row g-3 mb-3">
                                                        <div class="col-6">
                                                            <label class="text-muted small fw-semibold mb-2 d-block">
                                                                <i class="bi bi-calendar3 text-primary me-1"></i> Tanggal
                                                            </label>
                                                            <span class="badge bg-info bg-opacity-10 text-info px-3 py-2">
                                                                {{ \Carbon\Carbon::parse($row->tanggal)->format('d M Y') }}
                                                            </span>
                                                        </div>

                                                        <div class="col-6">
                                                            <label class="text-muted small fw-semibold mb-2 d-block">
                                                                <i class="bi bi-geo-alt-fill text-primary me-1"></i> Tempat
                                                            </label>
                                                            <p class="mb-0">{{ $row->tempat ?? '-' }}</p>
                                                        </div>
                                                    </div>

                                                    <div class="row g-3 mb-3">
                                                        <div class="col-6">
                                                            <label class="text-muted small fw-semibold mb-2 d-block">
                                                                <i class="bi bi-bar-chart-fill text-primary me-1"></i> Tingkat
                                                            </label>
                                                            <span class="badge bg-success bg-opacity-10 text-success px-3 py-2">
                                                                {{ $row->tingkat ?? '-' }}
                                                            </span>
                                                        </div>

                                                        <div class="col-6">
                                                            <label class="text-muted small fw-semibold mb-2 d-block">
                                                                <i class="bi bi-calendar-check text-primary me-1"></i> Tahun Ajaran
                                                            </label>
                                                            <p class="mb-0">{{ $row->tahun_ajaran ?? '-' }}</p>
                                                        </div>
                                                    </div>

                                                    <div>
                                                        <label class="text-muted small fw-semibold mb-2 d-block">
                                                            <i class="bi bi-card-text text-primary me-1"></i> Deskripsi
                                                        </label>
                                                        <p class="mb-0">{!! nl2br(e($row->deskripsi ?? '-')) !!}</p>
                                                    </div>
                                                </div>

                                                <div class="border-top pt-3 mt-3">
                                                    <small class="text-muted d-block mb-1">
                                                        <i class="bi bi-clock-history me-1"></i>
                                                        <strong>Dibuat:</strong> {{ optional($row->created_at)->format('d M Y, H:i') }}
                                                    </small>
                                                    <small class="text-muted d-block">
                                                        <i class="bi bi-arrow-repeat me-1"></i>
                                                        <strong>Diperbarui:</strong> {{ optional($row->updated_at)->format('d M Y, H:i') }}
                                                    </small>
                                                </div>
                                            </div>

                                            <div class="col-md-5 text-center">
                                                <label class="text-muted small fw-semibold mb-3 d-block">
                                                    <i class="bi bi-image text-primary me-1"></i> Foto Perlombaan
                                                </label>
                                                @if($row->foto && file_exists(storage_path('app/public/' . $row->foto)))
                                                <img src="{{ asset('storage/' . $row->foto) }}"
                                                    class="img-fluid rounded-4 shadow border border-3 border-primary"
                                                    style="max-width: 320px; object-fit: cover;">
                                                @else
                                                <div class="bg-light rounded-4 d-flex align-items-center justify-content-center" style="height: 320px;">
                                                    <div class="text-center">
                                                        <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                                                        <p class="text-muted small mt-2 mb-0">Tidak ada foto</p>
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer border-0 bg-light">
                                        <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
                                            <i class="bi bi-x-lg me-2"></i>Tutup
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- ==================== MODAL EDIT ==================== --}}
                        <div class="modal fade" id="modalEdit{{ $row->id }}" tabindex="-1">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content border-0 shadow-lg rounded-4">
                                    <div class="modal-header bg-warning text-white border-0 p-4">
                                        <div>
                                            <h5 class="modal-title fw-bold mb-1">Edit Perlombaan</h5>
                                            <small class="opacity-75">Perbarui informasi perlombaan</small>
                                        </div>
                                        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>

                                    <form action="{{ route('pembina.perlombaan.update', $row->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')

                                        <div class="modal-body p-4">
                                            <div class="row g-3">
                                                <div class="col-12">
                                                    <label class="form-label fw-semibold">
                                                        <i class="bi bi-trophy text-warning me-1"></i> Ekstrakurikuler
                                                    </label>
                                                    <select class="form-select" name="ekstrakurikuler_id" required>
                                                        @foreach($ekskul as $e)
                                                        <option value="{{ $e->id }}" {{ (isset($row) && $row->ekstrakurikuler_id == $e->id) ? 'selected' : '' }}>
                                                            {{ $e->nama_ekstrakurikuler }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-12">
                                                    <label class="form-label fw-semibold">
                                                        <i class="bi bi-award text-warning me-1"></i> Nama Perlombaan
                                                    </label>
                                                    <input type="text" name="nama_perlombaan" class="form-control" value="{{ $row->nama_perlombaan }}" required>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold">
                                                        <i class="bi bi-calendar3 text-warning me-1"></i> Tanggal
                                                    </label>
                                                    <input type="date" name="tanggal" class="form-control" value="{{ $row->tanggal }}">
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold">
                                                        <i class="bi bi-geo-alt text-warning me-1"></i> Tempat
                                                    </label>
                                                    <input type="text" name="tempat" class="form-control" value="{{ $row->tempat }}">
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold">
                                                        <i class="bi bi-bar-chart text-warning me-1"></i> Tingkat
                                                    </label>
                                                    <input type="text" name="tingkat" class="form-control" value="{{ $row->tingkat }}">
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold">
                                                        <i class="bi bi-calendar-check text-warning me-1"></i> Tahun Ajaran
                                                    </label>
                                                    <input type="text" name="tahun_ajaran" class="form-control" value="{{ $row->tahun_ajaran }}">
                                                </div>

                                                <div class="col-12">
                                                    <label class="form-label fw-semibold">
                                                        <i class="bi bi-card-text text-warning me-1"></i> Deskripsi
                                                    </label>
                                                    <textarea name="deskripsi" class="form-control" rows="4">{{ $row->deskripsi }}</textarea>
                                                </div>

                                                <div class="col-12">
                                                    <label class="form-label fw-semibold">
                                                        <i class="bi bi-image text-warning me-1"></i> Foto Saat Ini
                                                    </label>
                                                    <div class="text-center bg-light rounded-3 p-3 mb-3">
                                                        @if($row->foto && file_exists(storage_path('app/public/' . $row->foto)))
                                                        <img src="{{ asset('storage/' . $row->foto) }}"
                                                            class="img-fluid rounded-3 shadow-sm"
                                                            style="max-width: 220px; object-fit: cover;">
                                                        @else
                                                        <p class="text-muted mb-0">Tidak ada foto</p>
                                                        @endif
                                                    </div>
                                                    <label class="form-label fw-semibold">Ganti Foto</label>
                                                    <input type="file" name="foto" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal-footer border-0 bg-light p-4">
                                            <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
                                                <i class="bi bi-x-lg me-2"></i>Batal
                                            </button>
                                            <button type="submit" class="btn btn-warning text-white px-4">
                                                <i class="bi bi-check-lg me-2"></i>Perbarui
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        {{-- ==================== MODAL HAPUS ==================== --}}
                        <div class="modal fade" id="modalHapus{{ $row->id }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow-lg rounded-4">
                                    <div class="modal-header bg-danger text-white border-0 p-4">
                                        <div>
                                            <h5 class="modal-title fw-bold mb-1">Hapus Perlombaan</h5>
                                            <small class="opacity-75">Konfirmasi penghapusan data</small>
                                        </div>
                                        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>

                                    <form action="{{ route('pembina.perlombaan.destroy', $row->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <div class="modal-body text-center p-5">
                                            <div class="bg-danger bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                                <i class="bi bi-exclamation-triangle-fill text-danger" style="font-size: 2.5rem;"></i>
                                            </div>
                                            <h5 class="fw-bold mb-2">Apakah Anda yakin?</h5>
                                            <p class="text-muted mb-0">
                                                Perlombaan <strong class="text-dark">{{ $row->nama_perlombaan }}</strong> akan dihapus permanen dan tidak dapat dikembalikan.
                                            </p>
                                        </div>

                                        <div class="modal-footer border-0 bg-light justify-content-center p-4">
                                            <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
                                                <i class="bi bi-x-lg me-2"></i>Batal
                                            </button>
                                            <button type="submit" class="btn btn-danger px-4">
                                                <i class="bi bi-trash me-2"></i>Ya, Hapus
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-5">
                                <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                    <i class="bi bi-inbox text-muted" style="font-size: 2.5rem;"></i>
                                </div>
                                <h6 class="fw-bold mb-2">Belum Ada Data</h6>
                                <p class="text-muted mb-0">Tidak ada data perlombaan yang tersedia saat ini</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($perlombaan->hasPages())
            <div class="p-4 border-top">
                <div class="d-flex justify-content-center">
                    {{ $perlombaan->withQueryString()->links() }}
                </div>
            </div>
            @endif
        </div>

    </div>
</div>

<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-primary text-white border-0 p-4">
                <div>
                    <h5 class="modal-title fw-bold mb-1">Tambah Perlombaan</h5>
                    <small class="opacity-75">Tambahkan perlombaan baru ekstrakurikuler</small>
                </div>
                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('pembina.perlombaan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-trophy text-primary me-1"></i> Ekstrakurikuler
                            </label>
                            <select class="form-select" name="ekstrakurikuler_id" required>
                                <option value="">-- Pilih Ekstrakurikuler --</option>
                                @foreach($ekskul as $e)
                                <option value="{{ $e->id }}" {{ (isset($row) && $row->ekstrakurikuler_id == $e->id) ? 'selected' : '' }}>
                                    {{ $e->nama_ekstrakurikuler }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-award text-primary me-1"></i> Nama Perlombaan
                            </label>
                            <input type="text" name="nama_perlombaan" class="form-control" placeholder="Masukkan nama perlombaan" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-calendar3 text-primary me-1"></i> Tanggal
                            </label>
                            <input type="date" name="tanggal" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-geo-alt text-primary me-1"></i> Tempat
                            </label>
                            <input type="text" name="tempat" class="form-control" placeholder="Masukkan tempat">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-bar-chart text-primary me-1"></i> Tingkat
                            </label>
                            <input type="text" name="tingkat" class="form-control" placeholder="Contoh: Nasional, Regional">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-calendar-check text-primary me-1"></i> Tahun Ajaran
                            </label>
                            <input type="text" name="tahun_ajaran" class="form-control" placeholder="Contoh: 2024/2025">
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-card-text text-primary me-1"></i> Deskripsi
                            </label>
                            <textarea name="deskripsi" class="form-control" rows="4" placeholder="Masukkan deskripsi perlombaan"></textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-image text-primary me-1"></i> Foto (Opsional)
                            </label>
                            <input type="file" name="foto" class="form-control" accept="image/*">
                            <small class="text-muted d-block mt-2">
                                <i class="bi bi-info-circle me-1"></i>Format: JPG, PNG, JPEG. Maksimal 2MB
                            </small>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-0 bg-light p-4">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
                        <i class="bi bi-x-lg me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-check-lg me-2"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@if(!Auth::check() || !in_array(Auth::user()->role, ['pembina', 'ketua']))
<div class="container py-2">
    <div class="row mb-4">
        <div class="col-lg-8 mx-auto">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form method="GET" action="{{ route('perlombaan.index') }}" id="filterForm">
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
                                        placeholder="Cari nama perlombaan..."
                                        value="{{ request('search') }}">
                                </div>
                            </div>

                            <!-- Filter Ekstrakurikuler -->
                            <div class="col-md-6">
                                <select name="ekskul" class="form-select" onchange="document.getElementById('filterForm').submit()">
                                    <option value="">Semua Ekskul</option>
                                    @foreach($ekskul as $e)
                                    <option value="{{ $e->id }}" {{ request('ekskul') == $e->id ? 'selected' : '' }}>
                                        {{ $e->nama_ekstrakurikuler }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                        <div class="mt-3 d-flex flex-wrap gap-2">
                            <span class="text-muted small">Cepat:</span>
                            <a href="{{ route('perlombaan.index') }}"
                                class="badge bg-secondary text-decoration-none py-2 px-3">
                                <i class="bi bi-arrow-clockwise me-1"></i>Reset Filter
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-5 g-4">
        <div class="col-md-4">
            <div class="card-body text-center p-4">
                <h3 class="fw-bold text-primary">{{ $totalPerlombaan }}</h3>
                <p class="text-muted mb-0">Total Perlombaan</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-body text-center p-4">
                <h3 class="fw-bold text-success">{{ $tahunIni }}</h3>
                <p class="text-muted mb-0">Tahun Ini</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-body text-center p-4">
                <h3 class="fw-bold text-warning">{{ $totalEkskul }}</h3>
                <p class="text-muted mb-0">Ekstrakurikuler</p>
            </div>
        </div>
    </div>

    <!-- Competition Cards -->
    <div class="row g-4">
        @forelse($perlombaan as $row)
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm h-100 hover-card" style="border-radius: 12px; overflow: hidden;">
                <!-- Image Section -->
                <div class="position-relative overflow-hidden" style="height: 200px;">
                    @if($row->foto && file_exists(storage_path('app/public/' . $row->foto)))
                    <img src="{{ asset('storage/' . $row->foto) }}"
                        class="card-img-top w-100 h-100"
                        style="object-fit: cover;"
                        alt="{{ $row->nama_perlombaan }}">
                    @else
                    <div class="w-100 h-100 bg-gradient d-flex align-items-center justify-content-center"
                        style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <i class="bi bi-trophy text-white" style="font-size: 4rem; opacity: 0.3;"></i>
                    </div>
                    @endif

                    <!-- Badge Ekstrakurikuler di kiri atas -->
                    <div class="position-absolute top-0 start-0 m-3">
                        <span class="badge bg-primary px-3 py-2" style="font-weight: 500; letter-spacing: 0.5px;">
                            {{ $row->ekstrakurikuler->nama_ekstrakurikuler ?? 'Umum' }}
                        </span>
                    </div>

                    <!-- Badge Tingkat di kanan atas -->
                    <div class="position-absolute top-0 end-0 m-3">
                        <span class="badge bg-dark bg-opacity-75 px-3 py-2" style="font-weight: 500; letter-spacing: 0.5px;">
                            {{ $row->tingkat ?? 'Umum' }}
                        </span>
                    </div>
                </div>

                <div class="card-body d-flex flex-column p-4">
                    <!-- Title -->
                    <h5 class="card-title fw-bold mb-3" style="min-height: 50px; color: #333; line-height: 1.4;">
                        {{ $row->nama_perlombaan }}
                    </h5>

                    <!-- Description -->
                    <p class="text-muted mb-3" style="font-size: 0.9rem; line-height: 1.6;">
                        {{ Str::limit($row->deskripsi ?? 'Lomba Bola Voli ini diselenggarakan sebagai ajang pertandingan untuk mengukur kemampuan dan kekompakan tim. Kegiatan ini bertujuan memberikan pengalaman bertanding, meningkatkan sportivitas, serta mempererat hubungan antar peserta.', 100) }}
                    </p>

                    <!-- Action Button -->
                    <button class="btn btn-primary w-100 mt-auto"
                        data-bs-toggle="modal"
                        data-bs-target="#modalDetailInfo{{ $row->id }}"
                        style="border-radius: 8px; font-weight: 600; padding: 12px;">
                        <i class="bi bi-eye me-2"></i>Lihat Detail
                    </button>
                </div>
            </div>
        </div>

        <!-- MODAL DETAIL INFO -->
        <div class="modal fade" id="modalDetailInfo{{ $row->id }}" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content border-0 shadow-lg">
                    <!-- Modal Header with Image Background -->
                    <div class="position-relative" style="height: 250px; overflow: hidden;">
                        @if($row->foto && file_exists(storage_path('app/public/' . $row->foto)))
                        <img src="{{ asset('storage/' . $row->foto) }}"
                            class="w-100 h-100"
                            style="object-fit: cover; filter: brightness(0.7);"
                            alt="{{ $row->nama_perlombaan }}">
                        @else
                        <div class="w-100 h-100 bg-gradient"
                            style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);"></div>
                        @endif

                        <div class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-end p-4"
                            style="background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);">
                            <span class="badge bg-warning text-dark mb-2 align-self-start">
                                {{ $row->tingkat ?? 'Umum' }}
                            </span>
                            <h3 class="text-white fw-bold mb-0">{{ $row->nama_perlombaan }}</h3>
                        </div>

                        <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3"
                            data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body p-4">
                        <!-- Quick Info Cards -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <div class="card bg-light border-0">
                                    <div class="card-body p-3">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded bg-primary bg-opacity-10 p-3 me-3">
                                                <i class="bi bi-calendar3 text-primary fs-4"></i>
                                            </div>
                                            <div>
                                                <small class="text-muted d-block">Tanggal</small>
                                                <strong>{{ \Carbon\Carbon::parse($row->tanggal)->format('d F Y') }}</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card bg-light border-0">
                                    <div class="card-body p-3">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded bg-danger bg-opacity-10 p-3 me-3">
                                                <i class="bi bi-geo-alt text-danger fs-4"></i>
                                            </div>
                                            <div>
                                                <small class="text-muted d-block">Tempat</small>
                                                <strong>{{ $row->tempat ?? '-' }}</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Details Section -->
                        <div class="mb-4">
                            <h5 class="fw-bold mb-3">
                                <i class="bi bi-info-circle text-primary me-2"></i>Informasi Detail
                            </h5>

                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <td class="text-muted" style="width: 40%;">
                                                <i class="bi bi-mortarboard me-2"></i>Ekstrakurikuler
                                            </td>
                                            <td><strong>{{ $row->ekstrakurikuler->nama_ekstrakurikuler ?? '-' }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <i class="bi bi-award me-2"></i>Tingkat
                                            </td>
                                            <td><span class="badge bg-primary">{{ $row->tingkat ?? '-' }}</span></td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">
                                                <i class="bi bi-book me-2"></i>Tahun Ajaran
                                            </td>
                                            <td><strong>{{ $row->tahun_ajaran ?? '-' }}</strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Description Section -->
                        @if($row->deskripsi)
                        <div class="mb-4">
                            <h5 class="fw-bold mb-3">
                                <i class="bi bi-card-text text-primary me-2"></i>Deskripsi
                            </h5>
                            <div class="bg-light rounded p-3">
                                <p class="mb-0" style="white-space: pre-line;">{{ $row->deskripsi }}</p>
                            </div>
                        </div>
                        @endif

                        <!-- Timeline Info -->
                        <div class="border-top pt-3">
                            <small class="text-muted">
                                <i class="bi bi-clock-history me-1"></i>
                                Terakhir diperbarui: {{ optional($row->updated_at)->format('d M Y, H:i') }}
                            </small>
                        </div>
                    </div>

                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle me-2"></i>Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-5">
                    <i class="bi bi-inbox text-muted" style="font-size: 4rem;"></i>
                    <h4 class="text-muted mt-3">Belum Ada Data Perlombaan</h4>
                    <p class="text-muted">Silakan coba filter atau pencarian yang berbeda</p>
                </div>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-5 d-flex justify-content-center">
        {{ $perlombaan->withQueryString()->links() }}
    </div>

</div>

<style>
    .hover-card {
        transition: all 0.3s ease;
    }

    .hover-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15) !important;
    }

    .card-img-top {
        transition: transform 0.3s ease;
    }

    .hover-card:hover .card-img-top {
        transform: scale(1.05);
    }

    .form-select:focus,
    .form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }

    .badge {
        font-weight: 500;
        letter-spacing: 0.5px;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
    }
</style>
@endif
@endsection
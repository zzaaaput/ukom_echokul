@extends('layouts.template')

@section('content')
    @if(Auth::check() && Auth::user()->role === 'admin')
        <div class="container-fluid bg-light min-vh-100 py-5">
            <div class="container">

                <!-- Header Section -->
                <div class="bg-white rounded-4 shadow-sm p-4 mb-4">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                        <div>
                            <h2 class="fw-bold mb-2">Data Pengumuman</h2>
                            <p class="text-muted mb-0">
                                <i class="bi bi-megaphone-fill me-2"></i>
                                Total <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2">{{ $pengumuman->total() }} pengumuman</span>
                            </p>
                        </div>
                        
                        @if(Auth::check() && Auth::user()->role === 'admin')
                            <button class="btn btn-primary btn-lg px-4" data-bs-toggle="modal" data-bs-target="#modalTambah">
                                <i class="bi bi-plus-circle me-2"></i>Tambah Pengumuman
                            </button>
                        @endif
                    </div>
                </div>

                <!-- Filter & Search Section -->
                <div class="bg-white rounded-4 shadow-sm p-4 mb-4">
                    <div class="row g-3">
                        <!-- Items Per Page -->
                        <div class="col-md-2">
                            <form method="GET" action="{{ route('admin.pengumuman.index') }}">
                                <label for="per_page" class="form-label fw-semibold small">
                                    <i class="bi bi-list-ol text-primary me-1"></i>Tampilkan
                                </label>
                                <select name="per_page" id="per_page" class="form-select" onchange="this.form.submit()">
                                    @foreach([10, 20, 30, 50, 100] as $size)
                                        <option value="{{ $size }}" {{ request('per_page', 10) == $size ? 'selected' : '' }}>
                                            {{ $size }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </div>

                        <!-- Search -->
                        <div class="col-md-10">
                            <form method="GET" action="{{ route('admin.pengumuman.index') }}">
                                <input type="hidden" name="per_page" value="{{ request('per_page', 10) }}">
                                <label for="search" class="form-label fw-semibold small">
                                    <i class="bi bi-search text-primary me-1"></i>Pencarian
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white">
                                        <i class="bi bi-search text-muted"></i>
                                    </span>
                                    <input type="text" name="search" id="search" class="form-control" placeholder="Cari judul atau tanggal..." value="{{ request('search') }}" onchange="this.form.submit()">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Table Section -->
                <div class="bg-white rounded-4 shadow-sm overflow-hidden">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-primary bg-opacity-10">
                                <tr>
                                    <th class="py-3 ps-4 fw-semibold text-primary">No</th>
                                    <th class="py-3 fw-semibold text-primary">Judul Pengumuman</th>
                                    <th class="py-3 fw-semibold text-primary">Tanggal</th>
                                    <th class="py-3 fw-semibold text-primary">Deskripsi</th>
                                    <th class="py-3 fw-semibold text-primary">Foto</th>
                                    <th class="text-center py-3 fw-semibold text-primary">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($pengumuman as $index => $row)
                                <tr>
                                    <td class="ps-4 fw-semibold">{{ ($pengumuman->currentPage() - 1) * $pengumuman->perPage() + $loop->iteration }}</td>
                                    <td class="fw-bold">{{ $row->judul_pengumuman }}</td>
                                    <td>{{ \Carbon\Carbon::parse($row->tanggal)->format('d M Y') }}</td>
                                    <td class="text-wrap" style="max-width: 250px; word-break: break-word;">
                                        {{ Str::limit($row->isi, 50) }}
                                    </td>
                                    <td>
                                        @if($row->foto)
                                            <img src="{{ asset('storage/' . str_replace('storage/', '', $row->foto)) }}" 
                                                class="rounded" style="width:70px; height:70px; object-fit:cover;">
                                        @else
                                            <span class="badge bg-secondary bg-opacity-10 text-secondary px-2 py-1">
                                                <i class="bi bi-image me-1"></i>No Image
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex flex-wrap justify-content-center gap-2">
                                            <button class="btn btn-sm btn-primary"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modalDetail{{ $row->id }}">
                                                <i class="bi bi-eye me-1"></i> Detail
                                            </button>

                                            @if(Auth::check() && Auth::user()->role === 'admin')
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
                                            @endif
                                        </div>
                                    </td>
                                </tr>

                                {{-- ==================== MODAL DETAIL ==================== --}}
                                <div class="modal fade" id="modalDetail{{ $row->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content border-0 shadow-lg rounded-4">
                                            <div class="modal-header bg-primary text-white border-0 p-4">
                                                <div>
                                                    <h5 class="modal-title fw-bold mb-1">Detail Pengumuman</h5>
                                                    <small class="opacity-75">Informasi lengkap pengumuman</small>
                                                </div>
                                                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>

                                            <div class="modal-body p-4">
                                                <div class="row g-4">
                                                    <div class="col-md-8">
                                                        <div class="bg-light rounded-3 p-4 mb-3">
                                                            <div class="row g-3">
                                                                <div class="col-12">
                                                                    <label class="text-muted small fw-semibold mb-2 d-block">
                                                                        <i class="bi bi-megaphone-fill text-primary me-1"></i> Judul Pengumuman
                                                                    </label>
                                                                    <p class="fw-bold mb-0">{{ $row->judul_pengumuman }}</p>
                                                                </div>

                                                                <div class="col-12">
                                                                    <label class="text-muted small fw-semibold mb-2 d-block">
                                                                        <i class="bi bi-calendar-event text-primary me-1"></i> Tanggal
                                                                    </label>
                                                                    <p class="mb-0">{{ \Carbon\Carbon::parse($row->tanggal)->format('d M Y') }}</p>
                                                                </div>

                                                                <div class="col-12">
                                                                    <label class="text-muted small fw-semibold mb-2 d-block">
                                                                        <i class="bi bi-file-text text-primary me-1"></i> Deskripsi
                                                                    </label>
                                                                    <div class="bg-white rounded-2 p-3 border">
                                                                        <p class="mb-0" style="white-space: pre-line;">{{ $row->isi }}</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="border-top pt-3">
                                                            <small class="text-muted d-block mb-1">
                                                                <i class="bi bi-clock-history me-1"></i>
                                                                <strong>Dibuat:</strong> {{ $row->created_at?->format('d M Y, H:i') }}
                                                            </small>
                                                            <small class="text-muted d-block">
                                                                <i class="bi bi-arrow-repeat me-1"></i>
                                                                <strong>Diperbarui:</strong> {{ $row->updated_at?->format('d M Y, H:i') }}
                                                            </small>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 text-center">
                                                        <label class="text-muted small fw-semibold mb-3 d-block">
                                                            <i class="bi bi-image text-primary me-1"></i> Foto Pengumuman
                                                        </label>
                                                        @if($row->foto)
                                                            <img src="{{ asset('storage/' . str_replace('storage/', '', $row->foto)) }}"
                                                                class="img-fluid rounded-4 shadow border border-3 border-primary"
                                                                style="max-width: 230px; object-fit: cover;">
                                                        @else
                                                            <div class="bg-light rounded-4 d-flex align-items-center justify-content-center" style="height: 230px;">
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

                                @if(Auth::check() && Auth::user()->role === 'admin')
                                    {{-- ==================== MODAL EDIT ==================== --}}
                                    <div class="modal fade" id="modalEdit{{ $row->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                            <div class="modal-content border-0 shadow-lg rounded-4">
                                                <div class="modal-header bg-warning text-white border-0 p-4">
                                                    <div>
                                                        <h5 class="modal-title fw-bold mb-1">Edit Pengumuman</h5>
                                                        <small class="opacity-75">Perbarui informasi pengumuman</small>
                                                    </div>
                                                    <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                </div>

                                                <form action="{{ route('admin.pengumuman.update', $row->id) }}" method="POST" enctype="multipart/form-data">
                                                    @csrf @method('PUT')

                                                    <div class="modal-body p-4">
                                                        <div class="row g-3">
                                                            <div class="col-12">
                                                                <label class="form-label fw-semibold">
                                                                    <i class="bi bi-megaphone-fill text-warning me-1"></i> Judul Pengumuman
                                                                </label>
                                                                <input type="text" name="judul_pengumuman" class="form-control" value="{{ $row->judul_pengumuman }}" required>
                                                            </div>

                                                            <div class="col-12">
                                                                <label class="form-label fw-semibold">
                                                                    <i class="bi bi-calendar-event text-warning me-1"></i> Tanggal
                                                                </label>
                                                                <input type="date" name="tanggal" class="form-control" value="{{ $row->tanggal }}" required>
                                                            </div>

                                                            <div class="col-12">
                                                                <label class="form-label fw-semibold">
                                                                    <i class="bi bi-file-text text-warning me-1"></i> Deskripsi
                                                                </label>
                                                                <textarea name="isi" class="form-control" rows="4" required>{{ $row->isi }}</textarea>
                                                            </div>

                                                            <div class="col-12">
                                                                <label class="form-label fw-semibold">
                                                                    <i class="bi bi-image text-warning me-1"></i> Foto Saat Ini
                                                                </label>
                                                                <div class="text-center bg-light rounded-3 p-3 mb-3">
                                                                    @if($row->foto)
                                                                        <img src="{{ asset('storage/' . str_replace('storage/', '', $row->foto)) }}" 
                                                                            class="img-thumbnail shadow-sm rounded-3" 
                                                                            style="max-width: 180px; height:180px; object-fit:cover;">
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
                                                        <h5 class="modal-title fw-bold mb-1">Hapus Pengumuman</h5>
                                                        <small class="opacity-75">Konfirmasi penghapusan data</small>
                                                    </div>
                                                    <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                </div>

                                                <form action="{{ route('admin.pengumuman.destroy', $row->id) }}" method="POST">
                                                    @csrf @method('DELETE')

                                                    <div class="modal-body text-center p-5">
                                                        <div class="bg-danger bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                                            <i class="bi bi-exclamation-triangle-fill text-danger" style="font-size: 2.5rem;"></i>
                                                        </div>
                                                        <h5 class="fw-bold mb-2">Apakah Anda yakin?</h5>
                                                        <p class="text-muted mb-0">
                                                            Pengumuman <strong class="text-dark">{{ $row->judul_pengumuman }}</strong> akan dihapus permanen dan tidak dapat dikembalikan.
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
                                @endif

                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                            <i class="bi bi-inbox text-muted" style="font-size: 2.5rem;"></i>
                                        </div>
                                        <h6 class="fw-bold mb-2">Belum Ada Pengumuman</h6>
                                        <p class="text-muted mb-0">Tidak ada data pengumuman yang tersedia saat ini</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($pengumuman->hasPages())
                    <div class="p-4 border-top">
                        <div class="d-flex justify-content-center">
                            {{ $pengumuman->withQueryString()->links() }}
                        </div>
                    </div>
                    @endif
                </div>

            </div>
        </div>

        {{-- ==================== MODAL TAMBAH PENGUMUMAN ==================== --}}
        <div class="modal fade" id="modalTambah" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg rounded-4">
                    
                    <div class="modal-header bg-primary text-white border-0 p-4">
                        <div>
                            <h5 class="modal-title fw-bold mb-1">Tambah Pengumuman</h5>
                            <small class="opacity-75">Buat pengumuman baru</small>
                        </div>
                        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
        
                    <form action="{{ route('admin.pengumuman.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
        
                        <div class="modal-body p-4">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label fw-semibold">
                                        <i class="bi bi-megaphone-fill text-primary me-1"></i> Judul Pengumuman
                                    </label>
                                    <input type="text" name="judul_pengumuman" class="form-control" placeholder="Masukkan judul pengumuman" required>
                                </div>
        
                                <div class="col-12">
                                    <label class="form-label fw-semibold">
                                        <i class="bi bi-calendar-event text-primary me-1"></i> Tanggal
                                    </label>
                                    <input type="date" name="tanggal" class="form-control" required>
                                </div>
        
                                <div class="col-12">
                                    <label class="form-label fw-semibold">
                                        <i class="bi bi-file-text text-primary me-1"></i> Deskripsi
                                    </label>
                                    <textarea name="isi" class="form-control" rows="4" placeholder="Masukkan isi pengumuman..." required></textarea>
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

    @if(!Auth::check() || Auth::user()->role !== 'admin')
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
        </div>

        <style>
        .hover-card{transition:.3s;}
        .hover-card:hover{transform:translateY(-10px);box-shadow:0 10px 30px rgba(0,0,0,.15)!important;}
        </style>
    @endif

@endsection
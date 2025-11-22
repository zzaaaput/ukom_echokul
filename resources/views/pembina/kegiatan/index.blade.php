@extends('layouts.template')

@section('title', 'Kegiatan')

@section('content')
    @if(Auth::check() && in_array(Auth::user()->role, ['pembina', 'ketua']))
        <div class="container-fluid bg-light min-vh-100 py-5">
            <div class="container">

                <!-- Header Section -->
                <div class="bg-white rounded-4 shadow-sm p-4 mb-4">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                        <div>
                            <h2 class="fw-bold mb-2">Data Kegiatan</h2>
                            <p class="text-muted mb-0">
                                <i class="bi bi-calendar-event-fill me-2"></i>
                                Kelola kegiatan ekstrakurikuler
                            </p>
                        </div>

                        @if(Auth::check() && (Auth::user()->role === 'ketua' || Auth::user()->role === 'pembina'))
                        <button class="btn btn-primary btn-lg px-4"
                                data-bs-toggle="modal"
                                data-bs-target="#modalTambah">
                            <i class="bi bi-plus-circle me-2"></i>Tambah Kegiatan
                        </button>
                        @endif
                    </div>
                </div>

                <!-- Search Section -->
                <div class="bg-white rounded-4 shadow-sm p-4 mb-4">
                    <form method="GET" action="{{ route('pembina.kegiatan.index') }}">
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
                                placeholder="Cari nama kegiatan / lokasi / tanggal..."
                                value="{{ request('search') }}"
                                onchange="this.form.submit()">
                            @if(request('search'))
                                <a href="{{ route('pembina.kegiatan.index') }}" class="btn btn-outline-secondary">
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
                                    <th class="py-3 fw-semibold text-primary">Nama Kegiatan</th>
                                    <th class="py-3 fw-semibold text-primary">Tanggal</th>
                                    <th class="py-3 fw-semibold text-primary">Lokasi</th>
                                    <th class="py-3 fw-semibold text-primary">Foto</th>
                                    <th class="text-center py-3 fw-semibold text-primary">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kegiatan as $index => $row)
                                <tr>
                                    <td class="ps-4 fw-semibold">{{ $kegiatan->firstItem() + $index }}</td>
                                    <td>{{ $row->ekstrakurikuler->nama_ekstrakurikuler ?? '-' }}</td>
                                    <td class="fw-bold">{{ $row->nama_kegiatan }}</td>
                                    <td>
                                        <span class="badge bg-info bg-opacity-10 text-info px-3 py-2">
                                            <i class="bi bi-calendar3 me-1"></i>
                                            {{ \Carbon\Carbon::parse($row->tanggal)->format('d M Y') }}
                                        </span>
                                    </td>
                                    <td>{{ $row->lokasi ?? '-' }}</td>
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

                                            @if(Auth::check() && (Auth::user()->role === 'ketua' || Auth::user()->role === 'pembina'))
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
                                                    <h5 class="modal-title fw-bold mb-1">Detail Kegiatan</h5>
                                                    <small class="opacity-75">Informasi lengkap kegiatan ekstrakurikuler</small>
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
                                                                    <i class="bi bi-calendar-event text-primary me-1"></i> Nama Kegiatan
                                                                </label>
                                                                <p class="fw-bold mb-0">{{ $row->nama_kegiatan }}</p>
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
                                                                        <i class="bi bi-geo-alt-fill text-primary me-1"></i> Lokasi
                                                                    </label>
                                                                    <p class="mb-0">{{ $row->lokasi ?? '-' }}</p>
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
                                                            <i class="bi bi-image text-primary me-1"></i> Foto Kegiatan
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
                                                    <h5 class="modal-title fw-bold mb-1">Edit Kegiatan</h5>
                                                    <small class="opacity-75">Perbarui informasi kegiatan</small>
                                                </div>
                                                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>

                                            <form action="{{ route('pembina.kegiatan.update', $row->id) }}" method="POST" enctype="multipart/form-data">
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
                                                                    <option value="{{ $e->id }}" {{ $row->ekstrakurikuler_id == $e->id ? 'selected' : '' }}>
                                                                        {{ $e->nama_ekstrakurikuler }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="col-12">
                                                            <label class="form-label fw-semibold">
                                                                <i class="bi bi-calendar-event text-warning me-1"></i> Nama Kegiatan
                                                            </label>
                                                            <input type="text" name="nama_kegiatan" class="form-control" value="{{ $row->nama_kegiatan }}" required>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label class="form-label fw-semibold">
                                                                <i class="bi bi-calendar3 text-warning me-1"></i> Tanggal
                                                            </label>
                                                            <input type="date" name="tanggal" class="form-control" value="{{ $row->tanggal }}">
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label class="form-label fw-semibold">
                                                                <i class="bi bi-geo-alt text-warning me-1"></i> Lokasi
                                                            </label>
                                                            <input type="text" name="lokasi" class="form-control" value="{{ $row->lokasi }}">
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
                                                    <h5 class="modal-title fw-bold mb-1">Hapus Kegiatan</h5>
                                                    <small class="opacity-75">Konfirmasi penghapusan data</small>
                                                </div>
                                                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>

                                            <form action="{{ route('pembina.kegiatan.destroy', $row->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                
                                                <div class="modal-body text-center p-5">
                                                    <div class="bg-danger bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                                        <i class="bi bi-exclamation-triangle-fill text-danger" style="font-size: 2.5rem;"></i>
                                                    </div>
                                                    <h5 class="fw-bold mb-2">Apakah Anda yakin?</h5>
                                                    <p class="text-muted mb-0">
                                                        Kegiatan <strong class="text-dark">{{ $row->nama_kegiatan }}</strong> akan dihapus permanen dan tidak dapat dikembalikan.
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
                                    <td colspan="7" class="text-center py-5">
                                        <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                            <i class="bi bi-inbox text-muted" style="font-size: 2.5rem;"></i>
                                        </div>
                                        <h6 class="fw-bold mb-2">Belum Ada Data</h6>
                                        <p class="text-muted mb-0">Tidak ada data kegiatan yang tersedia saat ini</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($kegiatan->hasPages())
                    <div class="p-4 border-top">
                        <div class="d-flex justify-content-center">
                            {{ $kegiatan->withQueryString()->links() }}
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
                            <h5 class="modal-title fw-bold mb-1">Tambah Kegiatan</h5>
                            <small class="opacity-75">Tambahkan kegiatan baru ekstrakurikuler</small>
                        </div>
                        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>

                    <form action="{{ route('pembina.kegiatan.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="modal-body p-4">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label fw-semibold">
                                        <i class="bi bi-trophy text-primary me-1"></i> Ekstrakurikuler
                                    </label>
                                    @if(Auth::check() && Auth::user()->role === 'pembina')
                                        <input type="text" class="form-control" 
                                            value="{{ $pembinaEkskul->nama_ekstrakurikuler ?? '' }}" readonly>
                                        <input type="hidden" name="ekstrakurikuler_id" 
                                            value="{{ $pembinaEkskul->id ?? '' }}">
                                    @else
                                        <select name="ekstrakurikuler_id" class="form-select" required>
                                            <option value="">-- Pilih Ekstrakurikuler --</option>
                                            @foreach($ekstrakurikulerList as $e)
                                                <option value="{{ $e->id }}">{{ $e->nama_ekstrakurikuler }}</option>
                                            @endforeach
                                        </select>
                                    @endif
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-semibold">
                                        <i class="bi bi-calendar-event text-primary me-1"></i> Nama Kegiatan
                                    </label>
                                    <input type="text" name="nama_kegiatan" class="form-control" placeholder="Masukkan nama kegiatan" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">
                                        <i class="bi bi-calendar3 text-primary me-1"></i> Tanggal
                                    </label>
                                    <input type="date" name="tanggal" class="form-control">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">
                                        <i class="bi bi-geo-alt text-primary me-1"></i> Lokasi
                                    </label>
                                    <input type="text" name="lokasi" class="form-control" placeholder="Masukkan lokasi">
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-semibold">
                                        <i class="bi bi-card-text text-primary me-1"></i> Deskripsi
                                    </label>
                                    <textarea name="deskripsi" class="form-control" rows="4" placeholder="Masukkan deskripsi kegiatan"></textarea>
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

            <!-- FILTER & SEARCH -->
            <div class="row mb-4">
                <div class="col-lg-8 mx-auto">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <form method="GET" action="{{ route('kegiatan.index') }}" id="filterForm">
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
                                                placeholder="Cari nama kegiatan..."
                                                value="{{ request('search') }}">
                                        </div>
                                    </div>

                                    <!-- Filter Ekskul -->
                                    <div class="col-md-3">
                                        <select name="ekskul" class="form-select"
                                            onchange="document.getElementById('filterForm').submit()">
                                            <option value="">Semua Ekskul</option>
                                            @foreach($ekskul as $e)
                                                <option value="{{ $e->id }}" 
                                                    {{ request('ekskul') == $e->id ? 'selected' : '' }}>
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

                                    <!-- Reset -->
                                    <a href="{{ route('kegiatan.index') }}" 
                                        class="badge bg-secondary text-decoration-none py-2 px-3">
                                        <i class="bi bi-arrow-clockwise me-1"></i>Reset Filter
                                    </a>

                                    <!-- Hari ini -->
                                    <a href="{{ route('kegiatan.index', [
                                        'tanggal' => today()->format('Y-m-d'),
                                        'search' => request('search'),
                                        'ekskul' => request('ekskul')
                                    ]) }}" 
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
                        <h3 class="fw-bold text-primary">{{ $totalKegiatan }}</h3>
                        <p class="text-muted mb-0">Total Kegiatan</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card-body text-center p-4">
                        <h3 class="fw-bold text-success">{{ $kegiatanHariIni }}</h3>
                        <p class="text-muted mb-0">Kegiatan Hari Ini</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card-body text-center p-4">
                        <h3 class="fw-bold text-warning">{{ $totalEkstrakurikuler }}</h3>
                        <p class="text-muted mb-0">Ekstrakurikuler</p>
                    </div>
                </div>
            </div>

            <!-- LIST CARD -->
            <div class="row g-4">
                @forelse($kegiatan as $row)
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 shadow-sm h-100 hover-card">

                        <!-- Gambarnya -->
                        <div class="position-relative overflow-hidden" style="height: 220px;">
                            @if($row->foto)
                                <img src="{{ asset('storage/'.$row->foto) }}" 
                                    class="card-img-top w-100 h-100" style="object-fit: cover;">
                            @else
                            <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-primary bg-gradient">
                                <i class="bi bi-calendar-event text-white" style="font-size: 4rem; opacity:.4"></i>
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
                            <h5 class="card-title fw-bold mb-3">{{ $row->nama_kegiatan }}</h5>

                            <!-- Info -->
                            <div class="mb-3 flex-grow-1">
                                <div class="d-flex text-muted mb-2">
                                    <i class="bi bi-calendar3 me-2 text-primary"></i>
                                    <small>{{ \Carbon\Carbon::parse($row->tanggal)->format('d F Y') }}</small>
                                </div>
                                <div class="d-flex text-muted mb-2">
                                    <i class="bi bi-geo-alt me-2 text-danger"></i>
                                    <small>{{ $row->lokasi ?? '-' }}</small>
                                </div>
                                <div class="d-flex text-muted">
                                    <i class="bi bi-clock me-2 text-success"></i>
                                    <small>
                                        {{ $row->waktu_mulai }} - {{ $row->waktu_selesai ?? '-' }}
                                    </small>
                                </div>
                            </div>

                            <!-- Tombol -->
                            <button class="btn btn-primary w-100"
                                data-bs-toggle="modal"
                                data-bs-target="#modalDetailKegiatan{{ $row->id }}">
                                <i class="bi bi-eye me-2"></i>Detail
                            </button>

                        </div>
                    </div>
                </div>

                <!-- MODAL DETAIL -->
                <div class="modal fade" id="modalDetailKegiatan{{ $row->id }}">
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
                                    <h3 class="text-white fw-bold mb-0">{{ $row->nama_kegiatan }}</h3>
                                </div>
                            </div>

                            <div class="modal-body p-4">

                                <!-- Informasi -->
                                <div class="row g-3 mb-4">

                                    <div class="col-md-6">
                                        <div class="card bg-light border-0">
                                            <div class="card-body d-flex align-items-center p-3">
                                                <div class="bg-primary bg-opacity-10 p-3 me-3 rounded">
                                                    <i class="bi bi-calendar3 text-primary fs-4"></i>
                                                </div>
                                                <div>
                                                    <small class="text-muted">Tanggal</small>
                                                    <div class="fw-bold">
                                                        {{ \Carbon\Carbon::parse($row->tanggal)->format('d F Y') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="card bg-light border-0">
                                            <div class="card-body d-flex align-items-center p-3">
                                                <div class="bg-danger bg-opacity-10 p-3 me-3 rounded">
                                                    <i class="bi bi-geo-alt text-danger fs-4"></i>
                                                </div>
                                                <div>
                                                    <small class="text-muted">Lokasi</small>
                                                    <div class="fw-bold">{{ $row->lokasi ?? '-' }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <!-- Deskripsi -->
                                @if($row->deskripsi)
                                <div class="mb-4">
                                    <h5 class="fw-bold mb-3">
                                        <i class="bi bi-card-text text-primary me-2"></i>Deskripsi
                                    </h5>
                                    <div class="bg-light rounded p-3">
                                        <p class="mb-0" style="white-space:pre-line;">{{ $row->deskripsi }}</p>
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
                            <h4 class="text-muted mt-3">Belum Ada Kegiatan</h4>
                        </div>
                    </div>
                </div>
                @endforelse
            </div>

            <div class="mt-5 d-flex justify-content-center">
                {{ $kegiatan->withQueryString()->links() }}
            </div>

        </div>

        <style>
        .hover-card{transition:.3s;}
        .hover-card:hover{transform:translateY(-10px);box-shadow:0 10px 30px rgba(0,0,0,.15)!important;}
        </style>

    @endif

@endsection
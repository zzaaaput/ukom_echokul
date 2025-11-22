@extends('layouts.template')

@section('title', 'Kehadiran')

@section('content')
    <!-- Header Card dengan Total -->
    <div class="container py-5">
    <div class="card shadow-sm border-0 rounded-3 mb-4">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="fw-bold text-dark mb-2" style="font-size: 1.75rem;">Data Kehadiran</h3>
                    <p class="text-muted mb-0">Total <span class="badge bg-primary px-3 py-2" style="font-size: 0.9rem;">{{ $kehadiran->total() }} kehadiran</span></p>
                </div>

                @if(Auth::user()->role === 'pembina')
                <button class="btn btn-tambah px-4 py-2" data-bs-toggle="modal" data-bs-target="#modalTambah" style="font-weight: 500;">
                    <i class="bi bi-plus-circle me-2"></i>Tambah Kehadiran
                </button>
                @endif
            </div>
        </div>
    </div>

    <!-- Card dengan Filter dan Tabel -->
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body p-4">

            <!-- Filter Section -->
            <form method="GET" action="{{ route('pembina.kehadiran.index') }}" id="filterForm">
                <div class="row mb-4 g-3 align-items-end">
                    <div class="col-md-2">
                        <label class="form-label fw-semibold text-dark mb-2">Tampilkan</label>
                        <select name="per_page" class="form-select" style="height: 45px;" onchange="this.form.submit()">
                            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-dark mb-2">
                            <i class="bi bi-search me-1"></i>Pencarian
                        </label>
                        <input type="text" name="search" class="form-control" style="height: 45px;" placeholder="Cari nama anggota atau kegiatan..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold text-dark mb-2">
                            <i class="bi bi-funnel me-1"></i>Filter Status
                        </label>
                        <select name="status" class="form-select" style="height: 45px;">
                            <option value="">Semua Status</option>
                            <option value="hadir" {{ request('status') == 'hadir' ? 'selected' : '' }}>Hadir</option>
                            <option value="izin" {{ request('status') == 'izin' ? 'selected' : '' }}>Izin</option>
                            <option value="sakit" {{ request('status') == 'sakit' ? 'selected' : '' }}>Sakit</option>
                            <option value="alpha" {{ request('status') == 'alpha' ? 'selected' : '' }}>Alpha</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary flex-fill" style="height: 45px; font-weight: 500;">
                                <i class="bi bi-search me-2"></i>Cari Data
                            </button>
                            <a href="{{ route('pembina.kehadiran.index') }}" class="btn btn-primary" style="height: 45px; font-weight: 500; padding: 0 20px; display: flex; align-items: center; justify-content: center;" title="Reset Filter">
                                <i class="bi bi-arrow-clockwise me-1"></i>Reset
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Info Filter Aktif -->
                @if(request('search') || request('status'))
                <div class="alert alert-info alert-dismissible fade show mb-3" role="alert">
                    <i class="bi bi-info-circle me-2"></i>
                    <strong>Filter Aktif:</strong>
                    @if(request('search'))
                    Pencarian: "<strong>{{ request('search') }}</strong>"
                    @endif
                    @if(request('status'))
                    Status: <strong class="text-capitalize">{{ request('status') }}</strong>
                    @endif
                    <a href="{{ route('pembina.kehadiran.index') }}" class="alert-link ms-2">Hapus Filter</a>
                </div>
                @endif
            </form>

            <!-- Tabel -->
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background-color: #f8f9fc; border-bottom: 2px solid #e3e6f0;">
                        <tr>
                            <th class="py-3 px-4 text-center fw-semibold" style="width: 70px; color: #5a5c69;">No</th>
                            <th class="py-3 px-4 fw-semibold" style="color: #5a5c69;">Nama Anggota</th>
                            <th class="py-3 px-4 fw-semibold" style="color: #5a5c69;">Kegiatan</th>
                            <th class="py-3 px-4 text-center fw-semibold" style="color: #5a5c69;">Tanggal</th>
                            <th class="py-3 px-4 text-center fw-semibold" style="color: #5a5c69;">Status</th>
                            @if(Auth::user()->role === 'pembina')
                            <th class="py-3 px-4 text-center fw-semibold" style="color: #5a5c69;">Aksi</th>
                            @endif
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($kehadiran as $k)
                        <tr style="border-bottom: 1px solid #e3e6f0;">
                            <td class="text-center px-4 py-3">{{ $loop->iteration + ($kehadiran->currentPage() - 1) * $kehadiran->perPage() }}</td>
                            <td class="px-4 py-3 fw-semibold" style="color: #2c3e50;">{{ $k->anggota->user->name ?? $k->anggota->nama_anggota }}</td>
                            <td class="px-4 py-3" style="color: #5a5c69;">{{ $k->kegiatan->nama_kegiatan ?? '-' }}</td>
                            <td class="text-center px-4 py-3" style="color: #5a5c69;">{{ \Carbon\Carbon::parse($k->tanggal)->format('d/m/Y') }}</td>
                            <td class="text-center px-4 py-3">
                                @if($k->status == 'hadir')
                                <span class="badge bg-success rounded-pill px-3 py-2" style="font-size: 0.85rem; font-weight: 500;">
                                    <i class="bi bi-check-circle me-1"></i>Hadir
                                </span>
                                @elseif($k->status == 'izin')
                                <span class="badge bg-warning text-dark rounded-pill px-3 py-2" style="font-size: 0.85rem; font-weight: 500;">
                                    <i class="bi bi-info-circle me-1"></i>Izin
                                </span>
                                @elseif($k->status == 'sakit')
                                <span class="badge bg-info text-white rounded-pill px-3 py-2" style="font-size: 0.85rem; font-weight: 500;">
                                    <i class="bi bi-bandaid me-1"></i>Sakit
                                </span>
                                @else
                                <span class="badge bg-danger rounded-pill px-3 py-2" style="font-size: 0.85rem; font-weight: 500;">
                                    <i class="bi bi-x-circle me-1"></i>Alpha
                                </span>
                                @endif
                            </td>

                            @if(Auth::user()->role === 'pembina')
                            <td class="text-center px-4 py-3">
                                <div class="d-flex gap-1 justify-content-center flex-wrap">
                                    <button type="button" class="btn btn-info btn-sm text-white px-3" data-bs-toggle="modal" data-bs-target="#modalDetail{{ $k->id }}" style="min-width: 80px;">
                                        <i class="bi bi-eye me-1"></i>Detail
                                    </button>
                                    <button type="button" class="btn btn-warning btn-sm text-dark px-3" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $k->id }}" style="min-width: 70px;">
                                        <i class="bi bi-pencil me-1"></i>Edit
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm text-white px-3" onclick="confirmDelete({{ $k->id }})" style="min-width: 80px;">
                                        <i class="bi bi-trash me-1"></i>Hapus
                                    </button>
                                    <form id="delete-form-{{ $k->id }}" action="{{ route('pembina.kehadiran.destroy', $k->id) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </td>
                            @endif
                        </tr>

                        <!-- Modal Detail -->
                        <div class="modal fade" id="modalDetail{{ $k->id }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content border-0 shadow-lg">
                                    <div class="modal-header text-white" style="background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%); border-bottom: none;">
                                        <h5 class="modal-title fw-bold">
                                            <i class="bi bi-info-circle me-2"></i>Detail Kehadiran
                                        </h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body p-4">
                                        <div class="row g-4">
                                            <div class="col-md-6">
                                                <div class="detail-item">
                                                    <label class="text-muted small mb-1"><i class="bi bi-person me-2"></i>Nama Anggota</label>
                                                    <p class="fw-semibold mb-0">{{ $k->anggota->user->name ?? $k->anggota->nama_anggota }}</p>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="detail-item">
                                                    <label class="text-muted small mb-1"><i class="bi bi-calendar-event me-2"></i>Kegiatan</label>
                                                    <p class="fw-semibold mb-0">{{ $k->kegiatan->nama_kegiatan ?? '-' }}</p>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="detail-item">
                                                    <label class="text-muted small mb-1"><i class="bi bi-calendar me-2"></i>Tanggal</label>
                                                    <p class="fw-semibold mb-0">{{ \Carbon\Carbon::parse($k->tanggal)->format('d F Y') }}</p>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="detail-item">
                                                    <label class="text-muted small mb-1"><i class="bi bi-check-square me-2"></i>Status Kehadiran</label>
                                                    <p class="mb-0">
                                                        @if($k->status == 'hadir')
                                                        <span class="badge bg-success px-3 py-2">
                                                            <i class="bi bi-check-circle me-1"></i>Hadir
                                                        </span>
                                                        @elseif($k->status == 'izin')
                                                        <span class="badge bg-warning text-dark px-3 py-2">
                                                            <i class="bi bi-info-circle me-1"></i>Izin
                                                        </span>
                                                        @elseif($k->status == 'sakit')
                                                        <span class="badge bg-info px-3 py-2">
                                                            <i class="bi bi-bandaid me-1"></i>Sakit
                                                        </span>
                                                        @else
                                                        <span class="badge bg-danger px-3 py-2">
                                                            <i class="bi bi-x-circle me-1"></i>Alpha
                                                        </span>
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                            @if($k->bukti_kehadiran)
                                            <div class="col-12">
                                                <div class="detail-item">
                                                    <label class="text-muted small mb-2"><i class="bi bi-image me-2"></i>Bukti Kehadiran</label>
                                                    <div class="text-center">
                                                        <img src="{{ asset('storage/' . $k->bukti_kehadiran) }}" alt="Bukti Kehadiran" class="img-fluid rounded shadow" style="max-height: 300px;">
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                            <div class="col-md-6">
                                                <div class="detail-item">
                                                    <label class="text-muted small mb-1"><i class="bi bi-person-check me-2"></i>Dicatat Oleh</label>
                                                    <p class="fw-semibold mb-0">{{ $k->pencatat->name ?? '-' }}</p>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="detail-item">
                                                    <label class="text-muted small mb-1"><i class="bi bi-clock me-2"></i>Waktu Pencatatan</label>
                                                    <p class="fw-semibold mb-0">{{ \Carbon\Carbon::parse($k->created_at)->format('d/m/Y H:i') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer border-0 bg-light">
                                        <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
                                            <i class="bi bi-x-circle me-1"></i>Tutup
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Edit -->
                        <div class="modal fade" id="modalEdit{{ $k->id }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content border-0 shadow-lg">
                                    <div class="modal-header text-white" style="background: linear-gradient(135deg, #ffc107 0%, #ffb300 100%); border-bottom: none;">
                                        <h5 class="modal-title fw-bold text-dark">
                                            <i class="bi bi-pencil-square me-2"></i>Edit Kehadiran
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <form method="POST" action="{{ route('pembina.kehadiran.update', $k->id) }}" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')

                                        <div class="modal-body p-4" style="background-color: #f8f9fa;">
                                            <div class="row g-3">
                                                <!-- Card Nama Anggota -->
                                                <div class="col-md-6">
                                                    <div class="card border-0 shadow-sm h-100" style="background: white;">
                                                        <div class="card-body p-3">
                                                            <label class="form-label fw-semibold text-dark mb-2">
                                                                <i class="bi bi-person text-warning me-2"></i>Nama Anggota
                                                                <span class="text-danger">*</span>
                                                            </label>
                                                            <select name="anggota_ekskul_id" class="form-select" style="height: 45px;" required>
                                                                <option value="">-- Pilih Anggota --</option>
                                                                @foreach($anggota as $a)
                                                                <option value="{{ $a->id }}" {{ $k->anggota_ekskul_id == $a->id ? 'selected' : '' }}>
                                                                    {{ $a->user->name ?? $a->nama_anggota }}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Card Kegiatan -->
                                                <div class="col-md-6">
                                                    <div class="card border-0 shadow-sm h-100" style="background: white;">
                                                        <div class="card-body p-3">
                                                            <label class="form-label fw-semibold text-dark mb-2">
                                                                <i class="bi bi-calendar-event text-warning me-2"></i>Kegiatan
                                                                <span class="text-danger">*</span>
                                                            </label>
                                                            <select name="kegiatan_id" class="form-select" style="height: 45px;" required>
                                                                <option value="">-- Pilih Kegiatan --</option>
                                                                @foreach($kegiatan as $kg)
                                                                <option value="{{ $kg->id }}" {{ $k->kegiatan_id == $kg->id ? 'selected' : '' }}>
                                                                    {{ $kg->nama_kegiatan }} - {{ \Carbon\Carbon::parse($kg->tanggal)->format('d/m/Y') }}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Card Tanggal -->
                                                <div class="col-md-6">
                                                    <div class="card border-0 shadow-sm h-100" style="background: white;">
                                                        <div class="card-body p-3">
                                                            <label class="form-label fw-semibold text-dark mb-2">
                                                                <i class="bi bi-calendar text-warning me-2"></i>Tanggal
                                                                <span class="text-danger">*</span>
                                                            </label>
                                                            <input type="date" name="tanggal" class="form-control" style="height: 45px;" required value="{{ $k->tanggal }}">
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Card Status -->
                                                <div class="col-md-6">
                                                    <div class="card border-0 shadow-sm h-100" style="background: white;">
                                                        <div class="card-body p-3">
                                                            <label class="form-label fw-semibold text-dark mb-2">
                                                                <i class="bi bi-check-square text-warning me-2"></i>Status
                                                                <span class="text-danger">*</span>
                                                            </label>
                                                            <select name="status" class="form-select" style="height: 45px;" required>
                                                                <option value="">-- Pilih Status --</option>
                                                                <option value="hadir" {{ $k->status == 'hadir' ? 'selected' : '' }}>✓ Hadir</option>
                                                                <option value="izin" {{ $k->status == 'izin' ? 'selected' : '' }}>ℹ Izin</option>
                                                                <option value="sakit" {{ $k->status == 'sakit' ? 'selected' : '' }}>🏥 Sakit</option>
                                                                <option value="alpha" {{ $k->status == 'alpha' ? 'selected' : '' }}>✗ Alpha</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Card Bukti Kehadiran -->
                                                <div class="col-12">
                                                    <div class="card border-0 shadow-sm" style="background: white;">
                                                        <div class="card-body p-3">
                                                            <label class="form-label fw-semibold text-dark mb-2">
                                                                <i class="bi bi-image text-warning me-2"></i>Bukti Kehadiran
                                                                <span class="text-muted small">(opsional)</span>
                                                            </label>
                                                            @if($k->bukti_kehadiran)
                                                            <div class="mb-3">
                                                                <img src="{{ asset('storage/' . $k->bukti_kehadiran) }}" alt="Bukti Lama" class="img-thumbnail" style="max-height: 150px;">
                                                                <small class="d-block text-muted mt-1">Bukti kehadiran saat ini</small>
                                                            </div>
                                                            @endif
                                                            <input type="file" name="bukti_kehadiran" class="form-control" accept="image/*">
                                                            <small class="text-muted">Format: JPG, PNG, maksimal 2MB. Kosongkan jika tidak ingin mengubah.</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal-footer border-0" style="background-color: #fff8e1; padding: 1.25rem 1.5rem;">
                                            <button type="button" class="btn btn-secondary px-4 py-2" data-bs-dismiss="modal" style="font-weight: 500;">
                                                <i class="bi bi-x-circle me-1"></i>Batal
                                            </button>
                                            <button type="submit" class="btn btn-warning px-4 py-2 text-dark" style="font-weight: 500;">
                                                <i class="bi bi-check-circle me-1"></i>Update
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="120" height="120" viewBox="0 0 24 24" fill="none" stroke="#cbd5e0" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="opacity: 0.5; margin-bottom: 1.5rem;">
                                        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="8.5" cy="7" r="4"></circle>
                                        <polyline points="17 11 19 13 23 9"></polyline>
                                    </svg>
                                    <h5 class="text-muted mb-2" style="font-weight: 500;">
                                        @if(request('search') || request('status'))
                                        Tidak ada data yang sesuai dengan pencarian
                                        @else
                                        Belum ada data kehadiran
                                        @endif
                                    </h5>
                                    <p class="text-muted mb-0" style="font-size: 0.9rem;">
                                        @if(request('search') || request('status'))
                                        Coba gunakan kata kunci atau filter yang berbeda
                                        @else
                                        Data kehadiran akan ditampilkan di sini
                                        @endif
                                    </p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($kehadiran->hasPages())
            <div class="mt-4 d-flex justify-content-between align-items-center">
                <div class="text-muted">
                    Menampilkan {{ $kehadiran->firstItem() ?? 0 }} - {{ $kehadiran->lastItem() ?? 0 }} dari {{ $kehadiran->total() }} data
                </div>
                <div>
                    {{ $kehadiran->appends(request()->query())->links() }}
                </div>
            </div>
            @endif

        </div>
    </div>
</div>


<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="{{ route('pembina.kehadiran.store') }}" class="modal-content border-0 shadow-lg" enctype="multipart/form-data">
            @csrf

            <div class="modal-header text-white" style="background: #0d6efd; border-bottom: none;">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-plus-circle me-2"></i>Tambah Kehadiran
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body p-4">

                <div class="mb-4">
                    <label class="form-label fw-semibold text-dark mb-2">
                        <i class="bi bi-person text-primary me-2"></i>Nama Anggota
                        <span class="text-danger">*</span>
                    </label>
                    <select name="anggota_ekskul_id" class="form-select" style="height: 45px;" required>
                        <option value="">-- Pilih Anggota --</option>
                        @foreach($anggota as $a)
                        <option value="{{ $a->id }}">{{ $a->user->name ?? $a->nama_anggota }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold text-dark mb-2">
                        <i class="bi bi-calendar-event text-primary me-2"></i>Kegiatan
                        <span class="text-danger">*</span>
                    </label>
                    <select name="kegiatan_id" class="form-select" style="height: 45px;" required>
                        <option value="">-- Pilih Kegiatan --</option>
                        @foreach($kegiatan as $kg)
                        <option value="{{ $kg->id }}">{{ $kg->nama_kegiatan }} - {{ \Carbon\Carbon::parse($kg->tanggal)->format('d/m/Y') }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold text-dark mb-2">
                        <i class="bi bi-calendar text-primary me-2"></i>Tanggal
                        <span class="text-danger">*</span>
                    </label>
                    <input type="date" name="tanggal" class="form-control" style="height: 45px;" required value="{{ date('Y-m-d') }}">
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold text-dark mb-2">
                        <i class="bi bi-check-square text-primary me-2"></i>Status
                        <span class="text-danger">*</span>
                    </label>
                    <select name="status" class="form-select" style="height: 45px;" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="hadir">Hadir</option>
                        <option value="izin">Izin</option>
                        <option value="sakit">Sakit</option>
                        <option value="alpha">Alpha</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-dark mb-2">
                        <i class="bi bi-image text-primary me-2"></i>Bukti Kehadiran
                        <span class="text-muted small">(opsional)</span>
                    </label>
                    <input type="file" name="bukti_kehadiran" class="form-control" accept="image/*">
                    <small class="text-muted">Format: JPG, PNG, maksimal 2MB</small>
                </div>

            </div>

            <div class="modal-footer border-0" style="background-color: #f8f9fc; padding: 1.25rem 1.5rem;">
                <button type="button" class="btn btn-secondary px-4 py-2" data-bs-dismiss="modal" style="font-weight: 500;">
                    <i class="bi bi-x-circle me-1"></i>Batal
                </button>
                <button type="submit" class="btn btn-tambah px-4 py-2" style="font-weight: 500;">
                    <i class="bi bi-check-circle me-1"></i>Simpan
                </button>
            </div>

        </form>
    </div>
</div>

<!-- SweetAlert2 CSS & JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// Fungsi untuk konfirmasi hapus dengan SweetAlert2
function confirmDelete(id) {
    Swal.fire({
        title: 'Hapus Data?',
        text: "Data kehadiran ini akan dihapus permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="bi bi-trash me-1"></i> Ya, Hapus!',
        cancelButtonText: '<i class="bi bi-x-circle me-1"></i> Batal',
        reverseButtons: true,
        customClass: {
            confirmButton: 'btn btn-danger px-4',
            cancelButton: 'btn btn-secondary px-4'
        },
        buttonsStyling: false
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}

// Tampilkan pesan sukses jika ada
@if(session('success'))
Swal.fire({
    icon: 'success',
    title: 'Berhasil!',
    text: '{{ session("success") }}',
    showConfirmButton: false,
    timer: 2000,
    timerProgressBar: true
});
@endif

// Tampilkan pesan error jika ada
@if(session('error'))
Swal.fire({
    icon: 'error',
    title: 'Gagal!',
    text: '{{ session("error") }}',
    showConfirmButton: true,
    confirmButtonColor: '#dc3545'
});
@endif
</script>

<style>
    .table>tbody>tr:hover {
        background-color: #f8f9fc;
        transition: all 0.2s ease;
    }

    /* Tombol Tambah Kehadiran - Warna Biru Bootstrap Primary */
    .btn-tambah {
        background-color: #0d6efd;
        border: none;
        color: white;
        transition: all 0.3s ease;
    }

    .btn-tambah:hover {
        background-color: #0b5ed7;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(13, 110, 253, 0.4);
    }

    .btn-primary {
        background-color: #0d6efd;
        border: none;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #0b5ed7;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
    }

    .btn-secondary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(108, 117, 125, 0.3);
    }

    /* Button Info - Warna Biru */
    .btn-info {
        background-color: #0d6efd !important;
        border: none;
        transition: all 0.3s ease;
    }

    .btn-info:hover {
        background-color: #0b5ed7 !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.4);
    }

    /* Button Warning - Warna Kuning */
    .btn-warning {
        background-color: #ffc107 !important;
        border: none;
        transition: all 0.3s ease;
    }

    .btn-warning:hover {
        background-color: #ffca2c !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255, 193, 7, 0.4);
    }

    /* Button Danger - Warna Merah */
    .btn-danger {
        background-color: #dc3545 !important;
        border: none;
        transition: all 0.3s ease;
    }

    .btn-danger:hover {
        background-color: #bb2d3b !important;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(220, 53, 69, 0.4);
    }

    .btn-group .btn {
        margin: 0 2px;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }

    .card {
        transition: all 0.3s ease;
    }

    .badge {
        font-weight: 500;
        letter-spacing: 0.3px;
    }

    .modal-content {
        border-radius: 0.5rem;
        overflow: hidden;
    }

    .alert-info {
        background-color: #e7f3ff;
        border-color: #b8daff;
        color: #004085;
    }

    .detail-item {
        padding: 15px;
        background-color: #f8f9fa;
        border-radius: 8px;
        border-left: 4px solid #0d6efd;
    }

    .detail-item label {
        font-weight: 600;
        color: #6c757d;
        display: block;
        margin-bottom: 5px;
    }

    .detail-item p {
        color: #2c3e50;
        font-size: 1rem;
    }

    .modal-lg {
        max-width: 800px;
    }

    .img-thumbnail {
        border: 2px solid #dee2e6;
        border-radius: 8px;
        padding: 5px;
    }

    /* Animation for modals */
    .modal.fade .modal-dialog {
        transition: transform 0.3s ease-out;
    }

    .modal.show .modal-dialog {
        transform: none;
    }

    /* Card styling untuk form edit */
    .modal-body .card {
        background-color: white;
        transition: all 0.3s ease;
        border: 1px solid #e3e6f0;
    }

    .modal-body .card .card-body {
        padding: 1rem;
    }

    /* SweetAlert2 custom styling */
    .swal2-popup {
        border-radius: 12px;
        font-family: inherit;
    }

    .swal2-title {
        font-weight: 600;
    }

    .swal2-styled.btn {
        padding: 10px 24px;
        font-weight: 500;
        border-radius: 6px;
    }
</style>

@endsection
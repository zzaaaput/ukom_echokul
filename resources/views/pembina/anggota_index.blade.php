@extends('layouts.template')

@section('title', 'Anggota Ekstrakurikuler')

@section('content')
<div class="container-fluid bg-light min-vh-100 py-5">
    <div class="container">

        <!-- Header Section -->
        <div class="bg-white rounded-4 shadow-sm p-4 mb-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                <div>
                    <h2 class="fw-bold mb-2">Anggota Ekstrakurikuler</h2>
                    <p class="text-muted mb-0">
                        <i class="bi bi-people-fill me-2"></i>
                        Total <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2">{{ $anggota->count() }} anggota</span>
                    </p>
                </div>
                
                @if(Auth::check() && Auth::user()->role === 'pembina')
                    <button class="btn btn-primary btn-lg px-4" data-bs-toggle="modal" data-bs-target="#modalTambah">
                        <i class="bi bi-plus-circle me-2"></i>Tambah Anggota
                    </button>
                @endif
            </div>
        </div>

        <!-- Filter & Search Section -->
        <div class="bg-white rounded-4 shadow-sm p-4 mb-4">
            <div class="row g-3">
                <!-- Items Per Page -->
                <div class="col-md-2">
                    <form method="GET" action="{{ route('anggota.index') }}">
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
                <div class="col-md-7">
                    <form method="GET" action="{{ route('anggota.index') }}">
                        <input type="hidden" name="per_page" value="{{ request('per_page', 10) }}">
                        <label for="search" class="form-label fw-semibold small">
                            <i class="bi bi-search text-primary me-1"></i>Pencarian
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-white">
                                <i class="bi bi-search text-muted"></i>
                            </span>
                            <input type="text" name="search" id="search" class="form-control" placeholder="Cari nama atau jabatan..." value="{{ request('search') }}" onchange="this.form.submit()">
                        </div>
                    </form>
                </div>

                <!-- Filter Ekstrakurikuler -->
                <div class="col-md-3">
                    <form method="GET" action="{{ route('anggota.index') }}">
                        <input type="hidden" name="per_page" value="{{ request('per_page', 10) }}">
                        <input type="hidden" name="search" value="{{ request('search') }}">
                        <label for="ekstrakurikuler_id" class="form-label fw-semibold small">
                            <i class="bi bi-filter text-primary me-1"></i>Filter Ekstrakurikuler
                        </label>
                        <select name="ekstrakurikuler_id" id="ekstrakurikuler_id" class="form-select" onchange="this.form.submit()">
                            <option value="">-- Semua Ekstrakurikuler --</option>
                            @foreach($ekstrakurikulerList as $eks)
                                <option value="{{ $eks->id }}" {{ request('ekstrakurikuler_id') == $eks->id ? 'selected' : '' }}>
                                    {{ $eks->nama_ekstrakurikuler }}
                                </option>
                            @endforeach
                        </select>
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
                            <th class="py-3 fw-semibold text-primary">Nama Anggota</th>
                            <th class="py-3 fw-semibold text-primary">User</th>
                            <th class="py-3 fw-semibold text-primary">Ekstrakurikuler</th>
                            <th class="py-3 fw-semibold text-primary">Jabatan</th>
                            <th class="py-3 fw-semibold text-primary">Tahun Ajaran</th>
                            <th class="py-3 fw-semibold text-primary">Status</th>
                            <th class="text-center py-3 fw-semibold text-primary">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($anggota as $index => $item)
                        <tr>
                            <td class="ps-4 fw-semibold">{{ $loop->iteration }}</td>
                            <td class="fw-bold">{{ $item->nama_anggota }}</td>
                            <td>{{ $item->user->id ?? '-' }}</td>
                            <td>{{ $item->ekstrakurikuler->nama_ekstrakurikuler ?? '-' }}</td>
                            <td>
                                <span class="badge bg-info bg-opacity-10 text-info px-3 py-2">
                                    {{ ucfirst($item->jabatan) }}
                                </span>
                            </td>
                            <td>{{ $item->tahun_ajaran }}</td>
                            <td>
                                <span class="badge bg-{{ $item->status_anggota === 'aktif' ? 'success' : 'secondary' }} px-3 py-2">
                                    <i class="bi bi-{{ $item->status_anggota === 'aktif' ? 'check-circle-fill' : 'dash-circle-fill' }} me-1"></i>
                                    {{ ucfirst($item->status_anggota) }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex flex-wrap justify-content-center gap-2">
                                    <button class="btn btn-sm btn-primary"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalDetail{{ $item->id }}">
                                        <i class="bi bi-eye me-1"></i> Detail
                                    </button>

                                    @if(Auth::check() && Auth::user()->role === 'pembina')
                                        <button class="btn btn-sm btn-warning"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalEdit{{ $item->id }}">
                                            <i class="bi bi-pencil-square me-1"></i> Edit
                                        </button>

                                        <button class="btn btn-sm btn-danger"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalHapus{{ $item->id }}">
                                            <i class="bi bi-trash me-1"></i> Hapus
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>

                        {{-- ==================== MODAL DETAIL ==================== --}}
                        <div class="modal fade" id="modalDetail{{ $item->id }}" tabindex="-1">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content border-0 shadow-lg rounded-4">
                                    <div class="modal-header bg-primary text-white border-0 p-4">
                                        <div>
                                            <h5 class="modal-title fw-bold mb-1">Detail Anggota</h5>
                                            <small class="opacity-75">Informasi lengkap anggota ekstrakurikuler</small>
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
                                                                <i class="bi bi-person-fill text-primary me-1"></i> Nama Anggota
                                                            </label>
                                                            <p class="fw-bold mb-0">{{ $item->nama_anggota }}</p>
                                                        </div>

                                                        <div class="col-6">
                                                            <label class="text-muted small fw-semibold mb-2 d-block">
                                                                <i class="bi bi-person-badge text-primary me-1"></i> User ID
                                                            </label>
                                                            <p class="mb-0">{{ $item->user->id ?? '-' }}</p>
                                                        </div>

                                                        <div class="col-6">
                                                            <label class="text-muted small fw-semibold mb-2 d-block">
                                                                <i class="bi bi-trophy text-primary me-1"></i> Ekstrakurikuler
                                                            </label>
                                                            <p class="mb-0">{{ $item->ekstrakurikuler->nama_ekstrakurikuler ?? '-' }}</p>
                                                        </div>

                                                        <div class="col-6">
                                                            <label class="text-muted small fw-semibold mb-2 d-block">
                                                                <i class="bi bi-star-fill text-primary me-1"></i> Jabatan
                                                            </label>
                                                            <span class="badge bg-info bg-opacity-10 text-info px-3 py-2">
                                                                {{ ucfirst($item->jabatan) }}
                                                            </span>
                                                        </div>

                                                        <div class="col-6">
                                                            <label class="text-muted small fw-semibold mb-2 d-block">
                                                                <i class="bi bi-calendar-event text-primary me-1"></i> Tahun Ajaran
                                                            </label>
                                                            <p class="mb-0">{{ $item->tahun_ajaran }}</p>
                                                        </div>

                                                        <div class="col-6">
                                                            <label class="text-muted small fw-semibold mb-2 d-block">
                                                                <i class="bi bi-flag-fill text-primary me-1"></i> Status
                                                            </label>
                                                            <span class="badge bg-{{ $item->status_anggota === 'aktif' ? 'success' : 'secondary' }} px-3 py-2">
                                                                {{ ucfirst($item->status_anggota) }}
                                                            </span>
                                                        </div>

                                                        <div class="col-6">
                                                            <label class="text-muted small fw-semibold mb-2 d-block">
                                                                <i class="bi bi-calendar-check text-primary me-1"></i> Tanggal Gabung
                                                            </label>
                                                            <p class="mb-0">{{ $item->tanggal_gabung }}</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="border-top pt-3">
                                                    <small class="text-muted d-block mb-1">
                                                        <i class="bi bi-clock-history me-1"></i>
                                                        <strong>Dibuat:</strong> {{ $item->created_at?->format('d M Y, H:i') }}
                                                    </small>
                                                    <small class="text-muted d-block">
                                                        <i class="bi bi-arrow-repeat me-1"></i>
                                                        <strong>Diperbarui:</strong> {{ $item->updated_at?->format('d M Y, H:i') }}
                                                    </small>
                                                </div>
                                            </div>

                                            <div class="col-md-4 text-center">
                                                <label class="text-muted small fw-semibold mb-3 d-block">
                                                    <i class="bi bi-image text-primary me-1"></i> Foto Anggota
                                                </label>
                                                @if($item->foto && file_exists(public_path($item->foto)))
                                                    <img src="{{ asset($item->foto) }}"
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

                        @if(Auth::check() && Auth::user()->role === 'pembina')
                            {{-- ==================== MODAL EDIT ==================== --}}
                            <div class="modal fade" id="modalEdit{{ $item->id }}" tabindex="-1">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content border-0 shadow-lg rounded-4">
                                        <div class="modal-header bg-warning text-white border-0 p-4">
                                            <div>
                                                <h5 class="modal-title fw-bold mb-1">Edit Anggota</h5>
                                                <small class="opacity-75">Perbarui informasi anggota</small>
                                            </div>
                                            <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>

                                        <form action="{{ route('pembina.anggota.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf @method('PUT')

                                            <div class="modal-body p-4">
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-semibold">
                                                            <i class="bi bi-person-check text-warning me-1"></i> User
                                                        </label>
                                                        <select name="user_id" class="form-select" required>
                                                            @foreach($users as $u)
                                                                <option value="{{ $u->id }}" {{ $u->id == $item->user_id ? 'selected' : '' }}>
                                                                    {{ $u->nama_lengkap }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="form-label fw-semibold">
                                                            <i class="bi bi-trophy text-warning me-1"></i> Ekstrakurikuler
                                                        </label>
                                                        <input type="text" class="form-control" value="{{ $pembinaEkskul->nama_ekstrakurikuler }}" readonly>
                                                        <input type="hidden" name="ekstrakurikuler_id" value="{{ $pembinaEkskul->id }}">
                                                    </div>

                                                    <div class="col-12">
                                                        <label class="form-label fw-semibold">
                                                            <i class="bi bi-person-fill text-warning me-1"></i> Nama Anggota
                                                        </label>
                                                        <input type="text" name="nama_anggota" class="form-control" value="{{ $item->nama_anggota }}" required>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label class="form-label fw-semibold">
                                                            <i class="bi bi-star text-warning me-1"></i> Jabatan
                                                        </label>
                                                        <select name="jabatan" class="form-select" required>
                                                            <option value="anggota" {{ $item->jabatan == 'anggota' ? 'selected' : '' }}>Anggota</option>
                                                            <option value="pengurus" {{ $item->jabatan == 'pengurus' ? 'selected' : '' }}>Pengurus</option>
                                                            <option value="ketua" {{ $item->jabatan == 'ketua' ? 'selected' : '' }}>Ketua</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label class="form-label fw-semibold">
                                                            <i class="bi bi-calendar-event text-warning me-1"></i> Tahun Ajaran
                                                        </label>
                                                        <input type="number" name="tahun_ajaran" class="form-control" value="{{ $item->tahun_ajaran }}" required>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label class="form-label fw-semibold">
                                                            <i class="bi bi-flag text-warning me-1"></i> Status
                                                        </label>
                                                        <select name="status_anggota" class="form-select" required>
                                                            <option value="aktif" {{ $item->status_anggota == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                                            <option value="tidak aktif" {{ $item->status_anggota == 'tidak aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-12">
                                                        <label class="form-label fw-semibold">
                                                            <i class="bi bi-image text-warning me-1"></i> Foto Saat Ini
                                                        </label>
                                                        <div class="text-center bg-light rounded-3 p-3 mb-3">
                                                            @if($item->foto && file_exists(public_path($item->foto)))
                                                                <img src="{{ asset($item->foto) }}" class="img-thumbnail shadow-sm rounded-3" style="max-width: 180px; height:180px; object-fit:cover;">
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
                            <div class="modal fade" id="modalHapus{{ $item->id }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow-lg rounded-4">
                                        <div class="modal-header bg-danger text-white border-0 p-4">
                                            <div>
                                                <h5 class="modal-title fw-bold mb-1">Hapus Anggota</h5>
                                                <small class="opacity-75">Konfirmasi penghapusan data</small>
                                            </div>
                                            <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>

                                        <form action="{{ route('pembina.anggota.destroy', $item->id) }}" method="POST">
                                            @csrf @method('DELETE')

                                            <div class="modal-body text-center p-5">
                                                <div class="bg-danger bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                                    <i class="bi bi-exclamation-triangle-fill text-danger" style="font-size: 2.5rem;"></i>
                                                </div>
                                                <h5 class="fw-bold mb-2">Apakah Anda yakin?</h5>
                                                <p class="text-muted mb-0">
                                                    Data anggota <strong class="text-dark">{{ $item->nama_anggota }}</strong> akan dihapus permanen dan tidak dapat dikembalikan.
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
                            <td colspan="8" class="text-center py-5">
                                <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                    <i class="bi bi-inbox text-muted" style="font-size: 2.5rem;"></i>
                                </div>
                                <h6 class="fw-bold mb-2">Belum Ada Anggota</h6>
                                <p class="text-muted mb-0">Tidak ada data anggota yang tersedia saat ini</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($anggota->hasPages())
            <div class="p-4 border-top">
                <div class="d-flex justify-content-center">
                    {{ $anggota->links() }}
                </div>
            </div>
            @endif
        </div>

    </div>
</div>

@if(Auth::check() && Auth::user()->role === 'pembina')
    {{-- ==================== MODAL TAMBAH ANGGOTA ==================== --}}
    <div class="modal fade" id="modalTambah" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                
                <div class="modal-header bg-primary text-white border-0 p-4">
                    <div>
                        <h5 class="modal-title fw-bold mb-1">Tambah Anggota</h5>
                        <small class="opacity-75">Tambahkan anggota baru ke ekstrakurikuler</small>
                    </div>
                    <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
    
                <form action="{{ route('pembina.anggota.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
    
                    <div class="modal-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-person-check text-primary me-1"></i> User
                                </label>
                                <select name="user_id" class="form-select" required>
                                    <option value="">-- Pilih User --</option>
                                    @foreach($users as $u)
                                        <option value="{{ $u->id }}">{{ $u->nama_lengkap }}</option>
                                    @endforeach
                                </select>
                            </div>
    
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-trophy text-primary me-1"></i> Ekstrakurikuler
                                </label>
                                <input type="text" class="form-control" value="{{ $pembinaEkskul->nama_ekstrakurikuler }}" readonly>
                                <input type="hidden" name="ekstrakurikuler_id" value="{{ $pembinaEkskul->id }}">
                            </div>
    
                            <div class="col-12">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-person-fill text-primary me-1"></i> Nama Anggota
                                </label>
                                <input type="text" name="nama_anggota" class="form-control" placeholder="Masukkan nama anggota" required>
                            </div>
    
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-star text-primary me-1"></i> Jabatan
                                </label>
                                <select name="jabatan" class="form-select" required>
                                    <option value="anggota">Anggota</option>
                                    <option value="pengurus">Pengurus</option>
                                    <option value="ketua">Ketua</option>
                                </select>
                            </div>
    
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-calendar-event text-primary me-1"></i> Tahun Ajaran
                                </label>
                                <input type="number" name="tahun_ajaran" class="form-control" placeholder="2024" required>
                            </div>
    
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-flag text-primary me-1"></i> Status
                                </label>
                                <select name="status_anggota" class="form-select" required>
                                    <option value="aktif">Aktif</option>
                                    <option value="tidak aktif">Tidak Aktif</option>
                                </select>
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

@endsection
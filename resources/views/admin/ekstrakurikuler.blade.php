@extends('layouts.template')
@section('title', 'Ekstrakurikuler')

@section('content')
  @if(Auth::check() && Auth::user()->role === 'admin')
    <div class="container-fluid bg-light min-vh-100 py-5">
        <div class="container">

            <!-- Header Section -->
            <div class="bg-white rounded-4 shadow-sm p-4 mb-4">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                    <div>
                        <h2 class="fw-bold mb-2">Daftar Ekstrakurikuler</h2>
                        <p class="text-muted mb-0">
                            <i class="bi bi-trophy-fill me-2"></i>
                            Kelola semua data ekstrakurikuler
                        </p>
                    </div>
                    
                    <button class="btn btn-primary btn-lg px-4"
                            data-bs-toggle="modal" 
                            data-bs-target="#modalTambah">
                        <i class="bi bi-plus-circle me-2"></i>Tambah Ekstrakurikuler
                    </button>
                </div>
            </div>

            <!-- Search Section -->
            <div class="bg-white rounded-4 shadow-sm p-4 mb-4">
                <form method="GET" action="{{ route('ekstrakurikuler.index') }}">
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
                              placeholder="Cari ekstrakurikuler..."
                              value="{{ request('search') }}"
                              onchange="this.form.submit()">
                        @if(request('sort'))
                            <input type="hidden" name="sort" value="{{ request('sort') }}">
                            <input type="hidden" name="direction" value="{{ request('direction') }}">
                        @endif
                        @if(request('search'))
                            <a href="{{ route('ekstrakurikuler.index') }}" class="btn btn-outline-secondary">
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
                                <th class="py-3 fw-semibold text-primary">Nama Ekstrakurikuler</th>
                                <th class="py-3 fw-semibold text-primary">Pembina</th>
                                <th class="py-3 fw-semibold text-primary">Ketua</th>
                                <th class="py-3 fw-semibold text-primary">Deskripsi</th>
                                <th class="text-center py-3 fw-semibold text-primary">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ekstrakurikuler as $index => $item)
                            <tr>
                                <td class="ps-4 fw-semibold">{{ $index + 1 }}</td>
                                <td class="fw-bold">{{ $item->nama_ekstrakurikuler }}</td>
                                <td>{{ $item->pembina->nama_lengkap ?? '-' }}</td>
                                <td>{{ $item->ketua->nama_lengkap ?? '-' }}</td>
                                <td class="text-muted">{{ Str::limit($item->deskripsi, 50) }}</td>
                                <td class="text-center">
                                    <div class="d-flex flex-wrap justify-content-center gap-2">
                                        <button class="btn btn-sm btn-primary"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalDetail{{ $item->id }}">
                                            <i class="bi bi-eye me-1"></i> Detail
                                        </button>
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
                                    </div>
                                </td>
                            </tr>

                            {{-- ==================== MODAL DETAIL ==================== --}}
                            <div class="modal fade" id="modalDetail{{ $item->id }}" tabindex="-1">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content border-0 shadow-lg rounded-4">
                                        <div class="modal-header bg-primary text-white border-0 p-4">
                                            <div>
                                                <h5 class="modal-title fw-bold mb-1">Detail Ekstrakurikuler</h5>
                                                <small class="opacity-75">Informasi lengkap ekstrakurikuler</small>
                                            </div>
                                            <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body p-4">
                                            <div class="row g-4">
                                                <div class="col-md-7">
                                                    <div class="bg-light rounded-3 p-4">
                                                        <div class="mb-3">
                                                            <label class="text-muted small fw-semibold mb-2 d-block">
                                                                <i class="bi bi-trophy-fill text-primary me-1"></i> Nama Ekstrakurikuler
                                                            </label>
                                                            <p class="fw-bold mb-0">{{ $item->nama_ekstrakurikuler }}</p>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="text-muted small fw-semibold mb-2 d-block">
                                                                <i class="bi bi-person-badge-fill text-primary me-1"></i> Pembina
                                                            </label>
                                                            <p class="mb-0">{{ $item->pembina->nama_lengkap ?? '-' }}</p>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="text-muted small fw-semibold mb-2 d-block">
                                                                <i class="bi bi-star-fill text-primary me-1"></i> Ketua
                                                            </label>
                                                            <p class="mb-0">{{ $item->ketua->nama_lengkap ?? '-' }}</p>
                                                        </div>

                                                        <div>
                                                            <label class="text-muted small fw-semibold mb-2 d-block">
                                                                <i class="bi bi-card-text text-primary me-1"></i> Deskripsi
                                                            </label>
                                                            <p class="mb-0">{{ $item->deskripsi ?? '-' }}</p>
                                                        </div>
                                                    </div>

                                                    <div class="border-top pt-3 mt-3">
                                                        <small class="text-muted d-block mb-1">
                                                            <i class="bi bi-clock-history me-1"></i>
                                                            <strong>Dibuat:</strong> {{ $item->created_at?->format('d M Y, H:i') ?? '-' }}
                                                        </small>
                                                        <small class="text-muted d-block">
                                                            <i class="bi bi-arrow-repeat me-1"></i>
                                                            <strong>Diperbarui:</strong> {{ $item->updated_at?->format('d M Y, H:i') ?? '-' }}
                                                        </small>
                                                    </div>
                                                </div>

                                                <div class="col-md-5 text-center">
                                                    <label class="text-muted small fw-semibold mb-3 d-block">
                                                        <i class="bi bi-image text-primary me-1"></i> Foto Ekstrakurikuler
                                                    </label>
                                                    @if($item->foto && file_exists(public_path($item->foto)))
                                                        <img src="{{ asset($item->foto) }}" 
                                                            class="img-fluid rounded-4 shadow border border-3 border-primary" 
                                                            style="max-width: 250px; object-fit: cover;">
                                                    @else
                                                        <div class="bg-light rounded-4 d-flex align-items-center justify-content-center" style="height: 250px;">
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
                            <div class="modal fade" id="modalEdit{{ $item->id }}" tabindex="-1">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content border-0 shadow-lg rounded-4">
                                        <div class="modal-header bg-warning text-white border-0 p-4">
                                            <div>
                                                <h5 class="modal-title fw-bold mb-1">Edit Ekstrakurikuler</h5>
                                                <small class="opacity-75">Perbarui informasi ekstrakurikuler</small>
                                            </div>
                                            <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>

                                        <form action="{{ route('admin.ekstrakurikuler.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            
                                            <div class="modal-body p-4">
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-semibold">
                                                            <i class="bi bi-person-badge text-warning me-1"></i> Pembina
                                                        </label>
                                                        <select name="user_pembina_id" class="form-select" required>
                                                            <option value="">-- Pilih Pembina --</option>
                                                            @foreach($pembina as $p)
                                                                <option value="{{ $p->id }}" {{ $p->id == $item->user_pembina_id ? 'selected' : '' }}>
                                                                    {{ $p->nama_lengkap }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="form-label fw-semibold">
                                                            <i class="bi bi-star text-warning me-1"></i> Ketua
                                                        </label>
                                                        <select name="user_ketua_id" class="form-select">
                                                            <option value="">-- Pilih Ketua --</option>
                                                            @foreach($ketua as $k)
                                                                <option value="{{ $k->id }}" {{ $k->id == $item->user_ketua_id ? 'selected' : '' }}>
                                                                    {{ $k->nama_lengkap }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-12">
                                                        <label class="form-label fw-semibold">
                                                            <i class="bi bi-trophy text-warning me-1"></i> Nama Ekstrakurikuler
                                                        </label>
                                                        <input type="text" name="nama_ekstrakurikuler" class="form-control" value="{{ $item->nama_ekstrakurikuler }}" required>
                                                    </div>

                                                    <div class="col-12">
                                                        <label class="form-label fw-semibold">
                                                            <i class="bi bi-card-text text-warning me-1"></i> Deskripsi
                                                        </label>
                                                        <textarea name="deskripsi" class="form-control" rows="3">{{ $item->deskripsi }}</textarea>
                                                    </div>

                                                    <div class="col-12">
                                                        <label class="form-label fw-semibold">
                                                            <i class="bi bi-door-open text-warning me-1"></i> Status Pendaftaran
                                                        </label>
                                                        <select name="pendaftaran_dibuka" class="form-select">
                                                            <option value="0" {{ $item->pendaftaran_dibuka == 0 ? 'selected' : '' }}>Tutup</option>
                                                            <option value="1" {{ $item->pendaftaran_dibuka == 1 ? 'selected' : '' }}>Buka</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-12">
                                                        <label class="form-label fw-semibold">
                                                            <i class="bi bi-image text-warning me-1"></i> Foto Saat Ini
                                                        </label>
                                                        <div class="text-center bg-light rounded-3 p-3 mb-3">
                                                            @if($item->foto && file_exists(public_path($item->foto)))
                                                                <img src="{{ asset($item->foto) }}" 
                                                                    class="img-thumbnail shadow-sm rounded-3"
                                                                    style="max-width: 180px; height: 180px; object-fit: cover;">
                                                            @else
                                                                <p class="text-muted mb-0">Belum ada foto</p>
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
                                                <h5 class="modal-title fw-bold mb-1">Hapus Ekstrakurikuler</h5>
                                                <small class="opacity-75">Konfirmasi penghapusan data</small>
                                            </div>
                                            <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>

                                        <form action="{{ route('admin.ekstrakurikuler.destroy', $item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            
                                            <div class="modal-body text-center p-5">
                                                <h5 class="fw-bold mb-2">Apakah Anda yakin?</h5>
                                                <p class="text-muted mb-0">
                                                    Ekstrakurikuler <strong class="text-dark">{{ $item->nama_ekstrakurikuler }}</strong> akan dihapus permanen dan tidak dapat dikembalikan.
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
                                <td colspan="6" class="text-center py-5">
                                    <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                        <i class="bi bi-inbox text-muted" style="font-size: 2.5rem;"></i>
                                    </div>
                                    <h6 class="fw-bold mb-2">Belum Ada Data</h6>
                                    <p class="text-muted mb-0">Tidak ada data ekstrakurikuler yang tersedia saat ini</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($ekstrakurikuler->hasPages())
                <div class="p-4 border-top">
                    <div class="d-flex justify-content-center">
                        {{ $ekstrakurikuler->links() }}
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
                        <h5 class="modal-title fw-bold mb-1">Tambah Ekstrakurikuler</h5>
                        <small class="opacity-75">Tambahkan ekstrakurikuler baru</small>
                    </div>
                    <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ route('admin.ekstrakurikuler.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="modal-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-person-badge text-primary me-1"></i> Pembina
                                </label>
                                <select name="user_pembina_id" class="form-select" required>
                                    <option value="">-- Pilih Pembina --</option>
                                    @foreach($pembina as $p)
                                        <option value="{{ $p->id }}">{{ $p->nama_lengkap }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-star text-primary me-1"></i> Ketua
                                </label>
                                <select name="user_ketua_id" class="form-select">
                                    <option value="">-- Pilih Ketua --</option>
                                    @foreach($ketua as $k)
                                        <option value="{{ $k->id }}">{{ $k->nama_lengkap }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-trophy text-primary me-1"></i> Nama Ekstrakurikuler
                                </label>
                                <input type="text" name="nama_ekstrakurikuler" class="form-control" placeholder="Masukkan nama ekstrakurikuler" required>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-card-text text-primary me-1"></i> Deskripsi
                                </label>
                                <textarea name="deskripsi" class="form-control" rows="3" placeholder="Masukkan deskripsi ekstrakurikuler"></textarea>
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

        <div class="row mb-4">
            <div class="col-lg-8 mx-auto">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <form method="GET" action="{{ route('ekstrakurikuler.index') }}" id="filterForm">
                            <div class="row g-3">
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <span class="input-group-text bg-white border-end-0">
                                            <i class="bi bi-search text-muted"></i>
                                        </span>
                                        <input type="text" name="search" class="form-control border-start-0"
                                            placeholder="Cari nama ekstrakurikuler, pembina, atau ketua..."
                                            value="{{ request('search') }}">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <select name="sort" class="form-select" onchange="document.getElementById('filterForm').submit()">
                                        <option value="">Urutkan</option>
                                        <option value="nama_asc" {{ request('sort')=='nama_asc'?'selected':'' }}>Nama A-Z</option>
                                        <option value="nama_desc" {{ request('sort')=='nama_desc'?'selected':'' }}>Nama Z-A</option>
                                        <option value="terbaru" {{ request('sort')=='terbaru'?'selected':'' }}>Terbaru</option>
                                        <option value="terlama" {{ request('sort')=='terlama'?'selected':'' }}>Terlama</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mt-3 d-flex flex-wrap gap-2">
                                <span class="text-muted small">Cepat:</span>

                                <a href="{{ route('ekstrakurikuler.index') }}" class="badge bg-secondary text-decoration-none py-2 px-3">
                                    <i class="bi bi-arrow-clockwise me-1"></i>Reset Filter
                                </a>

                                <button type="submit" class="badge bg-primary border-0 py-2 px-3">
                                    <i class="bi bi-funnel me-1"></i>Terapkan Filter
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-5 g-4">
            <div class="col-md-4">
                <div class="card-body text-center p-4">
                    <h3 class="fw-bold text-primary">{{ $ekstrakurikuler->total() }}</h3>
                    <p class="text-muted mb-0">Total Ekstrakurikuler</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card-body text-center p-4">
                    <h3 class="fw-bold text-success">{{ $totalPembina }}</h3>
                    <p class="text-muted mb-0">Pembina Aktif</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card-body text-center p-4">
                    <h3 class="fw-bold text-warning">{{ $totalKetua }}</h3>
                    <p class="text-muted mb-0">Ketua Terpilih</p>
                </div>
            </div>
        </div>

        <div class="row g-4">

            @forelse($ekstrakurikuler as $item)
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm h-100 hover-card">

                    <div class="position-relative overflow-hidden" style="height: 220px;">
                        @if($item->foto && file_exists(public_path($item->foto)))
                            <img src="{{ asset($item->foto) }}" class="card-img-top w-100 h-100" style="object-fit: cover;">
                        @else
                            <div class="w-100 h-100 bg-gradient d-flex align-items-center justify-content-center">
                                <i class="bi bi-mortarboard text-white" style="font-size: 4rem; opacity: 0.3;"></i>
                            </div>
                        @endif

                        @auth
                            @if(auth()->user()->role === 'siswa')
                            <button class="btn btn-primary position-absolute top-0 end-0 m-3"
                                data-bs-toggle="modal" data-bs-target="#modalDaftar{{ $item->id }}">
                                Daftar
                            </button>
                            @endif
                        @endauth
                    </div>

                    <div class="card-body d-flex flex-column">

                        <h5 class="card-title fw-bold mb-3">{{ $item->nama_ekstrakurikuler }}</h5>

                        <div class="mb-3 flex-grow-1">
                            <div class="d-flex text-muted mb-2">
                                <i class="bi bi-person-badge text-primary me-2"></i>
                                <small><strong>Pembina:</strong><br> {{ $item->pembina->nama_lengkap ?? 'Belum ditentukan' }}</small>
                            </div>

                            <div class="d-flex text-muted mb-2">
                                <i class="bi bi-person-check text-success me-2"></i>
                                <small><strong>Ketua:</strong><br> {{ $item->ketua->nama_lengkap ?? 'Belum ditentukan' }}</small>
                            </div>

                            <div class="d-flex text-muted">
                                <i class="bi bi-card-text text-info me-2"></i>
                                <small>{{ Str::limit($item->deskripsi, 80) ?? 'Tidak ada deskripsi' }}</small>
                            </div>
                        </div>

                        <button class="btn btn-primary w-100" data-bs-toggle="modal"
                            data-bs-target="#modalDetailInfo{{ $item->id }}">
                            <i class="bi bi-eye me-2"></i>Lihat Detail
                        </button>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalDetailInfo{{ $item->id }}" tabindex="-1">
                <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content border-0 shadow-lg">

                        <!-- HEADER FOTO -->
                        <div class="position-relative" style="height:250px;overflow:hidden;">
                            @if($item->foto && file_exists(public_path($item->foto)))
                                <img src="{{ asset($item->foto) }}" 
                                    class="w-100 h-100" style="object-fit:cover;filter:brightness(.7);">
                            @else
                                <div class="w-100 h-100 bg-primary bg-gradient"></div>
                            @endif

                            <div class="position-absolute bottom-0 p-4 w-100"
                                style="background:linear-gradient(to top,rgba(0,0,0,.8),transparent)">
                                <h3 class="text-white fw-bold mb-0">{{ $item->nama_ekstrakurikuler }}</h3>
                            </div>
                        </div>

                        <div class="modal-body p-4">

                            <!-- INFO CARDS -->
                            <div class="row g-3 mb-4">

                                <!-- Pembina -->
                                <div class="col-md-6">
                                    <div class="card bg-light border-0">
                                        <div class="card-body d-flex align-items-center p-3">
                                            <div class="bg-primary bg-opacity-10 p-3 me-3 rounded">
                                                <i class="bi bi-person-badge text-primary fs-4"></i>
                                            </div>
                                            <div>
                                                <small class="text-muted">Pembina</small>
                                                <div class="fw-bold">
                                                    {{ $item->pembina->nama_lengkap ?? 'Belum ditentukan' }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Ketua -->
                                <div class="col-md-6">
                                    <div class="card bg-light border-0">
                                        <div class="card-body d-flex align-items-center p-3">
                                            <div class="bg-success bg-opacity-10 p-3 me-3 rounded">
                                                <i class="bi bi-person-check text-success fs-4"></i>
                                            </div>
                                            <div>
                                                <small class="text-muted">Ketua</small>
                                                <div class="fw-bold">
                                                    {{ $item->ketua->nama_lengkap ?? 'Belum ditentukan' }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <!-- DESKRIPSI -->
                            <div class="mb-4">
                                <h5 class="fw-bold mb-2">Deskripsi</h5>
                                <p class="text-muted">{{ $item->deskripsi ?? 'Tidak ada deskripsi tersedia.' }}</p>
                            </div>

                            <!-- INFO WAKTU -->
                            <div class="mt-4 pt-3 border-top">
                                <p class="text-muted small mb-1">
                                    <strong>Dibuat:</strong> {{ $item->created_at?->format('d M Y, H:i') ?? '-' }}
                                </p>
                                <p class="text-muted small mb-0">
                                    <strong>Terakhir diperbarui:</strong> {{ $item->updated_at?->format('d M Y, H:i') ?? '-' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalDaftar{{ $item->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <form action="{{ route('pendaftaran.store') }}" method="POST" enctype="multipart/form-data"
                        class="modal-content">
                        @csrf

                        <div class="modal-header">
                            <h5 class="modal-title">Form Pendaftaran</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">

                            <input type="hidden" name="ekstrakurikuler_id" value="{{ $item->id }}">

                            <div class="mb-3">
                                <label class="form-label">Ekstrakurikuler</label>
                                <input type="text" class="form-control" value="{{ $item->nama_ekstrakurikuler }}" disabled>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Alasan (opsional)</label>
                                <textarea name="alasan" class="form-control" rows="3">{{ old('alasan') }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Surat Keterangan Orang Tua (pdf/jpg/png)</label>
                                <input type="file" name="surat_keterangan_ortu" class="form-control">
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Kirim Pendaftaran</button>
                        </div>
                    </form>
                </div>
            </div>

            @empty
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="bi bi-inbox text-muted" style="font-size: 4rem;"></i>
                        <h4 class="text-muted mt-3">Belum Ada Data Ekstrakurikuler</h4>
                        <p class="text-muted">Silakan coba filter atau pencarian yang berbeda</p>
                    </div>
                </div>
            </div>
            @endforelse
        </div>

        <div class="mt-5 d-flex justify-content-center">
            {{ $ekstrakurikuler->withQueryString()->links() }}
        </div>

    </div>

    {{-- STYLE --}}
    <style>
        .hover-card {
            transition: all 0.3s ease;
        }
        .hover-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
        }
        .bg-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .form-control:focus, .form-select:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13,110,253,0.25);
        }
    </style>

  @endif

@endsection
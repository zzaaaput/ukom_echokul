@extends('layouts.template')

@section('title', 'Penilaian')

@section('content')
<div class="container-fluid bg-light min-vh-100 py-5">
    <div class="container">

        <!-- Header Section -->
        <div class="bg-white rounded-4 shadow-sm p-4 mb-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                <div>
                    <h2 class="fw-bold mb-2">Daftar Penilaian</h2>
                    <p class="text-muted mb-0">
                        <i class="bi bi-clipboard-check-fill me-2"></i>
                        Kelola penilaian anggota ekstrakurikuler
                    </p>
                </div>

                @if(Auth::check() && Auth::user()->role === 'pembina')
                <button class="btn btn-primary btn-lg px-4"
                        data-bs-toggle="modal"
                        data-bs-target="#modalTambah">
                    <i class="bi bi-plus-circle me-2"></i>Tambah Penilaian
                </button>
                @endif
            </div>
        </div>

        <!-- Search Section -->
        <div class="bg-white rounded-4 shadow-sm p-4 mb-4">
            <form method="GET" action="{{ route('penilaian.index') }}">
                <label for="search" class="form-label fw-semibold small">
                    <i class="bi bi-search text-primary me-1"></i>Pencarian & Filter
                </label>

                <div class="row g-2">
                    
                    <!-- Kolom Search -->
                    <div class="col-md-9">
                        <div class="input-group">
                            <span class="input-group-text bg-white">
                                <i class="bi bi-search text-muted"></i>
                            </span>
                            <input type="text" 
                                    name="search"
                                    id="search"
                                    class="form-control"
                                    placeholder="Cari anggota / ekskul / semester..."
                                    value="{{ request('search') }}"
                                    onchange="this.form.submit()">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <select name="semester" class="form-select" onchange="this.form.submit()">
                            <option value="">-- Semua Semester --</option>
                            @for ($i = 1; $i <= 6; $i++)
                                <option value="{{ $i }}" {{ request('semester') == $i ? 'selected' : '' }}>
                                    Semester {{ $i }}
                                </option>
                            @endfor
                        </select>
                    </div>

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
                            <th class="py-3 fw-semibold text-primary">Anggota</th>
                            <th class="py-3 fw-semibold text-primary">Ekstrakurikuler</th>
                            <th class="py-3 fw-semibold text-primary">Semester</th>
                            <th class="py-3 fw-semibold text-primary">Tahun Ajaran</th>
                            <th class="py-3 fw-semibold text-primary">Keterangan</th>
                            <th class="text-center py-3 fw-semibold text-primary">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($penilaian as $index => $item)
                        <tr>
                            <td class="ps-4 fw-semibold">{{ $index + 1 }}</td>
                            <td class="fw-bold">{{ $item->anggota->user->nama ?? $item->anggota->nama_anggota }}</td>
                            <td>{{ $item->ekstrakurikuler->nama_ekstrakurikuler ?? '-' }}</td>
                            <td>
                                <span class="badge bg-info bg-opacity-10 text-info px-3 py-2">
                                    Semester {{ $item->semester }}
                                </span>
                            </td>
                            <td>{{ $item->tahun_ajaran }}</td>
                            <td>
                                <span class="badge bg-{{ 
                                    $item->keterangan === 'sangat baik' ? 'success' : 
                                    ($item->keterangan === 'baik' ? 'primary' : 
                                    ($item->keterangan === 'cukup baik' ? 'info' : 
                                    ($item->keterangan === 'cukup' ? 'warning' : 'danger')))
                                }} px-3 py-2 text-capitalize">
                                    {{ $item->keterangan }}
                                </span>
                            </td>
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
                                            <h5 class="modal-title fw-bold mb-1">Detail Penilaian</h5>
                                            <small class="opacity-75">Informasi lengkap penilaian anggota</small>
                                        </div>
                                        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body p-4">
                                        <div class="row g-4">
                                            <div class="col-md-7">
                                                <div class="bg-light rounded-3 p-4">
                                                    <div class="mb-3">
                                                        <label class="text-muted small fw-semibold mb-2 d-block">
                                                            <i class="bi bi-person-fill text-primary me-1"></i> Nama Anggota
                                                        </label>
                                                        <p class="fw-bold mb-0">{{ $item->anggota->user->nama ?? $item->anggota->nama_anggota }}</p>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="text-muted small fw-semibold mb-2 d-block">
                                                            <i class="bi bi-trophy text-primary me-1"></i> Ekstrakurikuler
                                                        </label>
                                                        <p class="mb-0">{{ $item->ekstrakurikuler->nama_ekstrakurikuler ?? '-' }}</p>
                                                    </div>

                                                    <div class="row g-3 mb-3">
                                                        <div class="col-6">
                                                            <label class="text-muted small fw-semibold mb-2 d-block">
                                                                <i class="bi bi-calendar-event text-primary me-1"></i> Semester
                                                            </label>
                                                            <span class="badge bg-info bg-opacity-10 text-info px-3 py-2">
                                                                Semester {{ $item->semester }}
                                                            </span>
                                                        </div>

                                                        <div class="col-6">
                                                            <label class="text-muted small fw-semibold mb-2 d-block">
                                                                <i class="bi bi-calendar-check text-primary me-1"></i> Tahun Ajaran
                                                            </label>
                                                            <p class="mb-0">{{ $item->tahun_ajaran }}</p>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="text-muted small fw-semibold mb-2 d-block">
                                                            <i class="bi bi-star-fill text-primary me-1"></i> Keterangan
                                                        </label>
                                                        <span class="badge bg-{{ 
                                                            $item->keterangan === 'sangat baik' ? 'success' : 
                                                            ($item->keterangan === 'baik' ? 'primary' : 
                                                            ($item->keterangan === 'cukup baik' ? 'info' : 
                                                            ($item->keterangan === 'cukup' ? 'warning' : 'danger')))
                                                        }} px-3 py-2 text-capitalize">
                                                            {{ $item->keterangan }}
                                                        </span>
                                                    </div>

                                                    <div>
                                                        <label class="text-muted small fw-semibold mb-2 d-block">
                                                            <i class="bi bi-chat-left-quote text-primary me-1"></i> Catatan
                                                        </label>
                                                        <p class="mb-0">{{ $item->catatan ?? '-' }}</p>
                                                    </div>
                                                </div>

                                                <div class="border-top pt-3 mt-3">
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

                                            <div class="col-md-5 text-center">
                                                <label class="text-muted small fw-semibold mb-3 d-block">
                                                    <i class="bi bi-image text-primary me-1"></i> Foto Penilaian
                                                </label>
                                                @if($item->foto && file_exists(storage_path('app/public/' . $item->foto)))
                                                    <img src="{{ asset('storage/' . $item->foto) }}"
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
                                            <h5 class="modal-title fw-bold mb-1">Edit Penilaian</h5>
                                            <small class="opacity-75">Perbarui informasi penilaian</small>
                                        </div>
                                        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>

                                    <form action="{{ route('pembina.penilaian.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')

                                        <div class="modal-body p-4">
                                            <div class="row g-3">
                                                <div class="col-12">
                                                    <label class="form-label fw-semibold">
                                                        <i class="bi bi-person-check text-warning me-1"></i> Anggota
                                                    </label>
                                                    <select name="anggota_id" class="form-select" required>
                                                        @foreach($anggota as $a)
                                                        <option value="{{ $a->id }}" {{ $item->anggota_id == $a->id ? 'selected' : '' }}>
                                                            {{ $a->user->nama ?? $a->nama_anggota }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-12">
                                                    <label class="form-label fw-semibold">
                                                        <i class="bi bi-trophy text-warning me-1"></i> Ekstrakurikuler
                                                    </label>
                                                    <select name="ekstrakurikuler_id" class="form-select" required>
                                                        @foreach($ekstrakurikulerList as $e)
                                                        <option value="{{ $e->id }}" {{ $item->ekstrakurikuler_id == $e->id ? 'selected' : '' }}>
                                                            {{ $e->nama_ekstrakurikuler }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold">
                                                        <i class="bi bi-calendar-event text-warning me-1"></i> Tahun Ajaran
                                                    </label>
                                                    <input type="number" name="tahun_ajaran" class="form-control" value="{{ $item->tahun_ajaran }}">
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold">
                                                        <i class="bi bi-calendar-check text-warning me-1"></i> Semester
                                                    </label>
                                                    <select name="semester" class="form-select">
                                                        @for($i=1; $i<=6; $i++)
                                                            <option value="{{ $i }}" {{ $item->semester == $i ? 'selected' : '' }}>
                                                                Semester {{ $i }}
                                                            </option>
                                                        @endfor
                                                    </select>
                                                </div>

                                                <div class="col-12">
                                                    <label class="form-label fw-semibold">
                                                        <i class="bi bi-star text-warning me-1"></i> Keterangan
                                                    </label>
                                                    <select name="keterangan" class="form-select">
                                                        <option value="sangat baik" {{ $item->keterangan=='sangat baik'?'selected':'' }}>Sangat Baik</option>
                                                        <option value="baik" {{ $item->keterangan=='baik'?'selected':'' }}>Baik</option>
                                                        <option value="cukup baik" {{ $item->keterangan=='cukup baik'?'selected':'' }}>Cukup Baik</option>
                                                        <option value="cukup" {{ $item->keterangan=='cukup'?'selected':'' }}>Cukup</option>
                                                        <option value="kurang baik" {{ $item->keterangan=='kurang baik'?'selected':'' }}>Kurang Baik</option>
                                                    </select>
                                                </div>

                                                <div class="col-12">
                                                    <label class="form-label fw-semibold">
                                                        <i class="bi bi-chat-left-text text-warning me-1"></i> Catatan
                                                    </label>
                                                    <textarea name="catatan" class="form-control" rows="3">{{ $item->catatan }}</textarea>
                                                </div>

                                                <div class="col-12">
                                                    <label class="form-label fw-semibold">
                                                        <i class="bi bi-image text-warning me-1"></i> Foto Saat Ini
                                                    </label>
                                                    <div class="text-center bg-light rounded-3 p-3 mb-3">
                                                        @if($item->foto && file_exists(storage_path('app/public/' . $item->foto)))
                                                            <img src="{{ asset('storage/' . $item->foto) }}"
                                                                 class="img-fluid rounded-3 shadow-sm"
                                                                 style="max-width: 250px; object-fit: cover;">
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
                                            <h5 class="modal-title fw-bold mb-1">Hapus Penilaian</h5>
                                            <small class="opacity-75">Konfirmasi penghapusan data</small>
                                        </div>
                                        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>

                                    <form action="{{ route('pembina.penilaian.destroy', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <div class="modal-body text-center p-5">
                                            <div class="bg-danger bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                                <i class="bi bi-exclamation-triangle-fill text-danger" style="font-size: 2.5rem;"></i>
                                            </div>
                                            <h5 class="fw-bold mb-2">Apakah Anda yakin?</h5>
                                            <p class="text-muted mb-0">
                                                Penilaian untuk <strong class="text-dark">{{ $item->anggota->nama ?? '-' }}</strong> akan dihapus permanen dan tidak dapat dikembalikan.
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
                                <p class="text-muted mb-0">Tidak ada data penilaian yang tersedia saat ini</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($penilaian->hasPages())
            <div class="p-4 border-top">
                <div class="d-flex justify-content-center">
                    {{ $penilaian->links() }}
                </div>
            </div>
            @endif
        </div>

    </div>
</div>

{{-- ==================== MODAL TAMBAH ==================== --}}
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-primary text-white border-0 p-4">
                <div>
                    <h5 class="modal-title fw-bold mb-1">Tambah Penilaian</h5>
                    <small class="opacity-75">Tambahkan penilaian baru untuk anggota</small>
                </div>
                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('pembina.penilaian.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-person-check text-primary me-1"></i> Anggota
                            </label>
                            <select name="anggota_id" class="form-select" required>
                                <option value="">-- Pilih Anggota --</option>
                                @foreach($anggota as $a)
                                    <option value="{{ $a->id }}">
                                        {{ $a->user->nama ?? $a->nama_anggota }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-trophy text-primary me-1"></i> Ekstrakurikuler
                            </label>
                            <select name="ekstrakurikuler_id" class="form-select" required>
                                <option value="">-- Pilih Ekstrakurikuler --</option>
                                @foreach($ekstrakurikulerList as $e)
                                <option value="{{ $e->id }}">{{ $e->nama_ekstrakurikuler }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-calendar-check text-primary me-1"></i> Semester
                            </label>
                            <select name="semester" class="form-select">
                                @for($i=1; $i<=6; $i++)
                                    <option value="{{ $i }}">Semester {{ $i }}</option>
                                @endfor
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-calendar-event text-primary me-1"></i> Tahun Ajaran
                            </label>
                            <input type="number" name="tahun_ajaran" class="form-control" placeholder="2024" required>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-star text-primary me-1"></i> Keterangan
                            </label>
                            <select name="keterangan" class="form-select">
                                <option value="sangat baik">Sangat Baik</option>
                                <option value="baik">Baik</option>
                                <option value="cukup baik">Cukup Baik</option>
                                <option value="cukup">Cukup</option>
                                <option value="kurang baik">Kurang Baik</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-chat-left-text text-primary me-1"></i> Catatan
                            </label>
                            <textarea name="catatan" class="form-control" rows="3" placeholder="Masukkan catatan penilaian"></textarea>
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

@endsection
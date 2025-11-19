@extends('layouts.template')

@section('title', 'Perlombaan')

@section('content')
@if(Auth::check() && in_array(Auth::user()->role, ['pembina', 'ketua']))
    <div class="container py-4">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold text-dark">Data Perlombaan</h3>

            @if(Auth::check() && (Auth::user()->role === 'ketua' || Auth::user()->role === 'pembina'))
            <button class="btn text-white fw-semibold"
                style="background-color: #0d6efd;"
                data-bs-toggle="modal"
                data-bs-target="#modalTambah">
                <i class="bi bi-plus-circle me-1"></i> Tambah Perlombaan
            </button>
            @endif
        </div>

        <!-- Search -->
        <div class="mb-3" style="max-width: 420px;">
            <form method="GET" action="{{ route('pembina.perlombaan.index') }}" class="d-flex">
                <input type="text" name="search" class="form-control"
                    placeholder="Cari ekstrakurikuler / nama / tahun / tempat..."
                    value="{{ request('search') }}"
                    onchange="this.form.submit()">
            </form>
        </div>

        <!-- Table Card -->
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="text-white" style="background-color: #002142;">
                            <tr>
                                <th class="py-3 ps-4">No</th>
                                <th class="py-3 ps-4">Ekstrakurikuler</th>
                                <th class="py-3 ps-4">Nama Perlombaan</th>
                                <th class="py-3 ps-4">Tanggal</th>
                                <th class="py-3 ps-4">Tempat</th>
                                <th class="py-3 ps-4">Tingkat</th>
                                <th class="py-3 ps-4">Tahun Ajaran</th>
                                <th class="py-3 ps-4">Foto</th>
                                <th class="text-center py-3 ps-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($perlombaan as $index => $row)
                            <tr>
                                <td class="ps-4 fw-semibold">{{ $perlombaan->firstItem() + $index }}</td>
                                <td>{{ $row->ekstrakurikuler->nama_ekstrakurikuler ?? '-' }}</td>
                                <td>{{ $row->nama_perlombaan }}</td>
                                <td>{{ \Carbon\Carbon::parse($row->tanggal)->format('d M Y') }}</td>
                                <td>{{ $row->tempat ?? '-' }}</td>
                                <td>{{ $row->tingkat ?? '-' }}</td>
                                <td>{{ $row->tahun_ajaran ?? '-' }}</td>
                                <td>
                                    @if($row->foto && file_exists(storage_path('app/public/' . $row->foto)))
                                        <img src="{{ asset('storage/' . $row->foto) }}" class="rounded" style="width:70px; height:70px; object-fit:cover;">
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <!-- Detail -->
                                    <button class="btn btn-sm fw-semibold text-white me-1"
                                        style="background-color:#0d6efd;"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalDetail{{ $row->id }}">
                                        <i class="bi bi-eye"></i> Detail
                                    </button>

                                    @if(Auth::check() && (Auth::user()->role === 'ketua' || Auth::user()->role === 'pembina'))
                                    <!-- Edit -->
                                    <button class="btn btn-sm fw-semibold text-white me-1"
                                        style="background-color:#dfa700;"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalEdit{{ $row->id }}">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </button>

                                    <!-- Hapus -->
                                    <button class="btn btn-sm fw-semibold text-white"
                                        style="background-color:#dc3545;"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalHapus{{ $row->id }}">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                    @endif
                                </td>
                            </tr>

                            <!-- MODAL DETAIL -->
                            <div class="modal fade" id="modalDetail{{ $row->id }}" tabindex="-1">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content border-0 shadow">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title">Detail Perlombaan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p><strong>Ekstrakurikuler:</strong><br>{{ $row->ekstrakurikuler->nama_ekstrakurikuler ?? '-' }}</p>
                                                    <p><strong>Nama Perlombaan:</strong><br>{{ $row->nama_perlombaan }}</p>
                                                    <p><strong>Tanggal:</strong><br>{{ \Carbon\Carbon::parse($row->tanggal)->format('d M Y') }}</p>
                                                    <p><strong>Tempat:</strong><br>{{ $row->tempat ?? '-' }}</p>
                                                    <p><strong>Tingkat:</strong><br>{{ $row->tingkat ?? '-' }}</p>
                                                    <p><strong>Tahun Ajaran:</strong><br>{{ $row->tahun_ajaran ?? '-' }}</p>
                                                    <p><strong>Deskripsi:</strong><br>{!! nl2br(e($row->deskripsi ?? '-')) !!}</p>
                                                </div>

                                                <div class="col-md-6 text-center">
                                                    @if($row->foto && file_exists(storage_path('app/public/' . $row->foto)))
                                                        <img src="{{ asset('storage/' . $row->foto) }}"
                                                            class="img-fluid rounded shadow border"
                                                            style="max-width: 320px; object-fit: cover;">
                                                    @else
                                                        <span class="text-muted">Tidak ada foto</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <hr>
                                            <p class="small text-muted mb-0">
                                                <strong>Dibuat:</strong> {{ optional($row->created_at)->format('d M Y, H:i') }} <br>
                                                <strong>Diperbarui:</strong> {{ optional($row->updated_at)->format('d M Y, H:i') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- MODAL EDIT -->
                            <div class="modal fade" id="modalEdit{{ $row->id }}" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content border-0 shadow">
                                        <div class="modal-header text-white" style="background-color:#dfa700;">
                                            <h5 class="modal-title">Edit Perlombaan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <form action="{{ route('pembina.perlombaan.update', $row->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">

                                                <!-- Ekstrakurikuler Read-only -->
                                                <div class="mb-3">
                                                    <label class="fw-semibold">Ekstrakurikuler</label>
                                                    <select class="form-control" name="ekstrakurikuler_id" required>
                                                        @foreach($ekskul as $e)
                                                            <option value="{{ $e->id }}" {{ (isset($row) && $row->ekstrakurikuler_id == $e->id) ? 'selected' : '' }}>
                                                                {{ $e->nama_ekstrakurikuler }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="fw-semibold">Nama Perlombaan</label>
                                                    <input type="text" name="nama_perlombaan" class="form-control" value="{{ $row->nama_perlombaan }}" required>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label class="fw-semibold">Tanggal</label>
                                                        <input type="date" name="tanggal" class="form-control" value="{{ $row->tanggal }}">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="fw-semibold">Tempat</label>
                                                        <input type="text" name="tempat" class="form-control" value="{{ $row->tempat }}">
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="fw-semibold">Tingkat</label>
                                                    <input type="text" name="tingkat" class="form-control" value="{{ $row->tingkat }}">
                                                </div>

                                                <div class="mb-3">
                                                    <label class="fw-semibold">Tahun Ajaran</label>
                                                    <input type="text" name="tahun_ajaran" class="form-control" value="{{ $row->tahun_ajaran }}">
                                                </div>

                                                <div class="mb-3">
                                                    <label class="fw-semibold">Deskripsi</label>
                                                    <textarea name="deskripsi" class="form-control" rows="4">{{ $row->deskripsi }}</textarea>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="fw-semibold">Foto Saat Ini</label><br>
                                                    @if($row->foto && file_exists(storage_path('app/public/' . $row->foto)))
                                                        <img src="{{ asset('storage/' . $row->foto) }}"
                                                            class="img-fluid rounded shadow border mb-2"
                                                            style="max-width: 220px; object-fit: cover;">
                                                    @else
                                                        <p class="text-muted">Tidak ada foto</p>
                                                    @endif
                                                    <input type="file" name="foto" class="form-control">
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn text-white" style="background-color:#dfa700;">Perbarui</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- MODAL HAPUS -->
                            <div class="modal fade" id="modalHapus{{ $row->id }}">
                                <div class="modal-dialog">
                                    <div class="modal-content border-0 shadow">
                                        <div class="modal-header text-white" style="background-color:#dc3545;">
                                            <h5 class="modal-title">Hapus Perlombaan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <form action="{{ route('pembina.perlombaan.destroy', $row->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <div class="modal-body text-center">
                                                <p class="fs-5">
                                                    Yakin ingin menghapus perlombaan
                                                    <strong>{{ $row->nama_perlombaan }}</strong>?
                                                </p>
                                                <p class="text-muted">Aksi ini tidak bisa dibatalkan.</p>
                                            </div>

                                            <div class="modal-footer justify-content-center">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            @empty
                            <tr>
                                <td colspan="9" class="text-center py-4 text-muted">
                                    <i class="bi bi-exclamation-circle me-1"></i> Belum ada data perlombaan.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-3 px-3">
                        {{ $perlombaan->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL TAMBAH -->
    <div class="modal fade" id="modalTambah" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content border-0 shadow">
                <div class="modal-header text-white" style="background-color:#001f3f;">
                    <h5 class="modal-title">Tambah Perlombaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ route('pembina.perlombaan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">

                        <!-- Ekstrakurikuler Read-only untuk pembina/ketua -->
                        <div class="mb-3">
                            <label class="fw-semibold">Ekstrakurikuler</label>
                            <select class="form-control" name="ekstrakurikuler_id" required>
                                @foreach($ekskul as $e)
                                    <option value="{{ $e->id }}" {{ (isset($row) && $row->ekstrakurikuler_id == $e->id) ? 'selected' : '' }}>
                                        {{ $e->nama_ekstrakurikuler }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="fw-semibold">Nama Perlombaan</label>
                            <input type="text" name="nama_perlombaan" class="form-control" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="fw-semibold">Tanggal</label>
                                <input type="date" name="tanggal" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="fw-semibold">Tempat</label>
                                <input type="text" name="tempat" class="form-control">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="fw-semibold">Tingkat</label>
                            <input type="text" name="tingkat" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="fw-semibold">Tahun Ajaran</label>
                            <input type="text" name="tahun_ajaran" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="fw-semibold">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" rows="4"></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="fw-semibold">Foto</label>
                            <input type="file" name="foto" class="form-control">
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn text-white" style="background-color:#001f3f;">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif

@if(!Auth::check() || !in_array(Auth::user()->role, ['pembina', 'ketua']))
    <div class="container py-5">
        <div class="row mb-4">
            <div class="col-lg-8 mx-auto">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <form method="GET" action="{{ route('pembina.perlombaan.index') }}" id="filterForm">
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
                                <div class="col-md-3">
                                    <select name="ekskul" class="form-select" onchange="document.getElementById('filterForm').submit()">
                                        <option value="">Semua Ekskul</option>
                                        @foreach($ekskul as $e)
                                            <option value="{{ $e->id }}" {{ request('ekskul') == $e->id ? 'selected' : '' }}>
                                                {{ $e->nama_ekstrakurikuler }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Filter Tingkat -->
                                <div class="col-md-3">
                                    <select name="tingkat" class="form-select" onchange="document.getElementById('filterForm').submit()">
                                        <option value="">Semua Tingkat</option>
                                        <option value="Sekolah" {{ request('tingkat') == 'Sekolah' ? 'selected' : '' }}>Sekolah</option>
                                        <option value="Kecamatan" {{ request('tingkat') == 'Kecamatan' ? 'selected' : '' }}>Kecamatan</option>
                                        <option value="Kabupaten" {{ request('tingkat') == 'Kabupaten' ? 'selected' : '' }}>Kabupaten</option>
                                        <option value="Provinsi" {{ request('tingkat') == 'Provinsi' ? 'selected' : '' }}>Provinsi</option>
                                        <option value="Nasional" {{ request('tingkat') == 'Nasional' ? 'selected' : '' }}>Nasional</option>
                                        <option value="Internasional" {{ request('tingkat') == 'Internasional' ? 'selected' : '' }}>Internasional</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Quick Filter Buttons -->
                            <div class="mt-3 d-flex flex-wrap gap-2">
                                <span class="text-muted small">Cepat:</span>
                                <a href="{{ route('pembina.perlombaan.index') }}" 
                                class="badge bg-secondary text-decoration-none py-2 px-3">
                                    <i class="bi bi-arrow-clockwise me-1"></i>Reset Filter
                                </a>
                                <a href="{{ route('pembina.perlombaan.index', ['tingkat' => 'Nasional']) }}" 
                                class="badge bg-primary text-decoration-none py-2 px-3">
                                    <i class="bi bi-flag me-1"></i>Nasional
                                </a>
                                <a href="{{ route('pembina.perlombaan.index', ['tingkat' => 'Internasional']) }}" 
                                class="badge bg-success text-decoration-none py-2 px-3">
                                    <i class="bi bi-globe me-1"></i>Internasional
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
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center p-4">
                        <div class="rounded-circle bg-primary bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3" 
                            style="width: 70px; height: 70px;">
                            <i class="bi bi-trophy-fill fs-2 text-primary"></i>
                        </div>
                        <h3 class="fw-bold text-primary">{{ $totalPerlombaan }}</h3>
                        <p class="text-muted mb-0">Total Perlombaan</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center p-4">
                        <div class="rounded-circle bg-success bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3" 
                            style="width: 70px; height: 70px;">
                            <i class="bi bi-calendar-event fs-2 text-success"></i>
                        </div>
                        <h3 class="fw-bold text-success">#</h3>
                        <p class="text-muted mb-0">Tahun Ini</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center p-4">
                        <div class="rounded-circle bg-warning bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3" 
                            style="width: 70px; height: 70px;">
                            <i class="bi bi-star-fill fs-2 text-warning"></i>
                        </div>
                        <h3 class="fw-bold text-warning">{{ $totalEkskul }}</h3>
                        <p class="text-muted mb-0">Ekstrakurikuler</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Competition Cards -->
        <div class="row g-4">
            @forelse($perlombaan as $row)
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm h-100 hover-card">
                    <!-- Image Section -->
                    <div class="position-relative overflow-hidden" style="height: 220px;">
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
                        
                        <!-- Tingkat Badge -->
                        <div class="position-absolute top-0 end-0 m-3">
                            <span class="badge bg-dark bg-opacity-75 px-3 py-2">
                                <i class="bi bi-award me-1"></i>{{ $row->tingkat ?? 'Umum' }}
                            </span>
                        </div>
                    </div>

                    <div class="card-body d-flex flex-column">
                        <!-- Ekstrakurikuler Tag -->
                        <div class="mb-2">
                            <span class="badge rounded-pill" style="background-color: #0d6efd;">
                                {{ $row->ekstrakurikuler->nama_ekstrakurikuler ?? 'Umum' }}
                            </span>
                        </div>

                        <!-- Title -->
                        <h5 class="card-title fw-bold mb-3">{{ $row->nama_perlombaan }}</h5>

                        <!-- Info Items -->
                        <div class="mb-3 flex-grow-1">
                            <div class="d-flex align-items-center text-muted mb-2">
                                <i class="bi bi-calendar3 me-2 text-primary"></i>
                                <small>{{ \Carbon\Carbon::parse($row->tanggal)->format('d F Y') }}</small>
                            </div>
                            <div class="d-flex align-items-center text-muted mb-2">
                                <i class="bi bi-geo-alt me-2 text-danger"></i>
                                <small>{{ $row->tempat ?? 'Tempat belum ditentukan' }}</small>
                            </div>
                            <div class="d-flex align-items-center text-muted">
                                <i class="bi bi-book me-2 text-success"></i>
                                <small>{{ $row->tahun_ajaran ?? '-' }}</small>
                            </div>
                        </div>

                        <!-- Action Button -->
                        <button class="btn btn-primary w-100"
                                data-bs-toggle="modal"
                                data-bs-target="#modalDetailInfo{{ $row->id }}">
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
        box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
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
    </style>
@endif

@endsection
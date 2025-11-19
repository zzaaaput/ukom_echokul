@extends('layouts.template')

@section('title', 'Perlombaan')

@section('content')
@if(Auth::check() && in_array(Auth::user()->role, ['pembina', 'ketua']))
    <div class="container py-4">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold text-dark">Data Kegiatan</h3>

            @if(Auth::check() && (Auth::user()->role === 'ketua' || Auth::user()->role === 'pembina'))
            <button class="btn text-white fw-semibold"
                style="background-color: #0d6efd;"
                data-bs-toggle="modal"
                data-bs-target="#modalTambah">
                <i class="bi bi-plus-circle me-1"></i> Tambah Kegiatan
            </button>
            @endif
        </div>

        <!-- Search -->
        <div class="mb-3" style="max-width: 420px;">
            <form method="GET" action="{{ route('pembina.kegiatan.index') }}" class="d-flex">
                <input type="text" name="search" class="form-control"
                    placeholder="Cari nama kegiatan / lokasi / tanggal..."
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
                                <th class="py-3 ps-4">Nama Kegiatan</th>
                                <th class="py-3 ps-4">Tanggal</th>
                                <th class="py-3 ps-4">Lokasi</th>
                                <th class="py-3 ps-4">Foto</th>
                                <th class="text-center py-3 ps-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($kegiatan as $index => $row)
                            <tr>
                                <td class="ps-4 fw-semibold">{{ $kegiatan->firstItem() + $index }}</td>
                                <td>{{ $row->ekstrakurikuler->nama_ekstrakurikuler ?? '-' }}</td>
                                <td>{{ $row->nama_kegiatan }}</td>
                                <td>{{ \Carbon\Carbon::parse($row->tanggal)->format('d M Y') }}</td>
                                <td>{{ $row->lokasi ?? '-' }}</td>
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
                                            <h5 class="modal-title">Detail Kegiatan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p><strong>Ekstrakurikuler:</strong><br>{{ $row->ekstrakurikuler->nama_ekstrakurikuler ?? '-' }}</p>
                                                    <p><strong>Nama Kegiatan:</strong><br>{{ $row->nama_kegiatan }}</p>
                                                    <p><strong>Tanggal:</strong><br>{{ \Carbon\Carbon::parse($row->tanggal)->format('d M Y') }}</p>
                                                    <p><strong>Lokasi:</strong><br>{{ $row->lokasi ?? '-' }}</p>
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
                                            <h5 class="modal-title">Edit Kegiatan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <form action="{{ route('pembina.kegiatan.update', $row->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">

                                            <div class="mb-3">
                                                <label class="fw-semibold">Ekstrakurikuler</label>
                                                <select class="form-control" name="ekstrakurikuler_id" required>
                                                    @foreach($ekskul as $e)
                                                        <option value="{{ $e->id }}" {{ $row->ekstrakurikuler_id == $e->id ? 'selected' : '' }}>
                                                            {{ $e->nama_ekstrakurikuler }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                                <div class="mb-3">
                                                    <label class="fw-semibold">Nama Kegiatan</label>
                                                    <input type="text" name="nama_kegiatan" class="form-control" value="{{ $row->nama_kegiatan }}" required>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label class="fw-semibold">Tanggal</label>
                                                        <input type="date" name="tanggal" class="form-control" value="{{ $row->tanggal }}">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="fw-semibold">Lokasi</label>
                                                        <input type="text" name="lokasi" class="form-control" value="{{ $row->lokasi }}">
                                                    </div>
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
                                            <h5 class="modal-title">Hapus Kegiatan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <form action="{{ route('pembina.kegiatan.destroy', $row->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <div class="modal-body text-center">
                                                <p class="fs-5">
                                                    Yakin ingin menghapus kegiatan
                                                    <strong>{{ $row->nama_kegiatan }}</strong>?
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
                                <td colspan="7" class="text-center py-4 text-muted">
                                    <i class="bi bi-exclamation-circle me-1"></i> Belum ada data kegiatan.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-3 px-3">
                        {{ $kegiatan->withQueryString()->links() }}
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
                    <h5 class="modal-title">Tambah Kegiatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ route('pembina.kegiatan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">

                    <div class="mb-3">
                        <label class="fw-semibold">Ekstrakurikuler</label>
                        @if(Auth::check() && Auth::user()->role === 'pembina')
                            {{-- Tampilkan readonly input untuk pembina --}}
                            <input type="text" class="form-control" 
                                value="{{ $pembinaEkskul->nama_ekstrakurikuler ?? '' }}" readonly>
                            <input type="hidden" name="ekstrakurikuler_id" 
                                value="{{ $pembinaEkskul->id ?? '' }}">
                        @else
                            {{-- Dropdown untuk admin / guest --}}
                            <select name="ekstrakurikuler_id" class="form-control" required>
                                @foreach($ekstrakurikulerList as $e)
                                    <option value="{{ $e->id }}">{{ $e->nama_ekstrakurikuler }}</option>
                                @endforeach
                            </select>
                        @endif
                    </div>

                        <div class="mb-3">
                            <label class="fw-semibold">Nama Kegiatan</label>
                            <input type="text" name="nama_kegiatan" class="form-control" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="fw-semibold">Tanggal</label>
                                <input type="date" name="tanggal" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="fw-semibold">Lokasi</label>
                                <input type="text" name="lokasi" class="form-control">
                            </div>
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
    <div class="container py-2">

        <!-- FILTER & SEARCH -->
        <div class="row mb-4">
            <div class="col-lg-8 mx-auto">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <form method="GET" action="{{ route('pembina.kegiatan.index') }}" id="filterForm">
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
                                    <select name="ekskul" class="form-select" onchange="document.getElementById('filterForm').submit()">
                                        <option value="">Semua Ekskul</option>
                                        @foreach($ekskul as $e)
                                            <option value="{{ $e->id }}" {{ request('ekskul') == $e->id ? 'selected' : '' }}>
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

                                <a href="{{ route('pembina.kegiatan.index') }}" 
                                    class="badge bg-secondary text-decoration-none py-2 px-3">
                                    <i class="bi bi-arrow-clockwise me-1"></i>Reset Filter
                                </a>

                                <a href="{{ route('pembina.kegiatan.index', ['tanggal' => today()->format('Y-m-d')]) }}" 
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
                    <h3 class="fw-bold text-primary">#</h3>
                    <p class="text-muted mb-0">Total Kegiatan</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-body text-center p-4">
                    <h3 class="fw-bold text-success">#</h3>
                    <p class="text-muted mb-0">Kegiatan Hari Ini</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-body text-center p-4">
                    <h3 class="fw-bold text-warning">#</h3>
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
                        @if($row->foto && file_exists(storage_path('app/public/'.$row->foto)))
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
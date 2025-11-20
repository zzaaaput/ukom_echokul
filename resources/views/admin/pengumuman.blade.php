@extends('layouts.template')

@section('title', 'Pengumuman')

@section('content')
    @if(Auth::check() && Auth::user()->role === 'admin')
        <div class="container py-4">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold text-dark">Data Pengumuman</h3>

                <button class="btn text-white fw-semibold"
                    style="background-color: #0d6efd;"
                    data-bs-toggle="modal"
                    data-bs-target="#modalTambah">
                    <i class="bi bi-plus-circle me-1"></i> Tambah Pengumuman
                </button>
            </div>

            <div class="mb-3" style="max-width: 420px;">
                <form method="GET" action="{{ route('admin.pengumuman.index') }}" class="d-flex">
                    <input type="text" name="search" class="form-control"
                        placeholder="Cari judul / tanggal..."
                        value="{{ request('search') }}"
                        onchange="this.form.submit()">
                </form>
            </div>

            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="text-white" style="background-color: #002142;">
                                <tr>
                                    <th class="py-3 ps-4">No</th>
                                    <th class="py-3 ps-4">Judul Pengumuman</th>
                                    <th class="py-3 ps-4">Tanggal</th>
                                    <th class="py-3 ps-4">Deskripsi</th>
                                    <th class="py-3 ps-4">Foto</th>
                                    <th class="text-center py-3 ps-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pengumuman as $index => $row)
                                <tr>
                                    <td class="ps-4 fw-semibold">{{ $pengumuman->firstItem() + $index }}</td>
                                    <td>{{ $row->judul_pengumuman }}</td>
                                    <td>{{ \Carbon\Carbon::parse($row->tanggal)->format('d M Y') }}</td>
                                    <td>{{ Str::limit($row->isi, 50) }}</td>
                                    <td>
                                        @if($row->foto && file_exists(public_path($row->foto)))
                                            <img src="{{ asset($row->foto) }}" 
                                            class="rounded" style="width:70px; height:70px; object-fit:cover;">
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

                                        <button class="btn btn-sm fw-semibold text-white me-1"
                                            style="background-color:#dfa700;"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalEdit{{ $row->id }}">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </button>

                                        <button class="btn btn-sm fw-semibold text-white"
                                            style="background-color:#dc3545;"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalHapus{{ $row->id }}">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    </td>
                                </tr>

                                <!-- MODAL DETAIL -->
                                <div class="modal fade" id="modalDetail{{ $row->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content border-0 shadow">
                                            <div class="modal-header bg-primary text-white">
                                                <h5 class="modal-title">Detail Pengumuman</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>

                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <p><strong>Judul:</strong><br>{{ $row->judul_pengumuman }}</p>
                                                        <p><strong>Tanggal:</strong><br>{{ \Carbon\Carbon::parse($row->tanggal)->format('d M Y') }}</p>
                                                        <p><strong>Deskripsi:</strong><br>{!! nl2br(e($row->isi ?? '-')) !!}</p>
                                                    </div>

                                                    <div class="col-md-6 text-center">
                                                        @if($row->foto && file_exists(public_path($row->foto)))
                                                            <img src="{{ asset($row->foto) }}"
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
                                                <h5 class="modal-title">Edit Pengumuman</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>

                                            <form action="{{ route('admin.pengumuman.update', $row->id) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="fw-semibold">Judul</label>
                                                        <input type="text" name="judul_pengumuman" class="form-control" value="{{ $row->judul_pengumuman }}" required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="fw-semibold">Tanggal</label>
                                                        <input type="date" name="tanggal" class="form-control" value="{{ $row->tanggal }}">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="fw-semibold">Deskripsi</label>
                                                        <textarea name="isi" class="form-control" rows="4">{{ $row->isi }}</textarea>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="fw-semibold">Foto Saat Ini</label><br>
                                                        @if($row->foto && file_exists(public_path($row->foto)))
                                                            <img src="{{ asset($row->foto) }}">
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
                                                <h5 class="modal-title">Hapus Pengumuman</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>

                                            <form action="{{ route('admin.pengumuman.destroy', $row->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <div class="modal-body text-center">
                                                    <p class="fs-5">
                                                        Yakin ingin menghapus pengumuman
                                                        <strong>{{ $row->judul_pengumuman }}</strong>?
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
                                    <td colspan="6" class="text-center py-4 text-muted">
                                        <i class="bi bi-exclamation-circle me-1"></i> Belum ada data pengumuman.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <div class="mt-3 px-3">
                            {{ $pengumuman->withQueryString()->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalTambah" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Tambah Pengumuman</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <form action="{{ route('admin.pengumuman.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="fw-semibold">Judul Pengumuman</label>
                                <input type="text" name="judul_pengumuman" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="fw-semibold">Isi</label>
                                <textarea name="isi" class="form-control" rows="4" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="fw-semibold">Tanggal</label>
                                <input type="date" name="tanggal" class="form-control">
                            </div>


                            <div class="mb-3">
                                <label class="fw-semibold">Foto</label>
                                <input type="file" name="foto" class="form-control">
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
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
                            <form method="GET" action="{{ route('admin.pengumuman.index') }}" id="filterForm">
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

                                    <a href="{{ route('admin.pengumuman.index') }}" 
                                        class="badge bg-secondary text-decoration-none py-2 px-3">
                                        <i class="bi bi-arrow-clockwise me-1"></i>Reset Filter
                                    </a>

                                    <a href="{{ route('admin.pengumuman.index', ['tanggal' => today()->format('Y-m-d')]) }}" 
                                        class="badge bg-primary text-decoration-none py-2 px-3">
                                        <i class="bi bi-calendar-event me-1"></i>Hari Ini
                                    </a>

                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                @forelse($pengumuman as $row)
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 shadow-sm h-100 hover-card">

                        <div class="position-relative overflow-hidden" style="height: 220px;">
                            @if($row->foto && file_exists(public_path($row->foto)))
                                    <img src="{{ asset($row->foto) }}" 
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
                    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content border-0 shadow-lg">

                            <div class="position-relative" style="height:250px;overflow:hidden;">
                                @if($row->foto && file_exists(public_path($row->foto)))
                                    <img src="{{ asset($row->foto) }}" 
                                        class="w-100 h-100" style="object-fit:cover;filter:brightness(.7);">
                                @else
                                    <div class="w-100 h-100 bg-primary bg-gradient"></div>
                                @endif

                                <div class="position-absolute bottom-0 p-4 w-100"
                                    style="background:linear-gradient(to top,rgba(0,0,0,.8),transparent)">
                                    <h3 class="text-white fw-bold mb-0">{{ $row->judul_pengumuman }}</h3>
                                </div>
                            </div>

                            <div class="modal-body p-4">
                                @if($row->isi)
                                <div class="mb-4">
                                    <h5 class="fw-bold mb-3">
                                        <i class="bi bi-card-text text-primary me-2"></i>Deskripsi
                                    </h5>
                                    <div class="bg-light rounded p-3">
                                        <p class="mb-0" style="white-space:pre-line;">{{ $row->isi }}</p>
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
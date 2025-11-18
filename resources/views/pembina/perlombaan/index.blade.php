@extends('layouts.template')

@section('title', 'Perlombaan')

@section('content')
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

                        <!-- ========== MODAL DETAIL ========== -->
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

                        <!-- ========== MODAL EDIT ========== -->
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
                                            <div class="mb-3">
                                                <label class="fw-semibold">Ekstrakurikuler</label>
                                                <select name="ekstrakurikuler_id" class="form-control" required>
                                                    @foreach($ekskul as $e)
                                                        <option value="{{ $e->id }}" {{ $row->ekstrakurikuler->nama_ekstrakurikuler == $e->nama_ekstrakurikuler ? 'selected' : '' }}>
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

                        <!-- ========== MODAL HAPUS ========== -->
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

<!-- ========== MODAL TAMBAH ========== -->
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

                    <div class="mb-3">
                        <label class="fw-semibold">Ekstrakurikuler</label>
                        <select name="ekstrakurikuler_id" class="form-select">
                            <option value="">-- Pilih Ekstrakurikuler --</option>
                                 @foreach ($ekskul as $e)
                            <option value="{{ $e->id }}">{{ $e->nama_ekstrakurikuler }}</option>
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

@endsection
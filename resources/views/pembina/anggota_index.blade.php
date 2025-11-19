@extends('layouts.template')

@section('title', 'Anggota Ekstrakurikuler')

@section('content')
<div class="container py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-0">Anggota</h3>
            <span class="text-muted">Total: {{ $anggota->count() }} anggota</span>
        </div>

        @if(Auth::check() && Auth::user()->role === 'pembina')
            <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">
                Tambah Anggota
            </button>
        @endif
    </div>

    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
        <form method="GET" action="{{ route('anggota.index') }}" class="d-flex align-items-center gap-2 mb-2 mb-md-0">
            <label for="per_page" class="fw-semibold">Tampilkan:</label>
            <select name="per_page" id="per_page" class="form-select form-select-sm" style="width: 80px;" onchange="this.form.submit()">
                @foreach([10, 20, 30, 50, 100] as $size)
                    <option value="{{ $size }}" {{ request('per_page', 10) == $size ? 'selected' : '' }}>
                        {{ $size }}
                    </option>
                @endforeach
            </select>
        </form>

        <form method="GET" action="{{ route('anggota.index') }}" class="flex-grow-1 mx-2 mb-2 mb-md-0 d-flex">
            <input type="hidden" name="per_page" value="{{ request('per_page', 10) }}">
            <input type="text" name="search" class="form-control" placeholder="Cari nama atau jabatan..." value="{{ request('search') }}" onchange="this.form.submit()">
        </form>

        <form method="GET" action="{{ route('anggota.index') }}" class="d-flex align-items-center gap-2 mb-2 mb-md-0">
            <input type="hidden" name="per_page" value="{{ request('per_page', 10) }}">
            <input type="hidden" name="search" value="{{ request('search') }}">
            <select name="ekstrakurikuler_id" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="">-- Semua Ekstrakurikuler --</option>
                @foreach($ekstrakurikulerList as $eks)
                    <option value="{{ $eks->id }}" {{ request('ekstrakurikuler_id') == $eks->id ? 'selected' : '' }}>
                        {{ $eks->nama_ekstrakurikuler }}
                    </option>
                @endforeach
            </select>
            @if(request('search') || request('ekstrakurikuler_id'))
                <a href="{{ route('anggota.index') }}" class="btn btn-outline-secondary btn-sm">Reset</a>
            @endif
        </form>
    </div>

    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th class="py-3 ps-4">No</th>
                            <th class="py-3 ps-4">Nama Anggota</th>
                            <th class="py-3 ps-4">User</th>
                            <th class="py-3 ps-4">Ekstrakurikuler</th>
                            <th class="py-3 ps-4">Jabatan</th>
                            <th class="py-3 ps-4">Tahun Ajaran</th>
                            <th class="py-3 ps-4">Status</th>
                            <th class="text-center py-3">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($anggota as $index => $item)
                        <tr>
                            <td class="ps-4 fw-semibold">{{ $loop->iteration }}</td>
                            <td class="fw-semibold text-dark">{{ $item->nama_anggota }}</td>
                            <td>{{ $item->user->id ?? '-' }}</td>
                            <td>{{ $item->ekstrakurikuler->nama_ekstrakurikuler ?? '-' }}</td>
                            <td class="text-capitalize">{{ $item->jabatan }}</td>
                            <td>{{ $item->tahun_ajaran }}</td>
                            <td>
                                <span class="badge bg-{{ $item->status_anggota === 'aktif' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($item->status_anggota) }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex flex-wrap justify-content-center gap-1">

                                    <!-- Tombol Detail -->
                                    <button class="btn btn-sm btn-primary fw-semibold"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalDetail{{ $item->id }}">
                                        <i class="bi bi-eye"></i> Detail
                                    </button>

                                    @if(Auth::check() && Auth::user()->role === 'pembina')
                                        <!-- Tombol Edit -->
                                        <button class="btn btn-sm btn-warning text-white fw-semibold"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalEdit{{ $item->id }}">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </button>

                                        <!-- Tombol Hapus -->
                                        <button class="btn btn-sm btn-danger fw-semibold"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalHapus{{ $item->id }}">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>

                        {{-- ==================== MODAL DETAIL ==================== --}}
                        <div class="modal fade" id="modalDetail{{ $item->id }}" tabindex="-1">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content border-0 shadow">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title">Detail Anggota</h5>
                                        <button class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-7">
                                                <p><strong>Nama Anggota:</strong><br>{{ $item->nama_anggota }}</p>
                                                <p><strong>User:</strong><br>{{ $item->user->id ?? '-' }}</p>
                                                <p><strong>Ekstrakurikuler:</strong><br>{{ $item->ekstrakurikuler->nama_ekstrakurikuler ?? '-' }}</p>
                                                <p><strong>Jabatan:</strong><br>{{ ucfirst($item->jabatan) }}</p>
                                                <p><strong>Tahun Ajaran:</strong><br>{{ $item->tahun_ajaran }}</p>
                                                <p><strong>Status:</strong><br>{{ ucfirst($item->status_anggota) }}</p>
                                                <p><strong>Tanggal Gabung:</strong><br>{{ $item->tanggal_gabung }}</p>
                                            </div>

                                            <div class="col-md-5 text-center">
                                                @if($item->foto && file_exists(public_path($item->foto)))
                                                    <img src="{{ asset($item->foto) }}"
                                                         class="img-fluid rounded shadow-sm border"
                                                         style="max-width: 230px; object-fit: cover;">
                                                @else
                                                    <span class="text-muted">Tidak ada foto</span>
                                                @endif
                                            </div>
                                        </div>

                                        <hr>
                                        <p class="text-muted small">
                                            <strong>Dibuat:</strong> {{ $item->created_at?->format('d M Y, H:i') }}<br>
                                            <strong>Diperbarui:</strong> {{ $item->updated_at?->format('d M Y, H:i') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if(Auth::check() && Auth::user()->role === 'pembina')
                            {{-- ==================== MODAL EDIT ==================== --}}
                            <div class="modal fade" id="modalEdit{{ $item->id }}" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content border-0 shadow">
                                        <div class="modal-header bg-warning text-white">
                                            <h5 class="modal-title">Edit Anggota</h5>
                                            <button class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <form action="{{ route('pembina.anggota.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf @method('PUT')

                                            <div class="modal-body">

                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">User</label>
                                                    <select name="user_id" class="form-select" required>
                                                        @foreach($users as $u)
                                                            <option value="{{ $u->id }}" {{ $u->id == $item->user_id ? 'selected' : '' }}>
                                                                {{ $u->nama_lengkap }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">Ekstrakurikuler</label>
                                                    <input type="text" class="form-control" value="{{ $pembinaEkskul->nama_ekstrakurikuler }}" readonly>
                                                    <input type="hidden" name="ekstrakurikuler_id" value="{{ $pembinaEkskul->id }}">
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">Nama Anggota</label>
                                                    <input type="text" name="nama_anggota" class="form-control"
                                                        value="{{ $item->nama_anggota }}" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">Jabatan</label>
                                                    <select name="jabatan" class="form-select" required>
                                                        <option value="anggota" {{ $item->jabatan == 'anggota' ? 'selected' : '' }}>Anggota</option>
                                                        <option value="pengurus" {{ $item->jabatan == 'pengurus' ? 'selected' : '' }}>Pengurus</option>
                                                        <option value="ketua" {{ $item->jabatan == 'ketua' ? 'selected' : '' }}>Ketua</option>
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">Tahun Ajaran</label>
                                                    <input type="number" name="tahun_ajaran" class="form-control"
                                                        value="{{ $item->tahun_ajaran }}" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">Status</label>
                                                    <select name="status_anggota" class="form-select" required>
                                                        <option value="aktif" {{ $item->status_anggota == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                                        <option value="tidak aktif" {{ $item->status_anggota == 'tidak aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">Foto Saat Ini</label>
                                                    <div class="mb-2 text-center">
                                                        @if($item->foto && file_exists(public_path($item->foto)))
                                                            <img src="{{ asset($item->foto) }}"
                                                                class="img-thumbnail shadow-sm rounded mb-2"
                                                                style="max-width: 180px; height:180px; object-fit:cover;">
                                                        @else
                                                            <p class="text-muted">Tidak ada foto</p>
                                                        @endif
                                                    </div>
                                                    <label class="form-label fw-semibold">Ganti Foto</label>
                                                    <input type="file" name="foto" class="form-control">
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button class="btn btn-warning text-white">Perbarui</button>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>

                            {{-- ==================== MODAL HAPUS ==================== --}}
                            <div class="modal fade" id="modalHapus{{ $item->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content border-0 shadow">
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title">Hapus Anggota</h5>
                                            <button class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <form action="{{ route('pembina.anggota.destroy', $item->id) }}" method="POST">
                                            @csrf @method('DELETE')

                                            <div class="modal-body text-center">
                                                <p class="fs-5">
                                                    Apakah kamu yakin ingin menghapus <br>
                                                    <strong>{{ $item->nama_anggota }}</strong>?
                                                </p>
                                            </div>

                                            <div class="modal-footer justify-content-center">
                                                <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button class="btn btn-danger">Ya, Hapus</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        @endif


                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                <i class="bi bi-exclamation-circle me-1"></i> Belum ada anggota.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-3 d-flex justify-content-center">
        {{ $anggota->links() }}
    </div>

</div>

@if(Auth::check() && Auth::user()->role === 'pembina')
    {{-- ==================== MODAL TAMBAH ANGGOTA ==================== --}}
    <div class="modal fade" id="modalTambah" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content border-0 shadow">
                
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Tambah Anggota</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
    
                <form action="{{ route('pembina.anggota.store') }}" method="POST">
                    @csrf
    
                    <div class="modal-body">
    
                        <div class="mb-3">
                            <label class="form-label fw-semibold">User</label>
                            <select name="user_id" class="form-select" required>
                                <option value="">-- Pilih User --</option>
                                @foreach($users as $u)
                                    <option value="{{ $u->id }}">{{ $u->nama_lengkap }}</option>
                                @endforeach
                            </select>
                        </div>
    
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Ekstrakurikuler</label>
                            <input type="text" class="form-control" value="{{ $pembinaEkskul->nama_ekstrakurikuler }}" readonly>
                            <input type="hidden" name="ekstrakurikuler_id" value="{{ $pembinaEkskul->id }}">
                        </div>
    
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Anggota</label>
                            <input type="text" name="nama_anggota" class="form-control" required>
                        </div>
    
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Jabatan</label>
                            <select name="jabatan" class="form-select" required>
                                <option value="anggota">Anggota</option>
                                <option value="pengurus">Pengurus</option>
                                <option value="ketua">Ketua</option>
                            </select>
                        </div>
    
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Tahun Ajaran</label>
                            <input type="number" name="tahun_ajaran" class="form-control" required>
                        </div>
    
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Status</label>
                            <select name="status_anggota" class="form-select" required>
                                <option value="aktif">Aktif</option>
                                <option value="tidak aktif">Tidak Aktif</option>
                            </select>
                        </div>
    
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Foto (opsional)</label>
                            <input type="file" name="foto" class="form-control">
                        </div>
    
                    </div>
    
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button class="btn btn-primary">Simpan</button>
                    </div>
    
                </form>
    
            </div>
        </div>
    </div>
@endif


@endsection
@extends('layouts.template')

@section('title', 'Pengumuman')

@section('content')
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
                            <td class="text-wrap" style="max-width: 250px; word-break: break-word;">
                                {{ Str::limit($row->isi, 50) }}
                            </td>
                            <td>
                                @if($row->foto)
                                    <img src="{{ asset('storage/' . str_replace('storage/', '', $row->foto)) }}" 
                                         class="rounded" style="width:70px; height:70px; object-fit:cover;">
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex flex-column gap-1 align-items-center">
                                    <button class="btn btn-sm fw-semibold text-white w-100"
                                            style="background-color:#0d6efd; font-size: 0.8rem; padding: 0.25rem 0.5rem;"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalDetail{{ $row->id }}">
                                        <i class="bi bi-eye me-1"></i> Detail
                                    </button>

                                    <button class="btn btn-sm fw-semibold text-white w-100"
                                            style="background-color:#dfa700; font-size: 0.8rem; padding: 0.25rem 0.5rem;"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalEdit{{ $row->id }}">
                                        <i class="bi bi-pencil-square me-1"></i> Edit
                                    </button>

                                    <button class="btn btn-sm fw-semibold text-white w-100"
                                            style="background-color:#dc3545; font-size: 0.8rem; padding: 0.25rem 0.5rem;"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalHapus{{ $row->id }}">
                                        <i class="bi bi-trash me-1"></i> Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- MODAL DETAIL -->
<div class="modal fade" id="modalDetail{{ $row->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <!-- Header -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="bi bi-info-circle me-2"></i>Detail Pengumuman</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Body -->
            <div class="modal-body p-4">
                <div class="row">
                    <!-- Kolom Kiri: Info Utama -->
                    <div class="col-md-6">
                        <div class="mb-4">
                            <h6 class="fw-bold text-primary">📌 Judul:</h6>
                            <p class="fs-5 fw-semibold">{{ $row->judul_pengumuman }}</p>
                        </div>

                        <div class="mb-4">
                            <h6 class="fw-bold text-primary">📅 Tanggal:</h6>
                            <p class="fs-5">{{ \Carbon\Carbon::parse($row->tanggal)->format('d M Y') }}</p>
                        </div>

                        <div class="mb-4">
                            <h6 class="fw-bold text-primary">📝 Deskripsi:</h6>
                            <div class="bg-light rounded p-3">
                                <p class="mb-0" style="white-space: pre-line; font-size: 0.95rem;">
                                    {{ $row->isi }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Kolom Kanan: Foto -->
                    <div class="col-md-6 text-center">
                        @if($row->foto)
                            <img src="{{ asset('storage/' . str_replace('storage/', '', $row->foto)) }}"
                                 class="img-fluid rounded shadow"
                                 style="max-width: 100%; height: auto; object-fit: cover; border: 3px solid #f8f9fa;">
                        @else
                            <div class="d-flex align-items-center justify-content-center bg-light rounded" style="height: 250px;">
                                <div class="text-center">
                                    <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                                    <p class="mt-2 text-muted">Tidak ada foto</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Footer Informasi -->
                <div class="mt-4 pt-3 border-top">
                    <small class="text-muted">
                        <i class="bi bi-clock me-1"></i> Dibuat: {{ optional($row->created_at)->format('d M Y, H:i') }}<br>
                        <i class="bi bi-pencil me-1"></i> Diperbarui: {{ optional($row->updated_at)->format('d M Y, H:i') }}
                    </small>
                </div>
            </div>

            <!-- Footer Modal -->
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i>Tutup
                </button>
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
                                                @if($row->foto)
                                                    <img src="{{ asset('storage/' . str_replace('storage/', '', $row->foto)) }}" 
                                                         class="img-fluid rounded" 
                                                         style="max-width: 200px; max-height: 200px; object-fit: cover;">
                                                @else
                                                    <p class="text-muted">Tidak ada foto</p>
                                                @endif
                                                <input type="file" name="foto" class="form-control mt-2">
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

<!-- MODAL TAMBAH -->
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

<style>
    /* Gaya tabel */
    .table {
        border-collapse: separate;
        border-spacing: 0;
    }

    /* Pemisah antar baris */
    .table tbody tr {
        border-bottom: 1px solid #e9ecef !important;
    }

    /* Hilangkan garis di baris terakhir */
    .table tbody tr:last-child {
        border-bottom: none !important;
    }

    /* Padding dalam sel agar lebih lega */
    .table tbody td {
        padding: 1.1rem 0.75rem !important;
        vertical-align: middle !important;
    }

    /* Hover effect — sangat penting untuk tampilan modern */
    .table-hover tbody tr:hover {
        background-color: #f8f9fa !important;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05) !important;
    }

    /* Kolom deskripsi agar tidak melar */
    .table tbody td:nth-child(4) {
        max-width: 250px !important;
        word-wrap: break-word !important;
        word-break: break-word !important;
    }

    /* Header table lebih kontras */
    .table thead th {
        font-weight: 600 !important;
        letter-spacing: 0.3px !important;
        background-color: #002142 !important;
        color: white !important;
    }

    /* Responsif untuk layar kecil */
    @media (max-width: 768px) {
        .table-responsive {
            font-size: 0.9rem !important;
        }
        .table tbody td {
            padding: 0.8rem 0.5rem !important;
        }
    }
</style>
@endsection
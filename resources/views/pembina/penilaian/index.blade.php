@extends('layouts.template')

@section('title', 'Penilaian')

@section('content')
<div class="container py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-dark">Daftar Penilaian</h3>

        @if(Auth::check() && Auth::user()->role === 'pembina')
        <button class="btn text-white fw-semibold"
            style="background-color:#0d6efd;"
            data-bs-toggle="modal"
            data-bs-target="#modalTambah">
            <i class="bi bi-plus-circle me-1"></i> Tambah Penilaian
        </button>
        @endif
    </div>

    <!-- ========================== FILTER + SEARCH ========================== -->
    <div class="mb-3">
        <form method="GET" action="{{ route('penilaian.index') }}" class="row g-2 align-items-center">
            
            <!-- Kiri: optional filter tambahan / jumlah data -->
            <div class="col-md-3 col-12">
                <select name="per_page" class="form-select" onchange="this.form.submit()">
                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10 per halaman</option>
                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 per halaman</option>
                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 per halaman</option>
                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100 per halaman</option>
                </select>
            </div>

            <!-- Tengah: search -->
            <div class="col-md-6 col-12">
                <input type="text" name="search" class="form-control" placeholder="Cari anggota / ekskul / semester..."
                    value="{{ request('search') }}" onchange="this.form.submit()">
            </div>

            <!-- Kanan: filter per ekskul dan semester -->
            <div class="col-md-3 col-12 d-flex gap-2">
                <select name="ekstrakurikuler_id" class="form-select" onchange="this.form.submit()">
                    <option value="">-- Semua Ekskul --</option>
                    @foreach($ekstrakurikulerList as $e)
                        <option value="{{ $e->id }}" {{ request('ekstrakurikuler_id') == $e->id ? 'selected' : '' }}>
                            {{ $e->nama_ekstrakurikuler }}
                        </option>
                    @endforeach
                </select>

                <select name="semester" class="form-select" onchange="this.form.submit()">
                    <option value="">-- Semua Semester --</option>
                    @for($i=1; $i<=6; $i++)
                        <option value="{{ $i }}" {{ request('semester') == $i ? 'selected' : '' }}>
                            Semester {{ $i }}
                        </option>
                    @endfor
                </select>
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="text-white" style="background-color: #002142;">
                        <tr>
                            <th class="py-3 ps-4">No</th>
                            <th class="py-3 ps-4">Anggota</th>
                            <th class="py-3 ps-4">Ekstrakurikuler</th>
                            <th class="py-3 ps-4">Semester</th>
                            <th class="py-3 ps-4">Tahun Ajaran</th>
                            <th class="py-3 ps-4">Keterangan</th>
                            <th class="text-center py-3 ps-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                        @forelse($penilaian as $index => $item)
                        <tr>
                            <td class="ps-4 fw-semibold">{{ $index + 1 }}</td>
                            <td>{{ $item->anggota->user->nama ?? $item->anggota->nama_anggota }}</td>
                            <td>{{ $item->ekstrakurikuler->nama_ekstrakurikuler ?? '-' }}</td>
                            <td>{{ $item->semester }}</td>
                            <td>{{ $item->tahun_ajaran }}</td>
                            <td class="text-capitalize">{{ $item->keterangan }}</td>

                            <td class="text-center">

                                <!-- Detail -->
                                <button class="btn btn-sm fw-semibold text-white me-1"
                                    style="background-color:#0d6efd;"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalDetail{{ $item->id }}">
                                    <i class="bi bi-eye"></i> Detail
                                </button>

                                @if(Auth::check() && Auth::user()->role === 'pembina')
                                <button class="btn btn-sm fw-semibold text-white me-1"
                                    style="background-color:#dfa700;"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalEdit{{ $item->id }}">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </button>

                                <!-- Hapus -->
                                <button class="btn btn-sm fw-semibold text-white"
                                    style="background-color:#dc3545;"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalHapus{{ $item->id }}">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                                @endif

                            </td>
                        </tr>

                        <!-- ========================== MODAL DETAIL ========================== -->
                        <div class="modal fade" id="modalDetail{{ $item->id }}" tabindex="-1">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content border-0 shadow">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title">Detail Penilaian</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6">

                                                <p><strong>Anggota:</strong><br>{{ $item->anggota->user->nama ?? $item->anggota->nama_anggota }}</p>
                                                <p><strong>Ekstrakurikuler:</strong><br>{{ $item->ekstrakurikuler->nama_ekstrakurikuler ?? '-' }}</p>
                                                <p><strong>Semester:</strong><br>{{ $item->semester }}</p>
                                                <p><strong>Tahun Ajaran:</strong><br>{{ $item->tahun_ajaran }}</p>
                                                <p><strong>Keterangan:</strong><br>{{ $item->keterangan }}</p>
                                                <p><strong>Catatan:</strong><br>{{ $item->catatan ?? '-' }}</p>

                                            </div>

                                            <div class="col-md-6 text-center">
                                                @if($item->foto && file_exists(storage_path('app/public/' . $item->foto)))
                                                    <img src="{{ asset('storage/' . $item->foto) }}"
                                                        class="img-fluid rounded shadow border"
                                                        style="max-width: 250px; object-fit: cover;">
                                                @else
                                                    <span class="text-muted">Tidak ada foto</span>
                                                @endif
                                            </div>

                                        </div>

                                        <hr>
                                        <p class="small text-muted mb-0">
                                            <strong>Dibuat:</strong> {{ $item->created_at?->format('d M Y, H:i') }} <br>
                                            <strong>Diperbarui:</strong> {{ $item->updated_at?->format('d M Y, H:i') }}
                                        </p>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- ========================== MODAL EDIT ========================== -->
                        <div class="modal fade" id="modalEdit{{ $item->id }}" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content border-0 shadow">

                                    <div class="modal-header text-white" style="background-color:#dfa700;">
                                        <h5 class="modal-title">Edit Penilaian</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <form action="{{ route('pembina.penilaian.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')

                                        <div class="modal-body">

                                        <div class="mb-3">
                                            <label class="fw-semibold">Anggota</label>
                                            <select name="anggota_id" class="form-control" required>
                                                <option value="">-- Pilih Anggota --</option>
                                                @if(Auth::check() && Auth::user()->role === 'pembina')
                                                    @foreach($anggota as $a)
                                                        @if($a->ekstrakurikuler_id == $pembinaEkskul->id)
                                                            <option value="{{ $a->id }}"
                                                                {{ isset($item) && $item->anggota_id == $a->id ? 'selected' : '' }}>
                                                                {{ $a->user->nama ?? $a->nama_anggota }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                @else
                                                    {{-- Semua anggota --}}
                                                    @foreach($anggota as $a)
                                                        <option value="{{ $a->id }}"
                                                            {{ isset($item) && $item->anggota_id == $a->id ? 'selected' : '' }}>
                                                            {{ $a->user->nama ?? $a->nama_anggota }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>

                                            <div class="mb-3">
                                                <label class="fw-semibold">Ekstrakurikuler</label>
                                                @if(Auth::check() && Auth::user()->role === 'pembina')
                                                    <input type="text" class="form-control" 
                                                        value="{{ $item->ekstrakurikuler->nama_ekstrakurikuler ?? '' }}" readonly>
                                                    <input type="hidden" name="ekstrakurikuler_id" 
                                                        value="{{ $item->ekstrakurikuler_id }}">
                                                @else
                                                    <select name="ekstrakurikuler_id" class="form-control" required>
                                                        @foreach($ekstrakurikulerList as $e)
                                                            <option value="{{ $e->id }}" {{ $item->ekstrakurikuler_id == $e->id ? 'selected' : '' }}>
                                                                {{ $e->nama_ekstrakurikuler }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                @endif
                                            </div>

                                            <div class="mb-3">
                                                <label class="fw-semibold">Tahun Ajaran</label>
                                                <input type="number" name="tahun_ajaran" class="form-control" value="{{ $item->tahun_ajaran }}">
                                            </div>

                                            <div class="mb-3">
                                                <label class="fw-semibold">Semester</label>
                                                <select name="semester" class="form-control">
                                                    @for($i=1; $i<=6; $i++)
                                                        <option value="{{ $i }}" {{ $item->semester == $i ? 'selected' : '' }}>
                                                        {{ $i }}
                                                        </option>
                                                        @endfor
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="fw-semibold">Keterangan</label>
                                                <select name="keterangan" class="form-control">
                                                    <option value="sangat baik" {{ $item->keterangan=='sangat baik'?'selected':'' }}>Sangat Baik</option>
                                                    <option value="baik" {{ $item->keterangan=='baik'?'selected':'' }}>Baik</option>
                                                    <option value="cukup baik" {{ $item->keterangan=='cukup baik'?'selected':'' }}>Cukup Baik</option>
                                                    <option value="cukup" {{ $item->keterangan=='cukup'?'selected':'' }}>Cukup</option>
                                                    <option value="kurang baik" {{ $item->keterangan=='kurang baik'?'selected':'' }}>Kurang Baik</option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="fw-semibold">Catatan</label>
                                                <textarea name="catatan" class="form-control">{{ $item->catatan }}</textarea>
                                            </div>

                                            <div class="mb-3">
                                                <label class="fw-semibold">Foto Saat Ini</label><br>

                                                @if($item->foto && file_exists(storage_path('app/public/' . $item->foto)))
                                                    <img src="{{ asset('storage/' . $item->foto) }}"
                                                        class="img-fluid rounded shadow border"
                                                        style="max-width: 250px; object-fit: cover;">
                                                @else
                                                    <span class="text-muted">Tidak ada foto</span>
                                                @endif
                                                {{-- @if($item->foto && file_exists(public_path($item->foto)))
                                                <img src="{{ asset($item->foto) }}"
                                                    class="img-thumbnail shadow-sm rounded mb-2"
                                                    style="max-width:180px; height:180px; object-fit:cover;">
                                                @else
                                                <p class="text-muted">Belum ada foto</p>
                                                @endif --}}

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

                        <!-- ========================== MODAL HAPUS ========================== -->
                        <div class="modal fade" id="modalHapus{{ $item->id }}">
                            <div class="modal-dialog">
                                <div class="modal-content border-0 shadow">
                                    <div class="modal-header text-white" style="background-color:#dc3545;">
                                        <h5 class="modal-title">Hapus Penilaian</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <form action="{{ route('pembina.penilaian.destroy', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <div class="modal-body text-center">
                                            <p class="fs-5">
                                                Yakin ingin menghapus penilaian
                                                <strong>{{ $item->anggota->nama ?? '-' }}</strong>?
                                            </p>
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
                                <i class="bi bi-exclamation-circle me-1"></i> Belum ada data penilaian.
                            </td>
                        </tr>
                        @endforelse

                    </tbody>
                </table>

                <div class="mt-3 px-3">
                    {{ $penilaian->links() }}
                </div>

            </div>
        </div>
    </div>
</div>

<!-- ========================== MODAL TAMBAH ========================== -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">

            <div class="modal-header text-white" style="background-color:#001f3f;">
                <h5 class="modal-title">Tambah Penilaian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('pembina.penilaian.store') }}" method="POST" enctype="multipart/form-data">
                @csrf


                <div class="modal-body">

                    <!-- Bagian dropdown Ekstrakurikuler di modal tambah -->
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

                    <!-- Bagian dropdown Anggota di modal tambah -->
                    <div class="mb-3">
                        <label class="fw-semibold">Anggota</label>
                        <select name="anggota_id" class="form-control" required>
                            <option value="">-- Pilih Anggota --</option>
                            @if(Auth::check() && Auth::user()->role === 'pembina' && $pembinaEkskul)
                                @foreach($anggota as $a)
                                    @if($a->ekstrakurikuler_id == $pembinaEkskul->id)
                                        <option value="{{ $a->id }}">
                                            {{ $a->user->nama ?? $a->nama_anggota }}
                                        </option>
                                    @endif
                                @endforeach
                            @else
                                @foreach($anggota as $a)
                                    <option value="{{ $a->id }}">
                                        {{ $a->user->nama ?? $a->nama_anggota }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="fw-semibold">Semester</label>
                        <select name="semester" class="form-control">
                            @for($i=1; $i<=6; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="fw-semibold">Keterangan</label>
                        <select name="keterangan" class="form-control">
                            <option value="sangat baik">Sangat Baik</option>
                            <option value="baik">Baik</option>
                            <option value="cukup baik">Cukup Baik</option>
                            <option value="cukup">Cukup</option>
                            <option value="kurang baik">Kurang Baik</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="fw-semibold">Catatan</label>
                        <textarea name="catatan" class="form-control"></textarea>
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
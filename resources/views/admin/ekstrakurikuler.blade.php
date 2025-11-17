@extends('layouts.template')

@section('title', 'Ekstrakurikuler')

@section('content')
<div class="container py-4">

  <div class="d-flex justify-content-between align-items-center mb-4">
      @if(Auth::check() && Auth::user()->role === 'admin')
        <button class="btn text-white fw-semibold" style="background-color:#001f3f;"
                data-bs-toggle="modal" data-bs-target="#modalTambah">
          <i class="bi bi-plus-circle me-1"></i> Tambah Ekstrakurikuler
        </button>
      @endif
  </div>

<div class="mb-3" style="max-width: 300px;">
  <form method="GET" action="{{ route('ekstrakurikuler.index') }}" class="d-flex">
    <input type="text" name="search"
           class="form-control"
           placeholder="Cari ekskul / pembina / ketua..."
           value="{{ request('search') }}"
           onchange="this.form.submit()">
    @if(request('sort'))
      <input type="hidden" name="sort" value="{{ request('sort') }}">
      <input type="hidden" name="direction" value="{{ request('direction') }}">
    @endif
  </form>
</div>

  <div class="card border-0 shadow-sm rounded-3">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead class="text-white" style="background-color: #002142;">
            <tr>
              <th class="py-3 ps-4">No</th>
              <th class="py-3 ps-4">Nama Ekstrakurikuler</th>
              <th class="py-3 ps-4">Pembina</th>
              <th class="py-3 ps-4">Ketua</th>
              <th class="py-3 ps-4">Deskripsi</th>
              <th class="text-center py-3 ps-4">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($ekstrakurikuler as $index => $item)
            <tr>
              <td class="ps-4 fw-semibold">{{ $index + 1 }}</td>
              <td class="fw-semibold text-dark">{{ $item->nama_ekstrakurikuler }}</td>
              <td>{{ $item->pembina->nama_lengkap ?? '-' }}</td>
              <td>{{ $item->ketua->nama_lengkap ?? '-' }}</td>
              <td class="text-muted">{{ Str::limit($item->deskripsi, 50) }}</td>
              <td class="text-center">
                <button class="btn btn-sm fw-semibold text-white me-1"
                      style="background-color:#0d6efd;"
                      data-bs-toggle="modal"
                      data-bs-target="#modalDetail{{ $item->id }}">
                <i class="bi bi-eye"></i> Detail
              </button>
                @if(Auth::check() && Auth::user()->role === 'admin')
                  <button class="btn btn-sm fw-semibold text-white me-1"
                          style="background-color:#dfa700;"
                          data-bs-toggle="modal"
                          data-bs-target="#modalEdit{{ $item->id }}">
                    <i class="bi bi-pencil-square"></i> Edit
                  </button>
                  <button class="btn btn-sm fw-semibold text-white"
                          style="background-color:#dc3545;"
                          data-bs-toggle="modal"
                          data-bs-target="#modalHapus{{ $item->id }}">
                    <i class="bi bi-trash"></i> Hapus
                  </button>
                @endif
              </td>
            </tr>

            <div class="modal fade" id="modalDetail{{ $item->id }}" tabindex="-1" aria-hidden="true">
              <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content border-0 shadow">
                  <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Detail Ekstrakurikuler</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                  </div>
                  <div class="modal-body">
                    <div class="row align-items-start">
                      <div class="col-md-6">
                        <p><strong>Nama:</strong><br>{{ $item->nama_ekstrakurikuler }}</p>
                        <p><strong>Pembina:</strong><br>{{ $item->pembina->nama_lengkap ?? '-' }}</p>
                        <p><strong>Ketua:</strong><br>{{ $item->ketua->nama_lengkap ?? '-' }}</p>
                        <p><strong>Deskripsi:</strong><br>{{ $item->deskripsi ?? '-' }}</p>
                      </div>
                      <div class="col-md-6 text-center">
                        @if($item->foto && file_exists(public_path($item->foto)))
                          <img src="{{ asset($item->foto) }}" 
                               class="img-fluid rounded shadow-sm border" 
                               style="max-width: 250px; object-fit: cover;">
                        @else
                          <span class="text-muted">Tidak ada foto</span>
                        @endif
                      </div>
                    </div>
                    <hr>
                    <p class="text-muted small mb-0">
                      <strong>Dibuat:</strong> {{ $item->created_at?->format('d M Y, H:i') ?? '-' }}<br>
                      <strong>Diperbarui:</strong> {{ $item->updated_at?->format('d M Y, H:i') ?? '-' }}
                    </p>
                  </div>
                </div>
              </div>
            </div>

            @if(Auth::check() && Auth::user()->role === 'admin')
              <div class="modal fade" id="modalEdit{{ $item->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content border-0 shadow">
                    <div class="modal-header text-white" style="background-color:#dfa700;">
                      <h5 class="modal-title">Edit Ekstrakurikuler</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('admin.ekstrakurikuler.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                      @csrf
                      @method('PUT')
                      <div class="modal-body">
                        <div class="mb-3">
                          <label class="form-label fw-semibold">Pembina</label>
                          <select name="user_pembina_id" class="form-select" required>
                            <option value="">-- Pilih Pembina --</option>
                            @foreach($pembina as $p)
                              <option value="{{ $p->id }}" {{ $p->id == $item->user_pembina_id ? 'selected' : '' }}>
                                {{ $p->nama_lengkap }}
                              </option>
                            @endforeach
                          </select>
                        </div>

                        <div class="mb-3">
                          <label class="form-label fw-semibold">Ketua</label>
                          <select name="user_ketua_id" class="form-select">
                            <option value="">-- Pilih Ketua --</option>
                            @foreach($ketua as $k)
                              <option value="{{ $k->id }}" {{ $k->id == $item->user_ketua_id ? 'selected' : '' }}>
                                {{ $k->nama_lengkap }}
                              </option>
                            @endforeach
                          </select>
                        </div>

                        <div class="mb-3">
                          <label class="form-label fw-semibold">Nama Ekstrakurikuler</label>
                          <input type="text" name="nama_ekstrakurikuler" class="form-control" value="{{ $item->nama_ekstrakurikuler }}" required>
                        </div>

                        <div class="mb-3">
                          <label class="form-label fw-semibold">Deskripsi</label>
                          <textarea name="deskripsi" class="form-control" rows="3">{{ $item->deskripsi }}</textarea>
                        </div>

                        <div class="mb-3">
                          <label class="form-label fw-semibold">Foto Saat Ini</label>
                          <div class="mb-2 text-center">
                            @if($item->foto && file_exists(public_path($item->foto)))
                              <img src="{{ asset($item->foto) }}" 
                                  class="img-thumbnail shadow-sm rounded"
                                  style="max-width: 180px; height: 180px; object-fit: cover;">
                            @else
                              <p class="text-muted">Belum ada foto</p>
                            @endif
                          </div>
                          <label class="form-label fw-semibold">Ganti Foto</label>
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

              <div class="modal fade" id="modalHapus{{ $item->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content border-0 shadow">
                    <div class="modal-header text-white" style="background-color:#dc3545;">
                      <h5 class="modal-title">Hapus Ekstrakurikuler</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('admin.ekstrakurikuler.destroy', $item->id) }}" method="POST">
                      @csrf
                      @method('DELETE')
                      <div class="modal-body text-center">
                        <p class="fs-5">Apakah kamu yakin ingin menghapus <strong>{{ $item->nama_ekstrakurikuler }}</strong>?</p>
                      </div>
                      <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            @endif

            @empty
            <tr>
              <td colspan="7" class="text-center py-4 text-muted">
                <i class="bi bi-exclamation-circle me-1"></i> Belum ada data ekstrakurikuler.
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>

        <div class="mt-3 px-3">
            {{ $ekstrakurikuler->links() }}
        </div>

      </div>
    </div>
  </div>
</div>

  @if(Auth::check() && Auth::user()->role === 'admin')
    <div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
          <div class="modal-header text-white" style="background-color:#001f3f;">
            <h5 class="modal-title">Tambah Ekstrakurikuler</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <form action="{{ route('admin.ekstrakurikuler.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
              <div class="mb-3">
                <label class="form-label fw-semibold">Pembina</label>
                <select name="user_pembina_id" class="form-select" required>
                  <option value="">-- Pilih Pembina --</option>
                  @foreach($pembina as $p)
                    <option value="{{ $p->id }}">{{ $p->nama_lengkap }}</option>
                  @endforeach
                </select>
              </div>

              <div class="mb-3">
                <label class="form-label fw-semibold">Ketua</label>
                <select name="user_ketua_id" class="form-select">
                  <option value="">-- Pilih Ketua --</option>
                  @foreach($ketua as $k)
                    <option value="{{ $k->id }}">{{ $k->nama_lengkap }}</option>
                  @endforeach
                </select>
              </div>

              <div class="mb-3">
                <label class="form-label fw-semibold">Nama Ekstrakurikuler</label>
                <input type="text" name="nama_ekstrakurikuler" class="form-control" required>
              </div>

              <div class="mb-3">
                <label class="form-label fw-semibold">Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="3"></textarea>
              </div>

              <div class="mb-3">
                <label class="form-label fw-semibold">Foto</label>
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

@endsection
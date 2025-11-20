@extends('layouts.template')
@section('title', 'Ekstrakurikuler')

@section('content')
  @if(Auth::check() && Auth::user()->role === 'admin')
    <div class="container py-4">

      <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-dark">Daftar Ekstrakurikuler</h3>
            <button class="btn text-white fw-semibold" style="background-color:#001f3f;"
                    data-bs-toggle="modal" data-bs-target="#modalTambah">
              <i class="bi bi-plus-circle me-1"></i> Tambah Ekstrakurikuler
            </button>
      </div>

      <div class="mb-3" style="max-width: 300px;">
        <form method="GET" action="{{ route('ekstrakurikuler.index') }}" class="d-flex">
          <input type="text" name="search"
                class="form-control"
                placeholder="Cari..."
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
                                <label for="pendaftaran_dibuka" class="form-label">Buka Pendaftaran</label>
                                <select name="pendaftaran_dibuka" id="pendaftaran_dibuka" class="form-control">
                                    <option value="0">Tutup</option>
                                    <option value="1">Buka</option>
                                </select>
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
                                      <input type="text" 
                                            name="search" 
                                            class="form-control border-start-0" 
                                            placeholder="Cari nama ekstrakurikuler, pembina, atau ketua..."
                                            value="{{ request('search') }}">
                                  </div>
                              </div>

                              <div class="col-md-4">
                                  <select name="sort" class="form-select" onchange="document.getElementById('filterForm').submit()">
                                      <option value="">Urutkan</option>
                                      <option value="nama_asc" {{ request('sort') == 'nama_asc' ? 'selected' : '' }}>Nama A-Z</option>
                                      <option value="nama_desc" {{ request('sort') == 'nama_desc' ? 'selected' : '' }}>Nama Z-A</option>
                                      <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                                      <option value="terlama" {{ request('sort') == 'terlama' ? 'selected' : '' }}>Terlama</option>
                                  </select>
                              </div>
                          </div>

                          <div class="mt-3 d-flex flex-wrap gap-2">
                              <span class="text-muted small">Cepat:</span>
                              <a href="{{ route('ekstrakurikuler.index') }}" 
                                class="badge bg-secondary text-decoration-none py-2 px-3">
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
                          <img src="{{ asset($item->foto) }}" 
                              class="card-img-top w-100 h-100" 
                              style="object-fit: cover;"
                              alt="{{ $item->nama_ekstrakurikuler }}">
                      @else
                          <div class="w-100 h-100 bg-gradient d-flex align-items-center justify-content-center"
                              style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                              <i class="bi bi-mortarboard text-white" style="font-size: 4rem; opacity: 0.3;"></i>
                          </div>
                      @endif
                      
                      <div class="position-absolute top-0 end-0 m-3">
                          @if($item->pembina && $item->ketua)
                              <span class="badge bg-success bg-opacity-90 px-3 py-2">
                                  <i class="bi bi-check-circle me-1"></i>Aktif
                              </span>
                          @else
                              <span class="badge bg-warning bg-opacity-90 px-3 py-2">
                                  <i class="bi bi-exclamation-circle me-1"></i>Rekrutmen
                              </span>
                          @endif

                          @auth
                              @if(auth()->user()->role === 'siswa')
                              <button class="btn btn-primary"
                                      data-bs-toggle="modal"
                                      data-bs-target="#modalDaftar{{ $item->id }}">
                                  Daftar
                              </button>
                              @endif
                          @endauth
                      </div>
                  </div>

                  <div class="card-body d-flex flex-column">
                      <h5 class="card-title fw-bold mb-3">{{ $item->nama_ekstrakurikuler }}</h5>

                      <div class="mb-3 flex-grow-1">
                          <div class="d-flex align-items-start text-muted mb-2">
                              <i class="bi bi-person-badge me-2 text-primary mt-1"></i>
                              <small>
                                  <strong>Pembina:</strong><br>
                                  {{ $item->pembina->nama_lengkap ?? 'Belum ditentukan' }}
                              </small>
                          </div>
                          <div class="d-flex align-items-start text-muted mb-2">
                              <i class="bi bi-person-check me-2 text-success mt-1"></i>
                              <small>
                                  <strong>Ketua:</strong><br>
                                  {{ $item->ketua->nama_lengkap ?? 'Belum ditentukan' }}
                              </small>
                          </div>
                          <div class="d-flex align-items-start text-muted">
                              <i class="bi bi-card-text me-2 text-info mt-1"></i>
                              <small>{{ Str::limit($item->deskripsi, 80) ?? 'Tidak ada deskripsi' }}</small>
                          </div>
                      </div>

                      <button class="btn btn-primary w-100"
                              data-bs-toggle="modal"
                              data-bs-target="#modalDetailInfo{{ $item->id }}">
                          <i class="bi bi-eye me-2"></i>Lihat Detail
                      </button>
                  </div>
              </div>
          </div>

          <!-- detail -->
          <div class="modal fade" id="modalDetailInfo{{ $item->id }}" tabindex="-1">
              <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                  <div class="modal-content border-0 shadow-lg">
                      <div class="position-relative" style="height: 250px; overflow: hidden;">
                          @if($item->foto && file_exists(public_path($item->foto)))
                              <img src="{{ asset($item->foto) }}" 
                                  class="w-100 h-100" 
                                  style="object-fit: cover; filter: brightness(0.7);"
                                  alt="{{ $item->nama_ekstrakurikuler }}">
                          @else
                              <div class="w-100 h-100 bg-gradient"
                                  style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);"></div>
                          @endif
                          
                          <div class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-end p-4"
                              style="background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);">
                              @if($item->pembina && $item->ketua)
                                  <span class="badge bg-success mb-2 align-self-start">
                                      <i class="bi bi-check-circle me-1"></i>Aktif
                                  </span>
                              @else
                                  <span class="badge bg-warning text-dark mb-2 align-self-start">
                                      <i class="bi bi-exclamation-circle me-1"></i>Rekrutmen
                                  </span>
                              @endif
                              <h3 class="text-white fw-bold mb-0">{{ $item->nama_ekstrakurikuler }}</h3>
                          </div>
                          
                          <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" 
                                  data-bs-dismiss="modal"></button>
                      </div>

                      <div class="modal-body p-4">
                          <div class="row g-3 mb-4">
                              <div class="col-md-6">
                                  <div class="card bg-light border-0">
                                      <div class="card-body p-3">
                                          <div class="d-flex align-items-center">
                                              <div class="rounded bg-primary bg-opacity-10 p-3 me-3">
                                                  <i class="bi bi-person-badge text-primary fs-4"></i>
                                              </div>
                                              <div>
                                                  <small class="text-muted d-block">Pembina</small>
                                                  <strong>{{ $item->pembina->nama_lengkap ?? 'Belum ditentukan' }}</strong>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="card bg-light border-0">
                                      <div class="card-body p-3">
                                          <div class="d-flex align-items-center">
                                              <div class="rounded bg-success bg-opacity-10 p-3 me-3">
                                                  <i class="bi bi-person-check text-success fs-4"></i>
                                              </div>
                                              <div>
                                                  <small class="text-muted d-block">Ketua</small>
                                                  <strong>{{ $item->ketua->nama_lengkap ?? 'Belum ditentukan' }}</strong>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>

                          <div class="mb-4">
                              <h5 class="fw-bold mb-3">
                                  <i class="bi bi-info-circle text-primary me-2"></i>Informasi Detail
                              </h5>
                              
                              <div class="card bg-light border-0">
                                  <div class="card-body">
                                      <div class="mb-3">
                                          <small class="text-muted d-block mb-1">
                                              <i class="bi bi-mortarboard me-2"></i>Nama Ekstrakurikuler
                                          </small>
                                          <h6 class="mb-0">{{ $item->nama_ekstrakurikuler }}</h6>
                                      </div>
                                  </div>
                              </div>
                          </div>

                          @if($item->deskripsi)
                          <div class="mb-4">
                              <h5 class="fw-bold mb-3">
                                  <i class="bi bi-card-text text-primary me-2"></i>Deskripsi
                              </h5>
                              <div class="bg-light rounded p-3">
                                  <p class="mb-0" style="white-space: pre-line;">{{ $item->deskripsi }}</p>
                              </div>
                          </div>
                          @else
                          <div class="mb-4">
                              <h5 class="fw-bold mb-3">
                                  <i class="bi bi-card-text text-primary me-2"></i>Deskripsi
                              </h5>
                              <div class="bg-light rounded p-3">
                                  <p class="text-muted mb-0 fst-italic">Deskripsi belum tersedia</p>
                              </div>
                          </div>
                          @endif

                          @if($item->pembina || $item->ketua)
                          <div class="mb-4">
                              <h5 class="fw-bold mb-3">
                                  <i class="bi bi-telephone text-primary me-2"></i>Kontak
                              </h5>
                              <div class="row g-3">
                                  @if($item->pembina)
                                  <div class="col-md-6">
                                      <div class="card border-0 bg-light">
                                          <div class="card-body">
                                              <small class="text-muted">Pembina</small>
                                              <h6 class="mb-1">{{ $item->pembina->nama_lengkap }}</h6>
                                              @if($item->pembina->email)
                                                  <small class="text-muted">
                                                      <i class="bi bi-envelope me-1"></i>{{ $item->pembina->email }}
                                                  </small>
                                              @endif
                                          </div>
                                      </div>
                                  </div>
                                  @endif
                                  
                                  @if($item->ketua)
                                  <div class="col-md-6">
                                      <div class="card border-0 bg-light">
                                          <div class="card-body">
                                              <small class="text-muted">Ketua</small>
                                              <h6 class="mb-1">{{ $item->ketua->nama_lengkap }}</h6>
                                              @if($item->ketua->email)
                                                  <small class="text-muted">
                                                      <i class="bi bi-envelope me-1"></i>{{ $item->ketua->email }}
                                                  </small>
                                              @endif
                                          </div>
                                      </div>
                                  </div>
                                  @endif
                              </div>
                          </div>
                          @endif

                          <div class="border-top pt-3">
                              <small class="text-muted">
                                  <i class="bi bi-clock-history me-1"></i>
                                  Terakhir diperbarui: {{ $item->updated_at?->format('d M Y, H:i') ?? '-' }}
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

      <div class="modal fade" id="modalDaftar{{ $item->id }}" tabindex="-1">
          <div class="modal-dialog">
              <form action="{{ route('pendaftaran.store') }}" method="POST" enctype="multipart/form-data" class="modal-content">
                  @csrf
                  <div class="modal-header">
                      <h5 class="modal-title">Form Pendaftaran</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                  </div>

                  <div class="modal-body">

                      <!-- kirim id ekskul -->
                      <input type="hidden" name="ekstrakurikuler_id" value="{{ $item->id }}">

                      <div class="mb-3">
                          <label class="form-label">Ekstrakurikuler</label>
                          <input type="text" class="form-control" 
                                value="{{ $item->nama_ekstrakurikuler }}" disabled>
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
      .bg-gradient {
          background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      }
    </style>
    <script>
      document.addEventListener('DOMContentLoaded', function () {
          var modal = document.getElementById('modalPendaftaran');
          modal.addEventListener('show.bs.modal', function (event) {
              var button = event.relatedTarget;
              var ekskulId = button.getAttribute('data-ekskul-id');
              var ekskulNama = button.getAttribute('data-ekskul-nama');

              // isi input
              document.getElementById('modalEkstrakurikulerId').value = ekskulId;
              document.getElementById('modalEkstrakurikulerNama').value = ekskulNama;

              // optionally fetch pendaftaran info (mulai/selesai) via data attributes or AJAX
              // Jika kamu ingin menampilkan tanggal pendaftaran pada modal, kamu bisa
              // menambahkan data-pendaftaran-mulai/data-pendaftaran-selesai pada tombol dan baca di sini.
              var infoNode = document.getElementById('infoTanggalPendaftaran');
              var mulai = button.getAttribute('data-pendaftaran-mulai');
              var selesai = button.getAttribute('data-pendaftaran-selesai');
              if (mulai || selesai) {
                  infoNode.textContent = 'Periode pendaftaran: ' + (mulai ? mulai : '-') + ' s/d ' + (selesai ? selesai : '-');
              } else {
                  infoNode.textContent = '';
              }
          });
      });
    </script>

  @endif
@endsection
@extends('layouts.template')

@section('title', 'Data User')

@section('content')
    <div class="container py-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold text-dark mb-0">User</h3>
                <span class="text-muted">Total: {{ $users->count() }} user</span>
            </div>

            <div>
                <button class="btn btn-primary fw-semibold"
                    data-bs-toggle="modal"
                    data-bs-target="#modalTambahUser">
                    <i class="bi bi-plus-circle me-1"></i> Tambah User
                </button>
            </div>
        </div>

        <a href="{{ route('admin.user.export.excel') }}" 
            class="btn btn-success fw-semibold me-2">
            <i class="bi bi-file-earmark-excel"></i> Export Excel
        </a>
        <a href="{{ route('admin.user.export.pdf') }}" class="btn btn-danger fw-semibold">
            <i class="bi bi-file-earmark-pdf"></i> Export PDF
        </a>

        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table id="tabel-user" class="table table-hover align-middle mb-0">
                        <thead class="bg-dark text-white">
                            <tr>
                                <th class="py-3 ps-4">No</th>
                                <th class="py-3 ps-4 text-center">Foto</th> 
                                <th class="py-3 ps-4">Nama Lengkap</th>
                                <th class="py-3 ps-4">Email</th>
                                <th class="py-3 ps-4">Role</th>
                                <th class="py-3 ps-4">Status</th>
                                <th class="text-center py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $index => $user)
                            <tr>
                                <td class="ps-4 fw-semibold">{{ $loop->iteration }}</td>
                                <td class="text-center">
                                    @if($user->foto && file_exists(public_path($user->foto)))
                                        <img src="{{ asset($user->foto) }}"
                                            class="shadow-sm border"
                                            style="width:80px; height:80px; object-fit:cover; border-radius:50%;">
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="fw-semibold text-dark">{{ $user->nama_lengkap }}</td>
                                <td>{{ $user->email }}</td>
                                <td class="text-capitalize">{{ $user->role }}</td>
                                <td>
                                    <span class="badge bg-{{ $user->status_aktif ? 'success' : 'secondary' }}">
                                        {{ $user->status_aktif ? 'Aktif' : 'Tidak Aktif' }}
                                    </span>
                                </td>
                                <td class="text-center">

                                    <button class="btn btn-sm btn-primary me-1 fw-semibold"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalDetailUser{{ $user->id }}">
                                        <i class="bi bi-eye"></i> Detail
                                    </button>

                                    <button class="btn btn-sm btn-warning me-1 fw-semibold text-white"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalEditUser{{ $user->id }}">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </button>

                                    <button class="btn btn-sm btn-danger fw-semibold"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalHapusUser{{ $user->id }}">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>

                                </td>
                            </tr>

                            {{-- ==================== MODAL DETAIL ==================== --}}
                            <div class="modal fade" id="modalDetailUser{{ $user->id }}" tabindex="-1">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content border-0 shadow">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title">Detail User</h5>
                                            <button class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-7">
                                                    <p><strong>Nama Lengkap:</strong><br>{{ $user->nama_lengkap }}</p>
                                                    <p><strong>Email:</strong><br>{{ $user->email }}</p>
                                                    <p><strong>Role:</strong><br>{{ ucfirst($user->role) }}</p>
                                                    <p><strong>Status:</strong><br>{{ $user->status_aktif ? 'Aktif' : 'Tidak Aktif' }}</p>
                                                </div>
                                                <div class="col-md-5 text-center">
                                                    @if($user->foto && file_exists(public_path($user->foto)))
                                                        <img src="{{ asset($user->foto) }}"
                                                            class="img-fluid rounded shadow-sm border"
                                                            style="max-width: 230px; object-fit: cover;">
                                                    @else
                                                        <span class="text-muted">Tidak ada foto</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <hr>
                                            <p class="text-muted small">
                                                <strong>Dibuat:</strong> {{ $user->created_at?->format('d M Y, H:i') }}<br>
                                                <strong>Diperbarui:</strong> {{ $user->updated_at?->format('d M Y, H:i') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- ==================== MODAL EDIT ==================== --}}
                            <div class="modal fade" id="modalEditUser{{ $user->id }}" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content border-0 shadow">
                                        <div class="modal-header bg-warning text-white">
                                            <h5 class="modal-title">Edit User</h5>
                                            <button class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <form action="{{ route('admin.user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf @method('PUT')
                                            <div class="modal-body">

                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">Nama Lengkap</label>
                                                    <input type="text" name="nama_lengkap" class="form-control"
                                                        value="{{ $user->nama_lengkap }}" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">Email</label>
                                                    <input type="email" name="email" class="form-control"
                                                        value="{{ $user->email }}" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">Password (kosongkan jika tidak diganti)</label>
                                                    <input type="password" name="password" class="form-control">
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">Konfirmasi Password</label>
                                                    <input type="password" name="password_confirmation" class="form-control">
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">Role</label>
                                                    <select name="role" class="form-select" required>
                                                        @foreach(['admin','pembina','ketua','siswa'] as $role)
                                                            <option value="{{ $role }}" {{ $user->role == $role ? 'selected' : '' }}>
                                                                {{ ucfirst($role) }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">Status</label>
                                                    <select name="status_aktif" class="form-select" required>
                                                        <option value="1" {{ $user->status_aktif ? 'selected' : '' }}>Aktif</option>
                                                        <option value="0" {{ !$user->status_aktif ? 'selected' : '' }}>Tidak Aktif</option>
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold">Foto Saat Ini</label>
                                                    <div class="mb-2 text-center">
                                                        @if($user->foto && file_exists(public_path($user->foto)))
                                                            <img src="{{ asset($user->foto) }}"
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
                            <div class="modal fade" id="modalHapusUser{{ $user->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content border-0 shadow">
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title">Hapus User</h5>
                                            <button class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST">
                                            @csrf @method('DELETE')

                                            <div class="modal-body text-center">
                                                <p class="fs-5">
                                                    Apakah kamu yakin ingin menghapus <br>
                                                    <strong>{{ $user->nama_lengkap }}</strong>?
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

                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">
                                    <i class="bi bi-exclamation-circle me-1"></i> Belum ada user.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalTambahUser" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content border-0 shadow">
                
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Tambah User</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ route('admin.user.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>

                        <div class="mb-3 position-relative">
                            <label class="form-label fw-semibold">Password</label>
                            <input type="password" name="password" class="form-control" id="password" required>

                            <span class="position-absolute top-50 end-0 translate-middle-y me-3"
                                style="cursor:pointer;" onclick="togglePassword('password', this)">
                                <i class="fas fa-eye"></i>
                            </span>
                        </div>

                        <div class="mb-3 position-relative">
                            <label class="form-label fw-semibold">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" required>

                            <span class="position-absolute top-50 end-0 translate-middle-y me-3"
                                style="cursor:pointer;" onclick="togglePassword('password_confirmation', this)">
                                <i class="fas fa-eye"></i>
                            </span>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Role</label>
                            <select name="role" class="form-select" required>
                                @foreach(['admin','pembina','ketua','siswa'] as $role)
                                    <option value="{{ $role }}">{{ ucfirst($role) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Status</label>
                            <select name="status_aktif" class="form-select" required>
                                <option value="1" selected>Aktif</option>
                                <option value="0">Tidak Aktif</option>
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

    <script>
        function togglePassword(fieldId, iconElement) {
            const input = document.getElementById(fieldId);
            const icon = iconElement.querySelector('i');

            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                input.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }
    </script>

@endsection
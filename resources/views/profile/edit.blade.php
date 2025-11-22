@extends('layouts.template')

@section('content')
<div class="container-fluid bg-light min-vh-100 py-5">
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-4">
            <!-- Profile Preview Section -->
            <div class="col-lg-4">
                <div class="bg-white rounded-4 shadow-sm p-4 text-center sticky-top">
                    <div class="position-relative d-inline-block mb-4">
                        <img src="{{ asset(Auth::user()->foto ?? 'default/default-user.jpg') }}"
                             alt="Foto Profil"
                             class="rounded-circle border border-4 border-primary shadow"
                             width="160"
                             height="160">
                        <span class="position-absolute bottom-0 end-0 bg-success rounded-circle border border-3 border-white" 
                              style="width: 30px; height: 30px;"></span>
                    </div>
                    <h4 class="fw-bold mb-1">{{ $user->nama_lengkap }}</h4>
                    <p class="text-muted mb-4">{{ $user->email }}</p>
                    <div class="border-top pt-3">
                        <small class="text-muted d-block mb-2">Bergabung sejak</small>
                        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2">
                            {{ $user->created_at->format('d M Y') }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Edit Form Section -->
            <div class="col-lg-8">
                <div class="bg-white rounded-4 shadow-sm p-4 p-lg-5">
                    <div class="mb-5">
                        <h2 class="fw-bold mb-2">Pengaturan Profil</h2>
                        <p class="text-muted mb-0">Perbarui informasi profil dan foto Anda</p>
                    </div>

                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Nama Lengkap -->
                        <div class="mb-4">
                            <label for="nama_lengkap" class="form-label fw-semibold mb-2">
                                <i class="bi bi-person-fill text-primary me-2"></i>Nama Lengkap
                            </label>
                            <input type="text" 
                                   name="nama_lengkap" 
                                   id="nama_lengkap"
                                   value="{{ old('nama_lengkap', $user->nama_lengkap) }}" 
                                   class="form-control form-control-lg border-2 @error('nama_lengkap') is-invalid @enderror"
                                   placeholder="Masukkan nama lengkap"
                                   required>
                            @error('nama_lengkap')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-4">
                            <label for="email" class="form-label fw-semibold mb-2">
                                <i class="bi bi-envelope-fill text-primary me-2"></i>Alamat Email
                            </label>
                            <input type="email" 
                                   name="email" 
                                   id="email"
                                   value="{{ old('email', $user->email) }}" 
                                   class="form-control form-control-lg border-2 @error('email') is-invalid @enderror"
                                   placeholder="nama@email.com"
                                   required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Upload Foto -->
                        <div class="mb-5">
                            <label for="foto" class="form-label fw-semibold mb-3">
                                <i class="bi bi-camera-fill text-primary me-2"></i>Foto Profil
                            </label>
                            
                            <div class="border border-2 border-dashed rounded-3 p-4 bg-light">
                                <div class="d-flex flex-column flex-md-row align-items-center gap-3">
                                    <img src="{{ asset(Auth::user()->foto ?? 'default/default-user.jpg') }}"
                                         alt="Preview"
                                         class="rounded-3 border border-2 border-white shadow-sm"
                                         width="100"
                                         height="100">
                                    
                                    <div class="flex-grow-1">
                                        <input type="file" 
                                               name="foto" 
                                               id="foto"
                                               class="form-control @error('foto') is-invalid @enderror"
                                               accept="image/*">
                                        <small class="text-muted d-block mt-2">
                                            <i class="bi bi-info-circle me-1"></i>
                                            JPG, PNG, atau JPEG. Maksimal 2MB
                                        </small>
                                        @error('foto')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex flex-column flex-md-row gap-3 pt-4 border-top">
                            <button type="submit" class="btn btn-primary btn-lg px-5 flex-grow-1 flex-md-grow-0">
                                <i class="bi bi-check-lg me-2"></i>Simpan Perubahan
                            </button>
                            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-lg px-5 flex-grow-1 flex-md-grow-0">
                                <i class="bi bi-x-lg me-2"></i>Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
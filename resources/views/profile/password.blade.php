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
            <!-- Security Info Section -->
            <div class="col-lg-4">
                <div class="bg-white rounded-4 shadow-sm p-4 sticky-top">
                    <div class="text-center mb-4">
                        <div class="position-relative d-inline-block mb-4">
                          <img src="{{ asset(Auth::user()->foto ?? 'default/default-user.jpg') }}"
                              alt="Foto Profil"
                              class="rounded-circle border border-4 border-primary shadow"
                              width="160"
                              height="160">
                          <span class="position-absolute bottom-0 end-0 bg-success rounded-circle border border-3 border-white" 
                                style="width: 30px; height: 30px;"></span>
                      </div>
                        <h4 class="fw-bold mb-2">Keamanan Akun</h4>
                        <p class="text-muted small mb-0">Lindungi akun Anda dengan password yang kuat</p>
                    </div>

                    <div class="border-top pt-4">
                        <h6 class="fw-semibold mb-3">Tips Password Aman:</h6>
                        <ul class="list-unstyled small text-muted">
                            <li class="mb-2">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                Minimal 8 karakter
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                Kombinasi huruf & angka
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                Gunakan karakter khusus
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                Jangan gunakan info pribadi
                            </li>
                        </ul>
                    </div>

                    <div class="alert alert-info border-0 bg-info bg-opacity-10 mt-4" role="alert">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        <small>Password Anda terakhir diubah pada {{ Auth::user()->updated_at->format('d M Y') }}</small>
                    </div>
                </div>
            </div>

            <!-- Edit Password Form Section -->
            <div class="col-lg-8">
                <div class="bg-white rounded-4 shadow-sm p-4 p-lg-5">
                    <div class="mb-5">
                        <h2 class="fw-bold mb-2">Ubah Password</h2>
                        <p class="text-muted mb-0">Pastikan password Anda kuat dan mudah diingat</p>
                    </div>

                    <form action="{{ route('profile.password.update') }}" method="POST">
                        @csrf
                        
                        <!-- Password Lama -->
                        <div class="mb-4">
                            <label for="password_lama" class="form-label fw-semibold mb-2">
                                <i class="bi bi-key-fill text-primary me-2"></i>Password Lama
                            </label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-white border-2">
                                    <i class="bi bi-lock-fill text-muted"></i>
                                </span>
                                <input type="password" 
                                       name="password_lama" 
                                       id="password_lama"
                                       class="form-control border-2 @error('password_lama') is-invalid @enderror"
                                       placeholder="Masukkan password lama"
                                       required>
                                <button class="btn btn-outline-secondary border-2" 
                                        type="button"
                                        data-toggle-password="password_lama">
                                    <i class="bi bi-eye"></i>
                                </button>
                                @error('password_lama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Password Baru -->
                        <div class="mb-4">
                            <label for="password" class="form-label fw-semibold mb-2">
                                <i class="bi bi-key-fill text-primary me-2"></i>Password Baru
                            </label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-white border-2">
                                    <i class="bi bi-lock-fill text-muted"></i>
                                </span>
                                <input type="password" 
                                       name="password" 
                                       id="password"
                                       class="form-control border-2 @error('password') is-invalid @enderror"
                                       placeholder="Masukkan password baru"
                                       required>
                                <button class="btn btn-outline-secondary border-2" 
                                        type="button"
                                        data-toggle-password="password">
                                    <i class="bi bi-eye"></i>
                                </button>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="text-muted d-block mt-2">
                                <i class="bi bi-info-circle me-1"></i>
                                Minimal 8 karakter dengan kombinasi huruf, angka, dan simbol
                            </small>
                        </div>

                        <!-- Konfirmasi Password Baru -->
                        <div class="mb-5">
                            <label for="password_confirmation" class="form-label fw-semibold mb-2">
                                <i class="bi bi-check2-circle text-primary me-2"></i>Konfirmasi Password Baru
                            </label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-white border-2">
                                    <i class="bi bi-lock-fill text-muted"></i>
                                </span>
                                <input type="password" 
                                       name="password_confirmation" 
                                       id="password_confirmation"
                                       class="form-control border-2"
                                       placeholder="Ulangi password baru"
                                       required>
                                <button class="btn btn-outline-secondary border-2" 
                                        type="button"
                                        data-toggle-password="password_confirmation">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex flex-column flex-md-row gap-3 pt-4 border-top">
                            <button type="submit" class="btn btn-primary btn-lg px-5 flex-grow-1 flex-md-grow-0">
                                <i class="bi bi-shield-check me-2"></i>Simpan Password
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggleButtons = document.querySelectorAll('[data-toggle-password]');
    
    toggleButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-toggle-password');
            const input = document.getElementById(targetId);
            const icon = this.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        });
    });
});
</script>

@endsection
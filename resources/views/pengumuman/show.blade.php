@extends('layouts.')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                <!-- Header Image -->
                <div class="position-relative" style="height: 300px; overflow: hidden;">
                    @if($pengumuman->foto)
                        <img src="{{ asset('storage/' . str_replace('storage/', '', $pengumuman->foto)) }}" 
                             class="w-100 h-100" 
                             style="object-fit: cover; filter: brightness(0.9);">
                        <!-- Overlay gradient -->
                        <div class="position-absolute bottom-0 w-100" style="background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);">
                            <div class="p-4">
                                <h1 class="text-white fw-bold mb-0">{{ $pengumuman->judul_pengumuman }}</h1>
                            </div>
                        </div>
                    @else
                        <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-gradient-primary">
                            <i class="bi bi-megaphone text-white" style="font-size: 6rem; opacity: 0.3;"></i>
                        </div>
                        <div class="position-absolute bottom-0 w-100 bg-dark bg-opacity-75">
                            <div class="p-4">
                                <h1 class="text-white fw-bold mb-0">{{ $pengumuman->judul_pengumuman }}</h1>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="card-body p-4">
                    <!-- Info Tanggal -->
                    <div class="text-center mb-4">
                        <span class="badge bg-primary text-white px-3 py-2 rounded-pill">
                            <i class="bi bi-calendar3 me-1"></i>
                            {{ \Carbon\Carbon::parse($pengumuman->tanggal)->format('d F Y') }}
                        </span>
                    </div>

                    <!-- Isi Pengumuman -->
                    <div class="border rounded-3 p-4 bg-light">
                        <h5 class="fw-bold text-primary mb-3">
                            <i class="bi bi-card-text me-2"></i>Isi Pengumuman
                        </h5>
                        <div class="content-text">
                            <p class="mb-0" style="white-space: pre-line; line-height: 1.7; font-size: 1.05rem;">
                                {{ $pengumuman->isi }}
                            </p>
                        </div>
                    </div>

                    <!-- Informasi Tambahan -->
                    <div class="mt-4 p-3 bg-white border rounded-3">
                        <div class="row text-muted small">
                            <div class="col-6">
                                <i class="bi bi-clock me-1"></i>
                                Dibuat: {{ optional($pengumuman->created_at)->format('d M Y, H:i') }}
                            </div>
                            <div class="col-6 text-end">
                                <i class="bi bi-pencil me-1"></i>
                                Diperbarui: {{ optional($pengumuman->updated_at)->format('d M Y, H:i') }}
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Kembali -->
                    <div class="mt-4 text-center">
                        <a href="{{ route('pengumuman.index') }}" class="btn btn-outline-secondary px-4 py-2">
                            <i class="bi bi-arrow-left me-1"></i>Kembali ke Daftar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #0d6efd 0%, #002142 100%);
}
.content-text p {
    text-align: justify;
    hyphens: auto;
}
@media (max-width: 768px) {
    .content-text p {
        text-align: left;
        font-size: 0.95rem;
    }
}
</style>
@endsection
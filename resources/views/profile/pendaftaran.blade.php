@extends('layouts.template')

@section('title', 'Pendaftaran Saya')

@section('content')
<div class="container-fluid bg-light min-vh-100 py-5">
    <div class="container">
        
        <!-- Header Section -->
        <div class="bg-white rounded-4 shadow-sm p-4 mb-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                <div>
                    <h2 class="fw-bold mb-2">Pendaftaran Saya</h2>
                    <p class="text-muted mb-0">
                        <i class="bi bi-list-check me-2"></i>
                        Total <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2">{{ $pendaftaran->count() }} pendaftaran</span>
                    </p>
                </div>
                
                <div class="d-flex gap-2">
                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-2">
                        <i class="bi bi-check-circle-fill me-1"></i> Disetujui: {{ $pendaftaran->where('status', 'disetujui')->count() }}
                    </span>
                    <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2">
                        <i class="bi bi-clock-fill me-1"></i> Menunggu: {{ $pendaftaran->where('status', 'menunggu')->count() }}
                    </span>
                    <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2">
                        <i class="bi bi-x-circle-fill me-1"></i> Ditolak: {{ $pendaftaran->where('status', 'ditolak')->count() }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Cards Grid -->
        <div class="row g-4">
            @forelse ($pendaftaran as $p)
            <div class="col-lg-6">
                <div class="bg-white rounded-4 shadow-sm h-100 overflow-hidden">
                    
                    <!-- Card Header -->
                    <div class="bg-primary bg-opacity-10 p-4 border-bottom border-primary border-opacity-25">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <h5 class="fw-bold mb-2">{{ $p->ekstrakurikuler->nama_ekstrakurikuler ?? '-' }}</h5>
                                <small class="text-muted">
                                    <i class="bi bi-calendar3 me-1"></i>
                                    {{ $p->created_at->format('d M Y, H:i') }}
                                </small>
                            </div>
                            <span class="badge bg-{{ 
                                $p->status === 'disetujui' ? 'success' : 
                                ($p->status === 'menunggu' ? 'warning text-dark' : 'danger')
                            }} px-3 py-2">
                                {{ ucfirst($p->status) }}
                            </span>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="p-4">
                        <div class="mb-3">
                            <label class="text-muted small fw-semibold mb-2">
                                <i class="bi bi-chat-left-text text-primary me-1"></i> Catatan
                            </label>
                            <p class="mb-0">{{ $p->catatan ?? '-' }}</p>
                        </div>

                        @if($p->surat_keterangan_ortu)
                        <div class="alert alert-info border-0 bg-info bg-opacity-10 mb-0" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-file-earmark-text-fill text-info me-2" style="font-size: 1.5rem;"></i>
                                <div class="flex-grow-1">
                                    <small class="fw-semibold d-block">Surat Keterangan Tersedia</small>
                                    <small class="text-muted">Dokumen telah dilampirkan</small>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Card Footer -->
                    <div class="p-4 pt-0">
                        <div class="d-flex gap-2">
                            @if($p->surat_keterangan_ortu)
                            <a href="{{ asset('storage/' . $p->surat_keterangan_ortu) }}"
                               target="_blank"
                               class="btn btn-outline-secondary flex-grow-1">
                                <i class="bi bi-file-earmark-arrow-down me-2"></i>Lihat Surat
                            </a>
                            @endif
                            
                            <button class="btn btn-primary flex-grow-1"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalDetail{{ $p->id }}">
                                <i class="bi bi-info-circle me-2"></i>Detail Lengkap
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ==================== MODAL DETAIL ==================== --}}
            <div class="modal fade" id="modalDetail{{ $p->id }}" tabindex="-1">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content border-0 shadow-lg rounded-4">
                        
                        <!-- Modal Header -->
                        <div class="modal-header bg-primary text-white border-0 p-4">
                            <div>
                                <h5 class="modal-title fw-bold mb-1">Detail Pendaftaran</h5>
                                <small class="opacity-75">Informasi lengkap pendaftaran ekstrakurikuler</small>
                            </div>
                            <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>

                        <!-- Modal Body -->
                        <div class="modal-body p-4">
                            <div class="row g-4">
                                
                                <!-- Info Card -->
                                <div class="col-12">
                                    <div class="bg-light rounded-3 p-4">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="text-muted small fw-semibold mb-2 d-block">
                                                    <i class="bi bi-trophy-fill text-primary me-1"></i> Ekstrakurikuler
                                                </label>
                                                <p class="fw-bold mb-0">{{ $p->ekstrakurikuler->nama_ekstrakurikuler ?? '-' }}</p>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="text-muted small fw-semibold mb-2 d-block">
                                                    <i class="bi bi-calendar-check-fill text-primary me-1"></i> Tanggal Daftar
                                                </label>
                                                <p class="fw-bold mb-0">{{ $p->created_at->format('d M Y, H:i') }}</p>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="text-muted small fw-semibold mb-2 d-block">
                                                    <i class="bi bi-flag-fill text-primary me-1"></i> Status Pendaftaran
                                                </label>
                                                <span class="badge bg-{{ 
                                                    $p->status === 'disetujui' ? 'success' : 
                                                    ($p->status === 'menunggu' ? 'warning text-dark' : 'danger')
                                                }} px-3 py-2">
                                                    <i class="bi bi-{{ 
                                                        $p->status === 'disetujui' ? 'check-circle-fill' : 
                                                        ($p->status === 'menunggu' ? 'clock-fill' : 'x-circle-fill')
                                                    }} me-1"></i>
                                                    {{ ucfirst($p->status) }}
                                                </span>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="text-muted small fw-semibold mb-2 d-block">
                                                    <i class="bi bi-clock-history text-primary me-1"></i> Terakhir Diperbarui
                                                </label>
                                                <p class="mb-0">{{ $p->updated_at->format('d M Y, H:i') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Catatan -->
                                <div class="col-12">
                                    <label class="text-muted small fw-semibold mb-2 d-block">
                                        <i class="bi bi-chat-left-quote-fill text-primary me-1"></i> Catatan Pendaftaran
                                    </label>
                                    <div class="bg-light rounded-3 p-3">
                                        <p class="mb-0">{{ $p->catatan ?? 'Tidak ada catatan' }}</p>
                                    </div>
                                </div>

                                <!-- Surat Keterangan -->
                                <div class="col-12">
                                    <label class="text-muted small fw-semibold mb-2 d-block">
                                        <i class="bi bi-file-earmark-text-fill text-primary me-1"></i> Surat Keterangan Orang Tua
                                    </label>
                                    @if($p->surat_keterangan_ortu)
                                        <div class="border border-2 border-primary border-dashed rounded-3 p-3">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" 
                                                     style="width: 50px; height: 50px;">
                                                    <i class="bi bi-file-earmark-pdf-fill text-primary" style="font-size: 1.5rem;"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <p class="fw-semibold mb-1">Dokumen Tersedia</p>
                                                    <small class="text-muted">Surat keterangan telah dilampirkan</small>
                                                </div>
                                                <a href="{{ asset('storage/' . $p->surat_keterangan_ortu) }}" 
                                                   target="_blank" 
                                                   class="btn btn-primary">
                                                    <i class="bi bi-download me-2"></i>Unduh
                                                </a>
                                            </div>
                                        </div>
                                    @else
                                        <div class="alert alert-warning border-0 bg-warning bg-opacity-10 mb-0">
                                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                            <small>Tidak ada surat keterangan yang dilampirkan</small>
                                        </div>
                                    @endif
                                </div>

                            </div>
                        </div>

                        <!-- Modal Footer -->
                        <div class="modal-footer border-0 bg-light p-4">
                            <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
                                <i class="bi bi-x-lg me-2"></i>Tutup
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            @empty
            <div class="col-12">
                <div class="bg-white rounded-4 shadow-sm p-5 text-center">
                    <h5 class="fw-bold mb-2">Belum Ada Pendaftaran</h5>
                    <p class="text-muted mb-0">Anda belum mendaftar ke ekstrakurikuler manapun</p>
                </div>
            </div>
            @endforelse
        </div>

    </div>
</div>
@endsection
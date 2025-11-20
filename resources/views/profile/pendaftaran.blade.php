@extends('layouts.template')

@section('title', 'Pendaftaran Saya')

@section('content')
<div class="container py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-0">Pendaftaran Saya</h3>
            <span class="text-muted">Total: {{ $pendaftaran->count() }} pendaftaran</span>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th class="py-3 ps-4">No</th>
                            <th class="py-3 ps-4">Ekstrakurikuler</th>
                            <th class="py-3 ps-4">Tanggal Daftar</th>
                            <th class="py-3 ps-4">Status</th>
                            <th class="text-center py-3">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($pendaftaran as $p)
                        <tr>
                            <td class="ps-4 fw-semibold">{{ $loop->iteration }}</td>

                            <td class="fw-semibold text-dark">
                                {{ $p->ekstrakurikuler->nama_ekstrakurikuler ?? '-' }}
                            </td>

                            <td>{{ $p->created_at->format('d M Y') }}</td>

                            <td>
                                <span class="badge bg-{{ 
                                    $p->status === 'disetujui' ? 'success' : 
                                    ($p->status === 'menunggu' ? 'warning text-dark' : 'danger')
                                }}">
                                    {{ ucfirst($p->status) }}
                                </span>
                            </td>

                            <td class="text-center">
                                <div class="d-flex flex-wrap justify-content-center gap-1">

                                    @if($p->surat_keterangan_ortu)
                                        <a href="{{ asset('storage/' . $p->surat_keterangan_ortu) }}"
                                        target="_blank"
                                        class="btn btn-sm btn-outline-secondary fw-semibold">
                                        <i class="bi bi-file-earmark-text"></i> Lihat Surat
                                        </a>
                                    @endif

                                    <button class="btn btn-sm btn-primary fw-semibold"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalDetail{{ $p->id }}">
                                        <i class="bi bi-eye"></i> Detail
                                    </button>
                                </div>
                            </td>
                        </tr>

                        {{-- ==================== MODAL DETAIL ==================== --}}
                        <div class="modal fade" id="modalDetail{{ $p->id }}" tabindex="-1">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content border-0 shadow">
                                    
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title">Detail Pendaftaran</h5>
                                        <button class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="row">

                                            <div class="col-md-12">
                                                <p><strong>Ekstrakurikuler:</strong><br>
                                                    {{ $p->ekstrakurikuler->nama_ekstrakurikuler ?? '-' }}
                                                </p>

                                                <p><strong>Tanggal Daftar:</strong><br>
                                                    {{ $p->created_at->format('d M Y, H:i') }}
                                                </p>

                                                <p><strong>Status:</strong><br>
                                                    {{ ucfirst($p->status) }}
                                                </p>

                                                <p><strong>Catatan:</strong><br>
                                                    {{ $p->catatan ?? '-' }}
                                                </p>

                                                <p><strong>Surat Keterangan Orang Tua:</strong><br>
                                                    @if($p->surat_keterangan_ortu)
                                                        <a href="{{ asset('storage/' . $p->surat_keterangan_ortu) }}" 
                                                           target="_blank" class="btn btn-sm btn-outline-secondary">
                                                           <i class="bi bi-file-earmark"></i> Lihat Surat
                                                        </a>
                                                    @else
                                                        <span class="text-muted">Tidak ada surat</span>
                                                    @endif
                                                </p>
                                            </div>

                                        </div>

                                        <hr>
                                        <p class="text-muted small">
                                            <strong>Dibuat:</strong> {{ $p->created_at->format('d M Y, H:i') }}<br>
                                            <strong>Diperbarui:</strong> {{ $p->updated_at->format('d M Y, H:i') }}
                                        </p>

                                    </div>

                                </div>
                            </div>
                        </div>

                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                <i class="bi bi-exclamation-circle me-1"></i> Belum ada pendaftaran.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
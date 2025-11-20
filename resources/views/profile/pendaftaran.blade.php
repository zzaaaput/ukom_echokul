@extends('layouts.template')

@section('content')
<div class="container py-4">
    
    <h3 class="mb-3">Pendaftaran Saya</h3>

    <div class="card shadow-sm">
        <div class="card-body">

            <table class="table table-bordered table-hover">
                <thead class="table-primary">
                    <tr>
                        <th>Ekstrakurikuler</th>
                        <th>Tanggal Daftar</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($pendaftaran as $p)
                        <tr>
                            <td>{{ $p->ekstrakurikuler?->nama_ekstrakurikuler ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($p->created_at)->format('d M Y') }}</td>

                            <td>
                                @if($p->status === 'menunggu')
                                    <span class="badge bg-warning text-dark">Menunggu</span>
                                @elseif($p->status === 'disetujui')
                                    <span class="badge bg-success">Disetujui</span>
                                @else
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </td>

                            <td>
                                <div class="d-flex gap-2">

                                    {{-- Tombol lihat surat jika ada --}}
                                    @if($p->surat_keterangan_ortu)
                                        <a href="{{ asset('storage/' . $p->surat_keterangan_ortu) }}" 
                                           target="_blank" 
                                           class="btn btn-sm btn-outline-secondary">
                                           Lihat Surat
                                        </a>
                                    @endif

                                    {{-- Tombol detail --}}
                                    <a href="{{ route('profile.pendaftaran.show', $p->id) }}" 
                                       class="btn btn-sm btn-primary">
                                       Detail
                                    </a>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-3">
                                Belum ada pendaftaran.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>

</div>
@endsection

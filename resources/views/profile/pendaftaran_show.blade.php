@extends('layouts.template')

@section('content')
<div class="container py-4">

    <h3 class="mb-3">Detail Pendaftaran</h3>

    <div class="card shadow-sm">
        <div class="card-body">

            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th>Ekstrakurikuler</th>
                        <td>{{ $pendaftaran->ekstrakurikuler->nama }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Daftar</th>
                        <td>{{ \Carbon\Carbon::parse($pendaftaran->created_at)->format('d M Y') }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if($pendaftaran->status === 'menunggu')
                                <span class="badge bg-warning text-dark">Menunggu</span>
                            @elseif($pendaftaran->status === 'disetujui')
                                <span class="badge bg-success">Disetujui</span>
                            @else
                                <span class="badge bg-danger">Ditolak</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Surat Keterangan Orang Tua</th>
                        <td>
                            @if($pendaftaran->surat_keterangan_ortu)
                                <a href="{{ asset('storage/' . $pendaftaran->surat_keterangan_ortu) }}" 
                                   target="_blank" class="btn btn-sm btn-outline-secondary">
                                   Lihat Surat
                                </a>
                            @else
                                <span class="text-muted">Tidak ada surat</span>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="mt-3">
                <a href="{{ route('profile.pendaftaran') }}" class="btn btn-secondary">Kembali</a>
            </div>

        </div>
    </div>

</div>
@endsection

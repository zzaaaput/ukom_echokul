@extends('layouts.template')

@section('content')
    <div class="container">
        <h3>Pendaftaran Saya</h3>

        <table class="table">
            <thead>
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
                        <td>{{ $p->ekstrakurikuler->nama }}</td>
                        <td>{{ \Carbon\Carbon::parse($p->tanggal_daftar)->format('d M Y') }}</td>
                        <td>
                            @if($p->status === 'menunggu')
                                <span class="badge bg-warning">Menunggu</span>
                            @elseif($p->status === 'disetujui')
                                <span class="badge bg-success">Disetujui</span>
                            @else
                                <span class="badge bg-danger">Ditolak</span>
                            @endif
                        </td>
                        <td>
                            @if($p->surat_keterangan_ortu)
                                <a href="{{ asset('storage/' . $p->surat_keterangan_ortu) }}" target="_blank" class="btn btn-sm btn-outline-secondary">Lihat Surat</a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">Belum ada pendaftaran.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
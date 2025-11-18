@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Detail Pendaftaran</h2>

    <table class="table table-bordered">
        <tr>
            <th>Nama Peserta</th>
            <td>{{ $pendaftaran->user->name }}</td>
        </tr>
        <tr>
            <th>Ekstrakurikuler</th>
            <td>{{ $pendaftaran->ekstrakurikuler->nama }}</td>
        </tr>
        <tr>
            <th>Tanggal Daftar</th>
            <td>{{ $pendaftaran->tanggal_daftar }}</td>
        </tr>
        <tr>
            <th>Alasan</th>
            <td>{{ $pendaftaran->alasan }}</td>
        </tr>
        <tr>
            <th>Surat Keterangan Orang Tua</th>
            <td>
                @if($pendaftaran->surat_keterangan_ortu)
                    <a href="{{ asset('storage/surat_ortu/'.$pendaftaran->surat_keterangan_ortu) }}" target="_blank">Lihat File</a>
                @else
                    Tidak ada
                @endif
            </td>
        </tr>
        <tr>
            <th>Status</th>
            <td>{{ ucfirst($pendaftaran->status) }}</td>
        </tr>
        <tr>
            <th>Disetujui Oleh</th>
            <td>{{ $pendaftaran->disetujuiOleh ? $pendaftaran->disetujuiOleh->name : '-' }}</td>
        </tr>
        <tr>
            <th>Tanggal Disetujui</th>
            <td>{{ $pendaftaran->tanggal_disetujui ?? '-' }}</td>
        </tr>
    </table>

    <a href="{{ route('pendaftaran.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection

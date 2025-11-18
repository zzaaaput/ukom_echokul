@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Detail Kegiatan</h2>

    <table class="table table-bordered">
        <tr>
            <th>Judul</th>
            <td>{{ $kegiatan->judul }}</td>
        </tr>
        <tr>
            <th>Deskripsi</th>
            <td>{{ $kegiatan->deskripsi }}</td>
        </tr>
        <tr>
            <th>Tanggal</th>
            <td>{{ $kegiatan->tanggal }}</td>
        </tr>
    </table>

    <a href="{{ route('kegiatan.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection

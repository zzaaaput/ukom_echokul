@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Daftar Kegiatan</h2>
    <a href="{{ route('kegiatan.create') }}" class="btn btn-primary mb-3">Tambah Kegiatan</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Judul</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kegiatans as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->judul }}</td>
                <td>{{ $item->tanggal }}</td>
                <td>
                    <a href="{{ route('kegiatan.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <a href="{{ route('kegiatan.show', $item->id) }}" class="btn btn-info btn-sm">Detail</a>
                    <form action="{{ route('kegiatan.destroy', $item->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus data?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

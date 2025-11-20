@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Daftar Pendaftaran</h2>
    <a href="{{ route('pendaftaran.create') }}" class="btn btn-primary mb-3">Tambah Pendaftaran</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Ekstrakurikuler</th>
                <th>Tanggal Daftar</th>
                <th>Status</th>
                <th>Disetujui Oleh</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pendaftaran as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->user->name }}</td>
                <td>{{ $item->ekstrakurikuler->nama }}</td>
                <td>{{ $item->tanggal_daftar }}</td>
                <td>{{ ucfirst($item->status) }}</td>
                <td>{{ $item->disetujuiOleh ? $item->disetujuiOleh->name : '-' }}</td>
                <td>
                    <a href="{{ route('pendaftaran.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <a href="{{ route('pendaftaran.show', $item->id) }}" class="btn btn-info btn-sm">Detail</a>
                    <form action="{{ route('pendaftaran.destroy', $item->id) }}" method="POST" class="d-inline">
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

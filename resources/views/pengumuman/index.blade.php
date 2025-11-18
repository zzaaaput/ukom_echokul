@extends('layouts.app')

@section('content')
<h2>Daftar Pengumuman</h2>
<a href="{{ route('pengumuman.create') }}">Tambah</a>

<table border="1">
    <tr>
        <th>Judul</th>
        <th>Aksi</th>
    </tr>

    @foreach ($data as $item)
    <tr>
        <td>{{ $item->judul }}</td>
        <td>
            <a href="{{ route('pengumuman.show', $item->id) }}">Detail</a>
            <a href="{{ route('pengumuman.edit', $item->id) }}">Edit</a>
            <form action="{{ route('pengumuman.destroy', $item->id) }}" method="POST" style="display:inline">
                @csrf
                @method('DELETE')
                <button type="submit">Hapus</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
@endsection

@extends('layouts.template')
@section('content')

<h2>Edit Pengumuman</h2>

<form action="{{ route('pengumuman.update', $pengumuman->id) }}" method="POST">
    @csrf
    @method('PUT')

    <label>Judul</label>
    <input type="text" name="judul" value="{{ $pengumuman->judul }}" required>

    <label>Isi</label>
    <textarea name="isi" required>{{ $pengumuman->isi }}</textarea>

    <button type="submit">Update</button>
</form>

@endsection

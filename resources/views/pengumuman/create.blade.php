@extends('layouts.app')
@section('content')

<h2>Tambah Pengumuman</h2>

<form action="{{ route('pengumuman.store') }}" method="POST">
    @csrf
    <label>Judul</label>
    <input type="text" name="judul" required>

    <label>Isi</label>
    <textarea name="isi" required></textarea>

    <button type="submit">Simpan</button>
</form>

@endsection

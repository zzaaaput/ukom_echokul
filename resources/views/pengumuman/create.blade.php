@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h3 class="mb-4">Buat Pengumuman</h3>

    <form action="{{ route('pengumuman.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label>Ekstrakurikuler</label>
            <select name="ekstrakurikuler_id" class="form-control" required>
                <option value="">-- Pilih Ekskul --</option>
                @foreach($ekskul as $item)
                    <option value="{{ $item->id }}">{{ $item->nama_ekstrakurikuler }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Judul Pengumuman</label>
            <input type="text" name="judul_pengumuman" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Isi Pengumuman</label>
            <textarea name="isi" rows="5" class="form-control" required></textarea>
        </div>

        <div class="mb-3">
            <label>Tanggal</label>
            <input type="date" name="tanggal" class="form-control">
        </div>

        <div class="mb-3">
            <label>Foto (Opsional)</label>
            <input type="file" name="foto" class="form-control">
        </div>

        <button class="btn btn-primary">Simpan</button>
        <a href="{{ route('pengumuman.index') }}" class="btn btn-secondary">Kembali</a>
    </form>

</div>
@endsection

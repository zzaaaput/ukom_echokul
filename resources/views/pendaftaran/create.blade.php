@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Tambah Pendaftaran</h2>

    <form action="{{ route('pendaftaran.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label>Nama Peserta</label>
            <select name="user_id" class="form-control" required>
                <option value="">-- Pilih User --</option>
                @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Ekstrakurikuler</label>
            <select name="ekstrakurikuler_id" class="form-control" required>
                <option value="">-- Pilih Ekstrakurikuler --</option>
                @foreach($ekstrakurikulers as $ekstra)
                <option value="{{ $ekstra->id }}">{{ $ekstra->nama }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Tanggal Daftar</label>
            <input type="date" name="tanggal_daftar" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Alasan</label>
            <textarea name="alasan" class="form-control" rows="3"></textarea>
        </div>

        <div class="mb-3">
            <label>Surat Keterangan Orang Tua (PDF/JPG/PNG)</label>
            <input type="file" name="surat_keterangan_ortu" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('pendaftaran.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection


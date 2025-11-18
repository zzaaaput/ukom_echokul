@extends('layouts.app')
@section('content')

<h2>{{ $pengumuman->judul }}</h2>

<p>{{ $pengumuman->isi }}</p>

<a href="{{ route('pengumuman.index') }}">Kembali</a>

@endsection

<!-- rbelum dipanggil -->
@extends('layouts/template')

@section('title', 'siswa')

@section('content')
    <div class="text-center mb-10">
        <h1 class="text-3xl font-bold text-gray-900">Ekstrakurikuler SMAN 1</h1>
        <p class="mt-2 text-gray-600">Temukan kegiatan yang sesuai minatmu!</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($ekstrakurikulers as $ekskul)
        <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition">
            <div class="p-6">
                <h2 class="text-xl font-bold text-gray-800">{{ $ekskul->nama_ekstrakurikuler }}</h2>
                <p class="mt-2 text-gray-600">{{ Str::limit($ekskul->deskripsi, 100) }}</p>
                <p class="mt-3 text-sm text-indigo-600">Pembina: {{ $ekskul->pembina->name }}</p>
                @auth
                    @if(auth()->user()->isKetua() && auth()->user()->ledExtracurricular?->id === $ekskul->id)
                        <a href="{{ route('dashboard.ketua') }}" class="mt-4 inline-block bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Kelola</a>
                    @endif
                @endauth
            </div>
        </div>
        @endforeach
    </div>

@endsection
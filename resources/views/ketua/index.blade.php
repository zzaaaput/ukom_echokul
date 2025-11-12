@extends('layouts.template')

@section('title', 'Ketua')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

        <!-- Header Ekstrakurikuler -->
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 mb-4">
                Ekstrakurikuler: {{ $ekstrakurikuler->nama_ekstrakurikuler }}
            </h2>
            <button class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                Tambah Anggota
            </button>
        </div>

        <!-- Info Ekskul & Statistik -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-2">Info Ekstrakurikuler</h3>
                <p class="text-gray-600 mb-2">{{ $ekstrakurikuler->deskripsi }}</p>
                <p class="text-gray-700 font-medium flex items-center">
                    <img src="{{ asset($ekstrakurikuler->pembina->foto ?? 'build/assets/images/default-user.png') }}"
                         alt="Foto Pembina" class="w-10 h-10 rounded-full mr-2 object-cover">
                    Pembina: {{ $ekstrakurikuler->pembina->nama_lengkap }}
                </p>
            </div>

            <div class="flex flex-wrap gap-4">
                <div class="flex-1 min-w-[150px] bg-green-100 p-4 rounded-lg text-center">
                    <p class="text-2xl font-bold">{{ $anggotaList->where('status_anggota', 'aktif')->count() }}</p>
                    <p class="text-gray-700">Anggota Aktif</p>
                </div>
                <div class="flex-1 min-w-[150px] bg-blue-100 p-4 rounded-lg text-center">
                    <p class="text-2xl font-bold">{{ $anggotaList->where('jabatan', 'pengurus')->count() }}</p>
                    <p class="text-gray-700">Pengurus</p>
                </div>
                <div class="flex-1 min-w-[150px] bg-purple-100 p-4 rounded-lg text-center">
                    <p class="text-2xl font-bold">{{ $anggotaList->where('jabatan', 'ketua')->count() }}</p>
                    <p class="text-gray-700">Ketua</p>
                </div>
                <div class="flex-1 min-w-[150px] bg-gray-100 p-4 rounded-lg text-center">
                    <p class="text-2xl font-bold">{{ $anggotaList->count() }}</p>
                    <p class="text-gray-700">Total Anggota</p>
                </div>
            </div>
        </div>

        <!-- Daftar Anggota -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Daftar Anggota</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Foto</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Nama</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Jabatan</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Tahun Ajaran</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($anggotaList as $anggota)
                        <tr>
                            <td class="px-4 py-2">
                                <img src="{{ asset($anggota->foto ?? 'build/assets/images/default-user.png') }}" 
                                     class="w-10 h-10 rounded-full object-cover">
                            </td>
                            <td class="px-4 py-2">{{ $anggota->nama_anggota }}</td>
                            <td class="px-4 py-2">
                                <span class="px-2 py-1 rounded-full text-xs font-medium
                                    {{ $anggota->jabatan === 'ketua' ? 'bg-purple-100 text-purple-800' : 
                                       ($anggota->jabatan === 'pengurus' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                                    {{ ucfirst($anggota->jabatan) }}
                                </span>
                            </td>
                            <td class="px-4 py-2">{{ $anggota->tahun_ajaran }}</td>
                            <td class="px-4 py-2">
                                <span class="px-2 py-1 rounded-full text-xs font-medium
                                    {{ $anggota->status_anggota === 'aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($anggota->status_anggota) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection
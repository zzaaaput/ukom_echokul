@extends('layouts/template')

@section('title', 'admin')

@section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <h2 class="font-semibold text-xl text-gray-800 mb-4">
                Dashboard Admin
            </h2>

            <!-- sisanya tetap -->
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Kelola Pengguna & Ekstrakurikuler</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-indigo-50 p-4 rounded-lg">
                        <h4 class="font-bold text-indigo-700">Total Ekstrakurikuler</h4>
                        <p class="text-2xl mt-1">{{ \App\Models\Ekstrakurikuler::count() }}</p>
                    </div>
                    <div class="bg-green-50 p-4 rounded-lg">
                        <h4 class="font-bold text-green-700">Total Anggota</h4>
                        <p class="text-2xl mt-1">#</p>
                    </div>
                    <div class="bg-amber-50 p-4 rounded-lg">
                        <h4 class="font-bold text-amber-700">Pengguna Aktif</h4>
                        <p class="text-2xl mt-1">{{ \App\Models\User::count() }}</p>
                    </div>
                </div>

                <div class="mt-6">
                    <a href="#" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                        <i class="fas fa-plus mr-2"></i> Tambah Ekstrakurikuler
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
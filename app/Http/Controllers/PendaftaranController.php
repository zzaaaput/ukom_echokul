<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use Illuminate\Http\Request;

class PendaftaranController extends Controller
{
    public function index()
    {
        $data = Pendaftaran::latest()->get();
        return view('pembina.pendaftaran.index', compact('data'));
    }

    public function create()
    {
        return view('pendaftaran.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'kelas' => 'required',
            'ekskul' => 'required',
            'tanggal_daftar' => 'required|date'
        ]);

        Pendaftaran::create($request->all());

        return redirect()->route('pendaftaran.index')->with('success', 'Data pendaftaran berhasil ditambahkan.');
    }

    public function show($id)
    {
        $item = Pendaftaran::findOrFail($id);
        return view('pendaftaran.show', compact('item'));
    }

    public function edit($id)
    {
        $item = Pendaftaran::findOrFail($id);
        return view('pendaftaran.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = Pendaftaran::findOrFail($id);

        $request->validate([
            'nama' => 'required',
            'kelas' => 'required',
            'ekskul' => 'required',
            'tanggal_daftar' => 'required|date'
        ]);

        $item->update($request->all());

        return redirect()->route('pendaftaran.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Pendaftaran::destroy($id);
        return redirect()->route('pendaftaran.index')->with('success', 'Data berhasil dihapus.');
    }
}

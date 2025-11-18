<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use Illuminate\Http\Request;

class KegiatanController extends Controller
{
    public function index()
    {
        $data = Kegiatan::latest()->get();
        return view('kegiatan.index', compact('data'));
    }

    public function create()
    {
        return view('kegiatan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kegiatan' => 'required',
            'deskripsi' => 'required',
            'tanggal' => 'required|date',
            'tempat' => 'required'
        ]);

        Kegiatan::create($request->all());
        return redirect()->route('kegiatan.index')->with('success', 'Kegiatan berhasil ditambahkan.');
    }

    public function show($id)
    {
        $item = Kegiatan::findOrFail($id);
        return view('kegiatan.show', compact('item'));
    }

    public function edit($id)
    {
        $item = Kegiatan::findOrFail($id);
        return view('kegiatan.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = Kegiatan::findOrFail($id);

        $request->validate([
            'nama_kegiatan' => 'required',
            'deskripsi' => 'required',
            'tanggal' => 'required|date',
            'tempat' => 'required'
        ]);

        $item->update($request->all());
        return redirect()->route('kegiatan.index')->with('success', 'Kegiatan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Kegiatan::destroy($id);
        return redirect()->route('kegiatan.index')->with('success', 'Kegiatan berhasil dihapus.');
    }
}

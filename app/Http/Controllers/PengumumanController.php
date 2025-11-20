<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PengumumanController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengumuman::with('user');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('judul_pengumuman', 'like', "%$search%")
                  ->orWhereHas('user', fn($q) => $q->where('nama_lengkap', 'like', "%$search%"));
        }

        $sort = $request->get('sort', 'tanggal');
        $direction = $request->get('direction', 'desc');
        $allowedSorts = ['judul_pengumuman', 'user', 'tanggal'];

        if (in_array($sort, $allowedSorts)) {
            if ($sort === 'user') {
                $query->join('users as u', 'pengumuman.user_id', '=', 'u.id')
                      ->orderBy('u.nama_lengkap', $direction)
                      ->select('pengumuman.*');
            } else {
                $query->orderBy($sort, $direction);
            }
        }

        $pengumuman = $query->paginate(10)->appends($request->query());
        $totalUsers = Pengumuman::distinct('user_id')->count('user_id');

        return view('admin.pengumuman', compact('pengumuman', 'sort', 'direction', 'totalUsers'));
    }

    public function create()
    {
        return view('admin.pengumuman.create');
    }

    public function store(Request $request)
    {
        $this->checkAdmin();

        $data = $request->validate([
            'judul_pengumuman' => 'required',
            'isi'              => 'required',
            'tanggal'          => 'nullable|date',
            'foto'             => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $path = $file->storeAs('public/images/pengumuman', time().'_'.$file->getClientOriginalName());
            $data['foto'] = str_replace('public/', 'storage/', $path); // path untuk akses via browser
        }

        $data['user_id'] = Auth::id();

        Pengumuman::create($data);

        return redirect()->route('pembina.pengumuman.index')
                         ->with('success', 'Pengumuman berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        return view('admin.pengumuman.edit', compact('pengumuman'));
    }

    public function update(Request $request, $id)
    {
        $pengumuman = Pengumuman::findOrFail($id);

        $data = $request->validate([
            'judul_pengumuman' => 'required|string|max:255',
            'isi'              => 'required|string',
            'tanggal'          => 'nullable|date',
            'foto'             => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            if ($pengumuman->foto) {
                // hapus file lama
                $oldPath = str_replace('storage/', 'public/', $pengumuman->foto);
                Storage::delete($oldPath);
            }
            $file = $request->file('foto');
            $path = $file->storeAs('public/images/pengumuman', time().'_'.$file->getClientOriginalName());
            $data['foto'] = str_replace('public/', 'storage/', $path);
        }

        $pengumuman->update($data);

        return redirect()->route('pengumuman.index')
                         ->with('success', 'Pengumuman berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);

        if ($pengumuman->foto) {
            $oldPath = str_replace('storage/', 'public/', $pengumuman->foto);
            Storage::delete($oldPath);
        }

        $pengumuman->delete();

        return back()->with('success', 'Pengumuman berhasil dihapus!');
    }
}
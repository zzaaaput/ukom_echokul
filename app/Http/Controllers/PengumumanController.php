<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use App\Models\Ekstrakurikuler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PengumumanController extends Controller
{
    /**
     * Halaman publik: bisa diakses semua orang (tamu, siswa, dll)
     */
    public function indexPublik(Request $request)
    {
        $query = Pengumuman::orderBy('tanggal', 'desc');

        if ($request->filled('search')) {
            $query->where('judul_pengumuman', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        $pengumuman = $query->paginate(10);
        $ekskul = Ekstrakurikuler::all();

        return view('pengumuman.index', compact('pengumuman', 'ekskul'));
    }

    /**
     * Halaman admin: CRUD semua pengumuman
     */
    public function indexAdmin(Request $request)
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

    /**
     * Daftar pengumuman khusus pembina
     */
    public function pembinaIndex(Request $request)
    {
        $query = Pengumuman::where('user_id', Auth::id());

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('judul_pengumuman', 'like', "%$search%");
        }

        $pengumuman = $query->orderBy('tanggal', 'desc')->paginate(10);

        return view('pembina.pengumuman.index', compact('pengumuman'));
    }

    /**
     * Form tambah pengumuman pembina
     */
    public function pembinaCreate()
    {
        return view('pembina.pengumuman.create');
    }

    /**
     * Simpan pengumuman pembina
     */
    public function pembinaStore(Request $request)
    {
        $data = $request->validate([
            'judul_pengumuman' => 'required',
            'isi'              => 'required',
            'tanggal'          => 'nullable|date',
            'foto'             => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $path = $file->storeAs('public/images/pengumuman', time().'_'.$file->getClientOriginalName());
            $data['foto'] = str_replace('public/', 'storage/', $path);
        }

        $data['user_id'] = Auth::id();
        Pengumuman::create($data);

        return redirect()->route('pembina.pengumuman.index')
                         ->with('success', 'Pengumuman berhasil ditambahkan!');
    }

    /**
     * Edit pengumuman pembina
     */
    public function pembinaEdit($id)
    {
        $pengumuman = Pengumuman::where('user_id', Auth::id())->findOrFail($id);
        return view('pembina.pengumuman.edit', compact('pengumuman'));
    }

    /**
     * Update pengumuman pembina
     */
    public function pembinaUpdate(Request $request, $id)
    {
        $pengumuman = Pengumuman::where('user_id', Auth::id())->findOrFail($id);

        $data = $request->validate([
            'judul_pengumuman' => 'required|string|max:255',
            'isi'              => 'required|string',
            'tanggal'          => 'nullable|date',
            'foto'             => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            if ($pengumuman->foto) {
                $oldPath = str_replace('storage/', 'public/', $pengumuman->foto);
                Storage::delete($oldPath);
            }
            $file = $request->file('foto');
            $path = $file->storeAs('public/images/pengumuman', time().'_'.$file->getClientOriginalName());
            $data['foto'] = str_replace('public/', 'storage/', $path);
        }

        $pengumuman->update($data);

        return redirect()->route('pembina.pengumuman.index')
                         ->with('success', 'Pengumuman berhasil diperbarui!');
    }

    /**
     * Hapus pengumuman pembina
     */
    public function pembinaDestroy($id)
    {
        $pengumuman = Pengumuman::where('user_id', Auth::id())->findOrFail($id);

        if ($pengumuman->foto) {
            $oldPath = str_replace('storage/', 'public/', $pengumuman->foto);
            Storage::delete($oldPath);
        }

        $pengumuman->delete();

        return back()->with('success', 'Pengumuman berhasil dihapus!');
    }

    /**
     * Form tambah pengumuman (admin)
     */
    public function create()
    {
        return view('admin.pengumuman.create');
    }

    /**
     * Simpan pengumuman (admin)
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'judul_pengumuman' => 'required',
            'isi'              => 'required',
            'tanggal'          => 'nullable|date',
            'foto'             => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $path = $file->storeAs('public/images/pengumuman', time().'_'.$file->getClientOriginalName());
            $data['foto'] = str_replace('public/', 'storage/', $path);
        }

        $data['user_id'] = Auth::id();
        Pengumuman::create($data);

        return redirect()->route('admin.pengumuman.index')
                         ->with('success', 'Pengumuman berhasil ditambahkan!');
    }

    /**
     * Form edit pengumuman (admin)
     */
    public function edit($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        return view('admin.pengumuman.edit', compact('pengumuman'));
    }

    /**
     * Update pengumuman (admin)
     */
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
                $oldPath = str_replace('storage/', 'public/', $pengumuman->foto);
                Storage::delete($oldPath);
            }
            $file = $request->file('foto');
            $path = $file->storeAs('public/images/pengumuman', time().'_'.$file->getClientOriginalName());
            $data['foto'] = str_replace('public/', 'storage/', $path);
        }

        $pengumuman->update($data);

        return redirect()->route('admin.pengumuman.index')
                         ->with('success', 'Pengumuman berhasil diperbarui!');
    }

    /**
     * Hapus pengumuman (admin)
     */
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

    /**
     * Tampilkan detail pengumuman (publik)
     */
    public function show($id)
    {
        $pengumuman = Pengumuman::with('user')->findOrFail($id);
        return view('pengumuman.show', compact('pengumuman'));
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use App\Models\Ekstrakurikuler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PengumumanController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 12);
        $search  = $request->search;
        $user    = Auth::user();

        $pembinaEkskul = null;
        if ($user?->role === 'pembina') {
            $pembinaEkskul = Ekstrakurikuler::where('user_pembina_id', $user->id)->first();
        }

        $query = Pengumuman::with('ekstrakurikuler');

        if ($pembinaEkskul) {
            $query->where('ekstrakurikuler_id', $pembinaEkskul->id);
        }

        if ($user?->role === 'siswa' && $user->ekstrakurikuler_id) {
            $query->where('ekstrakurikuler_id', $user->ekstrakurikuler_id);
        }

        if ($request->filled('ekstrakurikuler_id')) {
            $query->where('ekstrakurikuler_id', $request->ekstrakurikuler_id);
        }

        if ($search) {
            $query->where('judul_pengumuman', 'like', "%$search%");
        }

        $pengumuman = $query->orderBy('tanggal', 'desc')
            ->paginate($perPage)
            ->appends([
                'search' => $search,
                'per_page' => $perPage,
                'ekstrakurikuler_id' => $request->ekstrakurikuler_id,
            ]);

        $ekskul = $pembinaEkskul ? collect([$pembinaEkskul]) : Ekstrakurikuler::all();

        return view('pengumuman.index', compact('pengumuman', 'ekskul', 'pembinaEkskul'));
    }

    public function create()
    {
        $user = Auth::user();

        if ($user->role === 'pembina') {
            $ekskul = collect([$user->ekstrakurikulerDibina]);
        } elseif ($user->role === 'ketua') {
            $ekskul = collect([$user->ekstrakurikulerDipimpin]);
        } else {
            $ekskul = Ekstrakurikuler::all();
        }

        return view('pengumuman.create', compact('ekskul'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'ekstrakurikuler_id' => 'required',
            'judul_pengumuman'   => 'required',
            'isi'                => 'required',
            'tanggal'            => 'nullable|date',
            'foto'               => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('pengumuman', 'public');
        }

        $data['user_id'] = Auth::id();

        Pengumuman::create($data);

        return redirect()->route('pengumuman.index')
            ->with('success', 'Pengumuman berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        $ekskul = Ekstrakurikuler::all();

        return view('pengumuman.edit', compact('pengumuman', 'ekskul'));
    }

    public function update(Request $request, $id)
    {
        $pengumuman = Pengumuman::findOrFail($id);

        $data = $request->validate([
            'ekstrakurikuler_id' => 'required',
            'judul_pengumuman'   => 'required',
            'isi'                => 'required',
            'tanggal'            => 'nullable|date',
            'foto'               => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            if ($pengumuman->foto) {
                Storage::disk('public')->delete($pengumuman->foto);
            }
            $data['foto'] = $request->file('foto')->store('pengumuman', 'public');
        }

        $pengumuman->update($data);

        return redirect()->route('pengumuman.index')
            ->with('success', 'Pengumuman berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);

        if ($pengumuman->foto) {
            Storage::disk('public')->delete($pengumuman->foto);
        }

        $pengumuman->delete();

        return back()->with('success', 'Pengumuman berhasil dihapus!');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\Ekstrakurikuler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class KegiatanController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 12);
        $search  = $request->search;
        $user    = Auth::user();

        // ================================
        // ROLE HANDLING SAMA DENGAN PENILAIAN
        // ================================
        $pembinaEkskul = null;

        if ($user?->role === 'pembina') {
            $pembinaEkskul = Ekstrakurikuler::where('user_pembina_id', $user->id)->first();
        }

        // Query dasar
        $query = Kegiatan::with('ekstrakurikuler');

        // Jika pembina → hanya ekskul yang dibina
        if ($pembinaEkskul) {
            $query->where('ekstrakurikuler_id', $pembinaEkskul->id);
        }

        // Siswa → sesuai ekskul_id anggota
        if ($user?->role === 'siswa' && $user->ekstrakurikuler_id) {
            $query->where('ekstrakurikuler_id', $user->ekstrakurikuler_id);
        }

        // Admin / bukan pembina → boleh filter manual
        if ($request->filled('ekstrakurikuler_id')) {
            $query->where('ekstrakurikuler_id', $request->ekstrakurikuler_id);
        }

        //----------------------------------------------------
        // Search
        //----------------------------------------------------
        if ($search) {
            $query->where('nama_kegiatan', 'like', "%$search%");
        }

        //----------------------------------------------------
        // Pagination
        //----------------------------------------------------
        $kegiatan = $query->orderBy('tanggal', 'desc')
            ->paginate($perPage)
            ->appends([
                'search' => $search,
                'per_page' => $perPage,
                'ekstrakurikuler_id' => $request->ekstrakurikuler_id,
            ]);

        //----------------------------------------------------
        // Daftar ekskul untuk dropdown filter
        //----------------------------------------------------
        if ($pembinaEkskul) {
            $ekskul = collect([$pembinaEkskul]); // PEMBINA → collection
        } else {
            $ekskul = Ekstrakurikuler::all(); // ADMIN → semua
        }

        return view('pembina.kegiatan.index', compact('kegiatan', 'ekskul', 'pembinaEkskul'));
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

        return view('pembina.kegiatan.create', compact('ekskul'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'ekstrakurikuler_id' => 'required',
            'nama_kegiatan'      => 'required',
            'deskripsi'          => 'nullable',
            'lokasi'             => 'nullable',
            'tanggal'            => 'required|date',
            'waktu_mulai'        => 'nullable',
            'waktu_selesai'      => 'nullable',
            'foto'               => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('kegiatan', 'public');
        }

        $data['dibuat_oleh'] = Auth::id();

        Kegiatan::create($data);

        return redirect()->route('pembina.kegiatan.index')
            ->with('success', 'Kegiatan berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $kegiatan = Kegiatan::findOrFail($id);
        $ekskul = Ekstrakurikuler::all();

        return view('pembina.kegiatan.edit', compact('kegiatan', 'ekskul'));
    }

    public function update(Request $request, $id)
    {
        $kegiatan = Kegiatan::findOrFail($id);

        $data = $request->validate([
            'ekstrakurikuler_id' => 'required',
            'nama_kegiatan'      => 'required',
            'deskripsi'          => 'nullable',
            'lokasi'             => 'nullable',
            'tanggal'            => 'required|date',
            'waktu_mulai'        => 'nullable',
            'waktu_selesai'      => 'nullable',
            'foto'               => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            if ($kegiatan->foto) {
                Storage::disk('public')->delete($kegiatan->foto);
            }
            $data['foto'] = $request->file('foto')->store('kegiatan', 'public');
        }

        $kegiatan->update($data);

        return redirect()->route('pembina.kegiatan.index')
            ->with('success', 'Kegiatan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $kegiatan = Kegiatan::findOrFail($id);

        if ($kegiatan->foto) {
            Storage::disk('public')->delete($kegiatan->foto);
        }

        $kegiatan->delete();

        return back()->with('success', 'Kegiatan berhasil dihapus!');
    }
}
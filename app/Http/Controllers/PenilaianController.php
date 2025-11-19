<?php

namespace App\Http\Controllers;

use App\Models\Penilaian;
use App\Models\AnggotaEkstrakurikuler;
use App\Models\Ekstrakurikuler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PenilaianController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
    
        // Jika user pembina, ambil ekskul yang dipimpin
        $pembinaEkskul = null;
        if (Auth::check() && Auth::user()->role === 'pembina') {
            $pembinaEkskul = Ekstrakurikuler::where('user_pembina_id', Auth::id())->first();
        }
    
        $query = Penilaian::with(['anggota', 'ekstrakurikuler']);
    
        // Jika pembina, batasi hanya penilaian di ekskul yang dipimpin
        if ($pembinaEkskul) {
            $query->where('ekstrakurikuler_id', $pembinaEkskul->id);
        }
    
        // Filter search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('anggota', function ($q) use ($search) {
                $q->where('nama_anggota', 'like', "%$search%")
                  ->orWhere('jabatan', 'like', "%$search%");
            });
        }
    
        // Filter per ekstrakurikuler (untuk admin / non-pembina)
        if ($request->filled('ekstrakurikuler_id')) {
            $query->where('ekstrakurikuler_id', $request->ekstrakurikuler_id);
        }
    
        // **Filter per semester**
        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }
    
        // Pagination dengan mempertahankan query string
        $penilaian = $query->paginate($perPage)
            ->appends([
                'search' => $request->search,
                'per_page' => $perPage,
                'ekstrakurikuler_id' => $request->ekstrakurikuler_id,
                'semester' => $request->semester, // tambahkan semester
            ]);
    
        $ekstrakurikulerList = Ekstrakurikuler::all();
        $anggota = AnggotaEkstrakurikuler::all();
    
        return view('pembina.penilaian.index', compact(
            'penilaian',
            'anggota',
            'ekstrakurikulerList',
            'pembinaEkskul'
        ));
    }
    
    public function create()
    {
        return redirect()->route('pembina.penilaian.index');
    }

    public function store(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'pembina') {
            abort(403, 'Hanya pembina yang dapat menambah penilaian.');
        }

        $request->validate([
            'anggota_id'         => 'required|exists:anggota_ekstrakurikuler,id',
            'ekstrakurikuler_id' => 'required|exists:ekstrakurikuler,id',
            'semester'           => 'required|in:1,2,3,4,5,6',
            'keterangan'         => 'required|in:sangat baik,baik,cukup baik,cukup,kurang baik',
            'catatan'            => 'nullable',
            'foto'               => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $anggota = AnggotaEkstrakurikuler::findOrFail($request->anggota_id);
        $tahunAjaran = $anggota->tahun_ajaran;

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('penilaians', 'public');
        }

        Penilaian::create([
            'anggota_id'         => $request->anggota_id,
            'ekstrakurikuler_id' => $request->ekstrakurikuler_id,
            'tahun_ajaran'       => $tahunAjaran,
            'semester'           => $request->semester,
            'keterangan'         => $request->keterangan,
            'catatan'            => $request->catatan,
            'foto'               => $fotoPath,
            'dibuat_oleh'        => Auth::id(),
        ]);

        return back()->with('success', 'Penilaian berhasil ditambahkan');
    }

    public function edit(Penilaian $penilaian)
    {
        $pembinaEkskul = null;
        if (Auth::check() && Auth::user()->role === 'pembina') {
            $pembinaEkskul = Ekstrakurikuler::where('user_pembina_id', Auth::id())->first();
            $anggota = AnggotaEkstrakurikuler::where('ekstrakurikuler_id', $pembinaEkskul->id)->get();
            $ekstra = [$pembinaEkskul];
        } else {
            $anggota = AnggotaEkstrakurikuler::all();
            $ekstra = Ekstrakurikuler::all();
        }

        return view('pembina.penilaian.edit', compact('penilaian', 'anggota', 'ekstra'));
    }

    public function update(Request $request, Penilaian $penilaian)
    {
        if (Auth::check() && Auth::user()->role === 'pembina') {
            $pembinaEkskul = Ekstrakurikuler::where('user_pembina_id', Auth::id())->first();
            if ($penilaian->ekstrakurikuler_id !== $pembinaEkskul->id) {
                abort(403, 'Anda tidak berhak mengubah penilaian ini.');
            }
        }

        $validated = $request->validate([
            'anggota_id'          => 'required|exists:anggota_ekstrakurikuler,id',
            'ekstrakurikuler_id'  => 'required|exists:ekstrakurikuler,id',
            'tahun_ajaran'        => 'required|digits:4',
            'semester'            => 'required|in:1,2,3,4,5,6',
            'keterangan'          => 'required|in:sangat baik,baik,cukup baik,cukup,kurang baik',
            'catatan'             => 'nullable',
            'foto'                => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            if ($penilaian->foto) {
                Storage::disk('public')->delete($penilaian->foto);
            }
            $validated['foto'] = $request->file('foto')->store('penilaians', 'public');
        }

        $penilaian->update($validated);

        return redirect()->route('pembina.penilaian.index')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy(Penilaian $penilaian)
    {
        if (Auth::check() && Auth::user()->role === 'pembina') {
            $pembinaEkskul = Ekstrakurikuler::where('user_pembina_id', Auth::id())->first();
            if ($penilaian->ekstrakurikuler_id !== $pembinaEkskul->id) {
                abort(403, 'Anda tidak berhak menghapus penilaian ini.');
            }
        }

        if ($penilaian->foto) {
            Storage::disk('public')->delete($penilaian->foto);
        }

        $penilaian->delete();

        return back()->with('success', 'Data berhasil dihapus');
    }
}
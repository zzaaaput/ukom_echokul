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
    private function getPembinaEkskul()
    {
        if (Auth::check() && Auth::user()->role === 'pembina') {
            return Ekstrakurikuler::where('user_pembina_id', Auth::id())->first();
        }
        return null;
    }

    public function index()
    {
        $pembinaEkskul = $this->getPembinaEkskul();

        $query = Penilaian::with(['anggota', 'ekstrakurikuler'])
            ->orderBy('id', 'DESC');

        // Jika pembina → filter penilaian hanya untuk ekskul miliknya
        if ($pembinaEkskul) {
            $query->where('ekstrakurikuler_id', $pembinaEkskul->id);
        }

        $penilaian = $query->paginate(10);

        return view('pembina.penilaian.index', [
            'penilaian' => $penilaian,
            'anggota'   => $pembinaEkskul
                ? AnggotaEkstrakurikuler::where('ekstrakurikuler_id', $pembinaEkskul->id)->get()
                : AnggotaEkstrakurikuler::all(),

            'ekstra' => $pembinaEkskul ? [$pembinaEkskul] : Ekstrakurikuler::all(),
        ]);
    }

    public function create()
    {
        $pembinaEkskul = $this->getPembinaEkskul();

        return view('pembina.penilaian.create', [
            'anggota' => $pembinaEkskul
                ? AnggotaEkstrakurikuler::where('ekstrakurikuler_id', $pembinaEkskul->id)->get()
                : AnggotaEkstrakurikuler::all(),

            'ekstra' => $pembinaEkskul ? [$pembinaEkskul] : Ekstrakurikuler::all(),
        ]);
    }

    public function store(Request $request)
    {
        $pembinaEkskul = $this->getPembinaEkskul();

        if (Auth::user()->role === 'pembina' && !$pembinaEkskul) {
            abort(403, "Anda tidak memiliki ekstrakurikuler.");
        }

        $request->validate([
            'anggota_id'          => 'required|exists:anggota_ekstrakurikuler,id',
            'semester'            => 'required|in:1,2,3,4,5,6',
            'keterangan'          => 'required|in:sangat baik,baik,cukup baik,cukup,kurang baik',
            'catatan'             => 'nullable',
            'foto'                => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Ambil data anggota
        $anggota = AnggotaEkstrakurikuler::findOrFail($request->anggota_id);

        // Tahun ajaran otomatis dari anggota
        $tahunAjaran = $anggota->tahun_ajaran;

        // Jika pembina → ekskul harus ekskul milik pembina
        $ekskulId = $pembinaEkskul ? $pembinaEkskul->id : $request->ekstrakurikuler_id;

        // Validasi anggota milik pembina
        if ($pembinaEkskul) {
            $validAnggota = AnggotaEkstrakurikuler::where('id', $request->anggota_id)
                ->where('ekstrakurikuler_id', $pembinaEkskul->id)
                ->exists();

            if (!$validAnggota) {
                abort(403, "Anggota tidak termasuk ekskul Anda.");
            }
        }

        // Upload Foto
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('penilaians', 'public');
        }

        // Simpan Penilaian
        Penilaian::create([
            'anggota_id'         => $request->anggota_id,
            'ekstrakurikuler_id' => $ekskulId,
            'tahun_ajaran'       => $tahunAjaran, // otomatis
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
        $pembinaEkskul = $this->getPembinaEkskul();

        if ($pembinaEkskul && $penilaian->ekstrakurikuler_id !== $pembinaEkskul->id) {
            abort(403, "Anda tidak berhak mengedit penilaian ini.");
        }

        return view('pembina.penilaian.edit', [
            'penilaian' => $penilaian,
            'anggota'   => $pembinaEkskul
                ? AnggotaEkstrakurikuler::where('ekstrakurikuler_id', $pembinaEkskul->id)->get()
                : AnggotaEkstrakurikuler::all(),

            'ekstra' => $pembinaEkskul ? [$pembinaEkskul] : Ekstrakurikuler::all(),
        ]);
    }

    public function update(Request $request, Penilaian $penilaian)
    {
        $pembinaEkskul = $this->getPembinaEkskul();

        if ($pembinaEkskul && $penilaian->ekstrakurikuler_id !== $pembinaEkskul->id) {
            abort(403, "Anda tidak berhak mengupdate penilaian ini.");
        }

        $validated = $request->validate([
            'anggota_id'          => 'required|exists:anggota_ekstrakurikuler,id',
            'tahun_ajaran'        => 'required|digits:4',
            'semester'            => 'required|in:1,2,3,4,5,6',
            'keterangan'          => 'required|in:sangat baik,baik,cukup baik,cukup,kurang baik',
            'catatan'             => 'nullable',
            'foto'                => 'nullable|image|max:2048',
        ]);

        if ($pembinaEkskul) {
            $validated['ekstrakurikuler_id'] = $pembinaEkskul->id;
        }

        if ($request->hasFile('foto')) {
            if ($penilaian->foto) {
                Storage::disk('public')->delete($penilaian->foto);
            }
            $validated['foto'] = $request->file('foto')->store('penilaians', 'public');
        }

        $penilaian->update($validated);

        return redirect()->route('pembina.penilaian.index')
            ->with('success', 'Data berhasil diperbarui');
    }

    public function destroy(Penilaian $penilaian)
    {
        $pembinaEkskul = $this->getPembinaEkskul();

        if ($pembinaEkskul && $penilaian->ekstrakurikuler_id !== $pembinaEkskul->id) {
            abort(403, "Anda tidak berhak menghapus penilaian ini.");
        }

        if ($penilaian->foto) {
            Storage::disk('public')->delete($penilaian->foto);
        }

        $penilaian->delete();

        return back()->with('success', 'Data berhasil dihapus');
    }
}
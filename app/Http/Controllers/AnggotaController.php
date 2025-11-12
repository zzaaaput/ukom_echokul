<?php

namespace App\Http\Controllers;

use App\Models\Ekstrakurikuler;
use App\Models\AnggotaEkstrakurikuler;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnggotaController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);

        // Dapatkan ekskul yang diasuh oleh pembina login (jika pembina)
        $pembinaEkskul = null;
        if (Auth::check() && Auth::user()->role === 'pembina') {
            $pembinaEkskul = Ekstrakurikuler::where('user_pembina_id', Auth::id())->first();
        }

        // Query dasar anggota
        $query = AnggotaEkstrakurikuler::with(['user', 'ekstrakurikuler'])
            ->orderBy('ekstrakurikuler_id')
            ->orderBy('jabatan', 'asc');

        // 🔒 Jika pembina login → filter anggota hanya dari ekskul yang ia bimbing
        if (Auth::check() && Auth::user()->role === 'pembina' && $pembinaEkskul) {
            $query->where('ekstrakurikuler_id', $pembinaEkskul->id);
        }

        // 🔍 Fitur pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_anggota', 'like', "%$search%")
                    ->orWhere('jabatan', 'like', "%$search%");
            });
        }

        $anggota = $query->paginate($perPage)
            ->appends(['search' => $request->search, 'per_page' => $perPage]);

        $users = User::where('role', 'siswa')
            ->orderBy('nama_lengkap')
            ->get();

        return view('pembina.anggota_index', compact('anggota', 'users', 'pembinaEkskul'));
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !== 'pembina') {
            abort(403, 'Hanya pembina yang dapat menambah anggota.');
        }

        $request->validate([
            'user_id'        => 'required|exists:users,id',
            'nama_anggota'   => 'required|string|max:255',
            'jabatan'        => 'required|in:anggota,pengurus,ketua',
            'tahun_ajaran'   => 'required|digits:4',
            'status_anggota' => 'required|in:aktif,tidak aktif',
            'foto'           => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $pembinaEkskul = Ekstrakurikuler::where('user_pembina_id', Auth::id())->first();
        if (!$pembinaEkskul) {
            return back()->with('error', 'Anda tidak memiliki ekstrakurikuler.');
        }

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $this->uploadFoto($request->file('foto'));
        }

        AnggotaEkstrakurikuler::create([
            'user_id'            => $request->user_id,
            'ekstrakurikuler_id' => $pembinaEkskul->id,
            'nama_anggota'       => $request->nama_anggota,
            'jabatan'            => $request->jabatan,
            'tahun_ajaran'       => $request->tahun_ajaran,
            'status_anggota'     => $request->status_anggota,
            'foto'               => $fotoPath,
            'tanggal_gabung'     => now(),
        ]);

        return redirect()->route('pembina.anggota.index')
            ->with('success', 'Anggota berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        if (Auth::user()->role !== 'pembina') {
            abort(403, 'Hanya pembina yang dapat mengubah anggota.');
        }

        $request->validate([
            'nama_anggota'   => 'required|string|max:255',
            'jabatan'        => 'required|in:anggota,pengurus,ketua',
            'tahun_ajaran'   => 'required|digits:4',
            'status_anggota' => 'required|in:aktif,tidak aktif',
            'foto'           => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $anggota = AnggotaEkstrakurikuler::findOrFail($id);
        if ($anggota->ekstrakurikuler->user_pembina_id !== Auth::id()) {
            abort(403, 'Anda tidak berhak mengubah data anggota ini.');
        }

        if ($request->hasFile('foto')) {
            if ($anggota->foto && file_exists(public_path($anggota->foto))) {
                unlink(public_path($anggota->foto));
            }
            $anggota->foto = $this->uploadFoto($request->file('foto'));
        }

        $anggota->update([
            'nama_anggota'   => $request->nama_anggota,
            'jabatan'        => $request->jabatan,
            'tahun_ajaran'   => $request->tahun_ajaran,
            'status_anggota' => $request->status_anggota,
            'foto'           => $anggota->foto,
        ]);

        return redirect()->route('pembina.anggota.index')
            ->with('success', 'Data anggota berhasil diperbarui!');
    }

    public function destroy($id)
    {
        if (Auth::user()->role !== 'pembina') {
            abort(403, 'Hanya pembina yang dapat menghapus anggota.');
        }

        $anggota = AnggotaEkstrakurikuler::findOrFail($id);
        if ($anggota->ekstrakurikuler->user_pembina_id !== Auth::id()) {
            abort(403, 'Anda tidak berhak menghapus anggota ini.');
        }

        if ($anggota->foto && file_exists(public_path($anggota->foto))) {
            unlink(public_path($anggota->foto));
        }

        $anggota->delete();

        return redirect()->route('pembina.anggota.index')
            ->with('success', 'Anggota berhasil dihapus!');
    }

    private function uploadFoto($file)
    {
        $path = public_path('build/assets/images/anggota');
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
        $file->move($path, $filename);

        return 'build/assets/images/anggota/' . $filename;
    }
}

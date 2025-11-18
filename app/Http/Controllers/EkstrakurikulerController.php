<?php

namespace App\Http\Controllers;

use App\Models\Ekstrakurikuler;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class EkstrakurikulerController extends Controller
{
public function index(Request $request)
{
    $query = Ekstrakurikuler::with(['pembina', 'ketua']);

    // Search otomatis
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where('nama_ekstrakurikuler', 'like', "%$search%")
              ->orWhereHas('pembina', fn($q) => $q->where('nama_lengkap', 'like', "%$search%"))
              ->orWhereHas('ketua', fn($q) => $q->where('nama_lengkap', 'like', "%$search%"));
    }

    // Sorting per kolom
    $sort = $request->get('sort', 'nama_ekstrakurikuler');
    $direction = $request->get('direction', 'asc');
    $allowedSorts = ['nama_ekstrakurikuler', 'pembina', 'ketua', 'deskripsi'];
    
    if (in_array($sort, $allowedSorts)) {
        if ($sort === 'pembina') {
            $query->join('users as u1', 'ekstrakurikuler.user_pembina_id', '=', 'u1.id')
                  ->orderBy('u1.nama_lengkap', $direction)
                  ->select('ekstrakurikuler.*');
        } elseif ($sort === 'ketua') {
            $query->join('users as u2', 'ekstrakurikuler.user_ketua_id', '=', 'u2.id')
                  ->orderBy('u2.nama_lengkap', $direction)
                  ->select('ekstrakurikuler.*');
        } else {
            $query->orderBy($sort, $direction);
        }
    }

    $ekstrakurikuler = $query->paginate(10)->appends($request->query());
    $pembina = User::where('role', 'pembina')->orderBy('nama_lengkap')->get();
    $ketua   = User::where('role', 'ketua')->orderBy('nama_lengkap')->get();

    return view('admin.ekstrakurikuler', compact('ekstrakurikuler', 'pembina', 'ketua', 'sort', 'direction'));
}

    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Hanya admin yang bisa menambahkan ekstrakurikuler.');
        }

        $validator = Validator::make($request->all(), [
            'user_pembina_id'      => 'required|exists:users,id',
            'user_ketua_id'        => 'nullable|exists:users,id',
            'nama_ekstrakurikuler' => 'required|string|max:255',
            'deskripsi'            => 'nullable|string',
            'foto'                 => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $request->only(['user_pembina_id', 'user_ketua_id', 'nama_ekstrakurikuler', 'deskripsi']);

        if ($request->hasFile('foto')) {
            $data['foto'] = $this->uploadFoto($request->file('foto'));
        }

        Ekstrakurikuler::create($data);

        return redirect()->route('ekstrakurikuler.index')->with('success', 'Ekstrakurikuler berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Hanya admin yang bisa mengedit ekstrakurikuler.');
        }

        $ekskul = Ekstrakurikuler::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'user_pembina_id'      => 'required|exists:users,id',
            'user_ketua_id'        => 'nullable|exists:users,id',
            'nama_ekstrakurikuler' => 'required|string|max:255',
            'deskripsi'            => 'nullable|string',
            'foto'                 => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $request->only(['user_pembina_id', 'user_ketua_id', 'nama_ekstrakurikuler', 'deskripsi']);

        if ($request->hasFile('foto')) {
            if ($ekskul->foto && file_exists(public_path($ekskul->foto))) {
                unlink(public_path($ekskul->foto));
            }
            $data['foto'] = $this->uploadFoto($request->file('foto'));
        }

        $ekskul->update($data);

        return redirect()->route('ekstrakurikuler.index')->with('success', 'Ekstrakurikuler berhasil diperbarui.');
    }

    public function destroy($id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Hanya admin yang bisa menghapus ekstrakurikuler.');
        }

        $ekskul = Ekstrakurikuler::findOrFail($id);

        if ($ekskul->foto && file_exists(public_path($ekskul->foto))) {
            unlink(public_path($ekskul->foto));
        }

        $ekskul->delete();

        return redirect()->route('ekstrakurikuler.index')->with('success', 'Ekstrakurikuler berhasil dihapus.');
    }

    private function uploadFoto($file)
    {
        $path = public_path('storage/images/ekstrakurikuler');
        if (!file_exists($path)) mkdir($path, 0777, true);

        $namaFile = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
        $file->move($path, $namaFile);

        return 'storage/images/ekstrakurikuler/' . $namaFile;
    }
}
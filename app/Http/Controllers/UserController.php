<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    /**
     * Tampilkan semua user
     */
    public function index()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Hanya admin yang bisa mengakses halaman ini.');
        }

        $users = User::orderBy('nama_lengkap')->get();

        return view('admin.user', compact('users'));
    }

    /**
     * Form tambah user
     */
    public function create()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Hanya admin yang bisa menambahkan user.');
        }

        $roles = ['admin', 'pembina', 'ketua', 'siswa']; // Pilihan role
        return view('admin.user.create', compact('roles'));
    }

    /**
     * Simpan data user baru
     */
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Hanya admin yang bisa menambahkan user.');
        }

        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email',
            'password'     => 'required|string|min:6|confirmed',
            'role'         => 'required|in:admin,pembina,ketua,siswa',
            'foto'         => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status_aktif' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $request->only(['nama_lengkap', 'email', 'role']);
        $data['status_aktif'] = $request->status_aktif ?? 1;
        $data['password'] = Hash::make($request->password);

        if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
            $data['foto'] = $this->uploadFoto($request->file('foto'));
        }

        User::create($data);

        return redirect()->route('admin.user.index')->with('success', 'User berhasil ditambahkan!');
    }

    /**
     * Form edit user
     */
    public function edit($id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Hanya admin yang bisa mengedit user.');
        }

        $user = User::findOrFail($id);
        $roles = ['admin', 'pembina', 'ketua', 'siswa'];

        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update data user
     */
    public function update(Request $request, $id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Hanya admin yang bisa mengubah data user.');
        }

        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email,' . $id,
            'password'     => 'nullable|string|min:6|confirmed',
            'role'         => 'required|in:admin,pembina,ketua,siswa',
            'foto'         => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status_aktif' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $request->only(['nama_lengkap', 'email', 'role']);
        $data['status_aktif'] = $request->status_aktif ?? $user->status_aktif;

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
            if ($user->foto && file_exists(public_path($user->foto))) {
                unlink(public_path($user->foto));
            }
            $data['foto'] = $this->uploadFoto($request->file('foto'));
        }

        $user->update($data);

        return redirect()->route('admin.user.index')->with('success', 'User berhasil diperbarui!');
    }

    /**
     * Hapus user
     */
    public function destroy($id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Hanya admin yang bisa menghapus user.');
        }

        $user = User::findOrFail($id);

        // Jangan biarkan admin menghapus dirinya sendiri
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.user.index')->with('error', 'Anda tidak bisa menghapus user sendiri!');
        }

        if ($user->foto && file_exists(public_path($user->foto))) {
            unlink(public_path($user->foto));
        }

        $user->delete();

        return redirect()->route('admin.user.index')->with('success', 'User berhasil dihapus!');
    }

    /**
     * Helper upload foto
     */
    private function uploadFoto($file)
    {
        $path = public_path('storage/images/users');

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $namaFile = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
        $file->move($path, $namaFile);

        return 'storage/images/users/' . $namaFile;
    }

    public function exportExcel()
    {
        return Excel::download(new UsersExport, 'data-user.xlsx');
    }

}
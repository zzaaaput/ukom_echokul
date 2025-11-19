<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class ProfileController extends Controller
{
    public function index()
    {
        $data = PendaftaranController::with('ekstrakurikuler')
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pendaftaran.index', compact('data'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
    
        $request->validate([
            'nama_lengkap' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'foto' => 'nullable|image|max:2048'
        ]);
    
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $path = public_path('storage/images/users');
        
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
        
            $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $file->move($path, $filename);
        
            // Hapus foto lama
            if ($user->foto && file_exists(public_path($user->foto))) {
                unlink(public_path($user->foto));
            }
        
            $user->foto = 'storage/images/users/' . $filename;
        }
        
    
        $user->nama_lengkap = $request->nama_lengkap;
        $user->email = $request->email;
        $user->save();
    
        return redirect()->route('profile.edit')->with('success', 'Profil berhasil diperbarui');
    }    

    public function password()
    {
        return view('profile.password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password_lama' => 'required',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = Auth::user();

        if (!Hash::check($request->password_lama, $user->password)) {
            return back()->withErrors(['password_lama' => 'Password lama salah']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('profile.password')->with('success', 'Password berhasil diubah');
    }
}
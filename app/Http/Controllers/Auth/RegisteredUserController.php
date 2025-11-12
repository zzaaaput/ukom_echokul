<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Tampilkan form register
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Proses pendaftaran
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['nullable', 'in:admin,pembina,ketua,siswa'], 
        ]);

        $user = User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role ?? 'siswa', 
        ]);

        Auth::login($user);

        switch ($user->role) {
            case 'admin':
                return redirect()->route('dashboard.admin.index');
            case 'pembina':
                return redirect()->route('dashboard.pembina.index');
            case 'ketua':
                return redirect()->route('dashboard.ketua.index');
            default:
                return redirect()->route('dashboard.siswa.index');
        }
    }
}
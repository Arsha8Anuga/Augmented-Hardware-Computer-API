<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // --- TAMBAHKAN INI (Untuk Menampilkan Halaman) ---
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }
    // ------------------------------------------------

    // 1. FUNGSI PROSES REGISTER
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users', 
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        User::create([
            'username' => $request->username,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect('/login')->with('success', 'Akun berhasil dibuat! Silakan login.');
    }

    // 2. FUNGSI PROSES LOGIN
    public function login(Request $request)
    {
        $user = User::where('username', $request->username)
                    ->where('email', $request->email)
                    ->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            return redirect('/mahasiswa'); 
        }

        return back()->withErrors([
            'loginError' => 'Username, Email, atau Password Anda salah!'
        ])->withInput();
    }

    // 3. FUNGSI LOGOUT
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
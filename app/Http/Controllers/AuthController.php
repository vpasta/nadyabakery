<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // 1. Menampilkan halaman form login
    public function showLogin()
    {
        return view('auth-login');
    }

    // 2. Memproses data email & password yang diinput
    public function prosesLogin(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required', 
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/kasir'); 
        }

        // Mengembalikan pesan error jika gagal
        return back()->with('error', 'Username atau Password salah!');
    }

    // 3. Proses Keluar (Logout)
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/'); // Kembali ke landing page
    }
}

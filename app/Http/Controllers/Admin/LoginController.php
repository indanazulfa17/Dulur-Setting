<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Tampilkan form login admin.
     */
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    /**
     * Override default login field (email → username)
     */
    public function username()
    {
        return 'username';
    }

    /**
     * Proses login admin.
     */
    public function login(Request $request)
    {
        // Validasi input login
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Ambil data login
        $credentials = $request->only('username', 'password');

        // Coba login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); // regenerate session untuk keamanan
            return redirect()->intended(route('admin.dashboard')); // gunakan intended
        }
        
        // Jika gagal login
        return back()->withErrors([
            'username' => 'Username atau password salah!',
        ])->withInput();
    }

    /**
     * Logout admin.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('status', 'Berhasil logout.');
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Tampilkan halaman login
    public function showLoginForm()
    {
        return view('auth.login'); // Pastikan file login.blade.php ada di resources/views/auth/
    }

    // Proses login
    public function login(Request $request)
    {
        // Validasi input email dan password
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Coba autentikasi user
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            // Redirect ke intended page (biasanya dashboard/home)
            return redirect()->intended('/home');
        }

        // Jika gagal, kembali dengan pesan error dan input email tetap tampil
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // Proses logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
    protected function authenticated(Request $request, $user)
{
    if ($user->hasRole('mandor')) {
        return redirect()->route('mandor.dashboard');
    }

    if ($user->hasRole('pemilik')) {
        return redirect()->route('pemilik.dashboard');
    }

    return redirect('/home');
}

}

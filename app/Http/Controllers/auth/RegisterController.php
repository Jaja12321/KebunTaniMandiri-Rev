<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class RegisterController extends Controller
{
    /**
     * Tampilkan form register.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        // Ambil hanya role yang diizinkan untuk dipilih saat register
        $roles = Role::whereIn('name', ['pemilik', 'mandor'])->get();

        return view('auth.register', compact('roles'));
    }

    /**
     * Proses registrasi user baru.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        // Validasi input user
        $validated = $request->validate([
            'name'       => ['required', 'string', 'max:255'],
            'last_name'  => ['required', 'string', 'max:255'],
            'email'      => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'   => ['required', 'string', 'min:8', 'confirmed'],
            'role'       => ['required', 'in:pemilik,mandor'],
        ]);

        // Simpan user baru
        $user = User::create([
            'name'      => $validated['name'],
            'last_name' => $validated['last_name'],
            'email'     => $validated['email'],
            'password'  => Hash::make($validated['password']),
        ]);

        // Assign role yang dipilih
        $user->assignRole($validated['role']);

        // Login user
        Auth::login($user);

        // Redirect ke halaman home/dashboard
        return redirect()
            ->route('home')
            ->with('success', 'Pendaftaran berhasil!');
    }
}

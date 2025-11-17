<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    /**
     * Show registration form
     */
    public function showRegisterForm()
    {
        return view('pages.register');
    }

    /**
     * Handle user registration
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'       => ['required', 'string', 'max:255'],
            'email'      => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone'      => ['required', 'string', 'max:20'],
            'university' => ['nullable', 'string', 'max:255'],
            'interest'   => ['nullable', 'string', 'max:255'],
            'password'   => ['required', 'confirmed', Password::min(8)],
        ], [
            'name.required'     => 'Nama lengkap wajib diisi.',
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'email.unique'      => 'Email sudah terdaftar.',
            'phone.required'    => 'Nomor handphone wajib diisi.',
            'password.required' => 'Password wajib diisi.',
            'password.confirmed'=> 'Konfirmasi password tidak cocok.',
            'password.min'      => 'Password minimal 8 karakter.',
        ]);

        // Create new user
        $user = User::create([
            'name'       => $validated['name'],
            'email'      => $validated['email'],
            'phone'      => $validated['phone'],
            'university' => $validated['university'] ?? null,
            'interest'   => $validated['interest'] ?? null,
            'password'   => Hash::make($validated['password']),
            'is_admin'   => false,
        ]);

        // Auto login after registration
        Auth::login($user);

        return redirect()->route('home')
            ->with('success', 'Pendaftaran berhasil! Selamat datang di Bimbel Farmasi.');
    }

    /**
     * Show login form
     */
    public function showLoginForm()
    {
        return view('pages.login');
    }

    /**
     * Handle user login (email + password)
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            if (Auth::user()->is_admin) {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->intended(route('home'))
                ->with('success', 'Selamat datang kembali!');
        }

        return back()->withErrors([
            'email' => 'Email atau password tidak valid.',
        ])->onlyInput('email');
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Anda telah keluar.');
    }

    // ====================================================
    //               LOGIN DENGAN GOOGLE
    // ====================================================

    /**
     * Redirect user ke halaman Google Login
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle callback dari Google
     */
    public function handleGoogleCallback()
    {
        try {
            // stateless() supaya aman kalau tidak pakai session state default
            $googleUser = Socialite::driver('google')->stateless()->user();
        } catch (\Exception $e) {
            return redirect()
                ->route('login')
                ->with('error', 'Gagal login dengan Google. Silakan coba lagi.');
        }

        // Cari user berdasarkan email Google
        $user = User::where('email', $googleUser->getEmail())->first();

        // Kalau belum ada, buat user baru
        if (! $user) {
            $user = User::create([
                'name'       => $googleUser->getName() ?? $googleUser->getNickname() ?? 'Pengguna Google',
                'email'      => $googleUser->getEmail(),
                'phone'      => null,
                'university' => null,
                'interest'   => null,
                // password random (user normalnya tetap login via Google)
                'password'   => Hash::make(uniqid('google_', true)),
                'is_admin'   => false,
            ]);
        }

        // Login user
        Auth::login($user, true);

        return redirect()->intended(route('home'))
            ->with('success', 'Berhasil login dengan Google.');
    }
}


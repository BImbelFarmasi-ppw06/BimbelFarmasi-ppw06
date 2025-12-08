<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    /**
     * Tampilkan form register
     */
    public function showRegisterForm()
    {
        // kamu tadi pakai view 'pages.register'
        return view('pages.register');
    }

    /**
     * Proses registrasi user baru (email + password biasa)
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'email'       => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone'       => ['required', 'string', 'max:20'],
            'university'  => ['nullable', 'string', 'max:255'],
            'interest'    => ['nullable', 'string', 'max:255'],
            'password'    => ['required', 'confirmed', Password::min(8)],
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

        // Buat user baru
        $user = User::create([
            'name'       => $validated['name'],
            'email'      => $validated['email'],
            'phone'      => $validated['phone'],
            'university' => $validated['university'] ?? null,
            'interest'   => $validated['interest'] ?? null,
            'password'   => Hash::make($validated['password']),
            'is_admin'   => false,
        ]);

        // Auto login setelah daftar
        Auth::login($user);

        return redirect()->route('home')
            ->with('success', 'Pendaftaran berhasil! Selamat datang di Bimbel Farmasi.');
    }

    /**
     * Tampilkan form login
     */
    public function showLoginForm()
    {
        // kamu tadi pakai view 'pages.login'
        return view('pages.login');
    }

    /**
     * Proses login biasa (email + password)
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

            // Arahkan sesuai role
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
     * LOGIN DENGAN GOOGLE
     * Step 1: redirect ke halaman OAuth Google
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * LOGIN DENGAN GOOGLE
     * Step 2: terima callback dari Google
     * 
     * Flow: Email baru → Auto-register dengan data minimal → Login
     */
    public function handleGoogleCallback()
    {
        try {
            // Ambil data user dari Google
            $googleUser = Socialite::driver('google')->user();
            $email = $googleUser->getEmail();
            $name = $googleUser->getName() ?? $googleUser->getNickname() ?? 'User';

            // Cek apakah email sudah terdaftar
            $user = User::where('email', $email)->first();

            if (!$user) {
                // ✅ Email baru → Auto-register dengan data minimal
                // User bisa lengkapi data di halaman profil nanti
                $user = User::create([
                    'name'       => $name,
                    'email'      => $email,
                    'phone'      => null,  // Akan diisi user di profil
                    'university' => null,  // Akan diisi user di profil
                    'interest'   => null,  // Akan diisi user di profil
                    'password'   => Hash::make(Str::random(32)),  // Random password
                    'is_admin'   => false,
                ]);
            }

            // Login user
            Auth::login($user, remember: true);

            // Jika data belum lengkap (tidak ada phone), arahkan ke profil untuk lengkapi
            if (is_null($user->phone)) {
                return redirect()->route('user.profile')
                    ->with('info', 'Selamat datang! Silakan lengkapi data profil Anda.');
            }

            return redirect()->intended(route('home'))
                ->with('success', 'Selamat datang! Anda berhasil login dengan Google.');

        } catch (\Exception $e) {
            return redirect()->route('login')
                ->with('error', 'Gagal login dengan Google: ' . $e->getMessage());
        }
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Anda telah keluar.');
    }
}

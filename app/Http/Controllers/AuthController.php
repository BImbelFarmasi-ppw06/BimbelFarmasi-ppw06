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
     * ✅ SMART FLOW: Jika email belum register → auto-register, kemudian login
     *               Jika email sudah register → langsung login
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
                // ✅ Email belum ada → Auto-register dengan data dari Google
                $user = User::create([
                    'name'       => $name,
                    'email'      => $email,
                    'phone'      => null,  // User isi nanti di profil
                    'university' => null,  // User isi nanti di profil
                    'interest'   => null,  // User isi nanti di profil
                    'password'   => Hash::make(Str::random(32)),  // Random password
                    'is_admin'   => false,
                ]);
                
                // Pesan untuk user baru
                $welcomeMessage = 'Selamat datang! Akun Anda berhasil dibuat dengan Google. Silakan lengkapi data profil Anda.';
                $redirectToProfile = true;
            } else {
                // Email sudah ada → User sudah pernah register
                $welcomeMessage = 'Selamat datang kembali! Anda berhasil login dengan Google.';
                $redirectToProfile = false;
            }

            // Login user
            Auth::login($user, remember: true);

            // Cek role untuk redirect sesuai
            if ($user->is_admin) {
                return redirect()->route('admin.dashboard')
                    ->with('success', 'Selamat datang di Admin Panel!');
            }

            // Jika user baru, arahkan ke profil untuk lengkapi data
            if ($redirectToProfile && is_null($user->phone)) {
                return redirect()->route('user.profile')
                    ->with('info', $welcomeMessage);
            }

            return redirect()->intended(route('home'))
                ->with('success', $welcomeMessage);

        } catch (\Exception $e) {
            return redirect()->route('login')
                ->with('error', 'Gagal login dengan Google: ' . $e->getMessage());
        }
    }

    /**
     * LOGIN DENGAN FACEBOOK
     * Step 1: redirect ke Facebook
     */
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * LOGIN DENGAN FACEBOOK
     * Step 2: terima callback dari Facebook
     * 
     * ✅ SMART FLOW: Jika email belum register → auto-register, kemudian login
     *               Jika email sudah register → langsung login
     */
    public function handleFacebookCallback()
    {
        try {
            // Ambil data user dari Facebook
            $facebookUser = Socialite::driver('facebook')->user();
            $email = $facebookUser->getEmail();
            $name = $facebookUser->getName() ?? 'User';

            // Validasi: Facebook harus return email
            if (!$email) {
                return redirect()->route('login')
                    ->with('error', 'Tidak dapat mengambil email dari Facebook. Pastikan akun Facebook Anda memiliki email.');
            }

            // Cek apakah email sudah terdaftar
            $user = User::where('email', $email)->first();

            if (!$user) {
                // ✅ Email belum ada → Auto-register dengan data dari Facebook
                $user = User::create([
                    'name'       => $name,
                    'email'      => $email,
                    'phone'      => null,  // User isi nanti di profil
                    'university' => null,  // User isi nanti di profil
                    'interest'   => null,  // User isi nanti di profil
                    'password'   => Hash::make(Str::random(32)),  // Random password
                    'is_admin'   => false,
                ]);
                
                // Pesan untuk user baru
                $welcomeMessage = 'Selamat datang! Akun Anda berhasil dibuat dengan Facebook. Silakan lengkapi data profil Anda.';
                $redirectToProfile = true;
            } else {
                // Email sudah ada → User sudah pernah register
                $welcomeMessage = 'Selamat datang kembali! Anda berhasil login dengan Facebook.';
                $redirectToProfile = false;
            }

            // Login user
            Auth::login($user, remember: true);

            // Cek role untuk redirect sesuai
            if ($user->is_admin) {
                return redirect()->route('admin.dashboard')
                    ->with('success', 'Selamat datang di Admin Panel!');
            }

            // Jika user baru, arahkan ke profil untuk lengkapi data
            if ($redirectToProfile && is_null($user->phone)) {
                return redirect()->route('user.profile')
                    ->with('info', $welcomeMessage);
            }

            return redirect()->intended(route('home'))
                ->with('success', $welcomeMessage);

        } catch (\Exception $e) {
            return redirect()->route('login')
                ->with('error', 'Gagal login dengan Facebook: ' . $e->getMessage());
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

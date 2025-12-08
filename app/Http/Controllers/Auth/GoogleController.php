<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    /**
     * Redirect ke Google OAuth
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
            $googleUser = Socialite::driver('google')->user();
            
            // Cari user berdasarkan email
            $user = User::where('email', $googleUser->email)->first();
            
            if ($user) {
                // Jika user sudah ada, langsung login
                Auth::login($user);
            } else {
                // Jika user baru, buat akun baru
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'password' => Hash::make(uniqid()), // Random password
                    'role' => 'student', // Default role
                    'google_id' => $googleUser->id,
                    'profile_photo' => $googleUser->avatar,
                ]);
                
                Auth::login($user);
            }
            
            return redirect()->route('student.courses')
                ->with('success', '🎉 Berhasil login dengan Google!');
                
        } catch (\Exception $e) {
            return redirect()->route('login')
                ->with('error', 'Gagal login dengan Google: ' . $e->getMessage());
        }
    }
}

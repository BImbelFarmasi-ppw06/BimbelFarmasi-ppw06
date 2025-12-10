@extends('layouts.app')

@section('title', 'Masuk Akun Bimbel Farmasi')

@section('content')
    <section class="bg-gradient-to-br from-blue-50 via-white to-blue-100 min-h-screen flex items-center justify-center">
        <div class="mx-auto max-w-xl px-4 py-16 sm:px-6 lg:px-8 w-full">
            <!-- Form Login (Tengah, Lebih Lebar) -->
            <div class="rounded-3xl border border-blue-200 bg-white p-10 shadow-xl hover:shadow-2xl transition-shadow duration-300">
                <!-- Logo -->
                <div class="flex justify-center mb-6">
                    <img src="{{ asset('images/logo bimbel farmasi.jpg') }}" alt="Bimbel Farmasi Logo" class="h-24 w-24 rounded-full object-cover shadow-lg">
                </div>
                <h2 class="text-center text-2xl font-bold text-[#2D3C8C] mb-2">Bimbel Farmasi</h2>
                <p class="text-center text-sm text-slate-600 mb-8 italic">"Rajin Pangkal Kompeten"</p>
                
                <div class="flex w-full flex-col gap-8">
                    <!-- Tab Masuk/Daftar -->
                    <div class="flex items-center gap-4 border-b border-blue-200 pb-4 text-sm font-semibold">
                        <span class="rounded-full bg-[#2D3C8C] px-6 py-2 text-white shadow-md">Masuk</span>
                        <a href="{{ route('register') }}" class="rounded-full px-6 py-2 text-[#2D3C8C] transition hover:bg-blue-50 hover:shadow-md">Daftar</a>
                    </div>

                    <!-- Form -->
                    <form action="{{ route('login.submit') }}" method="POST" class="space-y-6">
                        @csrf
                        <div>
                            <label for="email" class="text-xs font-semibold uppercase tracking-wide text-slate-500">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" class="mt-2 w-full rounded-xl border border-blue-200 px-4 py-3 text-sm text-slate-700 placeholder-slate-400 focus:border-[#2D3C8C] focus:outline-none focus:ring-2 focus:ring-blue-300 transition-all duration-200 @error('email') border-red-400 @enderror" placeholder="Masukkan email Anda" required aria-label="Email">
                            @error('email')
                                <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <div class="flex items-center justify-between text-xs font-semibold text-slate-500">
                                <label for="password" class="uppercase tracking-wide">Password</label>
                                <a href="#" class="text-[#2D3C8C] hover:underline hover:text-blue-700 transition-colors">Lupa Password?</a>
                            </div>
                            <input type="password" id="password" name="password" class="mt-2 w-full rounded-xl border border-blue-200 px-4 py-3 text-sm text-slate-700 placeholder-slate-400 focus:border-[#2D3C8C] focus:outline-none focus:ring-2 focus:ring-blue-300 transition-all duration-200 @error('password') border-red-400 @enderror" placeholder="Masukkan password Anda" required aria-label="Password">
                            @error('password')
                                <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                        <label class="flex items-center gap-3 text-xs text-slate-500 cursor-pointer">
                            <input type="checkbox" name="remember" class="h-4 w-4 rounded border-blue-300 text-[#2D3C8C] focus:ring-[#2D3C8C] focus:ring-2" aria-label="Ingat Saya">
                            Ingat Saya
                        </label>
                        <button type="submit" class="w-full rounded-full bg-[#2D3C8C] px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-[#2D3C8C]/40 transition-all duration-200 hover:bg-blue-900 hover:shadow-xl hover:scale-105" aria-label="Masuk">Masuk</button>
                    </form>

                    <!-- Divider -->
                    <div class="flex items-center gap-4 text-xs text-slate-400">
                        <span class="flex-1 border-t border-blue-200"></span>
                        atau
                        <span class="flex-1 border-t border-blue-200"></span>
                    </div>

                    <!-- Google Login -->
                    <a href="{{ route('login.google') }}" class="inline-flex w-full items-center justify-center gap-3 rounded-full border border-blue-200 bg-white px-6 py-3 text-sm font-semibold text-slate-600 shadow-md transition-all duration-200 hover:bg-blue-50 hover:shadow-lg hover:scale-105" aria-label="Masuk dengan Google">
                        <img src="{{ asset('images/google.png') }}" alt="Google" class="h-5 w-5">
                        Masuk dengan Google
                    </a>

                    <!-- Facebook Login -->
                    <a href="{{ route('login.facebook') }}" class="inline-flex w-full items-center justify-center gap-3 rounded-full border border-blue-600 bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-md transition-all duration-200 hover:bg-blue-700 hover:shadow-lg hover:scale-105" aria-label="Masuk dengan Facebook">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                        Masuk dengan Facebook
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
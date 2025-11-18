@extends('layouts.app')

@section('title', 'Daftar Akun Bimbel Farmasi')

@section('content')
    <section class="bg-gradient-to-br from-blue-50 via-white to-blue-100 min-h-screen flex items-center justify-center">
        <div class="mx-auto max-w-xl px-4 py-16 sm:px-6 lg:px-8 w-full">
            <!-- Form Register (Tengah) -->
            <div class="rounded-3xl border border-blue-200 bg-white p-10 shadow-xl hover:shadow-2xl transition-shadow duration-300">
                <!-- Logo -->
                <div class="flex justify-center mb-6">
                    <img src="{{ asset('images/logo bimbel farmasi.jpg') }}" alt="Bimbel Farmasi Logo" class="h-24 w-24 rounded-full object-cover shadow-lg">
                </div>
                <h2 class="text-center text-2xl font-bold text-[#2D3C8C] mb-2">Bimbel Farmasi</h2>
                <p class="text-center text-sm text-slate-600 mb-8 italic">"Raih Pangkal Kompeten"</p>
                
                <div class="flex w-full flex-col gap-8">
                    <!-- Tab Masuk/Daftar -->
                    <div class="flex items-center gap-4 border-b border-blue-200 pb-4 text-sm font-semibold">
                        <a href="{{ route('login') }}" class="rounded-full px-6 py-2 text-[#2D3C8C] transition hover:bg-blue-50 hover:shadow-md">Masuk</a>
                        <span class="rounded-full bg-[#2D3C8C] px-6 py-2 text-white shadow-md">Daftar</span>
                    </div>

                    <!-- Form -->
                    <form action="{{ route('register.submit') }}" method="POST" class="space-y-6">
                        @csrf
                        <div>
                            <label for="name" class="text-xs font-semibold uppercase tracking-wide text-slate-500">Nama Lengkap</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" class="mt-2 w-full rounded-xl border border-blue-200 px-4 py-3 text-sm text-slate-700 placeholder-slate-400 focus:border-[#2D3C8C] focus:outline-none focus:ring-2 focus:ring-blue-300 transition-all duration-200 @error('name') border-red-400 @enderror" placeholder="Masukkan nama lengkap" required aria-label="Nama Lengkap">
                            @error('name')
                                <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="email" class="text-xs font-semibold uppercase tracking-wide text-slate-500">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" class="mt-2 w-full rounded-xl border border-blue-200 px-4 py-3 text-sm text-slate-700 placeholder-slate-400 focus:border-[#2D3C8C] focus:outline-none focus:ring-2 focus:ring-blue-300 transition-all duration-200 @error('email') border-red-400 @enderror" placeholder="nama@email.com" required aria-label="Email">
                            @error('email')
                                <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="phone" class="text-xs font-semibold uppercase tracking-wide text-slate-500">No. Handphone</label>
                            <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" class="mt-2 w-full rounded-xl border border-blue-200 px-4 py-3 text-sm text-slate-700 placeholder-slate-400 focus:border-[#2D3C8C] focus:outline-none focus:ring-2 focus:ring-blue-300 transition-all duration-200 @error('phone') border-red-400 @enderror" placeholder="08xxxxxxxxxx" required aria-label="No. Handphone">
                            @error('phone')
                                <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="university" class="text-xs font-semibold uppercase tracking-wide text-slate-500">Universitas (Opsional)</label>
                            <input type="text" id="university" name="university" value="{{ old('university') }}" class="mt-2 w-full rounded-xl border border-blue-200 px-4 py-3 text-sm text-slate-700 placeholder-slate-400 focus:border-[#2D3C8C] focus:outline-none focus:ring-2 focus:ring-blue-300 transition-all duration-200" placeholder="Nama institusi" aria-label="Universitas">
                        </div>
                        <div>
                            <label for="interest" class="text-xs font-semibold uppercase tracking-wide text-slate-500">Tertarik Dengan</label>
                            <select id="interest" name="interest" class="mt-2 w-full rounded-xl border border-blue-200 bg-white px-4 py-3 text-sm text-slate-600 focus:border-[#2D3C8C] focus:outline-none focus:ring-2 focus:ring-blue-300 transition-all duration-200" aria-label="Tertarik Dengan">
                                <option value="">Pilih layanan</option>
                                <option value="Bimbel UKOM D3 Farmasi" {{ old('interest') == 'Bimbel UKOM D3 Farmasi' ? 'selected' : '' }}>Bimbel UKOM D3 Farmasi</option>
                                <option value="CPNS & P3K Farmasi" {{ old('interest') == 'CPNS & P3K Farmasi' ? 'selected' : '' }}>CPNS &amp; P3K Farmasi</option>
                                <option value="Joki Tugas Akademik" {{ old('interest') == 'Joki Tugas Akademik' ? 'selected' : '' }}>Joki Tugas Akademik</option>
                                <option value="Konsultasi Akademik" {{ old('interest') == 'Konsultasi Akademik' ? 'selected' : '' }}>Konsultasi Akademik</option>
                            </select>
                        </div>
                        <div class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <label for="password" class="text-xs font-semibold uppercase tracking-wide text-slate-500">Password</label>
                                <input type="password" id="password" name="password" class="mt-2 w-full rounded-xl border border-blue-200 px-4 py-3 text-sm text-slate-700 placeholder-slate-400 focus:border-[#2D3C8C] focus:outline-none focus:ring-2 focus:ring-blue-300 transition-all duration-200 @error('password') border-red-400 @enderror" placeholder="Minimal 8 karakter" required aria-label="Password">
                                @error('password')
                                    <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="password_confirmation" class="text-xs font-semibold uppercase tracking-wide text-slate-500">Konfirmasi Password</label>
                                <input type="password" id="password_confirmation" name="password_confirmation" class="mt-2 w-full rounded-xl border border-blue-200 px-4 py-3 text-sm text-slate-700 placeholder-slate-400 focus:border-[#2D3C8C] focus:outline-none focus:ring-2 focus:ring-blue-300 transition-all duration-200" placeholder="Ulangi password" required aria-label="Konfirmasi Password">
                            </div>
                        </div>
                        <label class="flex items-start gap-3 text-xs text-slate-500 cursor-pointer">
                            <input type="checkbox" class="mt-1 h-4 w-4 rounded border-blue-300 text-[#2D3C8C] focus:ring-[#2D3C8C] focus:ring-2" required aria-label="Setuju Syarat & Ketentuan">
                            Dengan mendaftar, saya menyetujui <a href="#" class="ml-1 font-semibold text-[#2D3C8C] hover:underline hover:text-blue-700 transition-colors">Syarat &amp; Ketentuan</a> dan kebijakan privasi Bimbel Farmasi.
                        </label>
                        <button type="submit" class="w-full rounded-full bg-[#2D3C8C] px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-[#2D3C8C]/40 transition-all duration-200 hover:bg-blue-900 hover:shadow-xl hover:scale-105" aria-label="Daftar">Daftar</button>
                    </form>

                    <!-- Divider -->
                    <div class="flex items-center gap-4 text-xs text-slate-400">
                        <span class="flex-1 border-t border-blue-200"></span>
                        atau
                        <span class="flex-1 border-t border-blue-200"></span>
                    </div>

                    <!-- Google Register -->
                    <a href="{{ route('login.google') }}" class="inline-flex w-full items-center justify-center gap-3 rounded-full border border-blue-200 bg-white px-6 py-3 text-sm font-semibold text-slate-600 shadow-md transition-all duration-200 hover:bg-blue-50 hover:shadow-lg hover:scale-105" aria-label="Daftar dengan Google">
                        <img src="https://www.gstatic.com/images/branding/product/2x/google_g_48dp.png" alt="Google" class="h-5 w-5">
                        Daftar dengan Google
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
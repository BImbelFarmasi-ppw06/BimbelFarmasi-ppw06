@extends('layouts.app')

@section('title', 'Hubungi Kami')

@section('meta_description', 'Hubungi Bimbel Farmasi untuk konsultasi UKOM D3 Farmasi, CPNS & P3K Farmasi, dan pendampingan tugas akademik. Layanan customer support 24/7 siap membantu Anda.')

@section('meta_keywords', 'kontak bimbel farmasi, hubungi bimbel farmasi, customer service farmasi, konsultasi ukom farmasi, info pendaftaran bimbel farmasi, whatsapp bimbel farmasi')

@section('og_title', 'Hubungi Kami - Bimbel Farmasi')

@section('og_description', 'Punya pertanyaan tentang program UKOM, CPNS & P3K Farmasi? Hubungi kami sekarang! Tim kami siap membantu Anda 24/7.')

@section('content')
    <!-- Hero Section with Full Background Image -->
    <section class="relative min-h-[600px] overflow-hidden">
        <!-- Background Image -->
        <div class="absolute inset-0">
            <img 
                src="{{ asset('images/kontak.png') }}" 
                alt="Hubungi Kami" 
                class="w-full h-full object-cover"
                onerror="this.style.background='linear-gradient(to bottom right, #2D3C8C, #1e2761)'">
            <!-- Dark Overlay -->
            <div class="absolute inset-0 bg-black/50"></div>
        </div>

        <!-- Content -->
        <div class="relative z-10 flex items-center justify-center min-h-[600px]">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-20">
                <div class="text-center text-white">
                    <span class="inline-flex items-center rounded-full bg-white/20 backdrop-blur-md px-6 py-2 text-xs font-semibold uppercase tracking-widest text-white mb-6">
                        💬 Layanan 24/7
                    </span>
                    <h1 class="text-5xl sm:text-6xl font-bold mb-6 drop-shadow-lg">Hubungi Kami</h1>
                    <p class="mx-auto max-w-2xl text-lg sm:text-xl text-white/90 drop-shadow-md leading-relaxed">
                        Kami siap membantu menjawab pertanyaan dan memberikan solusi terbaik untuk kebutuhan akademik farmasi Anda. Jangan ragu untuk menghubungi!
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Information & Form -->
    <section class="relative bg-gradient-to-br from-blue-50 via-white to-purple-50 py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-12 lg:grid-cols-2">
                <!-- Contact Information -->
                <div>
                    <div class="mb-10">
                        <h2 class="text-3xl font-bold text-gray-900">Informasi Kontak</h2>
                        <p class="mt-2 text-gray-600">Pilih cara yang paling nyaman untuk menghubungi kami</p>
                    </div>

                    <div class="space-y-4">
                        <!-- WhatsApp -->
                        <a href="https://wa.me/6281536908359?text=Halo%20Bimbel%20Farmasi,%20saya%20ingin%20bertanya%20tentang%20layanan" target="_blank" class="group flex items-start gap-4 rounded-2xl bg-white p-6 shadow-md transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            <div class="flex-shrink-0 rounded-full bg-gradient-to-br from-green-400 to-green-600 p-4 shadow-lg">
                                <svg class="h-8 w-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-bold text-gray-900 group-hover:text-green-600 transition">WhatsApp</h3>
                                <p class="mt-1 text-sm text-gray-600">Respon cepat & langsung chat</p>
                                <p class="mt-2 font-semibold text-green-600">+62 815-3690-8359</p>
                            </div>
                            <svg class="h-5 w-5 text-gray-400 group-hover:text-green-600 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>

                        <!-- Email -->
                        <a href="mailto:bimbelfarmasimdn@gmail.com?subject=Pertanyaan%20Layanan%20Bimbel" class="group flex items-start gap-4 rounded-2xl bg-white p-6 shadow-md transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            <div class="flex-shrink-0 rounded-full bg-gradient-to-br from-blue-400 to-[#2D3C8C] p-4 shadow-lg">
                                <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-bold text-gray-900 group-hover:text-[#2D3C8C] transition">Email</h3>
                                <p class="mt-1 text-sm text-gray-600">Kirim pertanyaan detail via email</p>
                                <p class="mt-2 font-semibold text-[#2D3C8C]">bimbelfarmasimdn@gmail.com</p>
                            </div>
                            <svg class="h-5 w-5 text-gray-400 group-hover:text-[#2D3C8C] transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>

                        <!-- Phone -->
                        <a href="tel:+6281536908359" class="group flex items-start gap-4 rounded-2xl bg-white p-6 shadow-md transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            <div class="flex-shrink-0 rounded-full bg-gradient-to-br from-purple-400 to-purple-600 p-4 shadow-lg">
                                <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-bold text-gray-900 group-hover:text-purple-600 transition">Telepon</h3>
                                <p class="mt-1 text-sm text-gray-600">Hubungi langsung via telepon</p>
                                <p class="mt-2 font-semibold text-purple-600">+62 815-3690-8359</p>
                            </div>
                            <svg class="h-5 w-5 text-gray-400 group-hover:text-purple-600 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>

                        <!-- Instagram -->
                        <a href="https://instagram.com/bimbelfarmasi" target="_blank" class="group flex items-start gap-4 rounded-2xl bg-white p-6 shadow-md transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            <div class="flex-shrink-0 rounded-full bg-gradient-to-br from-pink-400 via-purple-500 to-orange-400 p-4 shadow-lg">
                                <svg class="h-8 w-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-bold text-gray-900 group-hover:text-pink-600 transition">Instagram</h3>
                                <p class="mt-1 text-sm text-gray-600">Follow untuk tips & update terbaru</p>
                                <p class="mt-2 font-semibold text-pink-600">@bimbelfarmasi</p>
                            </div>
                            <svg class="h-5 w-5 text-gray-400 group-hover:text-pink-600 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>

                        <!-- Office Address -->
                        <div class="flex items-start gap-4 rounded-2xl bg-white p-6 shadow-md">
                            <div class="flex-shrink-0 rounded-full bg-gradient-to-br from-orange-400 to-red-500 p-4 shadow-lg">
                                <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-bold text-gray-900">Alamat Kantor</h3>
                                <a href="https://www.google.com/maps/search/?api=1&query=Jl.+Bunga+Mayang+I+No.+19,+Lau+Cih,+Medan+Tuntungan" 
                                   target="_blank" 
                                   rel="noopener noreferrer"
                                   class="mt-1 block text-sm text-blue-600 hover:text-blue-800 hover:underline transition">
                                    📍 Jl. Bunga Mayang I No. 19
                                </a>
                                <p class="text-sm text-gray-600">Lau Cih, Medan Tuntungan</p>
                                <a href="https://www.google.com/maps/search/?api=1&query=Jl.+Bunga+Mayang+I+No.+19,+Lau+Cih,+Medan+Tuntungan" 
                                   target="_blank" 
                                   rel="noopener noreferrer"
                                   class="mt-2 inline-flex items-center gap-1 text-xs text-blue-600 hover:text-blue-800 transition">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                    </svg>
                                    Buka di Google Maps
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Google Maps Embed -->
                    <div class="mt-8">
                        <h3 class="mb-4 text-xl font-bold text-gray-900">📍 Lokasi Kami di Peta</h3>
                        <div class="overflow-hidden rounded-2xl shadow-lg border-4 border-white">
                            <iframe 
                                src="https://www.google.com/maps/embed/v1/place?key={{ env('GOOGLE_MAPS_API_KEY') }}&q=Jl.+Bunga+Mayang+I+No.+19,+Lau+Cih,+Medan+Tuntungan&zoom=15&maptype=roadmap"
                                width="100%" 
                                height="350" 
                                style="border:0;" 
                                allowfullscreen="" 
                                loading="lazy" 
                                referrerpolicy="no-referrer-when-downgrade"
                                class="w-full">
                            </iframe>
                        </div>
                        <p class="mt-3 text-xs text-gray-500 text-center">
                            <svg class="inline h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Klik peta untuk navigasi langsung via Google Maps
                        </p>
                    </div>
                </div>

                <!-- Contact Form -->
                <div>
                    <div class="mb-10">
                        <h2 class="text-3xl font-bold text-gray-900">Kirim Pesan</h2>
                        <p class="mt-2 text-gray-600">Isi formulir di bawah ini dan kami akan segera merespons</p>
                    </div>

                    @if(session('success'))
                        <div class="mb-6 rounded-lg bg-green-50 border border-green-200 p-4">
                            <div class="flex items-start">
                                <svg class="h-5 w-5 text-green-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 000-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('contact.store') }}" method="POST" class="rounded-3xl border border-blue-100 bg-blue-50/50 p-8 shadow-sm space-y-6">
                        @csrf
                        <div class="grid gap-6 md:grid-cols-2">
                            <div>
                                <label for="name" class="text-xs font-semibold uppercase tracking-wide text-slate-600">Nama Lengkap</label>
                                <input type="text" id="name" name="name" value="{{ old('name') }}" required class="mt-2 w-full rounded-2xl border border-blue-100 bg-white px-4 py-3 text-sm text-slate-700 placeholder-slate-400 focus:border-[#2D3C8C] focus:outline-none focus:ring-2 focus:ring-blue-200 transition-all duration-200" placeholder="Masukkan nama Anda">
                                @error('name')
                                    <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="email" class="text-xs font-semibold uppercase tracking-wide text-slate-600">Email</label>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" required class="mt-2 w-full rounded-2xl border border-blue-100 bg-white px-4 py-3 text-sm text-slate-700 placeholder-slate-400 focus:border-[#2D3C8C] focus:outline-none focus:ring-2 focus:ring-blue-200 transition-all duration-200" placeholder="nama@email.com">
                                @error('email')
                                    <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="grid gap-6 md:grid-cols-2">
                            <div>
                                <label for="phone" class="text-xs font-semibold uppercase tracking-wide text-slate-600">No. WhatsApp</label>
                                <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" class="mt-2 w-full rounded-2xl border border-blue-100 bg-white px-4 py-3 text-sm text-slate-700 placeholder-slate-400 focus:border-[#2D3C8C] focus:outline-none focus:ring-2 focus:ring-blue-200 transition-all duration-200" placeholder="08xx-xxxx-xxxx">
                                @error('phone')
                                    <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="subject" class="text-xs font-semibold uppercase tracking-wide text-slate-600">Layanan yang Diminati</label>
                                <select id="subject" name="subject" class="mt-2 w-full rounded-2xl border border-blue-100 bg-white px-4 py-3 text-sm text-slate-600 focus:border-[#2D3C8C] focus:outline-none focus:ring-2 focus:ring-blue-200 transition-all duration-200">
                                    <option value="">Pilih layanan</option>
                                    <option value="Bimbel UKOM D3 Farmasi" {{ old('subject') == 'Bimbel UKOM D3 Farmasi' ? 'selected' : '' }}>Bimbel UKOM D3 Farmasi</option>
                                    <option value="CPNS & P3K Farmasi" {{ old('subject') == 'CPNS & P3K Farmasi' ? 'selected' : '' }}>CPNS &amp; P3K Farmasi</option>
                                    <option value="Joki Tugas Akademik" {{ old('subject') == 'Joki Tugas Akademik' ? 'selected' : '' }}>Joki Tugas Akademik</option>
                                    <option value="Konsultasi Akademik" {{ old('subject') == 'Konsultasi Akademik' ? 'selected' : '' }}>Konsultasi Akademik</option>
                                    <option value="Pertanyaan Umum" {{ old('subject') == 'Pertanyaan Umum' ? 'selected' : '' }}>Pertanyaan Umum</option>
                                </select>
                                @error('subject')
                                    <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div>
                            <label for="message" class="text-xs font-semibold uppercase tracking-wide text-slate-600">Pesan</label>
                            <textarea id="message" name="message" rows="6" required class="mt-2 w-full rounded-2xl border border-blue-100 bg-white px-4 py-3 text-sm text-slate-700 placeholder-slate-400 focus:border-[#2D3C8C] focus:outline-none focus:ring-2 focus:ring-blue-200 transition-all duration-200" placeholder="Tulis pesan atau pertanyaan Anda di sini...">{{ old('message') }}</textarea>
                            @error('message')
                                <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit" class="w-full rounded-full bg-[#2D3C8C] px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-[#2D3C8C]/30 transition-all duration-200 hover:bg-blue-900 hover:shadow-xl hover:scale-105">
                            Kirim Pesan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

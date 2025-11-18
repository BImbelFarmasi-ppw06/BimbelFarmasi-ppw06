<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="@yield('meta_description', 'Bimbel Farmasi: Solusi akademik dan karir farmasi terpercaya. Program UKOM D3 Farmasi, CPNS & P3K Farmasi, dan pendampingan tugas akademik dengan mentor profesional berpengalaman.')">
    <meta name="keywords" content="@yield('meta_keywords', 'bimbel farmasi, ukom d3 farmasi, cpns farmasi, p3k farmasi, joki tugas farmasi, bimbel apoteker, ujian kompetensi farmasi, tryout ukom, mentor farmasi, les privat farmasi')">
    <meta name="author" content="Bimbel Farmasi">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url()->current() }}">
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="@yield('og_title', 'Bimbel Farmasi - Solusi Akademik & Karir Farmasi Terpercaya')">
    <meta property="og:description" content="@yield('og_description', 'Dapatkan dukungan lengkap untuk menaklukkan UKOM D3 Farmasi, CPNS & P3K Farmasi, serta tugas akademik kefarmasian dengan tingkat kelulusan 95%.')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="@yield('og_image', asset('images/og-default.jpg'))">
    <meta property="og:locale" content="id_ID">
    <meta property="og:site_name" content="Bimbel Farmasi">
    
    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('twitter_title', 'Bimbel Farmasi - Solusi Akademik & Karir Farmasi')">
    <meta name="twitter:description" content="@yield('twitter_description', 'Program UKOM, CPNS & P3K Farmasi dengan tingkat kelulusan 95%. Mentor berpengalaman, modul lengkap, tryout adaptif.')">
    <meta name="twitter:image" content="@yield('twitter_image', asset('images/og-default.jpg'))">
    
    <title>
        @hasSection('title')
            @yield('title') · Bimbel Farmasi
        @else
            Bimbel Farmasi - Solusi Akademik & Karir Farmasi Terpercaya
        @endif
    </title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Alpine.js for dropdown -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @if (file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <!-- Fallback: Tailwind CSS CDN untuk development -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            'primary': '#2D3C8C',
                        },
                        fontFamily: {
                            sans: ['Poppins', 'ui-sans-serif', 'system-ui'],
                        },
                    }
                }
            }
        </script>
        <style type="text/css">
            body {
                font-family: 'Poppins', ui-sans-serif, system-ui, sans-serif;
                background-color: #F7F9FF;
                color: #1f2937;
                -webkit-font-smoothing: antialiased;
            }
            h1, h2, h3, h4 {
                color: #0f172a;
                font-weight: 600;
            }
            a {
                transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out;
            }
            .shadow-soft {
                box-shadow: 0 12px 40px -20px rgba(45, 60, 140, 0.35);
            }
        </style>
        <script>
            // Mobile menu toggle & smooth scroll
            document.addEventListener('DOMContentLoaded', () => {
                const mobileMenuButton = document.getElementById('mobile-menu-button');
                const mobileMenu = document.getElementById('mobile-menu');

                if (mobileMenuButton && mobileMenu) {
                    mobileMenuButton.addEventListener('click', () => {
                        const isExpanded = mobileMenuButton.getAttribute('aria-expanded') === 'true';
                        mobileMenuButton.setAttribute('aria-expanded', !isExpanded);
                        mobileMenu.classList.toggle('hidden');
                    });
                }

                document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                    anchor.addEventListener('click', function (e) {
                        const href = this.getAttribute('href');
                        if (href === '#') return;
                        
                        const target = document.querySelector(href);
                        if (target) {
                            e.preventDefault();
                            target.scrollIntoView({
                                behavior: 'smooth',
                                block: 'start'
                            });
                        }
                    });
                });
            });
        </script>
    @endif
</head>
<body class="min-h-screen flex flex-col bg-[#F7F9FF] text-slate-800">
    <header class="bg-[#2D3C8C] text-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between py-6">
                <div class="flex items-center gap-3">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 hover:opacity-90 transition-opacity">
                        <img src="{{ asset('images/logo bimbel farmasi.jpg') }}" alt="Bimbel Farmasi Logo" class="h-12 w-12 rounded-full object-cover shadow-lg">
                        <span class="text-2xl font-semibold tracking-wide hidden sm:inline">Bimbel Farmasi</span>
                    </a>
                </div>
                <button id="mobile-menu-button" type="button" class="md:hidden inline-flex items-center justify-center rounded-md p-2 text-white hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" aria-expanded="false" aria-label="Toggle menu">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <nav class="hidden md:flex flex-wrap items-center justify-center gap-4 text-sm font-medium">
                    <a href="{{ route('home') }}" class="@if(request()->routeIs('home')) font-semibold text-white @else text-white/80 hover:text-white @endif transition">Beranda</a>
                    <a href="{{ route('layanan') }}" class="@if(request()->routeIs('layanan')) font-semibold text-white @else text-white/80 hover:text-white @endif transition">Layanan</a>
                    <a href="{{ route('bimbel.ukom') }}" class="@if(request()->routeIs('bimbel.ukom')) font-semibold text-white @else text-white/80 hover:text-white @endif transition">Bimbel UKOM</a>
                    <a href="{{ route('cpns.p3k') }}" class="@if(request()->routeIs('cpns.p3k')) font-semibold text-white @else text-white/80 hover:text-white @endif transition">CPNS &amp; P3K</a>
                    <a href="{{ route('joki.tugas') }}" class="@if(request()->routeIs('joki.tugas')) font-semibold text-white @else text-white/80 hover:text-white @endif transition">Joki Tugas</a>
                    <a href="{{ route('testimonials.index') }}" class="@if(request()->routeIs('testimonials.*')) font-semibold text-white @else text-white/80 hover:text-white @endif transition">Testimoni</a>
                    <a href="{{ route('kontak') }}" class="@if(request()->routeIs('kontak')) font-semibold text-white @else text-white/80 hover:text-white @endif transition">Kontak</a>
                </nav>
                <div class="hidden md:flex justify-center md:justify-end">
                    @auth
                        <!-- User Dropdown Menu -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" @click.away="open = false" class="inline-flex items-center gap-2 rounded-full border border-white/70 bg-white px-4 py-2 text-sm font-semibold text-[#2D3C8C] shadow-sm transition hover:bg-blue-50">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <span>{{ Auth::user()->name }}</span>
                                <svg class="h-4 w-4" :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <!-- Dropdown Menu -->
                            <div x-show="open" 
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 class="absolute right-0 mt-2 w-56 origin-top-right rounded-lg border border-gray-200 bg-white shadow-lg z-50">
                                <div class="p-2">
                                    <div class="border-b border-gray-100 px-3 py-2 mb-2">
                                        <p class="text-xs font-semibold text-gray-900">{{ Auth::user()->name }}</p>
                                        <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                                    </div>
                                    <a href="{{ route('user.profile') }}" class="flex items-center gap-2 rounded-md px-3 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-[#2D3C8C] transition">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        Profil Saya
                                    </a>
                                    <a href="{{ route('user.services') }}" class="flex items-center gap-2 rounded-md px-3 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-[#2D3C8C] transition">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                        Layanan Saya
                                    </a>
                                    <a href="{{ route('order.my-orders') }}" class="flex items-center gap-2 rounded-md px-3 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-[#2D3C8C] transition">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                        </svg>
                                        Pesanan Saya
                                    </a>
                                    <a href="{{ route('testimonials.myTestimonials') }}" class="flex items-center gap-2 rounded-md px-3 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-[#2D3C8C] transition">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                        </svg>
                                        Testimoni Saya
                                    </a>
                                    <a href="{{ route('user.transactions') }}" class="flex items-center gap-2 rounded-md px-3 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-[#2D3C8C] transition">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        Riwayat Transaksi
                                    </a>
                                    <a href="{{ route('user.settings') }}" class="flex items-center gap-2 rounded-md px-3 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-[#2D3C8C] transition">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        Pengaturan
                                    </a>
                                    <hr class="my-2 border-gray-100">
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="flex w-full items-center gap-2 rounded-md px-3 py-2 text-sm text-red-600 hover:bg-red-50 transition">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                            </svg>
                                            Keluar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center rounded-full border border-white/70 bg-white px-4 py-2 text-sm font-semibold text-[#2D3C8C] shadow-sm transition hover:bg-blue-50">Masuk / Daftar</a>
                    @endauth
                </div>
            </div>
            <!-- Mobile menu -->
            <div id="mobile-menu" class="hidden md:hidden pb-4">
                <div class="flex flex-col space-y-3 text-sm font-medium">
                    <a href="{{ route('home') }}" class="@if(request()->routeIs('home')) font-semibold text-white @else text-white/80 hover:text-white @endif transition px-2 py-2">Beranda</a>
                    <a href="{{ route('layanan') }}" class="@if(request()->routeIs('layanan')) font-semibold text-white @else text-white/80 hover:text-white @endif transition px-2 py-2">Layanan</a>
                    <a href="{{ route('bimbel.ukom') }}" class="@if(request()->routeIs('bimbel.ukom')) font-semibold text-white @else text-white/80 hover:text-white @endif transition px-2 py-2">Bimbel UKOM</a>
                    <a href="{{ route('cpns.p3k') }}" class="@if(request()->routeIs('cpns.p3k')) font-semibold text-white @else text-white/80 hover:text-white @endif transition px-2 py-2">CPNS &amp; P3K</a>
                    <a href="{{ route('joki.tugas') }}" class="@if(request()->routeIs('joki.tugas')) font-semibold text-white @else text-white/80 hover:text-white @endif transition px-2 py-2">Joki Tugas</a>
                    <a href="{{ route('testimonials.index') }}" class="@if(request()->routeIs('testimonials.*')) font-semibold text-white @else text-white/80 hover:text-white @endif transition px-2 py-2">Testimoni</a>
                    <a href="{{ route('kontak') }}" class="@if(request()->routeIs('kontak')) font-semibold text-white @else text-white/80 hover:text-white @endif transition px-2 py-2">Kontak</a>
                    
                    @auth
                        <hr class="border-white/20 my-2">
                        <div class="px-2 py-2">
                            <p class="text-xs text-white/60 mb-1">Login sebagai:</p>
                            <p class="text-sm font-semibold text-white">{{ Auth::user()->name }}</p>
                        </div>
                        <a href="{{ route('user.profile') }}" class="text-white/80 hover:text-white transition px-2 py-2">Profil Saya</a>
                        <a href="{{ route('user.services') }}" class="text-white/80 hover:text-white transition px-2 py-2">Layanan Saya</a>
                        <a href="{{ route('order.my-orders') }}" class="text-white/80 hover:text-white transition px-2 py-2">Pesanan Saya</a>
                        <a href="{{ route('user.transactions') }}" class="text-white/80 hover:text-white transition px-2 py-2">Riwayat Transaksi</a>
                        <form action="{{ route('logout') }}" method="POST" class="px-2">
                            @csrf
                            <button type="submit" class="w-full text-left text-red-300 hover:text-red-200 transition py-2">Keluar</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-full border border-white/70 bg-white px-4 py-2 text-sm font-semibold text-[#2D3C8C] shadow-sm transition hover:bg-blue-50 mt-2">Masuk / Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Success Toast Notification -->
    @if(session('success'))
        <div 
            x-data="{ show: true }" 
            x-show="show" 
            x-init="setTimeout(() => show = false, 5000)"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="transform translate-x-full opacity-0"
            x-transition:enter-end="transform translate-x-0 opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="transform translate-x-0 opacity-100"
            x-transition:leave-end="transform translate-x-full opacity-0"
            class="fixed top-6 right-6 z-50 max-w-md"
        >
            <div class="rounded-2xl bg-white border border-green-200 p-4 shadow-2xl">
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0">
                        <div class="rounded-full bg-green-100 p-2">
                            <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1 pt-0.5">
                        <p class="text-sm font-semibold text-gray-900">Berhasil!</p>
                        <p class="mt-1 text-sm text-gray-600">{{ session('success') }}</p>
                    </div>
                    <button @click="show = false" class="flex-shrink-0 text-gray-400 hover:text-gray-600 transition">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Error Toast Notification -->
    @if(session('error'))
        <div 
            x-data="{ show: true }" 
            x-show="show" 
            x-init="setTimeout(() => show = false, 5000)"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="transform translate-x-full opacity-0"
            x-transition:enter-end="transform translate-x-0 opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="transform translate-x-0 opacity-100"
            x-transition:leave-end="transform translate-x-full opacity-0"
            class="fixed top-6 right-6 z-50 max-w-md"
        >
            <div class="rounded-2xl bg-white border border-red-200 p-4 shadow-2xl">
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0">
                        <div class="rounded-full bg-red-100 p-2">
                            <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1 pt-0.5">
                        <p class="text-sm font-semibold text-gray-900">Terjadi Kesalahan</p>
                        <p class="mt-1 text-sm text-gray-600">{{ session('error') }}</p>
                    </div>
                    <button @click="show = false" class="flex-shrink-0 text-gray-400 hover:text-gray-600 transition">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Loading Overlay -->
    <div id="loading-overlay" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center">
        <div class="bg-white rounded-2xl p-8 shadow-2xl max-w-sm mx-4">
            <div class="flex flex-col items-center gap-4">
                <div class="relative">
                    <img src="{{ asset('images/logo bimbel farmasi.jpg') }}" alt="Bimbel Farmasi" class="h-16 w-16 rounded-full object-cover shadow-lg mb-2">
                    <svg class="animate-spin h-12 w-12 text-[#2D3C8C] absolute -bottom-2 left-1/2 -translate-x-1/2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
                <div class="text-center">
                    <p class="text-lg font-semibold text-gray-900">Memproses...</p>
                    <p class="mt-1 text-sm text-gray-600">Mohon tunggu sebentar</p>
                </div>
            </div>
        </div>
    </div>

    <main class="flex-1">
        @yield('content')
    </main>

    <footer class="mt-16 bg-[#2D3C8C] text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="grid gap-8 md:grid-cols-3">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <img src="{{ asset('images/logo bimbel farmasi.jpg') }}" alt="Bimbel Farmasi Logo" class="h-16 w-16 rounded-full object-cover shadow-lg">
                        <h3 class="text-lg font-semibold">Bimbel Farmasi</h3>
                    </div>
                    <p class="text-sm text-white/80 leading-relaxed">Pendampingan akademik dan karir kefarmasian dengan mentor berpengalaman dan kurikulum terstruktur.</p>
                    <p class="mt-2 text-xs text-white/60 italic">"Raih Pangkal Kompeten"</p>
                </div>
                <div class="space-y-3">
                    <h4 class="text-sm font-semibold uppercase tracking-wide text-white/70">Navigasi</h4>
                    <div class="flex flex-wrap gap-3 text-sm text-white/80">
                        <a class="hover:text-white" href="{{ route('home') }}">Beranda</a>
                        <a class="hover:text-white" href="{{ route('layanan') }}">Layanan</a>
                        <a class="hover:text-white" href="{{ route('bimbel.ukom') }}">Bimbel UKOM</a>
                        <a class="hover:text-white" href="{{ route('cpns.p3k') }}">CPNS &amp; P3K</a>
                        <a class="hover:text-white" href="{{ route('joki.tugas') }}">Joki Tugas</a>
                        <a class="hover:text-white" href="{{ route('kontak') }}">Kontak</a>
                    </div>
                </div>
                <div class="space-y-3">
                    <h4 class="text-sm font-semibold uppercase tracking-wide text-white/70">Kontak</h4>
                    <ul class="space-y-2 text-sm text-white/80">
                        <li>Email: <a class="hover:text-white" href="mailto:bimbelfarmasimdn@gmail.com">bimbelfarmasimdn@gmail.com</a></li>
                        <li>Telepon: <a class="hover:text-white" href="tel:+6281536908359">+62 815-3690-8359</a></li>
                        <li>Alamat: Lau Cih, Medan Tuntungan</li>
                        <li>Instagram: <a class="hover:text-white" href="https://instagram.com/bimbelfarmasi" target="_blank">@bimbelfarmasi</a></li>
                    </ul>
                </div>
            </div>
            <hr class="my-8 border-white/20">
            <div class="flex flex-col gap-4 text-center text-sm text-white/70 md:flex-row md:items-center md:justify-between">
                <p>© 2025 FarmasiPro. Semua hak dilindungi.</p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a class="hover:text-white" href="#">Kebijakan Privasi</a>
                    <a class="hover:text-white" href="#">Syarat &amp; Ketentuan</a>
                    <a class="hover:text-white" href="#">Media Sosial</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Form Loading State Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Show loading overlay on form submit
            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    // Skip for forms with data-no-loading attribute
                    if (this.hasAttribute('data-no-loading')) {
                        return;
                    }
                    
                    // Validate form first
                    if (this.checkValidity()) {
                        document.getElementById('loading-overlay').classList.remove('hidden');
                    }
                });
            });

            // Auto-hide loading on page load (in case of back button)
            window.addEventListener('pageshow', function(event) {
                if (event.persisted) {
                    document.getElementById('loading-overlay').classList.add('hidden');
                }
            });
        });
    </script>
</body>
</html>

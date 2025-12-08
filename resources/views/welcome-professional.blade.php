<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Bimbel Farmasi - Solusi Terpercaya untuk UKOM & CPNS Farmasi</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            body { 
                font-family: 'Inter', sans-serif;
                -webkit-font-smoothing: antialiased;
                -moz-osx-font-smoothing: grayscale;
            }
            .blue-gradient {
                background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
            }
            .text-blue-gradient {
                background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-gray-50">
        <!-- Navigation -->
        <nav class="bg-white/95 backdrop-blur-sm border-b border-gray-200/50 sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center py-4">
                    <!-- Logo -->
                    <div class="flex items-center space-x-3">
                        <div class="flex items-center justify-center w-10 h-10 blue-gradient rounded-lg shadow-sm">
                            <span class="text-white font-semibold text-lg">💊</span>
                        </div>
                        <div>
                            <h1 class="text-xl font-semibold text-gray-900">Bimbel Farmasi</h1>
                            <p class="text-xs text-gray-500">Solusi Akademik Terpercaya</p>
                        </div>
                    </div>

                    <!-- Navigation Links -->
                    <div class="hidden md:flex items-center space-x-8">
                        <a href="#" class="text-gray-600 hover:text-blue-900 font-medium transition-colors">Beranda</a>
                        <a href="#layanan" class="text-gray-600 font-medium transition-colors" onmouseover="this.style.color='#1565C0'" onmouseout="this.style.color='#4B5563'">Layanan</a>
                        <a href="#testimoni" class="text-gray-600 font-medium transition-colors" onmouseover="this.style.color='#1565C0'" onmouseout="this.style.color='#4B5563'">Testimoni</a>
                        <a href="#" class="text-gray-600 font-medium transition-colors" onmouseover="this.style.color='#1565C0'" onmouseout="this.style.color='#4B5563'">Kontak</a>
                    </div>

                    @if (Route::has('login'))
                        <div class="flex items-center space-x-4">
                            @auth
                                <a href="{{ url('/home') }}" 
                                   class="blue-gradient text-white px-6 py-2 rounded-lg font-medium hover:shadow-md transition-all duration-200">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" 
                                   class="text-gray-600 font-medium transition-colors" onmouseover="this.style.color='#1565C0'" onmouseout="this.style.color='#4B5563'">
                                    Beranda
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" 
                                       class="blue-gradient text-white px-6 py-2 rounded-lg font-medium hover:shadow-md transition-all duration-200">
                                        Daftar
                                    </a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <main class="relative">
            <!-- Subtle Background Pattern -->
            <div class="absolute inset-0">
                <div class="absolute top-20 left-10 w-72 h-72 bg-blue-50 rounded-full opacity-30 blur-3xl"></div>
                <div class="absolute bottom-20 right-10 w-96 h-96 bg-blue-100 rounded-full opacity-20 blur-3xl"></div>
            </div>
            
            <div class="relative max-w-7xl mx-auto px-4 py-16 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <!-- Left Content -->
                    <div class="space-y-8">
                        <!-- Badge -->
                        <div class="inline-flex items-center px-4 py-2 rounded-full border" style="background-color: #E3F2FD; border-color: #BBDEFB;">
                            <span class="w-2 h-2 bg-blue-900 rounded-full mr-2"></span>
                            <span class="text-sm font-medium text-blue-900">Bimbel Farmasi Terpercaya</span>
                        </div>

                        <!-- Main Heading -->
                        <div class="space-y-4">
                            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 leading-tight">
                                Wujudkan Impian
                                <span class="text-blue-gradient block">Karir Farmasi Anda</span>
                            </h1>
                        </div>

                        <!-- Subtitle -->
                        <p class="text-xl text-gray-600 leading-relaxed max-w-2xl">
                            Platform bimbingan belajar farmasi terlengkap dengan tingkat kelulusan 
                            <span class="font-semibold text-blue-900">95%</span>. 
                            Siap menaklukkan UKOM, CPNS & P3K dengan mentor profesional.
                        </p>

                        <!-- Key Features -->
                        <div class="grid sm:grid-cols-3 gap-4">
                            <div class="flex items-center space-x-3 p-3 bg-white rounded-lg border border-gray-100 shadow-sm">
                                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <span class="text-blue-900 text-sm">✓</span>
                                </div>
                                <span class="font-medium text-gray-700 text-sm">Mentor Berpengalaman</span>
                            </div>
                            <div class="flex items-center space-x-3 p-3 bg-white rounded-lg border border-gray-100 shadow-sm">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background-color: #E3F2FD;">
                                    <span class="text-sm" style="color: #1565C0;">📚</span>
                                </div>
                                <span class="font-medium text-gray-700 text-sm">Materi Terkini</span>
                            </div>
                            <div class="flex items-center space-x-3 p-3 bg-white rounded-lg border border-gray-100 shadow-sm">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background-color: #E3F2FD;">
                                    <span class="text-sm" style="color: #1565C0;">🎯</span>
                                </div>
                                <span class="font-medium text-gray-700 text-sm">Success Rate 95%</span>
                            </div>
                        </div>

                        <!-- CTA Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="{{ route('layanan') }}" 
                               class="blue-gradient text-white px-8 py-4 rounded-lg font-semibold text-lg hover:shadow-lg transition-all duration-200 text-center">
                                Mulai Belajar Sekarang
                            </a>
                            <a href="#layanan" 
                               class="bg-white text-gray-700 px-8 py-4 rounded-lg font-semibold border border-gray-200 hover:border-blue-200 hover:bg-blue-50 transition-all duration-200 text-center">
                                Lihat Program
                            </a>
                        </div>
                    </div>

                    <!-- Right Content - Stats Card -->
                    <div class="relative hidden lg:block">
                        <div class="bg-white rounded-2xl p-8 shadow-lg border border-gray-100">
                            <!-- Header -->
                            <div class="text-center mb-8">
                                <div class="w-16 h-16 blue-gradient rounded-2xl flex items-center justify-center mx-auto mb-4">
                                    <span class="text-white text-2xl">🎓</span>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Statistik Keberhasilan</h3>
                                <p class="text-sm text-gray-500">Data pencapaian peserta kami</p>
                            </div>
                            
                            <!-- Stats -->
                            <div class="space-y-6">
                                <div class="bg-blue-50 p-4 rounded-xl border border-blue-100">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-2xl font-bold text-blue-600">95%</p>
                                            <p class="text-sm text-gray-600">Tingkat Kelulusan UKOM</p>
                                        </div>
                                        <div class="w-12 h-12 bg-blue-200 rounded-full flex items-center justify-center">
                                            <span class="text-blue-400 text-lg">📈</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-blue-50 p-4 rounded-xl border border-blue-100">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-2xl font-bold text-blue-400">500+</p>
                                            <p class="text-sm text-gray-600">Peserta Lulus CPNS</p>
                                        </div>
                                        <div class="w-12 h-12 bg-blue-200 rounded-full flex items-center justify-center">
                                            <span class="text-blue-400 text-lg">👥</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-blue-50 p-4 rounded-xl border border-blue-100">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-2xl font-bold text-blue-400">24/7</p>
                                            <p class="text-sm text-gray-600">Support Mentor</p>
                                        </div>
                                        <div class="w-12 h-12 bg-blue-200 rounded-full flex items-center justify-center">
                                            <span class="text-blue-400 text-lg">🕒</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Services Section -->
        <section id="layanan" class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Program Unggulan Kami</h2>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto">Pilih program terbaik untuk meraih masa depan impian Anda</p>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    <!-- UKOM Program -->
                    <div class="group bg-white rounded-2xl p-8 border border-gray-100 hover:border-blue-200 hover:shadow-lg transition-all duration-300">
                        <div class="w-14 h-14 blue-gradient rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                            <span class="text-white text-xl">🎓</span>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Bimbel UKOM D3 Farmasi</h3>
                        <p class="text-gray-600 mb-6 leading-relaxed">Program intensif persiapan UKOM dengan bank soal adaptif dan sesi klinis yang komprehensif.</p>
                        <a href="{{ route('bimbel.ukom') }}" class="inline-flex items-center text-blue-600 font-semibold hover:text-blue-700 transition-colors group">
                            Pelajari Lebih Lanjut 
                            <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>

                    <!-- CPNS Program -->
                    <div class="group bg-white rounded-2xl p-8 border border-gray-100 hover:border-blue-200 hover:shadow-lg transition-all duration-300">
                        <div class="w-14 h-14 blue-gradient rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                            <span class="text-white text-xl">🏥</span>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">CPNS & P3K Kefarmasian</h3>
                        <p class="text-gray-600 mb-6 leading-relaxed">Strategi jitu SKD & SKB dengan simulasi CAT, kisi-kisi terbaru, dan coaching karir profesional.</p>
                        <a href="{{ route('cpns.p3k') }}" class="inline-flex items-center text-blue-400 font-semibold hover:text-blue-500 transition-colors group">
                            Pelajari Lebih Lanjut 
                            <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>

                    <!-- Joki Tugas Program -->
                    <div class="group bg-white rounded-2xl p-8 border border-gray-100 hover:border-blue-200 hover:shadow-lg transition-all duration-300">
                        <div class="w-14 h-14 blue-gradient rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                            <span class="text-white text-xl">📝</span>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Joki Tugas Akademik</h3>
                        <p class="text-gray-600 mb-6 leading-relaxed">Pendampingan etis untuk penyusunan tugas, skripsi, KTI, dan publikasi ilmiah kefarmasian.</p>
                        <a href="{{ route('joki.tugas') }}" class="inline-flex items-center text-blue-400 font-semibold hover:text-blue-500 transition-colors group">
                            Pelajari Lebih Lanjut 
                            <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimonial Section -->
        <section id="testimoni" class="py-20 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Cerita Sukses Peserta</h2>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto">Ribuan tenaga kefarmasian telah meraih mimpi bersama kami</p>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    <div class="bg-white rounded-2xl p-6 border border-gray-100 hover:shadow-lg transition-all duration-300">
                        <div class="flex items-center space-x-4 mb-4">
                            <img src="https://i.pravatar.cc/100?img=47" alt="Putri" class="w-12 h-12 rounded-full">
                            <div>
                                <h4 class="font-semibold text-gray-900">Putri Maharani</h4>
                                <p class="text-sm text-gray-500">Lulus UKOM 2024</p>
                            </div>
                        </div>
                        <p class="text-gray-600 italic leading-relaxed">"Bank soal klinis dan pembahasan detailnya sangat membantu. Mentor selalu siap konsultasi!"</p>
                    </div>

                    <div class="bg-white rounded-2xl p-6 border border-gray-100 hover:shadow-lg transition-all duration-300">
                        <div class="flex items-center space-x-4 mb-4">
                            <img src="https://i.pravatar.cc/100?img=12" alt="Rama" class="w-12 h-12 rounded-full">
                            <div>
                                <h4 class="font-semibold text-gray-900">Rama Yudha</h4>
                                <p class="text-sm text-gray-500">ASN P3K 2025</p>
                            </div>
                        </div>
                        <p class="text-gray-600 italic leading-relaxed">"Simulasi CAT dan coaching karirnya luar biasa. Berhasil lolos formasi RSUD!"</p>
                    </div>

                    <div class="bg-white rounded-2xl p-6 border border-gray-100 hover:shadow-lg transition-all duration-300">
                        <div class="flex items-center space-x-4 mb-4">
                            <img src="https://i.pravatar.cc/100?img=32" alt="Nadia" class="w-12 h-12 rounded-full">
                            <div>
                                <h4 class="font-semibold text-gray-900">Nadia Husna</h4>
                                <p class="text-sm text-gray-500">Magister Farmasi UI</p>
                            </div>
                        </div>
                        <p class="text-gray-600 italic leading-relaxed">"Pendampingan tugas sangat profesional dan etis. Sukses publikasi jurnal!"</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-gray-900 text-white py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <div class="flex items-center justify-center space-x-3 mb-6">
                    <div class="w-10 h-10 blue-gradient rounded-lg flex items-center justify-center">
                        <span class="text-white text-lg">💊</span>
                    </div>
                    <h3 class="text-xl font-semibold">Bimbel Farmasi</h3>
                </div>
                <p class="text-gray-300 mb-8">Wujudkan impian karir farmasi Anda bersama kami</p>
                <div class="flex flex-wrap justify-center gap-6 text-sm">
                    <a href="#" class="text-gray-300 hover:text-blue-400 transition-colors">Beranda</a>
                    <a href="#layanan" class="text-gray-300 hover:text-blue-400 transition-colors">Layanan</a>
                    <a href="#testimoni" class="text-gray-300 hover:text-blue-400 transition-colors">Testimoni</a>
                    <a href="#" class="text-gray-300 hover:text-blue-400 transition-colors">Kontak</a>
                </div>
                <div class="mt-8 pt-8 border-t border-gray-700 text-sm text-gray-400">
                    © 2024 Bimbel Farmasi. Semua hak dilindungi.
                </div>
            </div>
        </footer>
    </body>
</html>
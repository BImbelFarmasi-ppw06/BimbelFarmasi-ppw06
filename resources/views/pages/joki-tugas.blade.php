@extends('layouts.app')

@section('title', 'Joki Tugas & Konsultasi Akademik Farmasi')

@section('meta_description', 'Jasa pendampingan tugas akademik farmasi profesional. Bantuan skripsi, jurnal ilmiah, laporan praktikum, dan tugas farmasi lainnya. Dikerjakan oleh mentor berpengalaman dengan hasil berkualitas tinggi.')

@section('meta_keywords', 'joki tugas farmasi, bantuan tugas farmasi, jasa skripsi farmasi, konsultasi akademik farmasi, pendampingan skripsi, jasa jurnal farmasi, tutor farmasi, mentor farmasi')

@section('og_title', 'Joki Tugas & Konsultasi Akademik Farmasi Profesional')

@section('og_description', 'Dapatkan bantuan profesional untuk tugas akademik farmasi Anda. Skripsi, jurnal, laporan praktikum - dikerjakan dengan standar akademik tinggi dan tepat waktu.')

@section('og_image', asset('images/unnamed.jpg'))

@section('content')
    <section class="relative bg-cover bg-center bg-no-repeat bg-gradient-to-br from-blue-100 via-white to-blue-50" style="background-image: url('/images/joki.png'); min-height: 70vh;">
        <div class="absolute inset-0 bg-gradient-to-r from-black/50 to-black/30"></div> <!-- Overlay gradien untuk kontras yang lebih halus -->
        <div class="relative z-10 mx-auto max-w-6xl px-4 py-24 sm:px-6 lg:px-8">
            <div class="grid gap-10 lg:grid-cols-2 lg:items-center">
                <div class="space-y-6 animate-fade-in">
                    <span class="inline-flex items-center rounded-full bg-white/90 backdrop-blur-sm px-4 py-1 text-xs font-semibold uppercase tracking-[0.4em] text-[#2D3C8C] shadow-lg">pendampingan etis</span>
                    <h1 class="text-4xl lg:text-5xl font-bold text-white leading-tight">Joki Tugas & Konsultasi Akademik Farmasi</h1>
                    <p class="text-lg leading-relaxed text-white/90">Dampingi setiap tahap penulisan ilmiahmu — mulai dari brainstorming topik, penyusunan proposal, analisis data, hingga publikasi. Semua berjalan etis dan edukatif.</p>
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('order.create', ['slug' => 'joki-tugas-farmasi']) }}" class="inline-flex items-center rounded-full bg-[#2D3C8C] px-6 py-3 text-white shadow-lg shadow-[#2D3C8C]/50 transition-all duration-300 hover:bg-blue-900 hover:scale-105 hover:shadow-xl">Beli Sekarang</a>
                        <a href="#paket" class="inline-flex items-center rounded-full bg-transparent border-2 border-white px-6 py-3 text-white font-semibold transition-all duration-300 hover:bg-white hover:text-[#2D3C8C] hover:scale-105">Lihat Paket Pendampingan</a>
                    </div>
                </div>
                <div class="rounded-3xl border border-blue-100 bg-white/95 backdrop-blur-sm p-10 shadow-2xl shadow-blue-200/50 animate-slide-up">
                    <h2 class="text-xl font-semibold text-slate-900 mb-4">Layanan yang Kami Tawarkan</h2>
                    <ul class="space-y-4 text-sm text-slate-600">
                        <li class="flex items-start gap-3 p-3 rounded-lg bg-blue-50 hover:bg-blue-100 transition-colors duration-200">
                            <span class="mt-1 text-lg text-[#2D3C8C]">💡</span>
                            <div>
                                <p class="font-semibold text-slate-800">Konsultasi ide topik skripsi, KTI, tesis, dan publikasi.</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-3 p-3 rounded-lg bg-blue-50 hover:bg-blue-100 transition-colors duration-200">
                            <span class="mt-1 text-lg text-[#2D3C8C]">📝</span>
                            <div>
                                <p class="font-semibold text-slate-800">Penyusunan proposal, bab penelitian, dan kerangka teori.</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-3 p-3 rounded-lg bg-blue-50 hover:bg-blue-100 transition-colors duration-200">
                            <span class="mt-1 text-lg text-[#2D3C8C]">📊</span>
                            <div>
                                <p class="font-semibold text-slate-800">Analisis data, statistik, dan interpretasi hasil.</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-3 p-3 rounded-lg bg-blue-50 hover:bg-blue-100 transition-colors duration-200">
                            <span class="mt-1 text-lg text-[#2D3C8C]">🔍</span>
                            <div>
                                <p class="font-semibold text-slate-800">Editing referensi, sitasi, dan pengecekan plagiarisme.</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-3 p-3 rounded-lg bg-blue-50 hover:bg-blue-100 transition-colors duration-200">
                            <span class="mt-1 text-lg text-[#2D3C8C]">🎤</span>
                            <div>
                                <p class="font-semibold text-slate-800">Persiapan presentasi, sidang, dan pembuatan poster ilmiah.</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-white py-16">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-8 md:grid-cols-3">
                <div class="rounded-3xl border border-blue-100 bg-gradient-to-br from-blue-50 to-blue-100 p-8 shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <h3 class="text-xl font-semibold text-[#2D3C8C] mb-4 flex items-center gap-2">
                        🚀 Tahap Awal
                    </h3>
                    <ul class="space-y-3 text-sm text-slate-600">
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> Brainstorming dan pemetaan masalah.</li>
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> Penyusunan latar belakang & rumusan masalah.</li>
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> Pembuatan kerangka teori dan tinjauan pustaka.</li>
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> Konsultasi metodologi penelitian.</li>
                    </ul>
                </div>
                <div class="rounded-3xl border border-blue-100 bg-white p-8 shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <h3 class="text-xl font-semibold text-[#2D3C8C] mb-4 flex items-center gap-2">
                        ⚙️ Tahap Pelaksanaan
                    </h3>
                    <ul class="space-y-3 text-sm text-slate-600">
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> Desain instrumen penelitian & pengambilan data.</li>
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> Analisis statistik (SPSS, R, Excel).</li>
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> Interpretasi hasil dan penulisan pembahasan.</li>
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> Supervisi penyusunan BAB IV & BAB V.</li>
                    </ul>
                </div>
                <div class="rounded-3xl border border-blue-100 bg-white p-8 shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <h3 class="text-xl font-semibold text-[#2D3C8C] mb-4 flex items-center gap-2">
                        🏁 Tahap Akhir
                    </h3>
                    <ul class="space-y-3 text-sm text-slate-600">
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> Proofreading, editing tata bahasa, dan layout.</li>
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> Cek kemiripan dan perbaikan sitasi.</li>
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> Pembuatan slide presentasi & latihan sidang.</li>
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> Pendampingan publikasi jurnal ilmiah.</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-white py-20">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl lg:text-4xl font-bold text-slate-900">Layanan yang Kami Tawarkan</h2>
                <p class="mt-3 text-base text-slate-600">Berbagai jenis pendampingan akademik yang dapat dikerjakan oleh tim penjoki kami.</p>
            </div>
            <div class="grid gap-8 lg:grid-cols-3">
                <!-- Starter Guidance -->
                <div class="flex flex-col rounded-3xl border border-blue-100 bg-gradient-to-br from-white to-blue-50 p-8 shadow-lg hover:shadow-xl transition-all duration-300">
                    <div class="mb-4">
                        <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-blue-100 mb-4">
                            <svg class="w-6 h-6 text-[#2D3C8C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-slate-900 mb-2">Starter Guidance</h3>
                        <p class="text-sm text-slate-600 mb-6">Pendampingan awal untuk memulai penulisan tugas akademik.</p>
                    </div>
                    <ul class="space-y-3 text-sm text-slate-600 flex-grow">
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>3 sesi konsultasi online</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Template kerangka bab</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Review literatur & sitasi</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Support revisi minor</span>
                        </li>
                    </ul>
                    <div class="mt-6 pt-4 border-t border-blue-200">
                        <p class="text-xs text-slate-500 text-center italic">Hubungi penjoki untuk info harga & detail</p>
                    </div>
                </div>

                <!-- Complete Writing -->
                <div class="relative flex flex-col rounded-3xl border-2 border-blue-200 bg-gradient-to-br from-blue-50 to-white p-8 shadow-2xl hover:shadow-3xl transition-all duration-300">
                    <div class="absolute -top-4 right-6 rounded-full bg-[#2D3C8C] px-4 py-1 text-xs font-semibold uppercase tracking-wide text-white shadow-lg">Populer</div>
                    <div class="mb-4">
                        <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-blue-600 mb-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-slate-900 mb-2">Complete Writing</h3>
                        <p class="text-sm text-slate-600 mb-6">Pendampingan menyeluruh dari awal hingga siap sidang.</p>
                    </div>
                    <ul class="space-y-3 text-sm text-slate-600 flex-grow">
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Pendampingan semua bab</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Analisis data & statistik</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Editing referensi & anti-plagiarisme</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Simulasi sidang & presentasi</span>
                        </li>
                    </ul>
                    <div class="mt-6 pt-4 border-t border-blue-200">
                        <p class="text-xs text-slate-500 text-center italic">Hubungi penjoki untuk info harga & detail</p>
                    </div>
                </div>

                <!-- Publishing Pro -->
                <div class="flex flex-col rounded-3xl border border-blue-100 bg-gradient-to-br from-white to-blue-50 p-8 shadow-lg hover:shadow-xl transition-all duration-300">
                    <div class="mb-4">
                        <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-blue-100 mb-4">
                            <svg class="w-6 h-6 text-[#2D3C8C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-slate-900 mb-2">Publishing Pro</h3>
                        <p class="text-sm text-slate-600 mb-6">Layanan khusus publikasi jurnal dan konferensi ilmiah.</p>
                    </div>
                    <ul class="space-y-3 text-sm text-slate-600 flex-grow">
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Reformat artikel sesuai template jurnal</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Konsultasi submit dan korespondensi</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Proofreading bahasa Inggris</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Strategi reviewer response</span>
                        </li>
                    </ul>
                    <div class="mt-6 pt-4 border-t border-blue-200">
                        <p class="text-xs text-slate-500 text-center italic">Hubungi penjoki untuk info harga & detail</p>
                    </div>
                </div>
            </div>
            
            <div class="mt-12 text-center">
                <p class="text-base text-slate-600 mb-6">💬 Ingin konsultasi lebih lanjut tentang layanan yang sesuai kebutuhan Anda?</p>
                <a href="#pilih-penjoki" class="inline-flex items-center justify-center rounded-full bg-[#2D3C8C] px-8 py-3 text-sm font-semibold text-white transition-all duration-300 hover:bg-blue-900 hover:shadow-lg">
                    Pilih Penjoki & Mulai Konsultasi
                </a>
            </div>
        </div>
    </section>

    <!-- Section Pilih Penjoki -->
    <section id="pilih-penjoki" class="bg-gradient-to-br from-blue-50 to-white py-20">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl lg:text-4xl font-bold text-slate-900 mb-4">Pilih Penjoki Anda</h2>
                <p class="text-base text-slate-600">Konsultasikan kebutuhan akademik Anda dengan penjoki pilihan kami yang berpengalaman</p>
            </div>

            @if($jokiPersons->isEmpty())
                <div class="text-center py-12">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-blue-100 mb-4">
                        <svg class="w-8 h-8 text-[#2D3C8C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-slate-700 mb-2">Belum Ada Penjoki Tersedia</h3>
                    <p class="text-slate-500">Silakan hubungi kami melalui halaman kontak untuk informasi lebih lanjut.</p>
                    <a href="{{ route('kontak') }}" class="inline-flex items-center justify-center mt-6 rounded-full bg-[#2D3C8C] px-8 py-3 text-sm font-semibold text-white transition-all duration-300 hover:bg-blue-900 hover:shadow-lg">
                        Hubungi Kami
                    </a>
                </div>
            @else
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($jokiPersons as $joki)
                        <div class="group rounded-3xl border border-blue-100 bg-white p-8 shadow-lg hover:shadow-2xl transition-all duration-300 hover:scale-105 hover:border-[#2D3C8C]">
                            <div class="flex flex-col items-center text-center">
                                <!-- Avatar -->
                                <div class="relative mb-6">
                                    <div class="w-24 h-24 rounded-full bg-gradient-to-br from-blue-400 to-[#2D3C8C] flex items-center justify-center text-white text-3xl font-bold shadow-lg group-hover:shadow-xl transition-all duration-300">
                                        {{ strtoupper(substr($joki->name, 0, 1)) }}
                                    </div>
                                    <div class="absolute -bottom-2 -right-2 w-8 h-8 rounded-full bg-green-500 border-4 border-white flex items-center justify-center">
                                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </div>

                                <!-- Info -->
                                <h3 class="text-xl font-bold text-slate-900 mb-2">{{ $joki->name }}</h3>
                                
                                @if($joki->expertise)
                                    <div class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-blue-100 text-xs font-semibold text-[#2D3C8C] mb-4">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                        </svg>
                                        {{ $joki->expertise }}
                                    </div>
                                @endif

                                @if($joki->description)
                                    <p class="text-sm text-slate-600 mb-6 line-clamp-3">{{ $joki->description }}</p>
                                @endif

                                <!-- WhatsApp Button -->
                                <a href="{{ $joki->wa_link }}" target="_blank" rel="noopener noreferrer" class="w-full inline-flex items-center justify-center gap-2 rounded-full bg-green-600 px-6 py-3 text-sm font-semibold text-white transition-all duration-300 hover:bg-green-700 hover:shadow-lg hover:scale-105 group">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                                    </svg>
                                    Chat via WhatsApp
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <section class="bg-white py-16">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-12 lg:grid-cols-2 lg:items-center">
                <div class="animate-fade-in">
                    <h2 class="text-3xl lg:text-4xl font-bold text-slate-900 mb-4">Tim Konsultan Akademik</h2>
                    <p class="text-sm leading-relaxed text-slate-600 mb-6">Dibimbing oleh dosen, reviewer jurnal, dan praktisi riset kefarmasian yang siap membantu secara profesional.</p>
                    <ul class="space-y-3 text-sm text-slate-600">
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> Komitmen kerahasiaan dan orisinalitas karya.</li>
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> Feedback konstruktif dan edukatif di setiap sesi.</li>
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> Garansi revisi sesuai arahan dosen pembimbing.</li>
                    </ul>
                </div>
                <div class="rounded-3xl border border-blue-100 bg-gradient-to-br from-blue-50 to-blue-100 p-10 shadow-lg animate-slide-up">
                    <h3 class="text-xl font-semibold text-[#2D3C8C] mb-4 flex items-center gap-2">
                        💬 Kata Mahasiswa
                    </h3>
                    <blockquote class="space-y-4 text-sm leading-relaxed text-slate-600">
                        <p class="italic">"Bukan cuma dibantu nulis, tapi juga diajari cara berpikir ilmiah. Saat sidang, saya siap menjawab tiap pertanyaan dosen."</p>
                        <footer class="pt-4 text-xs font-semibold text-[#2D3C8C]">— Gilang Nugraha, Mahasiswa S2 Farmasi</footer>
                    </blockquote>
                </div>
            </div>
        </div>
    </section>

    <style>
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes slide-up {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fade-in 0.8s ease-out;
        }
        .animate-slide-up {
            animation: slide-up 1s ease-out;
        }
        
        /* Smooth scroll */
        html {
            scroll-behavior: smooth;
        }
    </style>

    <script>
        // Smooth scroll untuk anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    const offsetTop = target.offsetTop - 80; // Offset untuk navbar
                    window.scrollTo({
                        top: offsetTop,
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>
@endsection
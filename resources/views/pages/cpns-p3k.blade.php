@extends('layouts.app')

@section('title', 'Bimbel CPNS & P3K Farmasi')

@section('content')
    <section class="relative bg-cover bg-center bg-no-repeat bg-gradient-to-br from-blue-50 via-white to-blue-100" style="background-image: url('/images/pns.png'); min-height: 70vh;">
        <div class="absolute inset-0 bg-gradient-to-r from-black/50 to-black/30"></div> <!-- Overlay gradien untuk kontras yang lebih halus -->
        <div class="relative z-10 mx-auto max-w-6xl px-4 py-24 sm:px-6 lg:px-8">
            <div class="grid gap-10 lg:grid-cols-2 lg:items-center">
                <div class="space-y-6 animate-fade-in">
                    <span class="inline-flex items-center rounded-full bg-white/90 backdrop-blur-sm px-4 py-1 text-xs font-semibold uppercase tracking-[0.4em] text-[#2D3C8C] shadow-lg">ASN kefarmasian</span>
                    <h1 class="text-4xl lg:text-5xl font-bold text-white leading-tight">Bimbel CPNS & P3K Farmasi</h1>
                    <p class="text-lg leading-relaxed text-white/90">Raih formasi instansi kefarmasian idaman dengan simulasi CAT real-time, analitik performa, dan coaching SKB mendalam bersama mentor ahli.</p>
                    <div class="flex flex-wrap gap-4">
                        <a href="#paket" class="inline-flex items-center rounded-full bg-[#2D3C8C] px-6 py-3 text-white shadow-lg shadow-[#2D3C8C]/50 transition-all duration-300 hover:bg-blue-900 hover:scale-105 hover:shadow-xl">Lihat Paket Bimbel</a>
                        <a href="{{ route('order.create', ['slug' => 'cpns-p3k-farmasi']) }}" class="inline-flex items-center rounded-full bg-transparent border-2 border-white px-6 py-3 text-white font-semibold transition-all duration-300 hover:bg-white hover:text-[#2D3C8C] hover:scale-105">Beli Sekarang</a>
                    </div>
                </div>
                <div class="rounded-3xl border border-blue-100 bg-white/95 backdrop-blur-sm p-10 shadow-2xl shadow-blue-200/50 animate-slide-up">
                    <h2 class="text-xl font-semibold text-slate-900 mb-4">Komponen Pembelajaran</h2>
                    <ul class="space-y-4 text-sm text-slate-600">
                        <li class="flex items-start gap-3 p-3 rounded-lg bg-blue-50 hover:bg-blue-100 transition-colors duration-200">
                            <span class="mt-1 text-lg text-[#2D3C8C]">📚</span>
                            <div>
                                <p class="font-semibold text-slate-800">Materi SKD lengkap (TWK, TIU, TKP) dengan kisi-kisi terbaru.</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-3 p-3 rounded-lg bg-blue-50 hover:bg-blue-100 transition-colors duration-200">
                            <span class="mt-1 text-lg text-[#2D3C8C]">🏥</span>
                            <div>
                                <p class="font-semibold text-slate-800">Klinik SKB kefarmasian: regulasi BPOM, pelayanan farmasi RS & klinik.</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-3 p-3 rounded-lg bg-blue-50 hover:bg-blue-100 transition-colors duration-200">
                            <span class="mt-1 text-lg text-[#2D3C8C]">💻</span>
                            <div>
                                <p class="font-semibold text-slate-800">Simulasi Computer Assisted Test (CAT) real-time & analitik skor.</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-3 p-3 rounded-lg bg-blue-50 hover:bg-blue-100 transition-colors duration-200">
                            <span class="mt-1 text-lg text-[#2D3C8C]">🎯</span>
                            <div>
                                <p class="font-semibold text-slate-800">Coaching karir, penyusunan portofolio, dan wawancara.</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-3 p-3 rounded-lg bg-blue-50 hover:bg-blue-100 transition-colors duration-200">
                            <span class="mt-1 text-lg text-[#2D3C8C]">👥</span>
                            <div>
                                <p class="font-semibold text-slate-800">Grup support P3K dengan update formasi & tips psikotes.</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-white py-16">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-8 md:grid-cols-2">
                <div class="rounded-3xl border border-blue-100 bg-gradient-to-br from-blue-50 to-blue-100 p-8 shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <h3 class="text-xl font-semibold text-[#2D3C8C] mb-4 flex items-center gap-2">
                        📖 Materi SKD
                    </h3>
                    <ul class="space-y-3 text-sm text-slate-600">
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> TWK: Pancasila, UUD 1945, wawasan kebangsaan.</li>
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> TIU: logika numerik, verbal, dan figural.</li>
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> TKP: pelayanan publik, sosial budaya, dan profesionalisme.</li>
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> Strategi pengerjaan & manajemen waktu CAT.</li>
                    </ul>
                </div>
                <div class="rounded-3xl border border-blue-100 bg-white p-8 shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <h3 class="text-xl font-semibold text-[#2D3C8C] mb-4 flex items-center gap-2">
                        🏥 Materi SKB Farmasi
                    </h3>
                    <ul class="space-y-3 text-sm text-slate-600">
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> Regulasi kefarmasian (Permenkes, BPOM, JKN).</li>
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> Manajemen Farmasi RS & Puskesmas.</li>
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> Clinical pharmacy case study.</li>
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> Administrasi kefarmasian & pelayanan publik.</li>
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> Simulasi wawancara dan microteaching.</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section id="paket" class="bg-gradient-to-br from-blue-50/70 to-blue-100/50 py-20">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl lg:text-4xl font-bold text-slate-900">Pilihan Paket</h2>
                <p class="mt-3 text-base text-slate-600">Dirancang untuk menghadapi persaingan ketat CPNS & P3K kefarmasian.</p>
            </div>
            <div class="grid gap-8 lg:grid-cols-3">
                <div class="flex flex-col rounded-3xl border border-blue-100 bg-white p-8 shadow-lg hover:shadow-2xl transition-all duration-300 hover:scale-105">
                    <h3 class="text-xl font-semibold text-slate-900 mb-2">Paket SKD Fokus</h3>
                    <p class="text-sm text-slate-600 mb-6">Pendalaman soal SKD dengan simulasi CAT intensif.</p>
                    <ul class="space-y-2 text-sm text-slate-600 mb-6">
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> 20x pertemuan intensif SKD</li>
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> 10x simulasi CAT & analitik</li>
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> Bank soal ribuan item</li>
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> Group coaching strategi CAT</li>
                    </ul>
                    <p class="text-2xl font-bold text-[#2D3C8C] mb-6">Rp1.450.000</p>
                    <a href="{{ route('order.create', ['slug' => 'cpns-p3k-skd']) }}" class="inline-flex items-center justify-center rounded-full bg-[#2D3C8C] px-6 py-3 text-sm font-semibold text-white transition-all duration-300 hover:bg-blue-900 hover:shadow-lg">Beli Sekarang</a>
                </div>
                <div class="relative flex flex-col rounded-3xl border-2 border-blue-200 bg-white p-8 shadow-2xl shadow-blue-200/50 hover:shadow-3xl transition-all duration-300 hover:scale-105">
                    <span class="absolute -top-4 right-6 rounded-full bg-[#2D3C8C] px-4 py-1 text-xs font-semibold uppercase tracking-wide text-white shadow-lg">Paling Dicari</span>
                    <h3 class="text-xl font-semibold text-slate-900 mb-2">Paket ASN Lengkap</h3>
                    <p class="text-sm text-slate-600 mb-6">Kolaborasi SKD + SKB dengan mentoring karir dan portofolio.</p>
                    <ul class="space-y-2 text-sm text-slate-600 mb-6">
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> Semua fasilitas Paket SKD Fokus</li>
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> 16x klinik SKB kefarmasian</li>
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> Coaching karir instansi & portofolio</li>
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> Konsultasi interview & psikotes</li>
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> Evaluasi progres personal</li>
                    </ul>
                    <p class="text-2xl font-bold text-[#2D3C8C] mb-6">Rp1.750.000</p>
                    <a href="{{ route('order.create', ['slug' => 'cpns-p3k-farmasi']) }}" class="inline-flex items-center justify-center rounded-full bg-[#2D3C8C] px-6 py-3 text-sm font-semibold text-white transition-all duration-300 hover:bg-blue-900 hover:shadow-lg">Beli Sekarang</a>
                </div>
                <div class="flex flex-col rounded-3xl border border-blue-100 bg-white p-8 shadow-lg hover:shadow-2xl transition-all duration-300 hover:scale-105">
                    <h3 class="text-xl font-semibold text-slate-900 mb-2">Paket SKB Farmasi</h3>
                    <p class="text-sm text-slate-600 mb-6">Fokus khusus SKB kefarmasian dengan materi terpadu.</p>
                    <ul class="space-y-2 text-sm text-slate-600 mb-6">
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> 16x pertemuan SKB farmasi</li>
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> Bank soal farmasi klinik</li>
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> Simulasi SKB & pembahasan</li>
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> Materi farmasi terkini</li>
                    </ul>
                    <p class="text-2xl font-bold text-[#2D3C8C] mb-6">Rp1.250.000</p>
                    <a href="{{ route('order.create', ['slug' => 'cpns-p3k-skb']) }}" class="inline-flex items-center justify-center rounded-full bg-[#2D3C8C] px-6 py-3 text-sm font-semibold text-white transition-all duration-300 hover:bg-blue-900 hover:shadow-lg">Beli Sekarang</a>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-white py-16">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-12 lg:grid-cols-2 lg:items-center">
                <div class="animate-fade-in">
                    <h2 class="text-3xl lg:text-4xl font-bold text-slate-900 mb-4">Keunggulan Program Kami</h2>
                    <ul class="space-y-3 text-sm text-slate-600">
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> Tim mentor ASN aktif dari Kemenkes, RSUD, dan BPOM.</li>
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> Update formasi dan strategi penempatan terbaru.</li>
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> Bank soal selalu diperbarui sesuai kisi-kisi nasional.</li>
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> Dashboard progres dengan rekomendasi adaptif.</li>
                    </ul>
                </div>
                <div class="rounded-3xl border border-blue-100 bg-gradient-to-br from-blue-50 to-blue-100 p-10 shadow-lg animate-slide-up">
                    <h3 class="text-xl font-semibold text-[#2D3C8C] mb-4 flex items-center gap-2">
                        💬 Cerita Peserta
                    </h3>
                    <blockquote class="space-y-4 text-sm leading-relaxed text-slate-600">
                        <p class="italic">"Simulasi CAT-nya mirip banget dengan ujian resmi. Saya bisa memetakan kelemahan dan memperbaikinya sebelum tes berlangsung."</p>
                        <footer class="pt-4 text-xs font-semibold text-[#2D3C8C]">— Vina Paramita, ASN P3K Kefarmasian 2024</footer>
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
    </style>
@endsection

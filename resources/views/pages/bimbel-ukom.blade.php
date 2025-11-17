@extends('layouts.app')

@section('title', 'Bimbel UKOM D3 Farmasi')

@section('content')
    <section class="relative bg-cover bg-center bg-no-repeat" style="background-image: url('/images/1.jpg'); min-height: 70vh;">
        <div class="absolute inset-0 bg-gradient-to-r from-black/50 to-black/30"></div> <!-- Overlay gradien untuk kontras yang lebih halus -->
        <div class="relative z-10 mx-auto max-w-6xl px-4 py-24 sm:px-6 lg:px-8">
            <div class="grid gap-10 lg:grid-cols-2 lg:items-center">
                <div class="space-y-6 animate-fade-in">
                    <span class="inline-flex items-center rounded-full bg-white/90 backdrop-blur-sm px-4 py-1 text-xs font-semibold uppercase tracking-[0.4em] text-[#2D3C8C] shadow-lg">program unggulan</span>
                    <h1 class="text-4xl lg:text-5xl font-bold text-white leading-tight">Program Bimbel UKOM D3 Farmasi</h1>
                    <p class="text-lg leading-relaxed text-white/90">Siap menaklukkan Uji Kompetensi Tenaga Teknis Kefarmasian (UKTTK) dengan modul klinis lengkap, analitik cerdas, dan coaching mentor berpengalaman.</p>
                    <div class="flex flex-wrap gap-4">
                        <a href="#paket" class="inline-flex items-center rounded-full bg-[#2D3C8C] px-6 py-3 text-white shadow-lg shadow-[#2D3C8C]/50 transition-all duration-300 hover:bg-blue-900 hover:scale-105 hover:shadow-xl">Lihat Paket Belajar</a>
                        <a href="{{ route('order.create', ['slug' => 'bimbel-ukom-d3-farmasi']) }}" class="inline-flex items-center rounded-full bg-transparent border-2 border-white px-6 py-3 text-white font-semibold transition-all duration-300 hover:bg-white hover:text-[#2D3C8C] hover:scale-105">Beli Sekarang</a>
                    </div>
                </div>
                <div class="rounded-3xl border border-blue-100 bg-white/95 backdrop-blur-sm p-10 shadow-2xl shadow-blue-200/50 animate-slide-up">
                    <h2 class="text-xl font-semibold text-slate-900 mb-4">Skema Pembelajaran</h2>
                    <ul class="space-y-4 text-sm text-slate-600">
                        <li class="flex items-start gap-3 p-3 rounded-lg bg-blue-50 hover:bg-blue-100 transition-colors duration-200">
                            <span class="mt-1 text-lg text-[#2D3C8C]">1️⃣</span>
                            <div>
                                <p class="font-semibold text-slate-800">Diagnostic Test & Study Plan</p>
                                <p>Pemetaan kompetensi awal dan pembuatan jadwal belajar personal.</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-3 p-3 rounded-lg bg-blue-50 hover:bg-blue-100 transition-colors duration-200">
                            <span class="mt-1 text-lg text-[#2D3C8C]">2️⃣</span>
                            <div>
                                <p class="font-semibold text-slate-800">Kelas Intensif & Klinik Kasus</p>
                                <p>Sesi live interaktif dengan pembahasan kasus klinik & komunitas.</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-3 p-3 rounded-lg bg-blue-50 hover:bg-blue-100 transition-colors duration-200">
                            <span class="mt-1 text-lg text-[#2D3C8C]">3️⃣</span>
                            <div>
                                <p class="font-semibold text-slate-800">Bank Soal Adaptif</p>
                                <p>Ribuan soal terbaru dengan analitik kesulitan dan rekomendasi materi.</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-3 p-3 rounded-lg bg-blue-50 hover:bg-blue-100 transition-colors duration-200">
                            <span class="mt-1 text-lg text-[#2D3C8C]">4️⃣</span>
                            <div>
                                <p class="font-semibold text-slate-800">Tryout Nasional & Review</p>
                                <p>Simulasi UKTTK serentak dan pembahasan mendalam bersama mentor.</p>
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
                        📚 Materi Pembelajaran
                    </h3>
                    <ul class="space-y-3 text-sm text-slate-600">
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> Farmakologi & Toksikologi</li>
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> Farmasi Klinik & Komunitas</li>
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> Farmasetika & Teknologi Farmasi</li>
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> Manajemen Farmasi RS & Puskesmas</li>
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> Etika Profesi & Regulasi Kefarmasian</li>
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> Studi kasus pasien & clinical pathway</li>
                    </ul>
                </div>
                <div class="rounded-3xl border border-blue-100 bg-white p-8 shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <h3 class="text-xl font-semibold text-[#2D3C8C] mb-4 flex items-center gap-2">
                        🎁 Benefit Peserta
                    </h3>
                    <ul class="space-y-3 text-sm text-slate-600">
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> Kelas live interaktif & rekaman seumur hidup</li>
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> Modul belajar digital & ringkasan klinik</li>
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> Grup diskusi Telegram & konsultasi harian</li>
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> Monitoring progres & reminder otomatis</li>
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> Voucher webinar kefarmasian tiap bulan</li>
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> Sertifikat kelulusan program intensif</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section id="paket" class="bg-gradient-to-br from-blue-50/70 to-blue-100/50 py-20">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl lg:text-4xl font-bold text-slate-900">Paket Pembelajaran</h2>
                <p class="mt-3 text-base text-slate-600">Sesuaikan dengan kebutuhan dan intensitas belajar kamu.</p>
            </div>
            <div class="grid gap-8 lg:grid-cols-3">
                <div class="flex flex-col rounded-3xl border border-blue-100 bg-white p-8 shadow-lg hover:shadow-2xl transition-all duration-300 hover:scale-105">
                    <h3 class="text-xl font-semibold text-slate-900 mb-2">Reguler</h3>
                    <p class="text-sm text-slate-600 mb-6">Untuk kamu yang ingin belajar mandiri dengan arahan mentor.</p>
                    <ul class="space-y-2 text-sm text-slate-600 mb-6">
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> 16 sesi live / hybrid</li>
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> Akses modul digital & bank soal</li>
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> 4x tryout terjadwal</li>
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> Grup diskusi komunitas</li>
                    </ul>
                    <p class="text-2xl font-bold text-[#2D3C8C] mb-6">Rp1.250.000</p>
                    <a href="{{ route('order.create', ['slug' => 'bimbel-ukom-d3-farmasi']) }}" class="inline-flex items-center justify-center rounded-full bg-[#2D3C8C] px-6 py-3 text-sm font-semibold text-white transition-all duration-300 hover:bg-blue-900 hover:shadow-lg">Beli Sekarang</a>
                </div>
                <div class="relative flex flex-col rounded-3xl border-2 border-blue-200 bg-white p-8 shadow-2xl shadow-blue-200/50 hover:shadow-3xl transition-all duration-300 hover:scale-105">
                    <span class="absolute -top-4 right-6 rounded-full bg-[#2D3C8C] px-4 py-1 text-xs font-semibold uppercase tracking-wide text-white shadow-lg">Best Seller</span>
                    <h3 class="text-xl font-semibold text-slate-900 mb-2">Intensif</h3>
                    <p class="text-sm text-slate-600 mb-6">Pendampingan intensif dengan jadwal fleksibel dan bimbingan personal.</p>
                    <ul class="space-y-2 text-sm text-slate-600 mb-6">
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> Semua fasilitas Paket Reguler</li>
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> Mentoring privat mingguan</li>
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> Evaluasi progres personal</li>
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> Konsultasi karir & interview</li>
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> Paket modul cetak & bank soal premium</li>
                    </ul>
                    <p class="text-2xl font-bold text-[#2D3C8C] mb-6">Rp1.850.000</p>
                    <a href="{{ route('order.create', ['slug' => 'bimbel-ukom-intensif']) }}" class="inline-flex items-center justify-center rounded-full bg-[#2D3C8C] px-6 py-3 text-sm font-semibold text-white transition-all duration-300 hover:bg-blue-900 hover:shadow-lg">Beli Sekarang</a>
                </div>
                <div class="flex flex-col rounded-3xl border border-blue-100 bg-white p-8 shadow-lg hover:shadow-2xl transition-all duration-300 hover:scale-105">
                    <h3 class="text-xl font-semibold text-slate-900 mb-2">Express</h3>
                    <p class="text-sm text-slate-600 mb-6">Program cepat untuk target kelulusan dengan waktu terbatas.</p>
                    <ul class="space-y-2 text-sm text-slate-600 mb-6">
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> 8 sesi intensif fokus</li>
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> Modul ringkas high-yield</li>
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> 2x tryout & pembahasan</li>
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> Akses grup diskusi</li>
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> Bank soal digital</li>
                    </ul>
                    <p class="text-2xl font-bold text-[#2D3C8C] mb-6">Rp750.000</p>
                    <a href="{{ route('order.create', ['slug' => 'bimbel-ukom-express']) }}" class="inline-flex items-center justify-center rounded-full bg-[#2D3C8C] px-6 py-3 text-sm font-semibold text-white transition-all duration-300 hover:bg-blue-900 hover:shadow-lg">Beli Sekarang</a>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-white py-16">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-12 lg:grid-cols-2 lg:items-center">
                <div class="animate-fade-in">
                    <h2 class="text-3xl lg:text-4xl font-bold text-slate-900 mb-4">Mentor Klinis & Akademisi Terbaik</h2>
                    <p class="text-sm leading-relaxed text-slate-600 mb-6">Dipandu oleh apoteker rumah sakit, dosen, dan praktisi industri dengan pengalaman sukses membimbing mahasiswa lulus UKTTK hingga 100%.</p>
                    <ul class="space-y-3 text-sm text-slate-600">
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> Mentor bersertifikat preseptor klinik</li>
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> Konsultasi kasus farmasi rumah sakit</li>
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> Strategi menjawab soal dengan clinical reasoning</li>
                    </ul>
                </div>
                <div class="rounded-3xl border border-blue-100 bg-gradient-to-br from-blue-50 to-blue-100 p-10 shadow-lg animate-slide-up">
                    <h3 class="text-xl font-semibold text-[#2D3C8C] mb-4 flex items-center gap-2">
                        💬 Testimoni Alumni
                    </h3>
                    <blockquote class="space-y-4 text-sm leading-relaxed text-slate-600">
                        <p class="italic">"Dari diagnostic test sampai tryout final, semuanya terstruktur. Nilai UKOM saya naik drastis setelah ikut program ini."</p>
                        <footer class="pt-4 text-xs font-semibold text-[#2D3C8C]">— Raras Salsabila, Lulus UKTTK 2024</footer>
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

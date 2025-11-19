@extends('layouts.app')

@section('title', 'Beranda')

@section('meta_description', 'Bimbel Farmasi - Solusi terpercaya untuk UKOM D3 Farmasi, CPNS & P3K Farmasi, dan pendampingan tugas akademik. Tingkat kelulusan 95%, mentor profesional, modul lengkap, dan metode pembelajaran terbukti efektif.')

@section('meta_keywords', 'bimbel farmasi, ukom d3 farmasi, cpns farmasi, p3k farmasi, joki tugas farmasi, les privat farmasi, kursus farmasi, bimbingan belajar farmasi, mentor farmasi')

@section('og_title', 'Bimbel Farmasi - Solusi Akademik & Karir Farmasi Terpercaya')

@section('og_description', 'Platform bimbingan belajar farmasi terlengkap dengan tingkat kelulusan 95%. Program UKOM, CPNS & P3K, dan pendampingan akademik oleh mentor berpengalaman.')

@section('content')
    <section class="relative overflow-hidden bg-gradient-to-br from-blue-50 via-white to-blue-100/60">
        <div class="absolute inset-0 pointer-events-none" aria-hidden="true">
            <div class="absolute -left-24 top-10 h-72 w-72 rounded-full bg-[#2D3C8C]/10 blur-3xl"></div>
            <div class="absolute right-0 bottom-0 h-80 w-80 rounded-full bg-[#DCE6F7]/70 blur-3xl"></div>
        </div>
        <div class="relative mx-auto max-w-7xl px-4 py-24 sm:px-6 lg:px-8">
            <div class="grid gap-12 lg:grid-cols-2 lg:items-center">
                <div class="space-y-6">
                    <span class="inline-flex items-center rounded-full bg-blue-100 px-4 py-1 text-xs font-semibold uppercase tracking-widest text-[#2D3C8C]">Pendampingan Kefarmasian</span>
                    <h1 class="text-4xl font-semibold text-slate-900 md:text-5xl">Solusi Akademik &amp; Karir Farmasi Terpercaya</h1>
                    <p class="text-lg leading-relaxed text-slate-600">Dapatkan dukungan lengkap untuk menaklukkan UKOM, CPNS &amp; P3K, serta tugas akademik kefarmasian. Mentor profesional, modul eksklusif, dan monitoring progres dalam satu platform.</p>
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('layanan') }}" class="inline-flex items-center rounded-full bg-[#2D3C8C] px-6 py-3 text-white shadow-lg shadow-[#2D3C8C]/30 transition hover:bg-blue-900">Jelajahi Layanan</a>
                        <a href="{{ route('kontak') }}" class="inline-flex items-center rounded-full border border-[#2D3C8C] px-6 py-3 text-[#2D3C8C] transition hover:bg-blue-50">Hubungi Kami</a>
                    </div>
                </div>
                <div class="relative">
                    <div class="absolute -left-8 top-8 h-40 w-40 rounded-full bg-[#2D3C8C]/20 blur-3xl"></div>
                    <div class="relative rounded-3xl border border-blue-100 bg-white p-8 shadow-xl shadow-blue-100/60">
                        <div class="grid gap-6">
                            <div class="flex items-center gap-4">
                                <span class="flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-50 text-2xl">💊</span>
                                <div>
                                    <h3 class="text-lg font-semibold text-slate-900">Materi Eksklusif</h3>
                                    <p class="text-sm text-slate-500">Bank soal &amp; modul terupdate dengan fokus klinis dan regulasi terbaru.</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <span class="flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-50 text-2xl">🩺</span>
                                <div>
                                    <h3 class="text-lg font-semibold text-slate-900">Mentor Praktisi</h3>
                                    <p class="text-sm text-slate-500">Pembimbing profesional dengan pengalaman rumah sakit dan industri.</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <span class="flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-50 text-2xl">📈</span>
                                <div>
                                    <h3 class="text-lg font-semibold text-slate-900">Monitoring Progres</h3>
                                    <p class="text-sm text-slate-500">Analitik belajar real-time dan laporan performa personal.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
        <div class="text-center">
            <h2 class="text-3xl font-semibold text-slate-900">Layanan Kami</h2>
            <p class="mt-3 text-base text-slate-600">Pilih pendampingan terbaik sesuai kebutuhanmu.</p>
        </div>
        <div class="mt-12 grid gap-8 md:grid-cols-3">
            <div class="flex flex-col rounded-3xl bg-white p-8 shadow-lg shadow-blue-100/60">
                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-50 text-2xl text-[#2D3C8C]">🎓</div>
                <h3 class="mt-6 text-xl font-semibold text-slate-900">Bimbel UKOM D3 Farmasi</h3>
                <p class="mt-3 flex-grow text-sm leading-relaxed text-slate-600">Program intensif persiapan UKOM dengan bank soal adaptif dan sesi klinis.</p>
                <a href="{{ route('bimbel.ukom') }}" class="mt-6 inline-flex items-center text-sm font-semibold text-[#2D3C8C] hover:underline">Pelajari Selengkapnya →</a>
            </div>
            <div class="flex flex-col rounded-3xl bg-white p-8 shadow-lg shadow-blue-100/60">
                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-50 text-2xl text-[#2D3C8C]">🏥</div>
                <h3 class="mt-6 text-xl font-semibold text-slate-900">Bimbel CPNS &amp; P3K Kefarmasian</h3>
                <p class="mt-3 flex-grow text-sm leading-relaxed text-slate-600">Strategi SKD &amp; SKB dengan simulasi CAT, kisi-kisi terbaru, dan coaching karir.</p>
                <a href="{{ route('cpns.p3k') }}" class="mt-6 inline-flex items-center text-sm font-semibold text-[#2D3C8C] hover:underline">Pelajari Selengkapnya →</a>
            </div>
            <div class="flex flex-col rounded-3xl bg-white p-8 shadow-lg shadow-blue-100/60">
                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-50 text-2xl text-[#2D3C8C]">📝</div>
                <h3 class="mt-6 text-xl font-semibold text-slate-900">Joki Tugas Akademik Farmasi</h3>
                <p class="mt-3 flex-grow text-sm leading-relaxed text-slate-600">Pendampingan penyusunan tugas, skripsi, KTI, dan publikasi ilmiah secara etis.</p>
                <a href="{{ route('joki.tugas') }}" class="mt-6 inline-flex items-center text-sm font-semibold text-[#2D3C8C] hover:underline">Pelajari Selengkapnya →</a>
            </div>
        </div>
    </section>

    <section class="bg-white">
        <div class="mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
            <div class="grid gap-12 lg:grid-cols-3">
                <div class="lg:col-span-1">
                    <span class="text-xs font-semibold uppercase tracking-[0.3em] text-[#2D3C8C]">Paket Terstruktur</span>
                    <h2 class="mt-4 text-3xl font-semibold text-slate-900">Detail Layanan Unggulan</h2>
                    <p class="mt-4 text-sm leading-relaxed text-slate-600">Semua program dikembangkan oleh tim akademik dan praktisi farmasi dengan update materi rutin.</p>
                </div>
                <div class="lg:col-span-2 grid gap-8">
                    <div class="rounded-3xl border border-blue-100 bg-blue-50 p-8 shadow-sm">
                        <h3 class="text-xl font-semibold text-[#2D3C8C]">Paket Bimbel UKOM</h3>
                        <div class="mt-4 grid gap-4 md:grid-cols-2">
                            <div>
                                <h4 class="text-sm font-semibold text-slate-800">Reguler</h4>
                                <ul class="mt-2 space-y-2 text-sm text-slate-600">
                                    <li>• 16x pertemuan intensif</li>
                                    <li>• Bank soal klinis &amp; komunitas</li>
                                    <li>• Tryout bulanan &amp; analitik</li>
                                </ul>
                            </div>
                            <div>
                                <h4 class="text-sm font-semibold text-slate-800">Premium</h4>
                                <ul class="mt-2 space-y-2 text-sm text-slate-600">
                                    <li>• Mentoring privat &amp; study plan</li>
                                    <li>• Konsultasi karir &amp; CV review</li>
                                    <li>• Akses modul offline &amp; online</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="rounded-3xl border border-blue-100 bg-white p-8 shadow-sm">
                        <h3 class="text-xl font-semibold text-[#2D3C8C]">Paket CPNS &amp; P3K</h3>
                        <div class="mt-4 grid gap-4 md:grid-cols-2">
                            <ul class="space-y-2 text-sm text-slate-600">
                                <li>• Materi SKD (TWK, TIU, TKP) &amp; SKB kefarmasian</li>
                                <li>• Simulasi CAT real-time &amp; pembahasan</li>
                                <li>• Update regulasi BPOM, Kemenkes, RS</li>
                            </ul>
                            <ul class="space-y-2 text-sm text-slate-600">
                                <li>• Coaching karir instansi dan formasi</li>
                                <li>• Grup diskusi dengan mentor ahli</li>
                                <li>• Tips psikotes &amp; microteaching</li>
                            </ul>
                        </div>
                    </div>
                    <div class="rounded-3xl border border-blue-100 bg-white p-8 shadow-sm">
                        <h3 class="text-xl font-semibold text-[#2D3C8C]">Joki Akademik &amp; Konsultasi</h3>
                        <div class="mt-4 grid gap-4 md:grid-cols-2">
                            <ul class="space-y-2 text-sm text-slate-600">
                                <li>• Penulisan Skripsi, KTI, Tesis</li>
                                <li>• Penyusunan proposal penelitian</li>
                                <li>• Review jurnal &amp; literatur evidence-based</li>
                            </ul>
                            <ul class="space-y-2 text-sm text-slate-600">
                                <li>• Konsultasi metodologi &amp; statistik</li>
                                <li>• Editing referensi &amp; plagiarisme</li>
                                <li>• Pendampingan sidang &amp; presentasi</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="testimoni" class="bg-blue-50/60">
        <div class="mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
            <div class="text-center">
                <span class="text-xs font-semibold uppercase tracking-[0.3em] text-[#2D3C8C]">Cerita Sukses</span>
                <h2 class="mt-3 text-3xl font-semibold text-slate-900">Testimoni Peserta</h2>
                <p class="mt-3 text-base text-slate-600">Ribuan tenaga kefarmasian telah meraih mimpi bersama kami.</p>
            </div>
            <div class="mt-12 grid gap-8 md:grid-cols-3">
                <article class="rounded-3xl bg-white p-8 shadow-lg shadow-blue-100/60">
                    <div class="flex items-center gap-4">
                        <img src="https://i.pravatar.cc/100?img=47" alt="Profil peserta" class="h-12 w-12 rounded-full object-cover">
                        <div>
                            <h3 class="font-semibold text-slate-900">Putri Maharani</h3>
                            <p class="text-xs text-slate-500">Lulus UKOM 2024</p>
                        </div>
                    </div>
                    <p class="mt-5 text-sm leading-relaxed text-slate-600">“Bank soal klinis dan pembahasan detailnya sangat membantu. Mentor selalu available untuk konsultasi kasus pasien.”</p>
                </article>
                <article class="rounded-3xl bg-white p-8 shadow-lg shadow-blue-100/60">
                    <div class="flex items-center gap-4">
                        <img src="https://i.pravatar.cc/100?img=12" alt="Profil peserta" class="h-12 w-12 rounded-full object-cover">
                        <div>
                            <h3 class="font-semibold text-slate-900">Rama Yudha</h3>
                            <p class="text-xs text-slate-500">ASN P3K 2025</p>
                        </div>
                    </div>
                    <p class="mt-5 text-sm leading-relaxed text-slate-600">“Simulasi CAT dan coaching karirnya membuka wawasan. Saya lolos formasi RSUD berkat strategi yang diberikan.”</p>
                </article>
                <article class="rounded-3xl bg-white p-8 shadow-lg shadow-blue-100/60">
                    <div class="flex items-center gap-4">
                        <img src="https://i.pravatar.cc/100?img=32" alt="Profil peserta" class="h-12 w-12 rounded-full object-cover">
                        <div>
                            <h3 class="font-semibold text-slate-900">Nadia Husna</h3>
                            <p class="text-xs text-slate-500">Magister Farmasi UI</p>
                        </div>
                    </div>
                    <p class="mt-5 text-sm leading-relaxed text-slate-600">“Pendampingan joki tugas mereka sangat etis. Saya dibimbing mulai dari proposal sampai publikasi jurnal.”</p>
                </article>
            </div>
        </div>
    </section>
@endsection

@extends('layouts.app')

@section('title', 'Layanan Bimbel Farmasi')

@section('content')
    <section class="relative overflow-hidden bg-gradient-to-br from-blue-100 via-white to-blue-50">
        <div class="absolute inset-0" aria-hidden="true">
            <div class="absolute -right-16 top-10 h-72 w-72 rounded-full bg-[#2D3C8C]/10 blur-3xl"></div>
            <div class="absolute left-20 bottom-0 h-80 w-80 rounded-full bg-[#DCE6F7]/80 blur-3xl"></div>
        </div>
        <div class="relative mx-auto max-w-6xl px-4 py-24 sm:px-6 lg:px-8">
            <div class="grid gap-10 lg:grid-cols-2 lg:items-center">
                <div class="space-y-6">
                    <span class="inline-flex items-center rounded-full bg-white/80 px-4 py-1 text-xs font-semibold uppercase tracking-[0.4em] text-[#2D3C8C]">layanan kami</span>
                    <h1 class="text-4xl font-semibold text-slate-900">Pilih Layanan Terbaikmu untuk Sukses Akademik &amp; Karir Farmasimu</h1>
                    <p class="text-lg text-slate-600">Setiap program dirancang untuk menjawab kebutuhan spesifik mahasiswa dan tenaga kefarmasian, mulai dari persiapan UKOM, seleksi CPNS &amp; P3K, hingga pendampingan tugas akademik.</p>
                    <a href="#paket" class="inline-flex items-center rounded-full bg-[#2D3C8C] px-6 py-3 text-white shadow-lg shadow-[#2D3C8C]/30 transition hover:bg-blue-900">Lihat Paket Layanan</a>
                </div>
                <div class="rounded-3xl border border-blue-100 bg-white/90 p-10 shadow-xl backdrop-blur">
                    <ul class="space-y-4 text-sm text-slate-600">
                        <li class="flex items-start gap-3">
                            <span class="mt-1 text-lg text-[#2D3C8C]">📘</span>
                            <p>Modul pembelajaran disusun oleh tim akademik dan praktisi kefarmasian dengan update reguler.</p>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="mt-1 text-lg text-[#2D3C8C]">🧠</span>
                            <p>Sesi live, rekaman, dan konsultasi personal untuk mempercepat pemahaman materi.</p>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="mt-1 text-lg text-[#2D3C8C]">📊</span>
                            <p>Analisis performa otomatis dengan rekomendasi pembelajaran personal.</p>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="mt-1 text-lg text-[#2D3C8C]">🤝</span>
                            <p>Komunitas supportif dan event networking untuk memperluas relasi profesional.</p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section id="paket" class="mx-auto max-w-6xl px-4 py-20 sm:px-6 lg:px-8">
        <div class="space-y-12">
            <div class="text-center">
                <h2 class="text-3xl font-semibold text-slate-900">Paket Layanan</h2>
                <p class="mt-3 text-base text-slate-600">Enam pilihan program yang dapat dikustomisasi sesuai targetmu.</p>
            </div>
            <div class="grid gap-8 lg:grid-cols-3">
                <div class="flex flex-col rounded-3xl border border-blue-100 bg-white p-8 shadow-sm">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-semibold text-slate-900">Bimbel UKOM D3 Farmasi</h3>
                        <span class="text-2xl">🎓</span>
                    </div>
                    <p class="mt-4 text-sm text-slate-600">Kelas intensif UKOM dengan modul klinis, komunitas, dan tryout adaptif.</p>
                    <div class="mt-6 space-y-2 text-sm text-slate-600">
                        <p><strong>Materi:</strong> Farmakologi, Farmakoterapi, Farmasetika, Farmasi Klinik.</p>
                        <ul class="space-y-1">
                            <li>• 16 sesi live &amp; rekaman</li>
                            <li>• Bank soal nasional terbaru</li>
                            <li>• Coaching psikologis pre-ujian</li>
                        </ul>
                    </div>
                    <div class="mt-6 text-sm text-slate-600">
                        <p><strong>Harga mulai</strong></p>
                        <p class="text-2xl font-semibold text-[#2D3C8C]">Rp1.250.000</p>
                    </div>
                    <a href="{{ route('bimbel.ukom') }}" class="mt-6 inline-flex items-center justify-center rounded-full bg-[#2D3C8C] px-6 py-3 text-sm font-semibold text-white shadow transition hover:bg-blue-900">Pilih Paket</a>
                </div>
                <div class="relative flex flex-col rounded-3xl border border-blue-200 bg-white p-8 shadow-xl shadow-blue-100">
                    <span class="absolute -top-4 right-6 rounded-full bg-[#2D3C8C] px-4 py-1 text-xs font-semibold uppercase tracking-wide text-white">Paling Populer</span>
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-semibold text-slate-900">CPNS &amp; P3K Farmasi</h3>
                        <span class="text-2xl">🏥</span>
                    </div>
                    <p class="mt-4 text-sm text-slate-600">Strategi lengkap SKD &amp; SKB dengan simulasi CAT dan mentoring karir instansi.</p>
                    <div class="mt-6 space-y-2 text-sm text-slate-600">
                        <p><strong>Materi:</strong> TWK, TIU, TKP, Regulasi BPOM &amp; Kemenkes.</p>
                        <ul class="space-y-1">
                            <li>• 24x simulasi CAT &amp; pembahasan</li>
                            <li>• Bank kisi-kisi instansi terkini</li>
                            <li>• Klinik SKB kefarmasian</li>
                        </ul>
                    </div>
                    <div class="mt-6 text-sm text-slate-600">
                        <p><strong>Harga mulai</strong></p>
                        <p class="text-2xl font-semibold text-[#2D3C8C]">Rp1.750.000</p>
                    </div>
                    <a href="{{ route('cpns.p3k') }}" class="mt-6 inline-flex items-center justify-center rounded-full bg-[#2D3C8C] px-6 py-3 text-sm font-semibold text-white shadow transition hover:bg-blue-900">Pilih Paket</a>
                </div>
                <div class="flex flex-col rounded-3xl border border-blue-100 bg-white p-8 shadow-sm">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-semibold text-slate-900">Joki Skripsi &amp; KTI</h3>
                        <span class="text-2xl">📝</span>
                    </div>
                    <p class="mt-4 text-sm text-slate-600">Pendampingan etis penulisan ilmiah dari outline, metodologi, hingga publikasi.</p>
                    <div class="mt-6 space-y-2 text-sm text-slate-600">
                        <p><strong>Materi:</strong> Metodologi, Statistik, Review Literatur.</p>
                        <ul class="space-y-1">
                            <li>• Konsultasi topik &amp; struktur</li>
                            <li>• Editing referensi &amp; sitasi</li>
                            <li>• Simulasi sidang &amp; presentasi</li>
                        </ul>
                    </div>
                    <div class="mt-6 text-sm text-slate-600">
                        <p><strong>Harga mulai</strong></p>
                        <p class="text-2xl font-semibold text-[#2D3C8C]">Rp1.450.000</p>
                    </div>
                    <a href="{{ route('joki.tugas') }}" class="mt-6 inline-flex items-center justify-center rounded-full bg-[#2D3C8C] px-6 py-3 text-sm font-semibold text-white shadow transition hover:bg-blue-900">Pilih Paket</a>
                </div>
            </div>

            <div class="grid gap-8 lg:grid-cols-3">
                <div class="flex flex-col rounded-3xl border border-blue-100 bg-white p-8 shadow-sm">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-semibold text-slate-900">Konsultasi Akademik</h3>
                        <span class="text-2xl">🧑‍🏫</span>
                    </div>
                    <p class="mt-4 flex-grow text-sm text-slate-600">Sesi diskusi privat dengan mentor untuk kurikulum, penelitian, atau karir farmasi.</p>
                    <ul class="mt-6 space-y-1 text-sm text-slate-600">
                        <li>• Review rencana studi</li>
                        <li>• Konsultasi pemilihan topik riset</li>
                        <li>• Strategi karir klinis &amp; industri</li>
                    </ul>
                    <div class="mt-6 text-sm text-slate-600">
                        <p><strong>Harga mulai</strong></p>
                        <p class="text-2xl font-semibold text-[#2D3C8C]">Rp550.000</p>
                    </div>
                    <a href="{{ route('home') }}#kontak" class="mt-6 inline-flex items-center justify-center rounded-full bg-[#2D3C8C] px-6 py-3 text-sm font-semibold text-white shadow transition hover:bg-blue-900">Konsultasi</a>
                </div>
                <div class="flex flex-col rounded-3xl border border-blue-100 bg-white p-8 shadow-sm">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-semibold text-slate-900">Kelas Reguler</h3>
                        <span class="text-2xl">📚</span>
                    </div>
                    <p class="mt-4 flex-grow text-sm text-slate-600">Program mingguan dengan fokus teori dan praktik kefarmasian dasar.</p>
                    <ul class="mt-6 space-y-1 text-sm text-slate-600">
                        <li>• 12x pertemuan tatap muka/online</li>
                        <li>• Modul praktikum &amp; studi kasus</li>
                        <li>• Forum diskusi komunitas</li>
                    </ul>
                    <div class="mt-6 text-sm text-slate-600">
                        <p><strong>Harga mulai</strong></p>
                        <p class="text-2xl font-semibold text-[#2D3C8C]">Rp980.000</p>
                    </div>
                    <a href="{{ route('home') }}#kontak" class="mt-6 inline-flex items-center justify-center rounded-full bg-[#2D3C8C] px-6 py-3 text-sm font-semibold text-white shadow transition hover:bg-blue-900">Pesan Kelas</a>
                </div>
                <div class="flex flex-col rounded-3xl border border-blue-100 bg-white p-8 shadow-sm">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-semibold text-slate-900">Program Intensif</h3>
                        <span class="text-2xl">⚡</span>
                    </div>
                    <p class="mt-4 flex-grow text-sm text-slate-600">Bootcamp singkat untuk kebutuhan mendesak dengan pendampingan penuh.</p>
                    <ul class="mt-6 space-y-1 text-sm text-slate-600">
                        <li>• 7 hari pendampingan personal</li>
                        <li>• Kelas malam &amp; akhir pekan</li>
                        <li>• Evaluasi harian &amp; sprint planner</li>
                    </ul>
                    <div class="mt-6 text-sm text-slate-600">
                        <p><strong>Harga mulai</strong></p>
                        <p class="text-2xl font-semibold text-[#2D3C8C]">Rp2.200.000</p>
                    </div>
                    <a href="{{ route('home') }}#kontak" class="mt-6 inline-flex items-center justify-center rounded-full bg-[#2D3C8C] px-6 py-3 text-sm font-semibold text-white shadow transition hover:bg-blue-900">Booking Sekarang</a>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-[#2D3C8C]">
        <div class="mx-auto max-w-6xl px-4 py-16 sm:px-6 lg:px-8">
            <div class="grid gap-10 lg:grid-cols-2 lg:items-center">
                <div class="space-y-4 text-white">
                    <h2 class="text-3xl font-semibold">Masih Bingung Memilih Program?</h2>
                    <p class="text-sm leading-relaxed text-white/80">Tim akademik kami siap merekomendasikan paket terbaik sesuai timeline ujian dan kebutuhan karirmu.</p>
                </div>
                <div class="flex justify-start lg:justify-end">
                    <a href="https://wa.me/6281234567890?text=Halo%20Bimbel%20Farmasi,%20saya%20ingin%20konsultasi%20mengenai%20program%20yang%20tersedia" target="_blank" rel="noopener noreferrer" class="inline-flex items-center rounded-full bg-white px-6 py-3 text-sm font-semibold text-[#2D3C8C] shadow-lg shadow-black/20 transition hover:bg-blue-50">Konsultasi Gratis →</a>
                </div>
            </div>
        </div>
    </section>
@endsection

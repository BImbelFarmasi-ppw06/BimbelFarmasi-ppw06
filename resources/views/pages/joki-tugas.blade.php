@extends('layouts.app')

@section('title', 'Joki Tugas & Konsultasi Akademik Farmasi')

@section('meta_description', 'Jasa pendampingan tugas akademik farmasi profesional. Bantuan skripsi, jurnal ilmiah, laporan praktikum, dan tugas farmasi lainnya. Dikerjakan oleh mentor berpengalaman dengan hasil berkualitas tinggi.')

@section('meta_keywords', 'joki tugas farmasi, bantuan tugas farmasi, jasa skripsi farmasi, konsultasi akademik farmasi, pendampingan skripsi, jasa jurnal farmasi, tutor farmasi, mentor farmasi')

@section('og_title', 'Joki Tugas & Konsultasi Akademik Farmasi Profesional')

@section('og_description', 'Dapatkan bantuan profesional untuk tugas akademik farmasi Anda. Skripsi, jurnal, laporan praktikum - dikerjakan dengan standar akademik tinggi dan tepat waktu.')

@section('og_image', asset('images/unnamed.jpg'))

@section('content')
    <section class="relative bg-cover bg-center bg-no-repeat bg-gradient-to-br from-blue-100 via-white to-blue-50" style="background-image: url('/images/unnamed.jpg'); min-height: 70vh;">
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

    <section id="paket" class="bg-gradient-to-br from-blue-50/70 to-blue-100/50 py-20">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl lg:text-4xl font-bold text-slate-900">Paket Pendampingan</h2>
                <p class="mt-3 text-base text-slate-600">Transparan, fleksibel, dan menyesuaikan kebutuhan tiap peserta.</p>
            </div>
            <div class="grid gap-8 lg:grid-cols-3">
                <div class="flex flex-col rounded-3xl border border-blue-100 bg-white p-8 shadow-lg hover:shadow-2xl transition-all duration-300 hover:scale-105">
                    <h3 class="text-xl font-semibold text-slate-900 mb-2">Starter Guidance</h3>
                    <p class="text-sm text-slate-600 mb-6">Pendampingan 1 bab untuk mengawali penulisan.</p>
                    <ul class="space-y-2 text-sm text-slate-600 mb-6">
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> 3 sesi konsultasi online</li>
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> Template kerangka bab</li>
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> Review literatur & sitasi</li>
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> Support revisi minor</li>
                    </ul>
                    <p class="text-2xl font-bold text-[#2D3C8C] mb-6">Rp500.000</p>
                    <div class="flex flex-col gap-2">
                        <a href="{{ route('order.create', ['slug' => 'joki-tugas-farmasi']) }}" class="inline-flex items-center justify-center rounded-full bg-[#2D3C8C] px-6 py-3 text-sm font-semibold text-white transition-all duration-300 hover:bg-blue-900 hover:shadow-lg">Beli Sekarang</a>
                        <a href="{{ route('kontak') }}" class="inline-flex items-center justify-center rounded-full bg-transparent border-2 border-[#2D3C8C] px-6 py-3 text-sm font-semibold text-[#2D3C8C] transition-all duration-300 hover:bg-blue-50">Konsultasi Gratis</a>
                    </div>
                </div>
                <div class="relative flex flex-col rounded-3xl border-2 border-blue-200 bg-white p-8 shadow-2xl shadow-blue-200/50 hover:shadow-3xl transition-all duration-300 hover:scale-105">
                    <span class="absolute -top-4 right-6 rounded-full bg-[#2D3C8C] px-4 py-1 text-xs font-semibold uppercase tracking-wide text-white shadow-lg">Favorit</span>
                    <h3 class="text-xl font-semibold text-slate-900 mb-2">Complete Writing</h3>
                    <p class="text-sm text-slate-600 mb-6">Pendampingan keseluruhan tugas akhir sampai siap sidang.</p>
                    <ul class="space-y-2 text-sm text-slate-600 mb-6">
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> Pendampingan semua bab</li>
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> Analisis data & statistik</li>
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> Editing referensi & anti-plagiarisme</li>
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> Simulasi sidang & presentasi</li>
                    </ul>
                    <p class="text-2xl font-bold text-[#2D3C8C] mb-6">Rp2.500.000</p>
                    <div class="flex flex-col gap-2">
                        <a href="{{ route('order.create', ['slug' => 'joki-tugas-premium']) }}" class="inline-flex items-center justify-center rounded-full bg-[#2D3C8C] px-6 py-3 text-sm font-semibold text-white transition-all duration-300 hover:bg-blue-900 hover:shadow-lg">Beli Sekarang</a>
                        <a href="{{ route('kontak') }}" class="inline-flex items-center justify-center rounded-full bg-transparent border-2 border-[#2D3C8C] px-6 py-3 text-sm font-semibold text-[#2D3C8C] transition-all duration-300 hover:bg-blue-50">Konsultasi Gratis</a>
                    </div>
                </div>
                <div class="flex flex-col rounded-3xl border border-blue-100 bg-white p-8 shadow-lg hover:shadow-2xl transition-all duration-300 hover:scale-105">
                    <h3 class="text-xl font-semibold text-slate-900 mb-2">Publishing Pro</h3>
                    <p class="text-sm text-slate-600 mb-6">Fokus pada publikasi jurnal & konferensi ilmiah.</p>
                    <ul class="space-y-2 text-sm text-slate-600 mb-6">
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> Reformat artikel sesuai template jurnal</li>
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> Konsultasi submit dan korespondensi</li>
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> Proofreading bahasa Inggris</li>
                        <li class="flex items-center gap-2"><span class="w-2 h-2 bg-[#2D3C8C] rounded-full"></span> Strategi reviewer response</li>
                    </ul>
                    <p class="text-2xl font-bold text-[#2D3C8C] mb-6">Custom</p>
                    <div class="flex flex-col gap-2">
                        <a href="{{ route('kontak') }}" class="inline-flex items-center justify-center rounded-full bg-[#2D3C8C] px-6 py-3 text-sm font-semibold text-white transition-all duration-300 hover:bg-blue-900 hover:shadow-lg">Konsultasi Gratis</a>
                    </div>
                </div>
            </div>
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
    </style>
@endsection
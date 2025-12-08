@extends('layouts.app')

@section('title', 'Jadwal Bimbel')

@section('content')
    <!-- Hero Section -->
    <section class="relative overflow-hidden bg-gradient-to-br from-[#2D3C8C] via-blue-800 to-blue-900 py-20 text-white">
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute -left-24 top-10 h-72 w-72 rounded-full bg-white/10 blur-3xl"></div>
            <div class="absolute right-0 bottom-0 h-80 w-80 rounded-full bg-blue-600/20 blur-3xl"></div>
        </div>
        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <span class="inline-flex items-center rounded-full bg-blue-700/50 px-4 py-1 text-xs font-semibold uppercase tracking-widest text-blue-100 backdrop-blur-sm">📅 Jadwal Kelas</span>
                <h1 class="mt-4 text-4xl font-bold sm:text-5xl">Jadwal Bimbel</h1>
                <p class="mx-auto mt-4 max-w-2xl text-lg text-blue-100">Lihat jadwal kelas dan acara bimbel farmasi. Jangan sampai ketinggalan!</p>
            </div>
        </div>
    </section>

    <!-- Calendar Section -->
    <section class="relative bg-gradient-to-br from-blue-50 via-white to-purple-50 py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            
            <!-- Google Calendar Embed -->
            @if(env('GOOGLE_CALENDAR_ID'))
            <div class="mb-8">
                <h2 class="mb-6 text-3xl font-bold text-gray-900 text-center">📅 Kalender Jadwal Kelas</h2>
                <div class="overflow-hidden rounded-3xl shadow-2xl border-4 border-white bg-white">
                    <iframe 
                        src="https://calendar.google.com/calendar/embed?src={{ urlencode(env('GOOGLE_CALENDAR_ID')) }}&ctz=Asia%2FJakarta&showTitle=0&showNav=1&showDate=1&showPrint=0&showTabs=1&showCalendars=0&mode=MONTH&height=600&wkst=1&bgcolor=%23ffffff"
                        style="border: 0" 
                        width="100%" 
                        height="600" 
                        frameborder="0" 
                        scrolling="no"
                        class="w-full">
                    </iframe>
                </div>
                <p class="mt-4 text-center text-sm text-gray-500">
                    <svg class="inline h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Klik pada event untuk melihat detail lengkap
                </p>
            </div>
            @else
            <div class="rounded-2xl bg-yellow-50 border border-yellow-200 p-6 text-center">
                <svg class="mx-auto h-12 w-12 text-yellow-600 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <h3 class="text-lg font-bold text-yellow-900 mb-2">Google Calendar Belum Dikonfigurasi</h3>
                <p class="text-sm text-yellow-700">Hubungi admin untuk mengaktifkan fitur jadwal.</p>
            </div>
            @endif

            <!-- Upcoming Events List -->
            <div class="mt-12">
                <h2 class="mb-6 text-2xl font-bold text-gray-900">🔔 Acara Mendatang</h2>
                <div id="events-list" class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    <!-- Events akan dimuat via JavaScript dari API -->
                    <div class="col-span-full text-center py-8">
                        <div class="inline-block animate-spin rounded-full h-8 w-8 border-4 border-blue-500 border-t-transparent"></div>
                        <p class="mt-4 text-gray-500">Memuat jadwal...</p>
                    </div>
                </div>
            </div>

            <!-- Info Box -->
            <div class="mt-12 rounded-3xl bg-gradient-to-r from-blue-600 to-purple-600 p-8 text-white shadow-xl">
                <div class="flex items-start gap-4">
                    <svg class="h-8 w-8 flex-shrink-0 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <h3 class="text-xl font-bold mb-2">💡 Tips Mengikuti Kelas</h3>
                        <ul class="space-y-2 text-sm text-blue-100">
                            <li>✅ Pastikan hadir 10 menit sebelum kelas dimulai</li>
                            <li>✅ Siapkan alat tulis dan koneksi internet stabil</li>
                            <li>✅ Aktifkan notifikasi Google Calendar untuk reminder otomatis</li>
                            <li>✅ Hubungi admin jika ada kendala teknis</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
    <script>
        // Load events dari API
        async function loadEvents() {
            try {
                const response = await fetch('/api/calendar/events');
                const data = await response.json();
                
                const container = document.getElementById('events-list');
                
                if (data.success && data.events.length > 0) {
                    container.innerHTML = data.events.map(event => `
                        <div class="rounded-2xl bg-white p-6 shadow-md hover:shadow-xl transition-shadow duration-300 border border-blue-100">
                            <div class="flex items-start justify-between mb-3">
                                <h3 class="text-lg font-bold text-gray-900">${event.title}</h3>
                                <span class="rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-800">Upcoming</span>
                            </div>
                            ${event.description ? `<p class="text-sm text-gray-600 mb-4">${event.description}</p>` : ''}
                            <div class="space-y-2 text-xs text-gray-500">
                                <div class="flex items-center gap-2">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span>${new Date(event.start).toLocaleString('id-ID')}</span>
                                </div>
                                ${event.location ? `
                                <div class="flex items-center gap-2">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span>${event.location}</span>
                                </div>
                                ` : ''}
                            </div>
                            ${event.link ? `
                            <a href="${event.link}" target="_blank" class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-blue-600 hover:text-blue-800 transition">
                                Lihat Detail
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                            ` : ''}
                        </div>
                    `).join('');
                } else {
                    container.innerHTML = `
                        <div class="col-span-full rounded-2xl bg-gray-50 border border-gray-200 p-8 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="text-gray-600">Belum ada jadwal untuk 30 hari ke depan</p>
                        </div>
                    `;
                }
            } catch (error) {
                document.getElementById('events-list').innerHTML = `
                    <div class="col-span-full rounded-2xl bg-red-50 border border-red-200 p-6 text-center">
                        <p class="text-red-600">Gagal memuat jadwal. Silakan refresh halaman.</p>
                    </div>
                `;
            }
        }

        // Load saat halaman dimuat
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', loadEvents);
        } else {
            loadEvents();
        }
    </script>
    @endpush
@endsection

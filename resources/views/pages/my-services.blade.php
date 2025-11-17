@extends('layouts.app')

@section('title', 'Layanan Saya')

@section('content')
    <section class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50 py-12">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Layanan Saya</h1>
                <p class="mt-2 text-gray-600">Program dan layanan yang sedang Anda ikuti</p>
            </div>

            <!-- Stats Cards -->
            <div class="mb-8 grid gap-6 sm:grid-cols-3">
                <div class="rounded-xl bg-white p-6 shadow-md">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Program Aktif</p>
                            <p class="mt-2 text-3xl font-bold text-[#2D3C8C]">{{ count(array_filter($enrollments, fn($e) => $e['status'] === 'active')) }}</p>
                        </div>
                        <div class="rounded-full bg-blue-100 p-3">
                            <svg class="h-8 w-8 text-[#2D3C8C]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="rounded-xl bg-white p-6 shadow-md">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Program Selesai</p>
                            <p class="mt-2 text-3xl font-bold text-green-600">{{ count(array_filter($enrollments, fn($e) => $e['status'] === 'completed')) }}</p>
                        </div>
                        <div class="rounded-full bg-green-100 p-3">
                            <svg class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="rounded-xl bg-white p-6 shadow-md">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Total Program</p>
                            <p class="mt-2 text-3xl font-bold text-purple-600">{{ count($enrollments) }}</p>
                        </div>
                        <div class="rounded-full bg-purple-100 p-3">
                            <svg class="h-8 w-8 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enrollments List -->
            <div class="space-y-6">
                @forelse($enrollments as $enrollment)
                    <div class="rounded-2xl bg-white p-6 shadow-lg">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center gap-3">
                                    <h3 class="text-lg font-bold text-gray-900">{{ $enrollment['program'] }}</h3>
                                    @if($enrollment['status'] === 'active')
                                        <span class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-800">
                                            Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-600">
                                            Selesai
                                        </span>
                                    @endif
                                </div>
                                <div class="mt-4 grid gap-4 sm:grid-cols-2">
                                    <div class="flex items-center gap-2 text-sm text-gray-600">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span>{{ \Carbon\Carbon::parse($enrollment['start_date'])->format('d M Y') }} - {{ \Carbon\Carbon::parse($enrollment['end_date'])->format('d M Y') }}</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-sm text-gray-600">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                        <span>{{ $enrollment['completed_sessions'] }} / {{ $enrollment['total_sessions'] }} Sesi</span>
                                    </div>
                                </div>

                                <!-- Progress Bar -->
                                <div class="mt-4">
                                    <div class="mb-2 flex items-center justify-between text-sm">
                                        <span class="font-medium text-gray-700">Progress</span>
                                        <span class="font-bold text-[#2D3C8C]">{{ $enrollment['progress'] }}%</span>
                                    </div>
                                    <div class="h-3 w-full overflow-hidden rounded-full bg-gray-200">
                                        <div class="h-full rounded-full bg-gradient-to-r from-blue-500 to-purple-600 transition-all" style="width: {{ $enrollment['progress'] }}%"></div>
                                    </div>
                                </div>
                            </div>

                            @if($enrollment['status'] === 'active')
                                <div class="ml-6">
                                    <a href="{{ route('program.access', $enrollment['id']) }}" class="inline-block rounded-lg bg-[#2D3C8C] px-6 py-3 text-sm font-semibold text-white shadow-lg transition hover:bg-blue-900">
                                        Akses Program
                                    </a>
                                </div>
                            @endif
                        </div>

                        <!-- Action Buttons -->
                        <div class="mt-6 flex gap-3 border-t border-gray-100 pt-4">
                            <a href="{{ route('program.materials', $enrollment['id']) }}" class="flex items-center gap-2 rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Lihat Materi
                            </a>
                            <a href="{{ route('program.schedule', $enrollment['id']) }}" class="flex items-center gap-2 rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Jadwal
                            </a>
                            <a href="{{ route('program.discussion', $enrollment['id']) }}" class="flex items-center gap-2 rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                </svg>
                                Diskusi
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="rounded-2xl bg-white p-12 text-center shadow-lg">
                        <div class="mx-auto mb-4 flex h-20 w-20 items-center justify-center rounded-full bg-gray-100">
                            <svg class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Belum Ada Layanan yang Dibeli</h3>
                        <p class="mt-2 text-sm text-gray-600">Anda belum membeli layanan apapun. Mulai perjalanan belajar Anda dengan memilih paket yang sesuai!</p>
                        <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:justify-center">
                            <a href="{{ route('bimbel.ukom') }}" class="inline-flex items-center justify-center gap-2 rounded-lg bg-[#2D3C8C] px-6 py-3 text-sm font-semibold text-white shadow-lg transition hover:bg-blue-900">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                                Bimbel UKOM
                            </a>
                            <a href="{{ route('cpns.p3k') }}" class="inline-flex items-center justify-center gap-2 rounded-lg border-2 border-[#2D3C8C] bg-white px-6 py-3 text-sm font-semibold text-[#2D3C8C] transition hover:bg-blue-50">
                                CPNS & P3K
                            </a>
                            <a href="{{ route('joki.tugas') }}" class="inline-flex items-center justify-center gap-2 rounded-lg border-2 border-[#2D3C8C] bg-white px-6 py-3 text-sm font-semibold text-[#2D3C8C] transition hover:bg-blue-50">
                                Joki Tugas
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection

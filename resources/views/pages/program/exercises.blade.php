@extends('layouts.app')

@section('title', 'Latihan Soal')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50 py-12">
    <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('program.access', $program->id) }}" class="inline-flex items-center gap-2 text-[#2D3C8C] hover:text-[#1e2761] mb-4 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali ke Dashboard
            </a>
            <h1 class="text-3xl font-bold text-gray-900">{{ $program->name }} - Latihan Soal</h1>
            <p class="mt-2 text-gray-600">Asah kemampuan dengan bank soal per topik</p>
        </div>

        <!-- Stats -->
        <div class="mb-8 grid gap-6 sm:grid-cols-3">
            <div class="rounded-xl bg-white p-6 shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Total Latihan</p>
                        <p class="mt-2 text-3xl font-bold text-[#2D3C8C]">{{ $exercises->count() }}</p>
                    </div>
                    <div class="rounded-full bg-blue-100 p-3">
                        <svg class="h-6 w-6 text-[#2D3C8C]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="rounded-xl bg-white p-6 shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Sudah Selesai</p>
                        <p class="mt-2 text-3xl font-bold text-green-600">
                            {{ $exercises->filter(fn($e) => $e->attempts->isNotEmpty())->count() }}
                        </p>
                    </div>
                    <div class="rounded-full bg-green-100 p-3">
                        <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="rounded-xl bg-white p-6 shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Rata-rata Nilai</p>
                        <p class="mt-2 text-3xl font-bold text-purple-600">
                            @php
                                $completedWithScore = $exercises->filter(fn($e) => $e->attempts->isNotEmpty());
                                $avg = $completedWithScore->count() > 0 ? round($completedWithScore->avg(fn($e) => $e->attempts->first()->score ?? 0)) : 0;
                            @endphp
                            {{ $avg }}
                        </p>
                    </div>
                    <div class="rounded-full bg-purple-100 p-3">
                        <svg class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Exercises List -->
        @if($exercises->count() > 0)
            <div class="space-y-4">
                @foreach($exercises as $exercise)
                    <div class="rounded-xl bg-white p-6 shadow-md hover:shadow-lg transition-shadow">
                        <div class="flex items-start justify-between gap-6">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2">
                                    <h3 class="text-lg font-bold text-gray-900">{{ $exercise->title }}</h3>
                                    @if($exercise->attempts->isNotEmpty())
                                        <span class="inline-flex items-center gap-1 rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-800">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            Sudah Dikerjakan
                                        </span>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-800">
                                            Belum Dikerjakan
                                        </span>
                                    @endif
                                </div>
                                
                                @if($exercise->description)
                                    <p class="text-sm text-gray-600 mb-4">{{ $exercise->description }}</p>
                                @endif
                                
                                <div class="flex items-center gap-6 text-sm text-gray-500">
                                    <div class="flex items-center gap-2">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>{{ $exercise->questions_count }} Soal</span>
                                    </div>
                                    @if($exercise->duration)
                                        <div class="flex items-center gap-2">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span>{{ $exercise->duration }} menit</span>
                                        </div>
                                    @endif
                                    @if($exercise->attempts->isNotEmpty())
                                        <div class="flex items-center gap-2 font-semibold text-[#2D3C8C]">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                            </svg>
                                            <span>Nilai: {{ $exercise->attempts->first()->score ?? '-' }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="flex flex-col gap-2">
                                <a href="{{ route('program.exercise.start', ['id' => $program->id, 'exerciseId' => $exercise->id]) }}" class="inline-block rounded-lg bg-[#2D3C8C] px-6 py-3 text-sm font-semibold text-white text-center transition hover:bg-blue-900 whitespace-nowrap">
                                    @if($exercise->attempts->isNotEmpty())
                                        Kerjakan Lagi
                                    @else
                                        Mulai Latihan
                                    @endif
                                </a>
                                @if($exercise->attempts->isNotEmpty())
                                    <a href="{{ route('program.result', ['id' => $program->id, 'resultId' => $exercise->attempts->first()->id]) }}" class="inline-block rounded-lg border border-gray-300 px-6 py-3 text-sm font-semibold text-gray-700 text-center transition hover:bg-gray-50 whitespace-nowrap">
                                        Lihat Hasil
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="rounded-xl bg-white p-12 text-center shadow-md">
                <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                </svg>
                <h3 class="mt-4 text-lg font-semibold text-gray-900">Belum Ada Latihan Soal</h3>
                <p class="mt-2 text-gray-600">Latihan soal akan segera ditambahkan oleh admin.</p>
            </div>
        @endif
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Dashboard Program - ' . $program->name)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50 py-12">
    <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('user.services') }}" class="inline-flex items-center gap-2 text-[#2D3C8C] hover:text-[#1e2761] mb-4 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali ke Layanan Saya
            </a>
            <h1 class="text-3xl font-bold text-gray-900">{{ $program->name }}</h1>
            <p class="mt-2 text-gray-600">Dashboard pembelajaran Anda</p>
        </div>

        <!-- Quick Stats -->
        <div class="mb-8 grid gap-6 sm:grid-cols-4">
            <div class="rounded-xl bg-white p-6 shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Progress</p>
                        <p class="mt-2 text-2xl font-bold text-[#2D3C8C]">
                            {{ $totalMaterials > 0 ? round(($completedMaterials / $totalMaterials) * 100) : 0 }}%
                        </p>
                    </div>
                    <div class="rounded-full bg-blue-100 p-3">
                        <svg class="h-6 w-6 text-[#2D3C8C]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="rounded-xl bg-white p-6 shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Sesi Selesai</p>
                        <p class="mt-2 text-2xl font-bold text-green-600">{{ $completedMaterials }}/{{ $totalMaterials }}</p>
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
                        <p class="text-sm text-gray-500">Nilai Rata-rata</p>
                        <p class="mt-2 text-2xl font-bold text-purple-600">{{ $averageScore > 0 ? $averageScore : '-' }}</p>
                    </div>
                    <div class="rounded-full bg-purple-100 p-3">
                        <svg class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="rounded-xl bg-white p-6 shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Hari Belajar</p>
                        <p class="mt-2 text-2xl font-bold text-orange-600">{{ $studyDays }}</p>
                    </div>
                    <div class="rounded-full bg-orange-100 p-3">
                        <svg class="h-6 w-6 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Menu -->
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            <a href="{{ route('program.materials', $program->id) }}" class="group rounded-2xl bg-white p-6 shadow-lg transition-all hover:shadow-xl hover:-translate-y-1">
                <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-lg bg-blue-100 group-hover:bg-blue-200 transition-colors">
                    <svg class="h-6 w-6 text-[#2D3C8C]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Materi Pembelajaran</h3>
                <p class="text-sm text-gray-600 mb-2">Akses video, PDF, dan materi pembelajaran lengkap</p>
                <span class="inline-block px-3 py-1 text-xs font-semibold bg-blue-100 text-blue-800 rounded-full">
                    {{ $totalMaterials }} Materi
                </span>
            </a>

            <a href="{{ route('program.schedule', $program->id) }}" class="group rounded-2xl bg-white p-6 shadow-lg transition-all hover:shadow-xl hover:-translate-y-1">
                <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-lg bg-green-100 group-hover:bg-green-200 transition-colors">
                    <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Jadwal Kelas</h3>
                <p class="text-sm text-gray-600 mb-2">Lihat jadwal pertemuan dan sesi belajar</p>
                <span class="inline-block px-3 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded-full">
                    {{ $totalSchedules }} Jadwal
                </span>
            </a>

            <a href="{{ route('program.discussion', $program->id) }}" class="group rounded-2xl bg-white p-6 shadow-lg transition-all hover:shadow-xl hover:-translate-y-1">
                <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-lg bg-purple-100 group-hover:bg-purple-200 transition-colors">
                    <svg class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Forum Diskusi</h3>
                <p class="text-sm text-gray-600 mb-2">Diskusi dengan mentor dan peserta lain</p>
                <span class="inline-block px-3 py-1 text-xs font-semibold bg-purple-100 text-purple-800 rounded-full">
                    Segera Hadir
                </span>
            </a>

            <a href="{{ route('program.exercises', $program->id) }}" class="group rounded-2xl bg-white p-6 shadow-lg transition-all hover:shadow-xl hover:-translate-y-1">
                <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-lg bg-yellow-100 group-hover:bg-yellow-200 transition-colors">
                    <svg class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Latihan Soal</h3>
                <p class="text-sm text-gray-600 mb-2">Bank soal per topik untuk mengasah pemahaman</p>
                <span class="inline-block px-3 py-1 text-xs font-semibold bg-yellow-100 text-yellow-800 rounded-full">
                    {{ $totalExercises }} Latihan
                </span>
            </a>

            <a href="{{ route('program.tryouts', $program->id) }}" class="group rounded-2xl bg-white p-6 shadow-lg transition-all hover:shadow-xl hover:-translate-y-1">
                <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-lg bg-red-100 group-hover:bg-red-200 transition-colors">
                    <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Try Out</h3>
                <p class="text-sm text-gray-600 mb-2">Simulasi ujian lengkap dengan sistem penilaian</p>
                <span class="inline-block px-3 py-1 text-xs font-semibold bg-red-100 text-red-800 rounded-full">
                    {{ $totalTryouts }} Try Out
                </span>
            </a>
        </div>

        <!-- Program Info -->
        @if($program->tutor || $program->schedule)
        <div class="mt-8 rounded-2xl bg-white p-6 shadow-lg">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Informasi Program</h3>
            <div class="grid gap-4 sm:grid-cols-2">
                @if($program->tutor)
                <div class="flex items-center gap-3 p-4 rounded-lg bg-blue-50">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-200">
                        <svg class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900">Tutor</p>
                        <p class="text-xs text-gray-500">{{ $program->tutor }}</p>
                    </div>
                </div>
                @endif

                @if($program->schedule)
                <div class="flex items-center gap-3 p-4 rounded-lg bg-green-50">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-green-200">
                        <svg class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900">Jadwal</p>
                        <p class="text-xs text-gray-500">{{ $program->schedule }}</p>
                    </div>
                </div>
                @endif
                
                @if($program->duration)
                <div class="flex items-center gap-3 p-4 rounded-lg bg-purple-50">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-purple-200">
                        <svg class="h-5 w-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900">Durasi Program</p>
                        <p class="text-xs text-gray-500">{{ $program->duration }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

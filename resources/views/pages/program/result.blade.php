@extends('layouts.app')

@section('title', 'Hasil ' . $attempt->quizBank->title)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50 py-12">
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-bold text-gray-900">Hasil {{ $attempt->quizBank->type === 'tryout' ? 'Try Out' : 'Latihan Soal' }}</h1>
            <p class="mt-2 text-gray-600">{{ $attempt->quizBank->title }}</p>
        </div>

        <!-- Score Card -->
        <div class="mb-8 rounded-2xl bg-gradient-to-br from-[#2D3C8C] to-[#1e2761] p-8 text-center shadow-xl">
            <div class="mb-4">
                @if($attempt->score >= $passingGrade)
                    <div class="mx-auto mb-4 flex h-20 w-20 items-center justify-center rounded-full bg-green-500">
                        <svg class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-white mb-2">Selamat! Anda Lulus</h2>
                @else
                    <div class="mx-auto mb-4 flex h-20 w-20 items-center justify-center rounded-full bg-yellow-500">
                        <svg class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-white mb-2">Terus Semangat!</h2>
                @endif
            </div>
            
            <div class="mb-6">
                <p class="text-6xl font-bold text-white">{{ $attempt->score }}</p>
                <p class="text-lg text-blue-100">Nilai Anda</p>
            </div>
            
            <div class="grid grid-cols-3 gap-4 text-white">
                <div>
                    <p class="text-2xl font-bold">{{ $attempt->correct_answers }}</p>
                    <p class="text-sm text-blue-100">Jawaban Benar</p>
                </div>
                <div>
                    <p class="text-2xl font-bold">{{ $wrongAnswers }}</p>
                    <p class="text-sm text-blue-100">Jawaban Salah</p>
                </div>
                <div>
                    <p class="text-2xl font-bold">{{ $durationSpent ?? '-' }}</p>
                    <p class="text-sm text-blue-100">Menit</p>
                </div>
            </div>
        </div>

        <!-- Stats -->
        <div class="mb-8 grid gap-6 sm:grid-cols-2">
            <div class="rounded-xl bg-white p-6 shadow-md">
                <div class="flex items-center gap-4">
                    <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-blue-100">
                        <svg class="h-6 w-6 text-[#2D3C8C]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Waktu Pengerjaan</p>
                        <p class="text-lg font-bold text-gray-900">{{ $durationSpent ? $durationSpent . ' menit' : 'Tidak Tercatat' }}</p>
                    </div>
                </div>
            </div>

            <div class="rounded-xl bg-white p-6 shadow-md">
                <div class="flex items-center gap-4">
                    <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-green-100">
                        <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Passing Grade</p>
                        <p class="text-lg font-bold text-gray-900">{{ $passingGrade }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary Info -->
        <div class="mb-8 rounded-xl bg-white p-6 shadow-md">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Ringkasan</h3>
            
            <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-600">Total Soal:</span>
                    <span class="font-semibold text-gray-900">{{ $attempt->total_questions }} soal</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Benar:</span>
                    <span class="font-semibold text-green-600">{{ $attempt->correct_answers }} soal</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Salah:</span>
                    <span class="font-semibold text-red-600">{{ $wrongAnswers }} soal</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Persentase Benar:</span>
                    <span class="font-semibold text-gray-900">{{ $attempt->score }}%</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Dikerjakan:</span>
                    <span class="font-semibold text-gray-900">{{ $attempt->completed_at ? $attempt->completed_at->format('d M Y H:i') : '-' }}</span>
                </div>
            </div>
        </div>

        <!-- Recommendations -->
        <div class="mb-8 rounded-xl bg-blue-50 border border-blue-200 p-6">
            <div class="flex gap-3">
                <svg class="w-6 h-6 text-[#2D3C8C] flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                </svg>
                <div>
                    <p class="font-semibold text-gray-900 mb-2">Rekomendasi:</p>
                    <ul class="text-sm text-gray-700 space-y-1 list-disc list-inside">
                        @if($attempt->score >= 90)
                            <li>Pertahankan performa Anda yang sangat baik!</li>
                            <li>Coba tingkatkan kecepatan mengerjakan soal</li>
                            <li>Bantu teman yang kesulitan di forum diskusi</li>
                        @elseif($attempt->score >= 70)
                            <li>Performa bagus! Pelajari kembali materi dengan nilai rendah</li>
                            <li>Perbanyak latihan soal untuk kategori yang lemah</li>
                            <li>Diskusikan pembahasan dengan mentor</li>
                        @else
                            <li>Fokus pelajari kembali materi fundamental</li>
                            <li>Ikuti kelas tambahan jika tersedia</li>
                            <li>Konsultasi dengan mentor untuk strategi belajar</li>
                            <li>Perbanyak latihan soal secara bertahap</li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-4">
            <a href="{{ route('program.access', $program->id) }}" class="flex-1 rounded-lg border-2 border-[#2D3C8C] px-6 py-3 text-center font-semibold text-[#2D3C8C] transition hover:bg-blue-50">
                Kembali ke Dashboard
            </a>
            <a href="{{ $attempt->quizBank->type === 'tryout' ? route('program.tryouts', $program->id) : route('program.exercises', $program->id) }}" class="flex-1 rounded-lg bg-[#2D3C8C] px-6 py-3 text-center font-semibold text-white transition hover:bg-blue-900">
                @if($attempt->quizBank->type === 'tryout')
                    Lihat Try Out Lainnya
                @else
                    Lihat Latihan Lainnya
                @endif
            </a>
        </div>
    </div>
</div>
@endsection

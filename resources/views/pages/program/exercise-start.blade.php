@extends('layouts.app')

@section('title', $exercise->title)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50 py-8">
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
        <!-- Header with Timer -->
        <div class="mb-6 rounded-xl bg-white p-6 shadow-lg sticky top-4 z-10">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-xl font-bold text-gray-900">{{ $exercise->title }}</h1>
                    <p class="text-sm text-gray-600">{{ $questions->count() }} Soal</p>
                </div>
                <div class="flex items-center gap-6">
                    @if($exercise->duration)
                        <div class="text-right">
                            <p class="text-sm text-gray-500">Waktu Tersisa</p>
                            <p id="timer" class="text-2xl font-bold text-[#2D3C8C]">{{ $exercise->duration }}:00</p>
                        </div>
                    @endif
                    <button type="button" onclick="confirmSubmit()" class="rounded-lg bg-green-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-green-700">
                        Selesai
                    </button>
                </div>
            </div>
        </div>

        <!-- Form -->
        <form id="exerciseForm" action="{{ route('program.exercise.submit', ['id' => $program->id, 'exerciseId' => $exercise->id]) }}" method="POST">
            @csrf
            
            <!-- Questions -->
            <div class="space-y-6">
                @foreach($questions as $index => $question)
                    <div class="rounded-xl bg-white p-6 shadow-md">
                        <div class="mb-4">
                            <span class="inline-block rounded-full bg-[#2D3C8C] px-3 py-1 text-xs font-semibold text-white">
                                Soal {{ $index + 1 }}
                            </span>
                        </div>
                        
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ $question->question }}</h3>
                        
                        <div class="space-y-3">
                            @foreach(['A', 'B', 'C', 'D', 'E'] as $option)
                                @if($question->{'option_' . strtolower($option)})
                                    <label class="flex items-start gap-3 p-4 rounded-lg border-2 border-gray-200 cursor-pointer transition hover:border-[#2D3C8C] hover:bg-blue-50">
                                        <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option }}" class="mt-1 h-4 w-4 text-[#2D3C8C] focus:ring-[#2D3C8C]">
                                        <span class="flex-1 text-gray-700">
                                            <span class="font-semibold">{{ $option }}.</span> {{ $question->{'option_' . strtolower($option)} }}
                                        </span>
                                    </label>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Submit Button (Fixed at bottom on mobile) -->
            <div class="mt-8 rounded-xl bg-white p-6 shadow-lg sticky bottom-4">
                <div class="flex items-center justify-between">
                    <a href="{{ route('program.exercises', $program->id) }}" class="text-gray-600 hover:text-gray-900">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </a>
                    <button type="button" onclick="confirmSubmit()" class="rounded-lg bg-green-600 px-8 py-3 font-semibold text-white transition hover:bg-green-700">
                        Selesai & Lihat Hasil
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@if($exercise->duration)
<script>
    // Timer countdown
    let timeLeft = {{ $exercise->duration }} * 60; // Convert to seconds
    
    function updateTimer() {
        const minutes = Math.floor(timeLeft / 60);
        const seconds = timeLeft % 60;
        document.getElementById('timer').textContent = 
            `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        
        if (timeLeft <= 0) {
            alert('Waktu habis! Jawaban Anda akan otomatis dikumpulkan.');
            document.getElementById('exerciseForm').submit();
            return;
        }
        
        // Change color when less than 5 minutes
        if (timeLeft <= 300) {
            document.getElementById('timer').classList.add('text-red-600');
            document.getElementById('timer').classList.remove('text-[#2D3C8C]');
        }
        
        timeLeft--;
        setTimeout(updateTimer, 1000);
    }
    
    // Start timer
    updateTimer();
</script>
@endif

<script>
    // Confirm submit
    function confirmSubmit() {
        if (confirm('Apakah Anda yakin ingin mengumpulkan jawaban?')) {
            document.getElementById('exerciseForm').submit();
        }
    }
    
    // Warn before leaving page
    window.addEventListener('beforeunload', function (e) {
        e.preventDefault();
        e.returnValue = '';
    });
</script>
@endsection

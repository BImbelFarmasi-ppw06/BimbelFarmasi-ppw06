@extends('layouts.admin')

@section('title', 'Detail Bank Soal')

@section('content')
    <div class="mb-6">
        <div class="flex items-center gap-2 text-sm text-gray-500 mb-4">
            <a href="{{ route('admin.questions.index') }}" class="hover:text-gray-700">Bank Soal</a>
            <span>/</span>
            <span class="text-gray-900">{{ $quizBank->title }}</span>
        </div>
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $quizBank->title }}</h1>
                <p class="mt-1 text-sm text-gray-500">{{ $quizBank->description }}</p>
            </div>
            <a href="{{ route('admin.questions.edit', $quizBank) }}" class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit Bank Soal
            </a>
        </div>
    </div>

    <!-- Stats -->
    <div class="mb-6 grid gap-4 sm:grid-cols-5">
        <div class="rounded-xl bg-white p-4 shadow-sm">
            <p class="text-sm text-gray-500">Program</p>
            <p class="mt-2 text-lg font-semibold text-gray-900">{{ $quizBank->program->name ?? '-' }}</p>
        </div>
        <div class="rounded-xl bg-white p-4 shadow-sm">
            <p class="text-sm text-gray-500">Kategori</p>
            <p class="mt-2 text-lg font-semibold text-gray-900">{{ $quizBank->category }}</p>
        </div>
        <div class="rounded-xl bg-white p-4 shadow-sm">
            <p class="text-sm text-gray-500">Jumlah Soal</p>
            <p class="mt-2 text-lg font-semibold text-gray-900">{{ $quizBank->questions->count() }}</p>
        </div>
        <div class="rounded-xl bg-white p-4 shadow-sm">
            <p class="text-sm text-gray-500">Durasi</p>
            <p class="mt-2 text-lg font-semibold text-gray-900">{{ $quizBank->duration_minutes }} menit</p>
        </div>
        <div class="rounded-xl bg-white p-4 shadow-sm">
            <p class="text-sm text-gray-500">Nilai Lulus</p>
            <p class="mt-2 text-lg font-semibold text-gray-900">{{ $quizBank->passing_score }}%</p>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="mb-4 rounded-lg bg-green-50 p-4 text-sm text-green-800">
        {{ session('success') }}
    </div>
    @endif

    <!-- Add Question Form -->
    <div class="mb-6 rounded-xl bg-white shadow-sm">
        <div class="border-b border-gray-200 px-6 py-4">
            <h2 class="text-lg font-semibold text-gray-900">Tambah Soal Baru</h2>
        </div>
        <form action="{{ route('admin.questions.addQuestion', $quizBank) }}" method="POST" class="p-6">
            @csrf
            
            <div class="space-y-4">
                <!-- Question -->
                <div>
                    <label for="question" class="block text-sm font-medium text-gray-700">Pertanyaan <span class="text-red-500">*</span></label>
                    <textarea id="question" name="question" rows="3" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Tulis pertanyaan di sini...">{{ old('question') }}</textarea>
                    @error('question')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Options -->
                <div class="grid gap-3">
                    <div>
                        <label for="option_a" class="block text-sm font-medium text-gray-700">Pilihan A <span class="text-red-500">*</span></label>
                        <input type="text" id="option_a" name="option_a" value="{{ old('option_a') }}" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('option_a')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="option_b" class="block text-sm font-medium text-gray-700">Pilihan B <span class="text-red-500">*</span></label>
                        <input type="text" id="option_b" name="option_b" value="{{ old('option_b') }}" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('option_b')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="option_c" class="block text-sm font-medium text-gray-700">Pilihan C <span class="text-red-500">*</span></label>
                        <input type="text" id="option_c" name="option_c" value="{{ old('option_c') }}" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('option_c')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="option_d" class="block text-sm font-medium text-gray-700">Pilihan D <span class="text-red-500">*</span></label>
                        <input type="text" id="option_d" name="option_d" value="{{ old('option_d') }}" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('option_d')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="option_e" class="block text-sm font-medium text-gray-700">Pilihan E <span class="text-red-500">*</span></label>
                        <input type="text" id="option_e" name="option_e" value="{{ old('option_e') }}" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('option_e')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Correct Answer -->
                <div>
                    <label for="correct_answer" class="block text-sm font-medium text-gray-700">Jawaban Benar <span class="text-red-500">*</span></label>
                    <select id="correct_answer" name="correct_answer" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Pilih Jawaban</option>
                        <option value="A" {{ old('correct_answer') == 'A' ? 'selected' : '' }}>A</option>
                        <option value="B" {{ old('correct_answer') == 'B' ? 'selected' : '' }}>B</option>
                        <option value="C" {{ old('correct_answer') == 'C' ? 'selected' : '' }}>C</option>
                        <option value="D" {{ old('correct_answer') == 'D' ? 'selected' : '' }}>D</option>
                        <option value="E" {{ old('correct_answer') == 'E' ? 'selected' : '' }}>E</option>
                    </select>
                    @error('correct_answer')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Explanation -->
                <div>
                    <label for="explanation" class="block text-sm font-medium text-gray-700">Penjelasan (Opsional)</label>
                    <textarea id="explanation" name="explanation" rows="2" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Jelaskan mengapa jawaban ini benar...">{{ old('explanation') }}</textarea>
                    @error('explanation')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-4 flex justify-end">
                <button type="submit" class="rounded-lg bg-[#2D3C8C] px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-900">
                    Tambah Soal
                </button>
            </div>
        </form>
    </div>

    <!-- Questions List -->
    <div class="rounded-xl bg-white shadow-sm">
        <div class="border-b border-gray-200 px-6 py-4">
            <h2 class="text-lg font-semibold text-gray-900">Daftar Soal ({{ $quizBank->questions->count() }})</h2>
        </div>
        
        <div class="divide-y divide-gray-200">
            @forelse($quizBank->questions as $index => $question)
            <div class="p-6">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-start gap-3">
                            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-100 text-sm font-semibold text-blue-800">{{ $index + 1 }}</span>
                            <div class="flex-1">
                                <p class="text-base font-medium text-gray-900">{{ $question->question }}</p>
                                <div class="mt-3 space-y-2">
                                    <div class="flex items-center gap-2">
                                        <span class="flex h-6 w-6 items-center justify-center rounded border text-sm {{ $question->correct_answer == 'A' ? 'bg-green-100 border-green-500 text-green-800 font-semibold' : 'border-gray-300 text-gray-600' }}">A</span>
                                        <span class="text-sm text-gray-700">{{ $question->option_a }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="flex h-6 w-6 items-center justify-center rounded border text-sm {{ $question->correct_answer == 'B' ? 'bg-green-100 border-green-500 text-green-800 font-semibold' : 'border-gray-300 text-gray-600' }}">B</span>
                                        <span class="text-sm text-gray-700">{{ $question->option_b }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="flex h-6 w-6 items-center justify-center rounded border text-sm {{ $question->correct_answer == 'C' ? 'bg-green-100 border-green-500 text-green-800 font-semibold' : 'border-gray-300 text-gray-600' }}">C</span>
                                        <span class="text-sm text-gray-700">{{ $question->option_c }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="flex h-6 w-6 items-center justify-center rounded border text-sm {{ $question->correct_answer == 'D' ? 'bg-green-100 border-green-500 text-green-800 font-semibold' : 'border-gray-300 text-gray-600' }}">D</span>
                                        <span class="text-sm text-gray-700">{{ $question->option_d }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="flex h-6 w-6 items-center justify-center rounded border text-sm {{ $question->correct_answer == 'E' ? 'bg-green-100 border-green-500 text-green-800 font-semibold' : 'border-gray-300 text-gray-600' }}">E</span>
                                        <span class="text-sm text-gray-700">{{ $question->option_e }}</span>
                                    </div>
                                </div>
                                @if($question->explanation)
                                <div class="mt-3 rounded-lg bg-blue-50 p-3">
                                    <p class="text-xs font-semibold text-blue-900">Penjelasan:</p>
                                    <p class="mt-1 text-sm text-blue-800">{{ $question->explanation }}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="ml-4 flex gap-2">
                        <a href="{{ route('admin.questions.editQuestion', [$quizBank, $question]) }}" class="rounded p-1 text-gray-600 hover:bg-gray-100" title="Edit">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </a>
                        <form action="{{ route('admin.questions.destroyQuestion', [$quizBank, $question]) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus soal ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="rounded p-1 text-red-600 hover:bg-red-50" title="Hapus">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="px-6 py-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <p class="mt-2 text-sm text-gray-500">Belum ada soal dalam bank soal ini.</p>
                <p class="text-sm text-gray-500">Gunakan form di atas untuk menambah soal pertama.</p>
            </div>
            @endforelse
        </div>
    </div>
@endsection

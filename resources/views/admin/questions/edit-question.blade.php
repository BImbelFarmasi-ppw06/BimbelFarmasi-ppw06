@extends('layouts.admin')

@section('title', 'Edit Soal')

@section('content')
    <div class="mb-6">
        <div class="flex items-center gap-2 text-sm text-gray-500 mb-4">
            <a href="{{ route('admin.questions.index') }}" class="hover:text-gray-700">Bank Soal</a>
            <span>/</span>
            <a href="{{ route('admin.questions.show', $quizBank) }}" class="hover:text-gray-700">{{ $quizBank->title }}</a>
            <span>/</span>
            <span class="text-gray-900">Edit Soal</span>
        </div>
        <h1 class="text-2xl font-bold text-gray-900">Edit Soal</h1>
        <p class="mt-1 text-sm text-gray-500">Perbarui soal dalam bank soal {{ $quizBank->title }}</p>
    </div>

    <div class="rounded-xl bg-white shadow-sm">
        <form action="{{ route('admin.questions.updateQuestion', [$quizBank, $question]) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')
            
            <div class="space-y-4">
                <!-- Question -->
                <div>
                    <label for="question" class="block text-sm font-medium text-gray-700">Pertanyaan <span class="text-red-500">*</span></label>
                    <textarea id="question" name="question" rows="3" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('question', $question->question) }}</textarea>
                    @error('question')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Options -->
                <div class="grid gap-3">
                    <div>
                        <label for="option_a" class="block text-sm font-medium text-gray-700">Pilihan A <span class="text-red-500">*</span></label>
                        <input type="text" id="option_a" name="option_a" value="{{ old('option_a', $question->option_a) }}" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('option_a')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="option_b" class="block text-sm font-medium text-gray-700">Pilihan B <span class="text-red-500">*</span></label>
                        <input type="text" id="option_b" name="option_b" value="{{ old('option_b', $question->option_b) }}" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('option_b')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="option_c" class="block text-sm font-medium text-gray-700">Pilihan C <span class="text-red-500">*</span></label>
                        <input type="text" id="option_c" name="option_c" value="{{ old('option_c', $question->option_c) }}" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('option_c')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="option_d" class="block text-sm font-medium text-gray-700">Pilihan D <span class="text-red-500">*</span></label>
                        <input type="text" id="option_d" name="option_d" value="{{ old('option_d', $question->option_d) }}" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('option_d')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="option_e" class="block text-sm font-medium text-gray-700">Pilihan E <span class="text-red-500">*</span></label>
                        <input type="text" id="option_e" name="option_e" value="{{ old('option_e', $question->option_e) }}" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
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
                        <option value="A" {{ old('correct_answer', $question->correct_answer) == 'A' ? 'selected' : '' }}>A</option>
                        <option value="B" {{ old('correct_answer', $question->correct_answer) == 'B' ? 'selected' : '' }}>B</option>
                        <option value="C" {{ old('correct_answer', $question->correct_answer) == 'C' ? 'selected' : '' }}>C</option>
                        <option value="D" {{ old('correct_answer', $question->correct_answer) == 'D' ? 'selected' : '' }}>D</option>
                        <option value="E" {{ old('correct_answer', $question->correct_answer) == 'E' ? 'selected' : '' }}>E</option>
                    </select>
                    @error('correct_answer')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Explanation -->
                <div>
                    <label for="explanation" class="block text-sm font-medium text-gray-700">Penjelasan (Opsional)</label>
                    <textarea id="explanation" name="explanation" rows="2" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('explanation', $question->explanation) }}</textarea>
                    @error('explanation')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end gap-3">
                <a href="{{ route('admin.questions.show', $quizBank) }}" class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                    Batal
                </a>
                <button type="submit" class="rounded-lg bg-[#2D3C8C] px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-900">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
@endsection

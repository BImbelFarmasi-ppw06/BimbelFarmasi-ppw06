@extends('layouts.admin')

@section('title', 'Kelola Soal - ' . $quiz->title)

@section('content')
    <div class="mb-6">
        <div class="flex items-center gap-2 text-sm text-gray-500 mb-2">
            <a href="{{ route('admin.classes.index') }}" class="hover:text-gray-700">Kelas</a>
            <span>/</span>
            <a href="{{ route('admin.classes.show', $program->id) }}" class="hover:text-gray-700">{{ $program->name }}</a>
            <span>/</span>
            <span class="text-gray-900">{{ $quiz->title }}</span>
        </div>
        
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $quiz->title }}</h1>
                <p class="mt-1 text-sm text-gray-500">
                    <span class="px-2 py-1 text-xs font-semibold rounded {{ $quiz->type === 'practice' ? 'bg-purple-100 text-purple-700' : 'bg-yellow-100 text-yellow-700' }}">
                        {{ $quiz->type === 'practice' ? 'Latihan Soal' : 'Try Out' }}
                    </span>
                    <span class="ml-2">{{ ucfirst($quiz->category) }}</span>
                    <span class="ml-2">• {{ $quiz->questions->count() }} Soal</span>
                </p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.classes.show', $program->id) }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                    ← Kembali
                </a>
                <button onclick="openQuestionModal()" class="px-4 py-2 text-sm font-medium text-white bg-[#2D3C8C] rounded-lg hover:bg-blue-900">
                    + Tambah Soal
                </button>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="mb-6 rounded-lg bg-green-50 p-4 text-green-800">
        {{ session('success') }}
    </div>
    @endif

    @if($quiz->questions->count() > 0)
    <div class="space-y-4">
        @foreach($quiz->questions as $index => $question)
        <div class="rounded-lg bg-white p-6 shadow-sm border border-gray-200">
            <div class="flex items-start justify-between mb-4">
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="px-2 py-1 text-xs font-bold rounded bg-blue-100 text-blue-700">Soal {{ $index + 1 }}</span>
                        <span class="px-2 py-1 text-xs font-semibold rounded bg-green-100 text-green-700">Jawaban: {{ $question->correct_answer }}</span>
                    </div>
                    <p class="text-gray-900 font-medium">{{ $question->question }}</p>
                </div>
                <div class="flex gap-2 ml-4">
                    <button onclick="openEditQuestionModal({{ $question->id }})" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Edit</button>
                    <button onclick="deleteQuestion({{ $question->id }})" class="text-red-600 hover:text-red-800 text-sm font-medium">Hapus</button>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mt-4">
                <div class="flex items-start gap-2 p-3 rounded {{ $question->correct_answer === 'A' ? 'bg-green-50 border border-green-200' : 'bg-gray-50' }}">
                    <span class="font-bold {{ $question->correct_answer === 'A' ? 'text-green-700' : 'text-gray-700' }}">A.</span>
                    <span class="{{ $question->correct_answer === 'A' ? 'text-green-900 font-medium' : 'text-gray-700' }}">{{ $question->option_a }}</span>
                </div>
                <div class="flex items-start gap-2 p-3 rounded {{ $question->correct_answer === 'B' ? 'bg-green-50 border border-green-200' : 'bg-gray-50' }}">
                    <span class="font-bold {{ $question->correct_answer === 'B' ? 'text-green-700' : 'text-gray-700' }}">B.</span>
                    <span class="{{ $question->correct_answer === 'B' ? 'text-green-900 font-medium' : 'text-gray-700' }}">{{ $question->option_b }}</span>
                </div>
                <div class="flex items-start gap-2 p-3 rounded {{ $question->correct_answer === 'C' ? 'bg-green-50 border border-green-200' : 'bg-gray-50' }}">
                    <span class="font-bold {{ $question->correct_answer === 'C' ? 'text-green-700' : 'text-gray-700' }}">C.</span>
                    <span class="{{ $question->correct_answer === 'C' ? 'text-green-900 font-medium' : 'text-gray-700' }}">{{ $question->option_c }}</span>
                </div>
                <div class="flex items-start gap-2 p-3 rounded {{ $question->correct_answer === 'D' ? 'bg-green-50 border border-green-200' : 'bg-gray-50' }}">
                    <span class="font-bold {{ $question->correct_answer === 'D' ? 'text-green-700' : 'text-gray-700' }}">D.</span>
                    <span class="{{ $question->correct_answer === 'D' ? 'text-green-900 font-medium' : 'text-gray-700' }}">{{ $question->option_d }}</span>
                </div>
                @if($question->option_e)
                <div class="flex items-start gap-2 p-3 rounded {{ $question->correct_answer === 'E' ? 'bg-green-50 border border-green-200' : 'bg-gray-50' }}">
                    <span class="font-bold {{ $question->correct_answer === 'E' ? 'text-green-700' : 'text-gray-700' }}">E.</span>
                    <span class="{{ $question->correct_answer === 'E' ? 'text-green-900 font-medium' : 'text-gray-700' }}">{{ $question->option_e }}</span>
                </div>
                @endif
            </div>

            @if($question->explanation)
            <div class="mt-4 p-3 bg-blue-50 rounded border border-blue-200">
                <p class="text-sm font-medium text-blue-900 mb-1">💡 Pembahasan:</p>
                <p class="text-sm text-blue-800">{{ $question->explanation }}</p>
            </div>
            @endif
        </div>
        @endforeach
    </div>
    @else
    <div class="rounded-lg bg-white p-12 text-center shadow-sm">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
        </svg>
        <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada soal</h3>
        <p class="mt-1 text-sm text-gray-500">Mulai tambahkan soal pilihan ganda untuk bank soal ini.</p>
        <div class="mt-6">
            <button onclick="openQuestionModal()" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-[#2D3C8C] rounded-lg hover:bg-blue-900">
                + Tambah Soal Pertama
            </button>
        </div>
    </div>
    @endif

    <!-- Modal: Add/Edit Question -->
    <div id="questionModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-10 mx-auto p-5 border w-full max-w-3xl shadow-lg rounded-md bg-white">
            <div class="flex items-center justify-between mb-4">
                <h3 id="questionModalTitle" class="text-lg font-semibold text-gray-900">Tambah Soal</h3>
                <button onclick="closeQuestionModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <form id="questionForm" method="POST" action="{{ route('admin.classes.quizzes.questions.store', [$program->id, $quiz->id]) }}">
                @csrf
                <input type="hidden" id="questionMethod" name="_method" value="POST">

                <div class="space-y-4 max-h-[70vh] overflow-y-auto pr-2">
                    <!-- Question -->
                    <div>
                        <label for="question_text" class="block text-sm font-medium text-gray-700">Pertanyaan <span class="text-red-500">*</span></label>
                        <textarea id="question_text" name="question" rows="3" required
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                  placeholder="Tulis pertanyaan disini..."></textarea>
                    </div>

                    <!-- Options -->
                    <div class="space-y-3">
                        <label class="block text-sm font-medium text-gray-700">Pilihan Jawaban <span class="text-red-500">*</span></label>
                        
                        <div>
                            <label class="text-xs text-gray-500">Opsi A</label>
                            <textarea id="option_a" name="option_a" rows="2" required
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                        </div>
                        
                        <div>
                            <label class="text-xs text-gray-500">Opsi B</label>
                            <textarea id="option_b" name="option_b" rows="2" required
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                        </div>
                        
                        <div>
                            <label class="text-xs text-gray-500">Opsi C</label>
                            <textarea id="option_c" name="option_c" rows="2" required
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                        </div>
                        
                        <div>
                            <label class="text-xs text-gray-500">Opsi D</label>
                            <textarea id="option_d" name="option_d" rows="2" required
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                        </div>
                        
                        <div>
                            <label class="text-xs text-gray-500">Opsi E (opsional)</label>
                            <textarea id="option_e" name="option_e" rows="2"
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                        </div>
                    </div>

                    <!-- Correct Answer -->
                    <div>
                        <label for="correct_answer" class="block text-sm font-medium text-gray-700">Jawaban Benar <span class="text-red-500">*</span></label>
                        <select id="correct_answer" name="correct_answer" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Pilih jawaban yang benar</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                            <option value="E">E</option>
                        </select>
                    </div>

                    <!-- Explanation -->
                    <div>
                        <label for="explanation" class="block text-sm font-medium text-gray-700">Pembahasan (opsional)</label>
                        <textarea id="explanation" name="explanation" rows="3"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                  placeholder="Penjelasan mengapa jawaban tersebut benar..."></textarea>
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-3 border-t pt-4">
                    <button type="button" onclick="closeQuestionModal()"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                        Batal
                    </button>
                    <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-[#2D3C8C] rounded-md hover:bg-blue-900">
                        Simpan Soal
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const questions = @json($quiz->questions);

        function openQuestionModal() {
            document.getElementById('questionModal').classList.remove('hidden');
            document.getElementById('questionForm').reset();
            document.getElementById('questionModalTitle').textContent = 'Tambah Soal';
            document.getElementById('questionForm').action = "{{ route('admin.classes.quizzes.questions.store', [$program->id, $quiz->id]) }}";
            document.getElementById('questionMethod').value = 'POST';
        }

        function openEditQuestionModal(questionId) {
            const question = questions.find(q => q.id === questionId);
            
            if (question) {
                document.getElementById('questionModal').classList.remove('hidden');
                document.getElementById('questionModalTitle').textContent = 'Edit Soal';
                document.getElementById('questionForm').action = `/admin/classes/{{ $program->id }}/quizzes/{{ $quiz->id }}/questions/${questionId}`;
                document.getElementById('questionMethod').value = 'PUT';
                
                // Fill form
                document.getElementById('question_text').value = question.question;
                document.getElementById('option_a').value = question.option_a;
                document.getElementById('option_b').value = question.option_b;
                document.getElementById('option_c').value = question.option_c;
                document.getElementById('option_d').value = question.option_d;
                document.getElementById('option_e').value = question.option_e || '';
                document.getElementById('correct_answer').value = question.correct_answer;
                document.getElementById('explanation').value = question.explanation || '';
            }
        }

        function closeQuestionModal() {
            document.getElementById('questionModal').classList.add('hidden');
            document.getElementById('questionForm').reset();
        }

        function deleteQuestion(questionId) {
            if (confirm('Apakah Anda yakin ingin menghapus soal ini?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/classes/{{ $program->id }}/quizzes/{{ $quiz->id }}/questions/${questionId}`;
                
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = '{{ csrf_token() }}';
                
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                
                form.appendChild(csrfInput);
                form.appendChild(methodInput);
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
@endsection

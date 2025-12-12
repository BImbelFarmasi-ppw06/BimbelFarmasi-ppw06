<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminClassController extends Controller
{
    /**
     * Display list of all programs/classes grouped by category
     */
    public function index()
    {
        $programs = Program::withCount([
                'orders' => function($query) {
                    $query->whereHas('payment', function($q) {
                        $q->where('status', 'paid');
                    });
                }
            ])
            ->orderBy('class_category')
            ->orderBy('name')
            ->get();

        // Group programs by class_category
        $groupedPrograms = $programs->groupBy('class_category');

        return view('admin.classes.index', compact('groupedPrograms'));
    }

    /**
     * Show form to create new program
     */
    public function create()
    {
        return view('admin.classes.create');
    }

    /**
     * Store new program
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'class_category' => ['required', 'in:bimbel-ukom,cpns-p3k,joki-tugas'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'duration' => ['required', 'string', 'max:100'],
            'tutor' => ['nullable', 'string', 'max:255'],
            'schedule' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:active,inactive'],
            'features' => ['nullable', 'array'],
            'features.*' => ['string', 'max:255'],
        ], [
            'name.required' => 'Nama program wajib diisi.',
            'class_category.required' => 'Kategori kelas wajib dipilih.',
            'description.required' => 'Deskripsi program wajib diisi.',
            'price.required' => 'Harga program wajib diisi.',
            'price.numeric' => 'Harga harus berupa angka.',
            'duration.required' => 'Durasi program wajib diisi.',
            'status.required' => 'Status program wajib dipilih.',
        ]);

        try {
            DB::beginTransaction();

            // Prepare features - filter out empty values but keep as array
            // Model will handle JSON encoding via casts
            $features = $request->features ? array_filter($request->features) : [];

            $program = Program::create([
                'name' => $validated['name'],
                'class_category' => $validated['class_category'],
                'description' => $validated['description'],
                'price' => $validated['price'],
                'duration' => $validated['duration'],
                'tutor' => $validated['tutor'] ?? null,
                'schedule' => $validated['schedule'] ?? null,
                'status' => $validated['status'],
                'features' => $features, // Pass array directly, model will JSON encode it
            ]);

            DB::commit();

            return redirect()->route('admin.classes.index')
                ->with('success', 'Program berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Gagal menambahkan program: ' . $e->getMessage());
        }
    }

    /**
     * Show form to edit program
     */
    public function edit($id)
    {
        $program = Program::findOrFail($id);
        return view('admin.classes.edit', compact('program'));
    }

    /**
     * Update program
     */
    public function update(Request $request, $id)
    {
        \Log::info('Update program called', ['id' => $id, 'method' => $request->method()]);
        
        $program = Program::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'class_category' => ['required', 'in:bimbel-ukom,cpns-p3k,joki-tugas'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'duration' => ['required', 'string', 'max:100'],
            'tutor' => ['nullable', 'string', 'max:255'],
            'schedule' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:active,inactive'],
            'features' => ['nullable', 'array'],
            'features.*' => ['string', 'max:255'],
        ]);

        try {
            DB::beginTransaction();

            // Prepare features - filter out empty values but keep as array
            // Model will handle JSON encoding via casts
            $features = $request->features ? array_filter($request->features) : [];

            $program->update([
                'name' => $validated['name'],
                'class_category' => $validated['class_category'],
                'description' => $validated['description'],
                'price' => $validated['price'],
                'duration' => $validated['duration'],
                'tutor' => $validated['tutor'] ?? null,
                'schedule' => $validated['schedule'] ?? null,
                'status' => $validated['status'],
                'features' => $features, // Pass array directly, model will JSON encode it
            ]);

            DB::commit();
            
            \Log::info('Program updated successfully', ['id' => $program->id, 'name' => $program->name]);

            return redirect()->route('admin.classes.index')
                ->with('success', 'Program berhasil diupdate!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Gagal mengupdate program: ' . $e->getMessage());
        }
    }

    /**
     * Show program detail with materials and students
     */
    public function show($id)
    {
        $program = Program::withCount('orders')
            ->with([
                'orders.user', 
                'orders.payment',
                'courses' => function($query) {
                    $query->orderBy('created_at', 'desc');
                },
                'classSchedules' => function($query) {
                    $query->orderBy('date', 'asc')->orderBy('start_time', 'asc');
                },
                'quizBanks' => function($query) {
                    $query->withCount('questions')->orderBy('created_at', 'desc');
                }
            ])
            ->findOrFail($id);

        // Get paid students only
        $students = $program->orders()
            ->whereHas('payment', function($query) {
                $query->where('status', 'paid');
            })
            ->with(['user', 'payment'])
            ->latest()
            ->get();

        return view('admin.classes.show', compact('program', 'students'));
    }
    
    /**
     * Store course material for program
     */
    public function storeMaterial(Request $request, $id)
    {
        $program = Program::findOrFail($id);
        
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'type' => ['required', 'in:video,material,assignment'],
            'video_url' => ['nullable', 'url'],
            'duration_minutes' => ['nullable', 'integer', 'min:1'],
            'file' => ['nullable', 'file', 'mimes:pdf,doc,docx,ppt,pptx,zip', 'max:10240'], // 10MB
        ]);

        try {
            DB::beginTransaction();

            $data = [
                'program_id' => $program->id,
                'title' => $validated['title'],
                'description' => $validated['description'],
                'type' => $validated['type'],
                'video_url' => $validated['video_url'] ?? null,
                'duration_minutes' => $validated['duration_minutes'] ?? null,
            ];

            // Handle file upload if exists
            if ($request->hasFile('file')) {
                $filePath = $request->file('file')->store('course-materials', 'public');
                $data['file_path'] = $filePath;
                $data['file_name'] = $request->file('file')->getClientOriginalName();
                $data['file_size'] = $request->file('file')->getSize();
            }

            $program->courses()->create($data);

            DB::commit();

            return back()->with('success', 'Materi pembelajaran berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menambahkan materi: ' . $e->getMessage());
        }
    }
    
    /**
     * Delete course material
     */
    public function deleteMaterial($programId, $materialId)
    {
        try {
            $program = Program::findOrFail($programId);
            $course = $program->courses()->findOrFail($materialId);
            
            // Delete file from storage
            if ($course->file_path && \Storage::disk('public')->exists($course->file_path)) {
                \Storage::disk('public')->delete($course->file_path);
            }
            
            $course->delete();

            return back()->with('success', 'Materi berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus materi: ' . $e->getMessage());
        }
    }

    /**
     * Store new class schedule
     */
    public function storeSchedule(Request $request, $id)
    {
        $program = Program::findOrFail($id);
        
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'date' => ['required', 'date'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
            'type' => ['required', 'in:online,offline'],
            'meeting_link' => ['nullable', 'url'],
            'location' => ['nullable', 'string', 'max:255'],
        ]);

        $program->classSchedules()->create($validated);

        return back()->with('success', 'Jadwal berhasil ditambahkan!');
    }

    /**
     * Update class schedule
     */
    public function updateSchedule(Request $request, $programId, $scheduleId)
    {
        $program = Program::findOrFail($programId);
        $schedule = $program->classSchedules()->findOrFail($scheduleId);
        
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'date' => ['required', 'date'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
            'type' => ['required', 'in:online,offline'],
            'meeting_link' => ['nullable', 'url'],
            'location' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:scheduled,ongoing,completed,cancelled'],
        ]);

        $schedule->update($validated);

        return back()->with('success', 'Jadwal berhasil diupdate!');
    }

    /**
     * Delete class schedule
     */
    public function deleteSchedule($programId, $scheduleId)
    {
        try {
            $program = Program::findOrFail($programId);
            $schedule = $program->classSchedules()->findOrFail($scheduleId);
            
            $schedule->delete();

            return back()->with('success', 'Jadwal berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus jadwal: ' . $e->getMessage());
        }
    }

    /**
     * Store new quiz/exercise
     */
    public function storeQuiz(Request $request, $id)
    {
        $program = Program::findOrFail($id);
        
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'category' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:practice,tryout'],
            'duration_minutes' => ['nullable', 'integer', 'min:1'],
            'passing_score' => ['required', 'integer', 'min:0', 'max:100'],
        ]);

        $validated['program_id'] = $program->id;
        $validated['total_questions'] = 0;

        \App\Models\QuizBank::create($validated);

        return back()->with('success', 'Bank soal berhasil ditambahkan!');
    }

    /**
     * Update quiz/exercise
     */
    public function updateQuiz(Request $request, $programId, $quizId)
    {
        $program = Program::findOrFail($programId);
        $quiz = $program->quizBanks()->findOrFail($quizId);
        
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'category' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:practice,tryout'],
            'duration_minutes' => ['nullable', 'integer', 'min:1'],
            'passing_score' => ['required', 'integer', 'min:0', 'max:100'],
        ]);

        $quiz->update($validated);

        return back()->with('success', 'Bank soal berhasil diupdate!');
    }

    /**
     * Delete quiz/exercise
     */
    public function deleteQuiz($programId, $quizId)
    {
        try {
            $program = Program::findOrFail($programId);
            $quiz = $program->quizBanks()->findOrFail($quizId);
            
            $quiz->delete();

            return back()->with('success', 'Bank soal berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus bank soal: ' . $e->getMessage());
        }
    }

    /**
     * Show quiz questions management page
     */
    public function showQuizQuestions($programId, $quizId)
    {
        $program = Program::findOrFail($programId);
        $quiz = $program->quizBanks()->with('questions')->findOrFail($quizId);
        
        return view('admin.classes.quiz-questions', compact('program', 'quiz'));
    }

    /**
     * Store new quiz question
     */
    public function storeQuizQuestion(Request $request, $programId, $quizId)
    {
        $program = Program::findOrFail($programId);
        $quiz = $program->quizBanks()->findOrFail($quizId);
        
        $validated = $request->validate([
            'question' => ['required', 'string'],
            'option_a' => ['required', 'string'],
            'option_b' => ['required', 'string'],
            'option_c' => ['required', 'string'],
            'option_d' => ['required', 'string'],
            'option_e' => ['nullable', 'string'],
            'correct_answer' => ['required', 'in:A,B,C,D,E'],
            'explanation' => ['nullable', 'string'],
        ]);

        $quiz->questions()->create($validated);
        
        // Update total questions count
        $quiz->update(['total_questions' => $quiz->questions()->count()]);

        return back()->with('success', 'Soal berhasil ditambahkan!');
    }

    /**
     * Update quiz question
     */
    public function updateQuizQuestion(Request $request, $programId, $quizId, $questionId)
    {
        $program = Program::findOrFail($programId);
        $quiz = $program->quizBanks()->findOrFail($quizId);
        $question = $quiz->questions()->findOrFail($questionId);
        
        $validated = $request->validate([
            'question' => ['required', 'string'],
            'option_a' => ['required', 'string'],
            'option_b' => ['required', 'string'],
            'option_c' => ['required', 'string'],
            'option_d' => ['required', 'string'],
            'option_e' => ['nullable', 'string'],
            'correct_answer' => ['required', 'in:A,B,C,D,E'],
            'explanation' => ['nullable', 'string'],
        ]);

        $question->update($validated);

        return back()->with('success', 'Soal berhasil diupdate!');
    }

    /**
     * Delete quiz question
     */
    public function deleteQuizQuestion($programId, $quizId, $questionId)
    {
        try {
            $program = Program::findOrFail($programId);
            $quiz = $program->quizBanks()->findOrFail($quizId);
            $question = $quiz->questions()->findOrFail($questionId);
            
            $question->delete();
            
            // Update total questions count
            $quiz->update(['total_questions' => $quiz->questions()->count()]);

            return back()->with('success', 'Soal berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus soal: ' . $e->getMessage());
        }
    }

    /**
     * Delete program
     */
    public function destroy($id)
    {
        try {
            $program = Program::findOrFail($id);

            // Check if program has active orders
            $activeOrders = $program->orders()
                ->whereIn('status', ['pending', 'processing'])
                ->count();

            if ($activeOrders > 0) {
                return back()->with('error', 'Tidak dapat menghapus program yang memiliki order aktif.');
            }

            $program->delete();

            return redirect()->route('admin.classes.index')
                ->with('success', 'Program berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus program: ' . $e->getMessage());
        }
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuizBank;
use App\Models\QuizQuestion;
use App\Models\Program;
use Illuminate\Http\Request;

class AdminQuestionController extends Controller
{
    public function index(Request $request)
    {
        $query = QuizBank::with(['program'])->latest();

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Search
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $quizBanks = $query->paginate(10);
        
        // Calculate stats by category
        $stats = QuizBank::selectRaw('category, COUNT(*) as count')
            ->groupBy('category')
            ->pluck('count', 'category')
            ->toArray();
        
        $categories = ['Farmakologi', 'Farmasi Klinik', 'Farmasetika', 'Kimia Farmasi', 'UKOM', 'CPNS'];

        return view('admin.questions.index', compact('quizBanks', 'categories', 'stats'));
    }

    public function create()
    {
        $programs = Program::all();
        $categories = ['Farmakologi', 'Farmasi Klinik', 'Farmasetika', 'Kimia Farmasi', 'UKOM', 'CPNS'];
        
        return view('admin.questions.create', compact('programs', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'program_id' => 'required|exists:programs,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string',
            'duration_minutes' => 'nullable|integer|min:1',
            'passing_score' => 'required|integer|min:0|max:100',
        ]);

        $quizBank = QuizBank::create($validated);

        return redirect()->route('admin.questions.show', $quizBank)
            ->with('success', 'Bank soal berhasil dibuat! Silakan tambahkan soal.');
    }

    public function show(QuizBank $quizBank)
    {
        $quizBank->load(['program', 'questions']);
        
        return view('admin.questions.show', compact('quizBank'));
    }

    public function edit(QuizBank $quizBank)
    {
        $programs = Program::all();
        $categories = ['Farmakologi', 'Farmasi Klinik', 'Farmasetika', 'Kimia Farmasi', 'UKOM', 'CPNS'];
        
        return view('admin.questions.edit', compact('quizBank', 'programs', 'categories'));
    }

    public function update(Request $request, QuizBank $quizBank)
    {
        $validated = $request->validate([
            'program_id' => 'required|exists:programs,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string',
            'duration_minutes' => 'nullable|integer|min:1',
            'passing_score' => 'required|integer|min:0|max:100',
        ]);

        $quizBank->update($validated);

        return redirect()->route('admin.questions.show', $quizBank)
            ->with('success', 'Bank soal berhasil diupdate!');
    }

    public function destroy(QuizBank $quizBank)
    {
        $quizBank->delete();

        return redirect()->route('admin.questions.index')
            ->with('success', 'Bank soal berhasil dihapus!');
    }

    // Question Management
    public function addQuestion(Request $request, QuizBank $quizBank)
    {
        $validated = $request->validate([
            'question' => 'required|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'required|string',
            'option_e' => 'nullable|string',
            'correct_answer' => 'required|in:A,B,C,D,E',
            'explanation' => 'nullable|string',
        ]);

        $quizBank->questions()->create($validated);
        $quizBank->increment('total_questions');

        return redirect()->route('admin.questions.show', $quizBank)
            ->with('success', 'Soal berhasil ditambahkan!');
    }

    public function editQuestion(QuizBank $quizBank, QuizQuestion $question)
    {
        return view('admin.questions.edit-question', compact('quizBank', 'question'));
    }

    public function updateQuestion(Request $request, QuizBank $quizBank, QuizQuestion $question)
    {
        $validated = $request->validate([
            'question' => 'required|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'required|string',
            'option_e' => 'nullable|string',
            'correct_answer' => 'required|in:A,B,C,D,E',
            'explanation' => 'nullable|string',
        ]);

        $question->update($validated);

        return redirect()->route('admin.questions.show', $quizBank)
            ->with('success', 'Soal berhasil diupdate!');
    }

    public function destroyQuestion(QuizBank $quizBank, QuizQuestion $question)
    {
        $question->delete();
        $quizBank->decrement('total_questions');

        return redirect()->route('admin.questions.show', $quizBank)
            ->with('success', 'Soal berhasil dihapus!');
    }
}

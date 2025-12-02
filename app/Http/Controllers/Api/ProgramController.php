<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\Order;
use App\Models\Course;
use App\Models\QuizBank;
use App\Models\QuizAttempt;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Programs",
 *     description="API Endpoints for programs management"
 * )
 */
class ProgramController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/programs",
     *     summary="Get all programs",
     *     tags={"Programs"},
     *     @OA\Response(
     *         response=200,
     *         description="List of programs",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array", @OA\Items(type="object"))
     *         )
     *     )
     * )
     */
    public function index()
    {
        $programs = Program::all();
        
        return response()->json([
            'success' => true,
            'data' => $programs
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/programs/{slug}",
     *     summary="Get program by slug",
     *     tags={"Programs"},
     *     @OA\Parameter(
     *         name="slug",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Program details",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Program not found")
     * )
     */
    public function show($slug)
    {
        $program = Program::where('slug', $slug)->first();
        
        if (!$program) {
            return response()->json([
                'success' => false,
                'message' => 'Program not found'
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'data' => $program
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/programs/{id}/materials",
     *     summary="Get program materials",
     *     tags={"Programs"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Program materials",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array", @OA\Items(type="object"))
     *         )
     *     ),
     *     @OA\Response(response=403, description="Access denied")
     * )
     */
    public function materials(Request $request, $id)
    {
        // Check if user has access to this program
        $hasAccess = Order::where('user_id', $request->user()->id)
            ->where('program_id', $id)
            ->whereHas('payment', function($q) {
                $q->where('status', 'approved');
            })
            ->exists();

        if (!$hasAccess) {
            return response()->json([
                'success' => false,
                'message' => 'You do not have access to this program'
            ], 403);
        }

        $courses = Course::where('program_id', $id)->get();
        
        return response()->json([
            'success' => true,
            'data' => $courses
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/programs/{id}/exercises",
     *     summary="Get program exercises",
     *     tags={"Programs"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Program exercises")
     * )
     */
    public function exercises(Request $request, $id)
    {
        // Check access
        $hasAccess = Order::where('user_id', $request->user()->id)
            ->where('program_id', $id)
            ->whereHas('payment', function($q) {
                $q->where('status', 'approved');
            })
            ->exists();

        if (!$hasAccess) {
            return response()->json([
                'success' => false,
                'message' => 'Access denied'
            ], 403);
        }

        $exercises = QuizBank::where('type', 'latihan')
            ->where('program_category', 'like', '%' . $id . '%')
            ->with('questions')
            ->get();
        
        return response()->json([
            'success' => true,
            'data' => $exercises
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/exercises/{exerciseId}/submit",
     *     summary="Submit exercise answers",
     *     tags={"Programs"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="exerciseId",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="answers", type="object", example={"1":"A","2":"B","3":"C"})
     *         )
     *     ),
     *     @OA\Response(response=200, description="Answers submitted successfully")
     * )
     */
    public function submitExercise(Request $request, $exerciseId)
    {
        $request->validate([
            'answers' => 'required|array',
            'started_at' => 'nullable|date',
            'time_spent_seconds' => 'nullable|integer',
        ]);

        $quiz = QuizBank::with('questions')->findOrFail($exerciseId);
        $answers = $request->answers;
        $correctCount = 0;
        $totalQuestions = $quiz->questions->count();
        $detailedAnswers = [];

        // Hitung jawaban benar dan buat detail per soal
        foreach ($quiz->questions as $index => $question) {
            $userAnswer = $answers[$question->id] ?? null;
            $isCorrect = $userAnswer === $question->correct_answer;
            
            if ($isCorrect) {
                $correctCount++;
            }

            $detailedAnswers[$question->id] = [
                'question_number' => $index + 1,
                'question' => $question->question,
                'user_answer' => $userAnswer,
                'correct_answer' => $question->correct_answer,
                'is_correct' => $isCorrect,
                'explanation' => $question->explanation,
                'options' => [
                    'A' => $question->option_a,
                    'B' => $question->option_b,
                    'C' => $question->option_c,
                    'D' => $question->option_d,
                    'E' => $question->option_e,
                ]
            ];
        }

        // Hitung persentase skor
        $scorePercentage = $totalQuestions > 0 ? ($correctCount / $totalQuestions) * 100 : 0;
        
        // Cek apakah lulus
        $isPassed = $scorePercentage >= $quiz->passing_score;

        // Simpan attempt
        $attempt = QuizAttempt::create([
            'user_id' => $request->user()->id,
            'quiz_bank_id' => $exerciseId,
            'score' => round($scorePercentage, 2),
            'correct_answers' => $correctCount,
            'total_questions' => $totalQuestions,
            'is_passed' => $isPassed,
            'answers' => $detailedAnswers,
            'started_at' => $request->started_at ?? now(),
            'completed_at' => now(),
            'time_spent_seconds' => $request->time_spent_seconds,
        ]);

        // Load relasi untuk response
        $attempt->load('quizBank', 'user');

        return response()->json([
            'success' => true,
            'message' => $isPassed ? 'Selamat! Anda lulus!' : 'Mohon maaf, Anda belum lulus. Silakan coba lagi.',
            'data' => [
                'attempt_id' => $attempt->id,
                'score' => round($scorePercentage, 2),
                'correct_answers' => $correctCount,
                'wrong_answers' => $totalQuestions - $correctCount,
                'total_questions' => $totalQuestions,
                'passing_score' => $quiz->passing_score,
                'is_passed' => $isPassed,
                'grade' => $attempt->grade,
                'status' => $attempt->status_text,
                'feedback' => $attempt->feedback,
                'time_spent' => $attempt->time_spent_formatted,
                'quiz_title' => $quiz->title,
                'quiz_category' => $quiz->category,
                'completed_at' => $attempt->completed_at->format('d M Y H:i:s'),
            ]
        ]);
    }

    public function schedule(Request $request, $id)
    {
        return response()->json([
            'success' => true,
            'message' => 'Schedule feature coming soon'
        ]);
    }

    public function tryouts(Request $request, $id)
    {
        $hasAccess = Order::where('user_id', $request->user()->id)
            ->where('program_id', $id)
            ->whereHas('payment', function($q) {
                $q->where('status', 'approved');
            })
            ->exists();

        if (!$hasAccess) {
            return response()->json([
                'success' => false,
                'message' => 'Access denied'
            ], 403);
        }

        $tryouts = QuizBank::where('type', 'tryout')
            ->where('program_category', 'like', '%' . $id . '%')
            ->with('questions')
            ->get();
        
        return response()->json([
            'success' => true,
            'data' => $tryouts
        ]);
    }

    public function submitTryout(Request $request, $tryoutId)
    {
        return $this->submitExercise($request, $tryoutId);
    }

    public function viewResult(Request $request, $resultId)
    {
        $attempt = QuizAttempt::with('quizBank', 'user')->findOrFail($resultId);
        
        if ($attempt->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        // Format detail hasil
        $result = [
            'id' => $attempt->id,
            'quiz_title' => $attempt->quizBank->title,
            'quiz_category' => $attempt->quizBank->category,
            'quiz_description' => $attempt->quizBank->description,
            
            // Informasi Peserta
            'user_name' => $attempt->user->name,
            'user_email' => $attempt->user->email,
            
            // Skor dan Hasil
            'score' => $attempt->score,
            'grade' => $attempt->grade,
            'correct_answers' => $attempt->correct_answers,
            'wrong_answers' => $attempt->total_questions - $attempt->correct_answers,
            'total_questions' => $attempt->total_questions,
            'passing_score' => $attempt->quizBank->passing_score,
            'is_passed' => $attempt->is_passed,
            'status' => $attempt->status_text,
            'feedback' => $attempt->feedback,
            
            // Waktu
            'started_at' => $attempt->started_at?->format('d M Y H:i:s'),
            'completed_at' => $attempt->completed_at?->format('d M Y H:i:s'),
            'time_spent' => $attempt->time_spent_formatted,
            'duration_limit' => $attempt->quizBank->duration_minutes . ' menit',
            
            // Detail Jawaban
            'answers' => $attempt->answers,
            
            // Statistik
            'accuracy_percentage' => $attempt->score,
            'wrong_percentage' => round(100 - $attempt->score, 2),
        ];
        
        return response()->json([
            'success' => true,
            'data' => $result
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/quiz-attempts/history",
     *     summary="Get user's quiz attempt history",
     *     tags={"Quiz"},
     *     security={{"sanctum":{}}},
     *     @OA\Response(response=200, description="Quiz attempt history")
     * )
     */
    public function quizHistory(Request $request)
    {
        $attempts = QuizAttempt::with('quizBank')
            ->where('user_id', $request->user()->id)
            ->orderBy('completed_at', 'desc')
            ->get()
            ->map(function($attempt) {
                return [
                    'id' => $attempt->id,
                    'quiz_title' => $attempt->quizBank->title,
                    'quiz_category' => $attempt->quizBank->category,
                    'score' => $attempt->score,
                    'grade' => $attempt->grade,
                    'correct_answers' => $attempt->correct_answers,
                    'total_questions' => $attempt->total_questions,
                    'is_passed' => $attempt->is_passed,
                    'status' => $attempt->status_text,
                    'completed_at' => $attempt->completed_at?->format('d M Y H:i:s'),
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $attempts
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/quiz-attempts/statistics",
     *     summary="Get user's quiz statistics",
     *     tags={"Quiz"},
     *     security={{"sanctum":{}}},
     *     @OA\Response(response=200, description="Quiz statistics")
     * )
     */
    public function quizStatistics(Request $request)
    {
        $userId = $request->user()->id;
        
        $totalAttempts = QuizAttempt::where('user_id', $userId)->count();
        $passedAttempts = QuizAttempt::where('user_id', $userId)->where('is_passed', true)->count();
        $averageScore = QuizAttempt::where('user_id', $userId)->avg('score');
        $highestScore = QuizAttempt::where('user_id', $userId)->max('score');
        $lowestScore = QuizAttempt::where('user_id', $userId)->min('score');

        // Statistik per kategori
        $categoryStats = QuizAttempt::with('quizBank')
            ->where('user_id', $userId)
            ->get()
            ->groupBy('quizBank.category')
            ->map(function($attempts, $category) {
                return [
                    'category' => $category,
                    'total_attempts' => $attempts->count(),
                    'passed' => $attempts->where('is_passed', true)->count(),
                    'average_score' => round($attempts->avg('score'), 2),
                    'highest_score' => round($attempts->max('score'), 2),
                ];
            })
            ->values();

        return response()->json([
            'success' => true,
            'data' => [
                'total_attempts' => $totalAttempts,
                'passed_attempts' => $passedAttempts,
                'failed_attempts' => $totalAttempts - $passedAttempts,
                'pass_rate' => $totalAttempts > 0 ? round(($passedAttempts / $totalAttempts) * 100, 2) : 0,
                'average_score' => round($averageScore, 2),
                'highest_score' => round($highestScore, 2),
                'lowest_score' => round($lowestScore, 2),
                'category_statistics' => $categoryStats,
            ]
        ]);
    }
}

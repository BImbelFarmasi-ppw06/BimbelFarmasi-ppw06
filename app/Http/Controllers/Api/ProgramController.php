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
            'answers' => 'required|array'
        ]);

        $quiz = QuizBank::with('questions')->findOrFail($exerciseId);
        $answers = $request->answers;
        $score = 0;
        $totalQuestions = $quiz->questions->count();

        foreach ($quiz->questions as $question) {
            if (isset($answers[$question->id]) && $answers[$question->id] === $question->correct_answer) {
                $score++;
            }
        }

        $percentage = ($score / $totalQuestions) * 100;

        $attempt = QuizAttempt::create([
            'user_id' => $request->user()->id,
            'quiz_bank_id' => $exerciseId,
            'score' => $percentage,
            'answers' => json_encode($answers),
            'completed_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Exercise submitted successfully',
            'data' => [
                'score' => $percentage,
                'correct' => $score,
                'total' => $totalQuestions,
                'attempt_id' => $attempt->id
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
        $attempt = QuizAttempt::with('quizBank')->findOrFail($resultId);
        
        if ($attempt->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }
        
        return response()->json([
            'success' => true,
            'data' => $attempt
        ]);
    }
}

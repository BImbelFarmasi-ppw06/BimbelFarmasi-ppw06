<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProgramController;

/*
|--------------------------------------------------------------------------
| API Routes - Bimbel Farmasi
|--------------------------------------------------------------------------
|
| API endpoints untuk integrasi eksternal atau mobile app (jika diperlukan).
| Sebagian besar fitur sudah tersedia di web routes, jadi API ini 
| hanya menyediakan endpoint penting untuk quiz submission & results.
|
*/

// Public API Routes
Route::prefix('v1')->group(function () {
    
    // Public Programs (untuk info program)
    Route::get('/programs', [ProgramController::class, 'index']);
    Route::get('/programs/{slug}', [ProgramController::class, 'show']);
});

// Protected API Routes (Requires Authentication)
Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    
    // Program Learning Content
    Route::get('/programs/{id}/materials', [ProgramController::class, 'materials']);
    Route::get('/programs/{id}/exercises', [ProgramController::class, 'exercises']);
    Route::get('/programs/{id}/tryouts', [ProgramController::class, 'tryouts']);
    
    // Quiz/Exercise Submission
    Route::post('/exercises/{exerciseId}/submit', [ProgramController::class, 'submitExercise']);
    Route::post('/tryouts/{tryoutId}/submit', [ProgramController::class, 'submitTryout']);
    Route::get('/results/{resultId}', [ProgramController::class, 'viewResult']);
    
    // Quiz History & Statistics
    Route::get('/quiz-attempts/history', [ProgramController::class, 'quizHistory']);
    Route::get('/quiz-attempts/statistics', [ProgramController::class, 'quizStatistics']);
});

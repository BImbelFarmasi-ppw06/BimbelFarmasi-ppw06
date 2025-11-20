<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProgramController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\TestimonialController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\PaymentController;

// Public API Routes
Route::prefix('v1')->group(function () {
    
    // Authentication
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
    
    // Public Programs
    Route::get('/programs', [ProgramController::class, 'index']);
    Route::get('/programs/{slug}', [ProgramController::class, 'show']);
    
    // Public Testimonials
    Route::get('/testimonials', [TestimonialController::class, 'index']);
    
    // Contact Form
    Route::post('/contact', [ContactController::class, 'store']);
});

// Protected API Routes (Requires Authentication)
Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    
    // Auth User
    Route::get('/user', [UserController::class, 'profile']);
    Route::put('/user/profile', [UserController::class, 'updateProfile']);
    Route::put('/user/password', [UserController::class, 'updatePassword']);
    Route::delete('/user/account', [UserController::class, 'deleteAccount']);
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // User Services & Transactions
    Route::get('/user/services', [UserController::class, 'myServices']);
    Route::get('/user/transactions', [UserController::class, 'transactions']);
    Route::get('/user/orders', [OrderController::class, 'myOrders']);
    
    // Orders
    Route::post('/orders', [OrderController::class, 'store']);
    Route::get('/orders/{orderNumber}', [OrderController::class, 'show']);
    Route::post('/orders/{orderNumber}/payment', [PaymentController::class, 'uploadProof']);
    
    // Testimonials
    Route::get('/user/testimonials', [TestimonialController::class, 'myTestimonials']);
    Route::post('/testimonials', [TestimonialController::class, 'store']);
    Route::get('/testimonials/{id}', [TestimonialController::class, 'show']);
    Route::put('/testimonials/{id}', [TestimonialController::class, 'update']);
    Route::delete('/testimonials/{id}', [TestimonialController::class, 'destroy']);
    
    // Program Access (for enrolled students)
    Route::get('/programs/{id}/materials', [ProgramController::class, 'materials']);
    Route::get('/programs/{id}/schedule', [ProgramController::class, 'schedule']);
    Route::get('/programs/{id}/exercises', [ProgramController::class, 'exercises']);
    Route::get('/programs/{id}/tryouts', [ProgramController::class, 'tryouts']);
    
    // Quiz/Exercise Submission
    Route::post('/exercises/{exerciseId}/submit', [ProgramController::class, 'submitExercise']);
    Route::post('/tryouts/{tryoutId}/submit', [ProgramController::class, 'submitTryout']);
    Route::get('/results/{resultId}', [ProgramController::class, 'viewResult']);
});

// Admin API Routes (Future enhancement)
Route::prefix('v1/admin')->middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::get('/dashboard/stats', function () {
        return response()->json([
            'message' => 'Admin API endpoints - Coming soon'
        ]);
    });
});

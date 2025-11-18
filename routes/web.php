<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminPaymentController;
use App\Http\Controllers\Admin\AdminStudentController;
use App\Http\Controllers\TestimonialController;

// =================== PUBLIC PAGES ===================
Route::view('/', 'pages.home')->name('home');
Route::view('/layanan', 'pages.layanan')->name('layanan');
Route::view('/bimbel-ukom-d3-farmasi', 'pages.bimbel-ukom')->name('bimbel.ukom');
Route::view('/cpns-p3k-farmasi', 'pages.cpns-p3k')->name('cpns.p3k');
Route::view('/joki-tugas-farmasi', 'pages.joki-tugas')->name('joki.tugas');
Route::get('/testimoni', [TestimonialController::class, 'index'])->name('testimonials.index');
Route::view('/kontak', 'pages.kontak')->name('kontak');
Route::post('/kontak', [ContactController::class, 'store'])->name('contact.store');

// ⚠️ HAPUS route view login/google yang lama
// Route::view('/login/google', 'pages.login-google')->name('login.google');

// =================== USER AUTH ===================
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 🔹 GOOGLE LOGIN (GET semua)
Route::get('/login/google', [AuthController::class, 'redirectToGoogle'])
    ->name('login.google');

Route::get('/login/google/callback', [AuthController::class, 'handleGoogleCallback'])
    ->name('login.google.callback');

// =================== USER PROTECTED ROUTES ===================
Route::middleware('auth')->group(function () {
    Route::get('/profil', [UserController::class, 'profile'])->name('user.profile');
    Route::post('/profil', [UserController::class, 'updateProfile'])->name('user.profile.update');

    Route::get('/layanan-saya', [UserController::class, 'myServices'])->name('user.services');
    Route::get('/riwayat-transaksi', [UserController::class, 'transactions'])->name('user.transactions');

    // Program Learning Routes
    Route::get('/program/{id}', [UserController::class, 'accessProgram'])->name('program.access');
    Route::get('/program/{id}/materi', [UserController::class, 'materials'])->name('program.materials');
    Route::get('/program/{id}/jadwal', [UserController::class, 'schedule'])->name('program.schedule');
    Route::get('/program/{id}/diskusi', [UserController::class, 'discussion'])->name('program.discussion');
    Route::get('/program/{id}/latihan-soal', [UserController::class, 'exercises'])->name('program.exercises');
    Route::get('/program/{id}/latihan-soal/{exerciseId}', [UserController::class, 'startExercise'])->name('program.exercise.start');
    Route::post('/program/{id}/latihan-soal/{exerciseId}/submit', [UserController::class, 'submitExercise'])->name('program.exercise.submit');
    Route::get('/program/{id}/try-out', [UserController::class, 'tryouts'])->name('program.tryouts');
    Route::get('/program/{id}/try-out/{tryoutId}', [UserController::class, 'startTryout'])->name('program.tryout.start');
    Route::post('/program/{id}/try-out/{tryoutId}/submit', [UserController::class, 'submitTryout'])->name('program.tryout.submit');
    Route::get('/program/{id}/hasil/{resultId}', [UserController::class, 'viewResult'])->name('program.result');

    Route::get('/pengaturan', [UserController::class, 'settings'])->name('user.settings');
    Route::post('/pengaturan/password', [UserController::class, 'updatePassword'])->name('user.password.update');
    Route::delete('/pengaturan/akun', [UserController::class, 'deleteAccount'])->name('user.account.delete');

    // Order Routes
    Route::get('/order/{slug}', [OrderController::class, 'create'])->name('order.create');
    Route::post('/order', [OrderController::class, 'store'])->name('order.store');
    Route::get('/order/{orderNumber}/payment', [OrderController::class, 'payment'])->name('order.payment');
    Route::post('/order/{orderNumber}/payment', [OrderController::class, 'processPayment'])->name('order.payment.process');
    Route::get('/order/{orderNumber}/success', [OrderController::class, 'success'])->name('order.success');
    Route::get('/pesanan-saya', [OrderController::class, 'myOrders'])->name('order.my-orders');

    // Testimonial Routes
    Route::get('/testimoni-saya', [TestimonialController::class, 'myTestimonials'])->name('testimonials.myTestimonials');
    Route::get('/order/{orderNumber}/testimoni/create', [TestimonialController::class, 'create'])->name('testimonials.create');
    Route::post('/order/{orderNumber}/testimoni', [TestimonialController::class, 'store'])->name('testimonials.store');
    Route::get('/testimoni/{id}/edit', [TestimonialController::class, 'edit'])->name('testimonials.edit');
    Route::put('/testimoni/{id}', [TestimonialController::class, 'update'])->name('testimonials.update');
    Route::delete('/testimoni/{id}', [TestimonialController::class, 'destroy'])->name('testimonials.destroy');
});

// =================== ADMIN AUTH ===================
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
});

// =================== ADMIN PROTECTED PAGES ===================
Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
    Route::view('/', 'admin.dashboard')->name('dashboard');

    // Student Management
    Route::get('/students', [AdminStudentController::class, 'index'])->name('students.index');
    Route::get('/students/{id}', [AdminStudentController::class, 'show'])->name('students.show');

    Route::view('/classes', 'admin.classes.index')->name('classes.index');
    Route::view('/questions', 'admin.questions.index')->name('questions.index');

    // Payment Management
    Route::get('/payments', [AdminPaymentController::class, 'index'])->name('payments.index');
    Route::get('/payments/{id}', [AdminPaymentController::class, 'show'])->name('payments.show');
    Route::post('/payments/{id}/approve', [AdminPaymentController::class, 'approve'])->name('payments.approve');
    Route::post('/payments/{id}/reject', [AdminPaymentController::class, 'reject'])->name('payments.reject');
    Route::get('/payments/{id}/proof', [AdminPaymentController::class, 'viewProof'])->name('payments.proof');

    Route::view('/statistics', 'admin.statistics')->name('statistics');
});

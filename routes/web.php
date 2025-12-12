<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminPaymentController;
use App\Http\Controllers\Admin\AdminStudentController;
use App\Http\Controllers\Admin\AdminClassController;
use App\Http\Controllers\Admin\AdminCourseController;
use App\Http\Controllers\Admin\AdminProgramController;
use App\Http\Controllers\TestimonialController;

// =================== PUBLIC PAGES ===================
Route::view('/', 'pages.home')->name('home');
Route::view('/layanan', 'pages.layanan')->name('layanan');
Route::view('/bimbel-ukom-d3-farmasi', 'pages.bimbel-ukom')->name('bimbel.ukom');

// Midtrans Notification Callback (No Auth Required)
Route::post('/midtrans/notification', [OrderController::class, 'handleNotification'])->name('midtrans.notification');
Route::view('/cpns-p3k-farmasi', 'pages.cpns-p3k')->name('cpns.p3k');
Route::view('/joki-tugas-farmasi', 'pages.joki-tugas')->name('joki.tugas');
Route::get('/testimoni', [TestimonialController::class, 'index'])->name('testimonials.index');
Route::view('/kontak', 'pages.kontak')->name('kontak');
Route::post('/kontak', [ContactController::class, 'store'])->name('contact.store');


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

// 🔹 FACEBOOK LOGIN (GET semua)
Route::get('/login/facebook', [AuthController::class, 'redirectToFacebook'])
    ->name('login.facebook');

Route::get('/login/facebook/callback', [AuthController::class, 'handleFacebookCallback'])
    ->name('login.facebook.callback');

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
    Route::get('/order/{orderNumber}/snap-token', [OrderController::class, 'createSnapToken'])->name('order.snap-token');
    Route::get('/order/{orderNumber}/check-status', [OrderController::class, 'checkPaymentStatus'])->name('order.check-status');
    Route::post('/order/{orderNumber}/cancel', [OrderController::class, 'cancelOrder'])->name('order.cancel');
    Route::post('/order/{orderNumber}/cancel-payment', [OrderController::class, 'cancelPayment'])->name('order.cancel-payment');
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
    Route::get('/dashboard', [App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])->name('dashboard');

    // Student Management
    Route::get('/students', [AdminStudentController::class, 'index'])->name('students.index');
    Route::get('/students/{id}', [AdminStudentController::class, 'show'])->name('students.show');
    Route::delete('/students/{id}', [AdminStudentController::class, 'destroy'])->name('students.destroy');
    Route::post('/students/bulk-delete', [AdminStudentController::class, 'bulkDelete'])->name('students.bulk-delete');
    Route::post('/students/{id}/suspend', [AdminStudentController::class, 'suspend'])->name('students.suspend');
    Route::patch('/students/{id}/activate', [AdminStudentController::class, 'activate'])->name('students.activate');
    Route::get('/students/export', [AdminStudentController::class, 'export'])->name('students.export');

    // Program Management (CRUD)
    Route::resource('programs', AdminProgramController::class);

    // Class/Program Management
    Route::get('/classes', [AdminClassController::class, 'index'])->name('classes.index');
    Route::get('/classes/create', [AdminClassController::class, 'create'])->name('classes.create');
    Route::post('/classes', [AdminClassController::class, 'store'])->name('classes.store');
    Route::get('/classes/{id}', [AdminClassController::class, 'show'])->name('classes.show');
    Route::get('/classes/{id}/edit', [AdminClassController::class, 'edit'])->name('classes.edit');
    Route::put('/classes/{id}', [AdminClassController::class, 'update'])->name('classes.update');
    Route::delete('/classes/{id}', [AdminClassController::class, 'destroy'])->name('classes.destroy');
    
    // Material Management for Classes
    Route::post('/classes/{id}/materials', [AdminClassController::class, 'storeMaterial'])->name('classes.materials.store');
    Route::delete('/classes/{programId}/materials/{materialId}', [AdminClassController::class, 'deleteMaterial'])->name('classes.materials.destroy');

    Route::view('/questions', 'admin.questions.index')->name('questions.index');

    // Payment Management
    Route::get('/payments', [AdminPaymentController::class, 'index'])->name('payments.index');
    Route::get('/payments/{id}', [AdminPaymentController::class, 'show'])->name('payments.show');
    Route::post('/payments/{id}/approve', [AdminPaymentController::class, 'approve'])->name('payments.approve');
    Route::post('/payments/{id}/reject', [AdminPaymentController::class, 'reject'])->name('payments.reject');
    Route::get('/payments/{id}/proof', [AdminPaymentController::class, 'viewProof'])->name('payments.proof');

    // Course/Material Management
    Route::get('/courses', [AdminCourseController::class, 'index'])->name('courses.index');
    Route::get('/courses/create', [AdminCourseController::class, 'create'])->name('courses.create');
    Route::post('/courses', [AdminCourseController::class, 'store'])->name('courses.store');
    Route::get('/courses/{course}', [AdminCourseController::class, 'show'])->name('courses.show');
    Route::get('/courses/{course}/edit', [AdminCourseController::class, 'edit'])->name('courses.edit');
    Route::put('/courses/{course}', [AdminCourseController::class, 'update'])->name('courses.update');
    Route::delete('/courses/{course}', [AdminCourseController::class, 'destroy'])->name('courses.destroy');
    Route::delete('/courses/{course}/file', [AdminCourseController::class, 'deleteFile'])->name('courses.file.delete');

    Route::view('/statistics', 'admin.statistics')->name('statistics');
});

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminPaymentController;
use App\Http\Controllers\Admin\AdminStudentController;

// =================== PUBLIC PAGES ===================
Route::view('/', 'pages.home')->name('home');
Route::view('/layanan', 'pages.layanan')->name('layanan');
Route::view('/bimbel-ukom-d3-farmasi', 'pages.bimbel-ukom')->name('bimbel.ukom');
Route::view('/cpns-p3k-farmasi', 'pages.cpns-p3k')->name('cpns.p3k');
Route::view('/joki-tugas-farmasi', 'pages.joki-tugas')->name('joki.tugas');
Route::view('/testimoni', 'pages.testimoni')->name('testimoni');
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

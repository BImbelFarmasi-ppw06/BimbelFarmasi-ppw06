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
use App\Http\Controllers\Admin\AdminProgramController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\HealthCheckController;

/*
|--------------------------------------------------------------------------
| Web Routes - Bimbel Farmasi
|--------------------------------------------------------------------------
|
| File ini berisi definisi semua route untuk website Bimbel Farmasi.
| Route dikelompokkan berdasarkan fungsi dan level akses:
| - Public: Dapat diakses tanpa login
| - Auth: Membutuhkan login user
| - Admin: Membutuhkan login sebagai admin
|
*/

// =================== HEALTH CHECK ENDPOINTS ===================
// Endpoint untuk monitoring kesehatan aplikasi dan server
Route::get('/ping', [HealthCheckController::class, 'ping'])->name('health.ping'); // Cek server hidup/mati
Route::get('/health', [HealthCheckController::class, 'health'])->name('health.check'); // Cek status database & sistem

// =================== PUBLIC PAGES ===================
// Halaman-halaman yang dapat diakses oleh siapa saja tanpa login
Route::view('/', 'pages.home')->name('home'); // Halaman beranda
Route::view('/layanan', 'pages.layanan')->name('layanan'); // Halaman daftar layanan
Route::view('/bimbel-ukom-d3-farmasi', 'pages.bimbel-ukom')->name('bimbel.ukom'); // Halaman program UKOM D3 Farmasi

// Webhook Midtrans - Notifikasi status pembayaran dari payment gateway (tidak butuh autentikasi)
Route::post('/midtrans/notification', [OrderController::class, 'handleNotification'])->name('midtrans.notification');

Route::view('/cpns-p3k-farmasi', 'pages.cpns-p3k')->name('cpns.p3k'); // Halaman program CPNS & P3K Farmasi
Route::view('/joki-tugas-farmasi', 'pages.joki-tugas')->name('joki.tugas'); // Halaman layanan Joki Tugas
Route::get('/testimoni', [TestimonialController::class, 'index'])->name('testimonials.index'); // Halaman daftar testimoni
Route::view('/kontak', 'pages.kontak')->name('kontak'); // Halaman kontak
Route::post('/kontak', [ContactController::class, 'store'])->name('contact.store'); // Proses submit form kontak

// ⚠️ Route lama sudah dihapus - diganti dengan controller redirect ke Google OAuth
// =================== USER AUTH ===================
// Route autentikasi untuk user (login, register, logout)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login'); // Tampilkan form login
Route::post('/login', [AuthController::class, 'login'])->name('login.submit'); // Proses login

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register'); // Tampilkan form registrasi
Route::post('/register', [AuthController::class, 'register'])->name('register.submit'); // Proses registrasi

Route::post('/logout', [AuthController::class, 'logout'])->name('logout'); // Proses logout

// 🔹 GOOGLE OAUTH LOGIN - Login menggunakan akun Google
Route::get('/login/google', [AuthController::class, 'redirectToGoogle'])
    ->name('login.google'); // Redirect ke halaman login Google

Route::get('/login/google/callback', [AuthController::class, 'handleGoogleCallback'])
    ->name('login.google.callback'); // Callback setelah user login di Google

// =================== USER PROTECTED ROUTES ===================
// Semua route di dalam grup ini membutuhkan user sudah login (middleware: auth)
Route::middleware('auth')->group(function () {
    
    // === PROFIL & PENGATURAN AKUN ===
    Route::get('/profil', [UserController::class, 'profile'])->name('user.profile'); // Halaman profil user
    Route::post('/profil', [UserController::class, 'updateProfile'])->name('user.profile.update'); // Update data profil

    Route::get('/layanan-saya', [UserController::class, 'myServices'])->name('user.services'); // Daftar program yang sudah dibeli
    Route::get('/riwayat-transaksi', [UserController::class, 'transactions'])->name('user.transactions'); // Riwayat transaksi pembelian

    // === PROGRAM PEMBELAJARAN ===
    // Route untuk mengakses konten program yang sudah dibeli
    Route::get('/program/{id}', [UserController::class, 'accessProgram'])->name('program.access'); // Dashboard program
    Route::get('/program/{id}/materi', [UserController::class, 'materials'])->name('program.materials'); // Materi pembelajaran
    Route::get('/program/{id}/jadwal', [UserController::class, 'schedule'])->name('program.schedule'); // Jadwal kelas
    Route::get('/program/{id}/diskusi', [UserController::class, 'discussion'])->name('program.discussion'); // Forum diskusi
    
    // === LATIHAN SOAL ===
    Route::get('/program/{id}/latihan-soal', [UserController::class, 'exercises'])->name('program.exercises'); // Daftar bank soal latihan
    Route::get('/program/{id}/latihan-soal/{exerciseId}', [UserController::class, 'startExercise'])->name('program.exercise.start'); // Mulai mengerjakan latihan soal
    Route::post('/program/{id}/latihan-soal/{exerciseId}/submit', [UserController::class, 'submitExercise'])->name('program.exercise.submit'); // Submit jawaban latihan
    
    // === TRY OUT (UJIAN SIMULASI) ===
    Route::get('/program/{id}/try-out', [UserController::class, 'tryouts'])->name('program.tryouts'); // Daftar try out
    Route::get('/program/{id}/try-out/{tryoutId}', [UserController::class, 'startTryout'])->name('program.tryout.start'); // Mulai mengerjakan try out
    Route::post('/program/{id}/try-out/{tryoutId}/submit', [UserController::class, 'submitTryout'])->name('program.tryout.submit'); // Submit jawaban try out
    Route::get('/program/{id}/hasil/{resultId}', [UserController::class, 'viewResult'])->name('program.result'); // Lihat hasil & pembahasan

    // === PENGATURAN AKUN ===
    Route::get('/pengaturan', [UserController::class, 'settings'])->name('user.settings'); // Halaman pengaturan
    Route::post('/pengaturan/password', [UserController::class, 'updatePassword'])->name('user.password.update'); // Ganti password
    Route::delete('/pengaturan/akun', [UserController::class, 'deleteAccount'])->name('user.account.delete'); // Hapus akun permanen

    // === PEMESANAN & PEMBAYARAN ===
    Route::get('/order/{slug}', [OrderController::class, 'create'])->name('order.create'); // Form pemesanan program
    Route::post('/order', [OrderController::class, 'store'])->name('order.store'); // Proses pembuatan pesanan
    Route::get('/order/{orderNumber}/payment', [OrderController::class, 'payment'])->name('order.payment'); // Halaman pembayaran
    Route::post('/order/{orderNumber}/payment', [OrderController::class, 'processPayment'])->name('order.payment.process'); // Proses pembayaran (upload bukti/Midtrans)
    Route::get('/order/{orderNumber}/snap-token', [OrderController::class, 'createSnapToken'])->name('order.snap-token'); // Generate Midtrans payment token
    Route::get('/order/{orderNumber}/check-status', [OrderController::class, 'checkPaymentStatus'])->name('order.check-status'); // Cek status pembayaran real-time
    Route::get('/order/{orderNumber}/success', [OrderController::class, 'success'])->name('order.success'); // Halaman sukses setelah pembayaran
    Route::get('/pesanan-saya', [OrderController::class, 'myOrders'])->name('order.my-orders'); // Daftar semua pesanan user

    // === TESTIMONI ===
    Route::get('/testimoni-saya', [TestimonialController::class, 'myTestimonials'])->name('testimonials.myTestimonials'); // Daftar testimoni yang sudah dibuat
    Route::get('/order/{orderNumber}/testimoni/create', [TestimonialController::class, 'create'])->name('testimonials.create'); // Form buat testimoni untuk pesanan tertentu
    Route::post('/order/{orderNumber}/testimoni', [TestimonialController::class, 'store'])->name('testimonials.store'); // Simpan testimoni baru
    Route::get('/testimoni/{id}/edit', [TestimonialController::class, 'edit'])->name('testimonials.edit'); // Form edit testimoni
    Route::put('/testimoni/{id}', [TestimonialController::class, 'update'])->name('testimonials.update'); // Update testimoni
    Route::delete('/testimoni/{id}', [TestimonialController::class, 'destroy'])->name('testimonials.destroy'); // Hapus testimoni
});

// =================== ADMIN AUTH ===================
// Route autentikasi khusus untuk admin (prefix: /admin)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login'); // Halaman login admin
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit'); // Proses login admin
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout'); // Logout admin
});
// =================== ADMIN PROTECTED PAGES ===================
// Semua route di dalam grup ini membutuhkan login sebagai admin (middleware: admin)
// URL diawali dengan /admin (prefix: admin)
Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
    
    // === DASHBOARD & MONITORING ===
    Route::get('/dashboard', [App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])->name('dashboard'); // Dashboard admin dengan statistik
    Route::get('/metrics', [HealthCheckController::class, 'metrics'])->name('metrics'); // Metrics sistem (CPU, memory, database)

    // === MANAJEMEN SISWA/USER ===
    Route::get('/students', [AdminStudentController::class, 'index'])->name('students.index'); // Daftar semua siswa
    Route::get('/students/{id}', [AdminStudentController::class, 'show'])->name('students.show'); // Detail siswa & riwayat belajar
    Route::delete('/students/{id}', [AdminStudentController::class, 'destroy'])->name('students.destroy'); // Hapus siswa
    Route::post('/students/bulk-delete', [AdminStudentController::class, 'bulkDelete'])->name('students.bulk-delete'); // Hapus banyak siswa sekaligus
    Route::post('/students/{id}/suspend', [AdminStudentController::class, 'suspend'])->name('students.suspend'); // Suspend/non-aktifkan akun siswa
    Route::patch('/students/{id}/activate', [AdminStudentController::class, 'activate'])->name('students.activate'); // Aktifkan kembali akun siswa
    Route::get('/students/export', [AdminStudentController::class, 'export'])->name('students.export'); // Export data siswa ke Excel/CSV

    // === MANAJEMEN PROGRAM (CRUD) ===
    Route::resource('programs', AdminProgramController::class); // CRUD lengkap untuk program (create, read, update, delete)

    // === MANAJEMEN KELAS/PROGRAM ===
    Route::get('/classes', [AdminClassController::class, 'index'])->name('classes.index'); // Daftar semua kelas/program
    Route::get('/classes/create', [AdminClassController::class, 'create'])->name('classes.create'); // Form tambah kelas baru
    Route::post('/classes', [AdminClassController::class, 'store'])->name('classes.store'); // Simpan kelas baru
    Route::get('/classes/{id}', [AdminClassController::class, 'show'])->name('classes.show'); // Detail kelas
    Route::get('/classes/{id}/edit', [AdminClassController::class, 'edit'])->name('classes.edit'); // Form edit kelas
    Route::put('/classes/{id}', [AdminClassController::class, 'update'])->name('classes.update'); // Update data kelas
    Route::delete('/classes/{id}', [AdminClassController::class, 'destroy'])->name('classes.destroy'); // Hapus kelas

    // === MANAJEMEN BANK SOAL ===
    Route::view('/questions', 'admin.questions.index')->name('questions.index'); // Halaman kelola bank soal

    // === MANAJEMEN PEMBAYARAN ===
    Route::get('/payments', [AdminPaymentController::class, 'index'])->name('payments.index'); // Daftar semua pembayaran (pending, approved, rejected)
    Route::get('/payments/{id}', [AdminPaymentController::class, 'show'])->name('payments.show'); // Detail pembayaran
    Route::post('/payments/{id}/approve', [AdminPaymentController::class, 'approve'])->name('payments.approve'); // Approve/terima pembayaran
    Route::post('/payments/{id}/reject', [AdminPaymentController::class, 'reject'])->name('payments.reject'); // Reject/tolak pembayaran
    Route::get('/payments/{id}/proof', [AdminPaymentController::class, 'viewProof'])->name('payments.proof'); // Lihat bukti pembayaran (gambar)

    // === STATISTIK & LAPORAN ===
    Route::view('/statistics', 'admin.statistics')->name('statistics'); // Halaman statistik & laporan lengkap
});

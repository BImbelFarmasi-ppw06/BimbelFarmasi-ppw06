<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProgramController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\DriveController;


//  API sederhana dengan 3 endpoint utama:
//  GET /api/v1/programs          -> Lihat semua program bimbel
// GET /api/v1/programs/{slug}   -> Detail program tertentu
// POST /api/v1/contact          -> Kirim pesan kontak

Route::prefix('v1')->group(function () {
    
    
    Route::get('/programs', [ProgramController::class, 'index']);
    
    
    Route::get('/programs/{slug}', [ProgramController::class, 'show']);
    

    Route::post('/contact', [\App\Http\Controllers\ContactController::class, 'store']);
    

    Route::get('/calendar/events', [CalendarController::class, 'getEvents']);
    

    Route::get('/drive/files', [DriveController::class, 'listFiles']);
});

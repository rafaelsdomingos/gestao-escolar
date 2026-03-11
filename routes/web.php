<?php

use Illuminate\Support\Facades\Route;
use App\Filament\Pages\RegisterAttendance;
use App\Filament\Pages\RegisterWorkshopAttendance;
use App\Http\Controllers\PdfController;

// Route::get('/', function () {
//     return redirect('/admin');
// });

Route::get('/pages/welcome', function () {
     return view('welcome');
});

Route::get('register-attendance/{lesson_id}}', RegisterAttendance::class)
    ->name('filament.pages.register-attendance')
    ->middleware(['auth']);

Route::get('register-workshop-attendance/{workshop_lesson_id}}', RegisterWorkshopAttendance::class)
    ->name('filament.pages.register-workshop-attendance')
    ->middleware(['auth']); 

Route::get('/reports/workshop-attendance-blank/{workshop}/month/{month}', [PdfController::class, 'blankWorkshopAttendance'])
    ->name('reports.workshop-attendance-blank')
    ->middleware(['auth']);

Route::get('/reports/workshop-attendance/{workshop}/month/{month}', [PdfController::class, 'workshopAttendance'])
    ->name('reports.workshop-attendance')
    ->middleware(['auth']);

Route::get('/reports/attendance-blank/{subjectClass}/month/{month}', [PdfController::class, 'blankAttendance'])
    ->name('reports.attendance-blank')
    ->middleware(['auth']);

Route::get('/reports/attendance/{subjectClass}/month/{month}', [PdfController::class, 'attendance'])
    ->name('reports.attendance')
    ->middleware(['auth']);
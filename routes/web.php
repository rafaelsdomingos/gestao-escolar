<?php

use Illuminate\Support\Facades\Route;
use App\Filament\Pages\RegisterAttendance;
use App\Filament\Pages\RegisterWorkshopAttendance;

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
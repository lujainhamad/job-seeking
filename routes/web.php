<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\ResumeController;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/resume/view', [ResumeController::class, 'viewHtml'])->name('resume.view');
    Route::get('/resume/download', [ResumeController::class, 'downloadPdf'])->name('resume.download');
});


Route::get('/test-resume', function () {
    return view('resume-test');
});


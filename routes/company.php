<?php

use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Company\AuthController;
use App\Http\Controllers\Company\EducationController;
use App\Http\Controllers\Company\JobController;
use App\Http\Controllers\Company\JobOfferDateController;
use App\Http\Controllers\Company\ChatController;
use App\Http\Controllers\User\LanguageController;
use App\Http\Controllers\User\ResumeController;
use App\Http\Controllers\User\SkillController;
use App\Http\Middleware\ApiLocalization;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => [ApiLocalization::class]], function () {
    Route::get('/hello',function(){
        return 'ger';
    });
});

 Route::group(['prefix' => 'auth'], function () {
        Route::post('register', [AuthController::class, 'register']);
        Route::post('login', [AuthController::class, 'login']);
    });

Route::middleware([ApiLocalization::class,'auth:sanctum'])->group(function () {
   

    Route::apiResource('job-offers',JobController::class);

    Route::get('educations',[EducationController::class,'index']);
    Route::post('interview',[JobController::class,'createInerview']);
    Route::post('submit-interview/{id}',[JobController::class,'submitInterview']);
    Route::post('reject-interview/{id}',[JobController::class,'rejectInterview']);

    Route::get('profile', [AuthController::class, 'getProfile']);
    Route::put('update-profile', [AuthController::class, 'updateProfile']);
    


    Route::post('accept-user/{id}',[JobController::class,'acceptUser']);

    Route::get('employees',[CompanyController::class,'employees']);

    Route::get('interviews',[JobController::class,'interviews']);
    Route::get('user/{id}',[JobController::class,'userById']);


    Route::post('rate-user/{id}', [CompanyController::class, 'rateUser']);

    Route::get('resume-compatibility/{id}', [CompanyController::class, 'calculateResumeCompatibility']);
    Route::get('chats',[ChatController::class,'index']); 
    Route::get('chats/users',[ChatController::class,'usersChats']); 
    Route::post('send-message',[ChatController::class,'store']);




    Route::post('job-offers-dates',[JobOfferDateController::class,'store']);
    Route::get('languages',[LanguageController::class,'index']);
    Route::get('skills',[SkillController::class,'index']);
});

Route::get('/cv/view/{id}', [ResumeController::class, 'viewHtml']);
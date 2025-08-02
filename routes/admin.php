<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\ProblemReportController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Middleware\ApiLocalization;
use Illuminate\Support\Facades\Route;




Route::prefix('auth')->group(function(){
    
    Route::post('login',[AuthController::class,'login']);

});

Route::middleware([ApiLocalization::class,'auth:sanctum'])->group(function () {
   Route::get('problem-reports',[ProblemReportController::class,'index']); 
   Route::apiResource('companies',CompanyController::class);
   Route::apiResource('users',UserController::class);
   Route::get('statistics',[UserController::class,'statistics']);
   Route::get('most-wanted',[UserController::class,'mostWanted']);
   Route::post('response/{problem_report}',[ProblemReportController::class,'responed']);


   
});
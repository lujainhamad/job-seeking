<?php

use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\ProblemReportController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Company\EducationController;
use App\Http\Controllers\Company\JobController;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\ChatController;
use App\Http\Controllers\User\JobOfferDateController;
use App\Http\Controllers\User\LanguageController;
use App\Http\Controllers\User\ResumeController;
use App\Http\Controllers\User\SkillController;
use App\Http\Middleware\ApiLocalization;
use App\Models\Language;
use App\Models\Resume;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post(
    '/test',
    function (Request $request) {

        $request->validate([
            'word' => 'required|string'
        ]);

        $word = $request->input('word');

        $response = Http::get("https://api.datamuse.com/words?ml={$word}");

       
        if ($response->successful()) {
            $words = collect($response->json())->pluck('word')->take(10);
            return response()->json([
                'word' => $word,
                'similar_words' => $words
            ]);
        }

        return response()->json(['error' => 'Failed to fetch similar words'], 500);
    }


);

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
});
Route::middleware([ApiLocalization::class, 'auth:sanctum'])->group(function () {
    Route::prefix('job-offers')->group(function () {
        Route::get('/', [JobController::class, 'index']);
        Route::get('/my-jobs', [JobController::class, 'myJobs']);
        Route::get('/search', [JobController::class, 'search']);
        Route::get('/{job_offer}', [JobController::class, 'show']);
        Route::post('/apply/{id}', [JobController::class, 'apply']);
        Route::post('/choose-date', [JobController::class, 'chooseDate']);
    });

    Route::post('favorites/{id}', [UserController::class, 'favorites']);
    Route::post('unfavorites/{id}', [UserController::class, 'unfavorites']);

    Route::put('update-profile', [AuthController::class, 'updateProfile']);
    Route::get('profile', [AuthController::class, 'getProfile']);


    Route::post('rate-company/{id}', [UserController::class, 'rateCompany']);


    Route::get('job-offers-dates', [JobOfferDateController::class, 'index']);
    Route::get('/companies', [CompanyController::class, 'index']);
    Route::get('/companies/{company}', [CompanyController::class, 'show']);

    Route::get('languages', [LanguageController::class, 'index']);
    Route::get('skills', [SkillController::class, 'index']);
    Route::get('educations',[EducationController::class,'index']);


    Route::get('user-interviews', [JobController::class, 'userInterviews']);

    Route::get('most-published', [UserController::class, 'mostPublished']);

    Route::post('problem-reports', [ProblemReportController::class, 'store']);

    Route::get('chats', [ChatController::class, 'index']);

    Route::post('send-message', [ChatController::class, 'store']);






    Route::prefix('resumes')->group(function () {
        Route::post('/', [ResumeController::class, 'store']);
        Route::get('/my-cv', [ResumeController::class, 'myCv']);
        Route::get('/view/{id}', [ResumeController::class, 'viewHtml']);
        
    });
});

Route::get('resumes/download-pdf/{id}', [ResumeController::class, 'downloadPdf']);
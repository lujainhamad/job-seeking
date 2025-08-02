<?php

namespace App\Providers;

use App\Models\Company;
use App\Models\Job;
use App\Models\ProblemReport;
use App\Models\Resume;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Cache\RateLimiting\Limit;



class RouteServiceProvider extends ServiceProvider
{

    public function register(): void
    {
         Route::bind('company', function ($value) {
            return Company::findOrFail($value);
        });
        Route::bind('problem_report', function ($value) {
            return ProblemReport::findOrFail($value);
        });
        Route::bind('job_offer', function ($value) {
            return Job::findOrFail($value);
        });
         Route::bind('resume', function ($value) {
            return Resume::findOrFail($value);
        });
    }


    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}

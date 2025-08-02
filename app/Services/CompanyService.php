<?php

namespace App\Services;

use App\Models\Company;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CompanyService extends BaseService
{


    public function __construct()
    {
        $this->model = Company::class;
        $this->relations = ['jobOffers'];
    }

    public function rateUser($data, $id)
    {
        $rating = $data['rating'];
        $user = User::find($id);
        $companyId = auth()->guard('company')->user()->id;
        $company = Company::find($companyId);
        
       
        $existingRating = $user->companyRatings()->where('company_id', $companyId)->first();
        
        if ($existingRating) {
            $user->companyRatings()->updateExistingPivot($companyId, ['rating' => $rating]);
        } else {
            $user->companyRatings()->attach($companyId, ['rating' => $rating]);
        }
        
        return true;
    }

    public function employees()
{
    $companyId = auth('company')->user()->id;

    $userIds = DB::table('job_offers_users')
        ->join('jobs_offers', 'job_offers_users.job_offer_id', '=', 'jobs_offers.id')
        ->where('jobs_offers.company_id', $companyId)
        ->where('job_offers_users.is_approved', 1)
        ->pluck('job_offers_users.user_id');

    $users = User::whereIn('id', $userIds)->get();

    return $users;
}

    function calculateResumeCompatibility($job, $resume)
    {
     
        $requiredSkills = $job->skills->pluck('id')->toArray();
        $resumeSkills = $resume->skills->pluck('id')->toArray();
        $matchedSkills = count(array_intersect($requiredSkills, $resumeSkills));
        $skillsScore = count($requiredSkills) > 0 ? $matchedSkills / count($requiredSkills) : 1;

        $jobEducation = $job->education->pluck('id')->toArray();
        $resumeEducation = $resume->educations->pluck('id')->toArray();
        $educationScore = count(array_intersect($jobEducation, $resumeEducation)) > 0 ? 1 : 0;

        $resumeYears = $resume->experiences->reduce(function ($carry, $exp) use ($job) {
            $start = Carbon::parse($exp->start_date);
            $end = $exp->end_date ? Carbon::parse($exp->end_date) : Carbon::now();

            $diffInYears = $start->diffInDays($end) / 365;
            $isBelong = $exp->where('name', 'LIKE', '%'.$job->job_title.'%')->where('id',$exp->id)->first();
            if ($isBelong) {
                 return $carry + $diffInYears;
            }else {
                return $carry;
            }
            
        }, 0);

        $resumeYears = round($resumeYears, 1);
        $experienceScore = $job->experience > 0 ? min($resumeYears / $job->experience, 1) : 1;

     
        $requiredLanguages = $job->languages->pluck('id')->toArray();
        $resumeLanguages = $resume->languages->pluck('id')->toArray();
        $matchedLanguages = count(array_intersect($requiredLanguages, $resumeLanguages));
        $languageScore = count($requiredLanguages) > 0 ? $matchedLanguages / count($requiredLanguages) : 1;

        $weightSum = $job->skills_weight + $job->education_weight + $job->experience_weight + $job->lang_weight;

        $totalScore = (
            $skillsScore * $job->skills_weight +
            $educationScore * $job->education_weight +
            $experienceScore * $job->experience_weight +
            $languageScore * $job->lang_weight
        ) / $weightSum;

        return round($totalScore * 100, 2);
    }
}

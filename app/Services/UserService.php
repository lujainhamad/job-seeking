<?php

namespace App\Services;

use App\Models\Company;
use App\Models\Job;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserService extends BaseService
{


    public function __construct()
    {
        $this->model = User::class;
        $this->relations = ['favorites','jobOffers'];
    }


    public function statistics()
    {
        $companies = Company::count();
        $users = User::count();
        $jobs = Job::count();

        return [
            'companies' => $companies,
            'users' => $users,
            'jobs' => $jobs,
        ];
    }

    public function mostWanted()
    {
        $jobIds = DB::table('job_offers_users')
            ->select('job_offer_id', DB::raw('COUNT(*) as total'))
            ->groupBy('job_offer_id')
            ->orderByDesc('total')
            ->pluck('job_offer_id');

        if ($jobIds->isNotEmpty()) {
            $orderedIds = $jobIds->implode(',');

            $jobs = Job::whereIn('id', $jobIds)
                ->orderByRaw("FIELD(id, $orderedIds)")
                ->get();
        } else {
            $jobs = collect(); 
        }

        return $jobs;
    }

    public function favorites($id)
    {
        $user = Auth::user();
        $user->favorites()->attach($id);
        return true;
    }

    public function unfavorites($id)
    {
        $user = Auth::user();
        $user->favorites()->detach($id);
        return true;
    }

    public function rateCompany($data, $id)
    {
        $rating = $data['rating'];
        $company = Company::find($id);
        $userId = Auth::id();
        
        $existingRating = $company->userRatings()->where('user_id', $userId)->first();
        
        if ($existingRating) {
            $company->userRatings()->updateExistingPivot($userId, ['rating' => $rating]);
        } else {
            $company->userRatings()->attach($userId, ['rating' => $rating]);
        }
        
        return true;
    }

    public function mostPublished()
    {
        $offers = DB::table('jobs_offers as a')
            ->select('a.*')
            ->selectSub(function ($query) {
                $query->from('jobs_offers as b')
                    ->selectRaw('COUNT(*)')
                    ->whereRaw('b.job_title LIKE CONCAT("%", a.job_title, "%")');
            }, 'published_count')
            ->orderByDesc('published_count')
            ->get();

        return $offers;
    }
}

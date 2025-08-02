<?php

namespace App\Services;

use App\Exceptions\UnAuthorizedException;
use App\Exceptions\UnVerifiedException;
use App\Helpers\Transaction;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Throwable;

class AuthService
{

    public function register($req)
    {
        return Transaction::run(function () use ($req) {
            foreach ($req as $key => $value) {
                try {
                    if (file_exists($value)) {
                        $req[$key] = StorageService::storeFile($value, 'images/user/');
                    }
                } catch (Throwable $e) {
                }
            }
            $comapny = User::create($req);
            $comapny->access_token = $comapny->createToken('API')->plainTextToken;
            return new UserResource($comapny);
        });
    }

    public function updateProfile($req){
        return Transaction::run(function () use ($req) {
            foreach($req as $key => $value){
                try{
                    if(file_exists($value)){
                        $req[$key] = StorageService::storeFile($value,'images/user/');
                    }
                }catch(Throwable $e){}
            }
            $user = auth()->user();
            $user->update($req);
            
            return new UserResource($user);
        });
    }

    public static function Login($req)
    {
        $user = User::where('email', $req->email)->first();
        if (Auth::attempt([
            'email' => $req->email,
            'password' => $req->password
        ])) {

            $user->access_token = $user->createToken('API')->plainTextToken;
            return $user;
        } else {
            throw new UnAuthorizedException();
        }
        return false;
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

        $resumeYears = $resume->experiences->reduce(function ($carry, $exp) {
            $start = Carbon::parse($exp->start_date);
            $end = $exp->end_date ? Carbon::parse($exp->end_date) : Carbon::now();

            $diffInYears = $start->diffInDays($end) / 365;
            return $carry + $diffInYears;
        }, 0);

        $resumeYears = round($resumeYears, 1);
        $experienceScore = $job->experience > 0 ? min($resumeYears / $job->experience, 1) : 1;

        $weightSum = $job->skills_weight + $job->education_weight + $job->experience_weight;

        $totalScore = (
            $skillsScore * $job->skills_weight +
            $educationScore * $job->education_weight +
            $experienceScore * $job->experience_weight
        ) / $weightSum;

        return round($totalScore * 100, 2);
    }

    public function getProfile(){
        $user = auth()->user();
        return new UserResource($user);
    }
}

<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Company\CompanyResource;
use App\Http\Resources\Resume\ResumeResource;
use App\Services\StorageService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'birthdate' => $this->birthdate,
            'logo' => StorageService::urlOf($this->logo),
            'phone' => $this->phone,
            'favorites' => CompanyResource::collection($this->favorites),
            'average_rating' => round($this->companyRatings()->avg('company_ratings.rating'), 2),
            'access_token' => $this->access_token,
            'resume' => ResumeResource::make($this->resume)
        ];
    }
}

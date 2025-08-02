<?php

namespace App\Http\Resources\Company;

use App\Http\Resources\JobResource;
use App\Services\StorageService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class CompanyResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'address' => $this->address,
            'logo' => StorageService::urlOf($this->logo),
            'file' => StorageService::urlOf($this->file),
            'token' => $this->access_token,
            'is_active' => $this->is_active,
            'job_offers' => JobResource::collection($this->whenLoaded('jobOffers')),
            'average_rating' => round($this->userRatings()->avg('user_ratings.rating')),
            'is_favorited' => Auth::guard('users')->check()
            ? Auth::user()->favorites->contains($this->id)
            : false,
            'user_rating' => $this->userRatings->first()?->pivot->rating ?? null,
        ];
    }
}

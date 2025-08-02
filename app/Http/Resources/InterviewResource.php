<?php

namespace App\Http\Resources;

use App\Http\Resources\Resume\ResumeResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InterviewResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'job_offer_id' => $this->job_offer_id,
            'interview_date' => $this->interview_date,
            'interview_status' => $this->interview_status,
            'user' => UserResource::make($this->user),
            'resume' => ResumeResource::make($this->user->resume),
            'job_offer' => JobResource::make($this->jobOffer),
            'is_approved' => (boolean) $this->is_approved
        ];
    }
}

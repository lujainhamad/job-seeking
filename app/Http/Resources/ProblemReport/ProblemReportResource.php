<?php

namespace App\Http\Resources\ProblemReport;

use App\Http\Resources\JobResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProblemReportResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'job_offer_id' => $this->job_offer_id,
            'description' => $this->description,
            'job_offer' => new JobResource($this->jobOffer),
            'user' => $this->user,
            'response' => $this->response,
            // 'created_at' => $this->created_at
        ];
    }
}

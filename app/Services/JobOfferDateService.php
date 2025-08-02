<?php

namespace App\Services;

use App\Helpers\Transaction;
use App\Http\Pipelines\JobOfferDate\JobOfferDatePipeline;
use App\Http\Resources\JobOfferDateResource;
use App\Models\JobOfferDate;
use Throwable;

class JobOfferDateService extends BaseService
{


    public function __construct()
    {
        $this->model = JobOfferDate::class;
        $this->pipeline = JobOfferDatePipeline::class;
        $this->relations = ['jobOffer'];
    }

    public function create($data)
    {
        return Transaction::run(function () use ($data) {
            foreach ($data as $key => $value) {
                try {
                    if (file_exists($value)) {
                        $data[$key] = StorageService::storeFile($value, $this->storagePath);
                    }
                } catch (Throwable $e) {
                }
            }
            if (!empty($data['dates'])) {
                foreach ($data['dates'] as $date) {
                    $object = $this->model::create([
                        'job_offer_id' => $data['job_offer_id'],
                        'date' => $date,
                    ]);
                }
            }
           
            $dates = JobOfferDate::where('job_offer_id', $data['job_offer_id'])->get();
    

            return JobOfferDateResource::collection($dates);
        });
    }
}

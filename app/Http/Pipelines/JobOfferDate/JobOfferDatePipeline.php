<?php

namespace App\Http\Pipelines\JobOfferDate;

use App\Http\Pipelines\EqualFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Routing\Pipeline;

class JobOfferDatePipeline extends Pipeline {

    protected function pipes():array
    {
        return [
            new EqualFilter('job_offer_id')
        ];
    }

    public static function make(Builder $builder): Builder
    {
        return app(static::class)
            ->send($builder)
            ->thenReturn();
    }

}

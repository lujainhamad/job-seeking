<?php

namespace App\Http\Pipelines\Job;

use App\Http\Pipelines\EqualFilter;
use App\Http\Pipelines\Job\Filters;
use App\Http\Pipelines\Job\Filters\JobTitleMatchFilter;
use App\Http\Pipelines\Job\Filters\JobTypeOrder;
use App\Http\Pipelines\LikeFilter;
use App\Http\Pipelines\Job\Filters\MaxSalaryFilter;
use App\Http\Pipelines\Job\Filters\MinSalaryFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Routing\Pipeline;

class JobPipeline extends Pipeline {

    protected function pipes():array
    {
        return [
            new EqualFilter('job_level'),
            new EqualFilter('company_id'),
            new EqualFilter('job_type'),
            new MinSalaryFilter('min_salary', 'salary'),
            new MaxSalaryFilter(),
            new JobTitleMatchFilter()

         

        ];
    }

    public static function make(Builder $builder): Builder
    {
        return app(static::class)
            ->send($builder)
            ->thenReturn();
    }

}

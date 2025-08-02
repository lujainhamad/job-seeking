<?php

namespace App\Http\Pipelines\Resume;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Routing\Pipeline;

class ResumePipeline extends Pipeline {

    protected function pipes():array
    {
        return [
               
        ];
    }

    public static function make(Builder $builder): Builder
    {
        return app(static::class)
            ->send($builder)
            ->thenReturn();
    }

}

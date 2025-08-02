<?php

namespace App\Http\Pipelines\Chat;

use App\Http\Pipelines\Chat\Filters\SenderFilter;
use App\Http\Pipelines\EqualFilter;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Routing\Pipeline;

class ChatPipeline extends Pipeline {

    protected function pipes():array
    {
        return [
            new SenderFilter()
        ];
    }

    public static function make(Builder $builder): Builder
    {
        return app(static::class)
            ->send($builder)
            ->thenReturn();
    }

}

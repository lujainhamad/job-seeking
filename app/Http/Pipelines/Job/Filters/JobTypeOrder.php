<?php

namespace App\Http\Pipelines\Chat\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class JobTypeOrder
{




    public function handle(Builder $builder, Closure $next)
    {
        
        return $next($builder);
    }
}

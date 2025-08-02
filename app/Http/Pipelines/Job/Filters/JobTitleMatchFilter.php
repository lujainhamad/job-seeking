<?php

namespace App\Http\Pipelines\Job\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class JobTitleMatchFilter
{
    protected string $guard;

    public function __construct(string $guard = 'users')
    {
        $this->guard = $guard;
    }

    public function handle(Builder $builder, Closure $next)
{
    $user = auth($this->guard)->user();

    if ($user && $user->resume) {
        $main = $user->resume->main_field;
        $second = $user->resume->second_field;

        
        $builder->orderByRaw("
            CASE
                WHEN job_title LIKE ? THEN 1
                WHEN job_title LIKE ? THEN 2
                ELSE 3
            END
        ", ["%{$main}%", "%{$second}%"]);
    }

    return $next($builder);
}

}

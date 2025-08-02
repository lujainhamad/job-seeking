<?php

namespace App\Http\Pipelines\Job\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class MaxSalaryFilter{


    protected $key;
    protected $column;

    public function __construct(string $key = 'max_salary', string $column = 'salary'){
        $this->key = $key;
        $this->column = $column ?? $key;
    }


    public function handle(Builder $builder, Closure $next)
    {
        $value = request()->get($this->key);

        if (isset($value)) {
            $builder->where($this->column, '<=', $value);
        }

        return $next($builder);
    }
}

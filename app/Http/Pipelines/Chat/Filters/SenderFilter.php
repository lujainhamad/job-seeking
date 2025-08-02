<?php

namespace App\Http\Pipelines\Chat\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class SenderFilter
{
    public function handle(Builder $builder, Closure $next)
    {
        $auth = Auth::user();

        if ($auth) {


            $authType = $auth instanceof \App\Models\Company ? 'company' : 'user';
        $oppositeType = $authType === 'company' ? 'user' : 'company';

        $withId = request()->get('with_id');

        if ($withId) {

            $builder->where(function ($query) use ($auth, $authType, $oppositeType, $withId) {
                $query->where(function ($q) use ($auth, $authType, $oppositeType, $withId) {
                    $q->where('sender_id', $auth->id)
                      ->where('sender_type', $authType)
                      ->where('receiver_id', $withId)
                      ->where('receiver_type', $oppositeType);
                })->orWhere(function ($q) use ($auth, $authType, $oppositeType, $withId) {
                    $q->where('receiver_id', $auth->id)
                      ->where('receiver_type', $authType)
                      ->where('sender_id', $withId)
                      ->where('sender_type', $oppositeType);
                });
            });
        } else {

            $builder->where(function ($query) use ($auth, $authType) {
                $query->where(function ($q) use ($auth, $authType) {
                    $q->where('sender_id', $auth->id)
                      ->where('sender_type', $authType);
                })->orWhere(function ($q) use ($auth, $authType) {
                    $q->where('receiver_id', $auth->id)
                      ->where('receiver_type', $authType);
                });
            });
        }




            
        }

        $builder->orderBy('created_at','desc');

        return $next($builder);
    }
}

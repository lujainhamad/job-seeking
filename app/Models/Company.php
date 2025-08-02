<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class Company extends Authenticatable
{
    use HasFactory, Notifiable,HasApiTokens;
    protected $fillable = [
        'name',
        'email',
        'password',
        'logo',
        'address',
        'is_active',
        'file'
    ];


    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at'
    ];


    protected $casts = [
        'password' => 'hashed',
    ];

    protected $attributes = [
        'is_active' => false
    ];

    public function userRatings(){
        return $this->belongsToMany(User::class,'user_ratings','company_id','user_id')->withPivot('rating');
    }


    public function jobOffers(): HasMany
    {
        return $this->hasMany(Job::class);
    }
}

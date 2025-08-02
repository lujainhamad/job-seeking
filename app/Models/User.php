<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{

    use HasFactory, Notifiable,HasApiTokens;


    protected $fillable = [
        'name',
        'email',
        'password',
        'birthdate',
        'phone',
        'fcm_token',
        'logo'
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function jobOffers(){
        return $this->belongsToMany(Job::class,'job_offers_users','user_id','job_offer_id')->withPivot(['interview_status','interview_date']);
    }

    public function favorites(){
        return $this->belongsToMany(Company::class,'favorites','user_id','company_id');
    }

    public function companyRatings(){
        return $this->belongsToMany(Company::class,'company_ratings','user_id','company_id')->withPivot('rating');
    }
    public function resume(){
        return $this->hasOne(Resume::class,'user_id');
    }
    public function notifications()
    {
        return $this->morphMany(Notification::class, 'notifiable');
    }
}

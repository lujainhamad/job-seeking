<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $table = 'jobs_offers';
    protected $fillable = [
        'company_id',
        'job_title',
        'salary',
        'experience',
        'age',
        'education_id',
        'job_type',
        'gender',
        'job_level',
        'application_deadline',
        'requirements',
        'skills_weight',
        'education_weight',
        'experience_weight',
        'lang_weight'
    ];   

    public $with = ['company'];

    public function education(){
        return $this->belongsTo(Education::class,'education_id');
    }

    public function skills(){
        return $this->belongsToMany(Skill::class,'skills_jobs','job_id','skill_id');
    }
    public function languages(){
        return $this->belongsToMany(Language::class,'languages_jobs','job_id','language_id');
    }

    public function company(){
        return $this->belongsTo(Company::class,'company_id');
    }

    public function users(){
        return $this->belongsToMany(User::class,'job_offers_users','job_offer_id','user_id');
    }

    public function notifications()
    {
        return $this->morphMany(Notification::class, 'contentable');
    }

    public function jobOfferDates(){
        return $this->hasMany(JobOfferDate::class,'job_offer_id');
    }
}

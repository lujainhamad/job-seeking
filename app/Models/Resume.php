<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resume extends Model
{
    protected $table = 'resumes';

    protected $fillable = [
        'user_id',
        'title',
        'about',
        'main_field',
        'second_field'
    ];

    public function skills(){
        return $this->belongsToMany(Skill::class,'skills_resumes','resume_id','skill_id');
    }

    public function educations(){
        return $this->belongsToMany(Education::class,'educations_resumes','resume_id','education_id');
    }

    public function experiences(){
        return $this->hasMany(Experience::class,'resume_id');
    }
    public function languages(){
        return $this->belongsToMany(Language::class,'languages_resumes','resume_id','language_id');
    }
}

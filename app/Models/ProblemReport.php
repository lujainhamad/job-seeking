<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProblemReport extends Model
{
    protected $table = 'problem_reports';
    protected $fillable = ['user_id', 'job_offer_id', 'description','response'];

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function jobOffer(){
        return $this->belongsTo(Job::class,'job_offer_id');
    }
}

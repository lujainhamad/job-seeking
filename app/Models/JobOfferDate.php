<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobOfferDate extends Model
{
    protected $table = 'job_offer_dates';


    protected $fillable = [
        'job_offer_id',
        'date',
    ];

    public function jobOffer(){
        return $this->belongsTo(Job::class,'job_offer_id');
    }
}

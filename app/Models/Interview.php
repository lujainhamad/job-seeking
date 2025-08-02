<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Interview extends Model
{
    protected $table = 'job_offers_users';

      protected $fillable = [
        'job_offer_id',
        'user_id',
        'initial_salary',
        'interview_status',
        'is_approved',
        'interview_date',
    ];

      public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jobOffer()
    {
        return $this->belongsTo(Job::class, 'job_offer_id');
    }
}

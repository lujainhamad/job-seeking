<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Experience extends Model
{
     
    protected $table = 'experiences';

    protected $fillable = [
        'name',
        'description',
        'user_id',
        'start_date',
        'end_date',
        'resume_id'
    ];

   
}

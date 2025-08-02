<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Skill extends Model
{
    use HasTranslations;
    protected $table = 'skills';

    protected $fillable = [
        'name',
    ];

    
    public $translatable = ['name'];
}

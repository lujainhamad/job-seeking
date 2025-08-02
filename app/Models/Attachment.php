<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Attachment extends Model
{
    protected $fillable = [
        'id',
        'user_id',
        'owner_type',
        'owner_id',
        'file',
        'type'
    ];

    
}

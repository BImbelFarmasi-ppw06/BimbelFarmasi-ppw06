<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JokiPerson extends Model
{
    protected $table = 'joki_persons';
    
    protected $fillable = [
        'name',
        'expertise',
        'wa_link',
        'description',
        'photo',
        'is_active',
        'order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}

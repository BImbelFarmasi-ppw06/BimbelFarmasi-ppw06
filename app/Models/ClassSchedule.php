<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClassSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_id',
        'title',
        'description',
        'date',
        'start_time',
        'end_time',
        'type',
        'meeting_link',
        'location',
        'status',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}

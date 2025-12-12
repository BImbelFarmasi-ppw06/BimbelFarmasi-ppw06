<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_id',
        'order_id',
        'user_id',
        'title',
        'description',
        'content',
        'video_url',
        'file_urls',
        'file_path',
        'file_name',
        'file_size',
        'type',
        'duration_minutes',
        'status',
        'completed_at',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
        'file_urls' => 'array',
    ];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

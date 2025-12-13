<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'type',
        'class_category',
        'description',
        'features',
        'price',
        'duration_months',
        'total_sessions',
        'is_active',
        'tutor',
        'schedule',
        'duration',
        'status',
    ];

    protected $casts = [
        'features' => 'array',
        'is_active' => 'boolean',
        'price' => 'decimal:2',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    
    public function courses()
    {
        return $this->hasMany(Course::class);
    }
    
    public function classSchedules()
    {
        return $this->hasMany(ClassSchedule::class);
    }
    
    public function quizBanks()
    {
        return $this->hasMany(QuizBank::class);
    }
}

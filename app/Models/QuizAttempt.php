<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizAttempt extends Model
{
    protected $fillable = [
        'user_id',
        'quiz_bank_id',
        'order_id',
        'score',
        'total_questions',
        'correct_answers',
        'answers',
        'completed_at',
    ];

    protected $casts = [
        'answers' => 'array',
        'completed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function quizBank()
    {
        return $this->belongsTo(QuizBank::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizAttempt extends Model
{
    protected $fillable = [
        'quiz_bank_id',
        'user_id',
        'score',
        'correct_answers',
        'total_questions',
        'is_passed',
        'started_at',
        'completed_at',
        'answers',
        'time_spent_seconds',
    ];

    protected $casts = [
        'answers' => 'array',
        'is_passed' => 'boolean',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function quizBank()
    {
        return $this->belongsTo(QuizBank::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get formatted score percentage
     */
    public function getScorePercentageAttribute()
    {
        return round($this->score, 2);
    }

    /**
     * Get grade based on score
     */
    public function getGradeAttribute()
    {
        if ($this->score >= 90) return 'A';
        if ($this->score >= 80) return 'B+';
        if ($this->score >= 70) return 'B';
        if ($this->score >= 60) return 'C';
        if ($this->score >= 50) return 'D';
        return 'E';
    }

    /**
     * Get status text
     */
    public function getStatusTextAttribute()
    {
        return $this->is_passed ? 'LULUS' : 'TIDAK LULUS';
    }

    /**
     * Get performance feedback
     */
    public function getFeedbackAttribute()
    {
        if ($this->score >= 90) {
            return 'Luar biasa! Anda menguasai materi dengan sangat baik.';
        } elseif ($this->score >= 80) {
            return 'Sangat bagus! Anda memahami materi dengan baik.';
        } elseif ($this->score >= 70) {
            return 'Bagus! Anda lulus dengan nilai yang memuaskan.';
        } elseif ($this->score >= 60) {
            return 'Cukup, tapi masih perlu belajar lebih giat lagi.';
        } elseif ($this->score >= 50) {
            return 'Kurang. Pelajari kembali materi yang belum dipahami.';
        } else {
            return 'Sangat kurang. Sebaiknya pelajari kembali seluruh materi.';
        }
    }

    /**
     * Get time spent in human readable format
     */
    public function getTimeSpentFormattedAttribute()
    {
        if (!$this->time_spent_seconds) {
            return 'N/A';
        }

        $minutes = floor($this->time_spent_seconds / 60);
        $seconds = $this->time_spent_seconds % 60;

        return sprintf('%d menit %d detik', $minutes, $seconds);
    }
}

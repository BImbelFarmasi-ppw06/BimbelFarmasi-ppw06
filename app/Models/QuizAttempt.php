<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model QuizAttempt - Mengelola data hasil pengerjaan quiz/tryout
 */
class QuizAttempt extends Model
{
    protected $fillable = [
        'quiz_bank_id',        // ID quiz/tryout yang dikerjakan
        'user_id',             // ID user yang mengerjakan
        'score',               // Nilai persentase (0-100)
        'correct_answers',     // Jumlah jawaban benar
        'total_questions',     // Total jumlah soal
        'is_passed',           // Status lulus/tidak (boolean)
        'started_at',          // Waktu mulai mengerjakan
        'completed_at',        // Waktu selesai mengerjakan
        'answers',             // JSON jawaban user (question_id => answer)
        'time_spent_seconds',  // Durasi pengerjaan dalam detik
    ];

    protected $casts = [
        'answers' => 'array',
        'is_passed' => 'boolean',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    /**
     * Relasi ke QuizBank - Quiz/tryout yang dikerjakan
     */
    public function quizBank()
    {
        return $this->belongsTo(QuizBank::class);
    }

    /**
     * Relasi ke User - User yang mengerjakan
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Accessor - Dapatkan nilai persentase yang sudah dibulatkan
     * Return: nilai dengan 2 desimal (contoh: 85.50)
     */
    public function getScorePercentageAttribute()
    {
        return round($this->score, 2);
    }

    /**
     * Accessor - Dapatkan grade huruf berdasarkan nilai
     * A: 90-100%, B+: 80-89%, B: 70-79%, C: 60-69%, D: 50-59%, E: 0-49%
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
     * Accessor - Dapatkan text status kelulusan
     * Return: "LULUS" atau "TIDAK LULUS"
     */
    public function getStatusTextAttribute()
    {
        return $this->is_passed ? 'LULUS' : 'TIDAK LULUS';
    }

    /**
     * Accessor - Dapatkan feedback motivasi berdasarkan nilai
     * Return: Pesan motivasi sesuai range nilai
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
     * Accessor - Format durasi pengerjaan ke format yang mudah dibaca
     * Return: "X menit Y detik" (contoh: "15 menit 30 detik")
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

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Model QuizBank - Mengelola bank soal quiz/tryout
 * Berisi kumpulan soal untuk latihan atau tryout
 */
class QuizBank extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',           // ID pesanan (jika quiz terkait dengan pesanan tertentu)
        'user_id',            // ID user pembuat/pemilik
        'title',              // Judul quiz/tryout
        'description',        // Deskripsi quiz
        'category',           // Kategori (Farmakologi, Farmasi Klinik, dll)
        'total_questions',    // Total jumlah soal
        'duration_minutes',   // Durasi waktu mengerjakan (dalam menit)
        'passing_score',      // Nilai minimum kelulusan (%)
    ];

    /**
     * Relasi ke Order - Pesanan yang terkait dengan quiz ini
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Relasi ke User - Pembuat/pemilik quiz
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke QuizQuestion - Semua soal dalam quiz ini
     * Relasi: One to Many (1 quiz bank punya banyak soal)
     */
    public function questions()
    {
        return $this->hasMany(QuizQuestion::class);
    }

    /**
     * Relasi ke QuizAttempt - Semua attempt/pengerjaan quiz ini
     * Relasi: One to Many (1 quiz bank bisa dikerjakan banyak kali)
     */
    public function attempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }
}

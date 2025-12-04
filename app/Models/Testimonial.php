<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model Testimonial - Mengelola testimoni/review dari user
 * User bisa memberikan rating & komentar untuk program yang sudah dibeli
 */
class Testimonial extends Model
{
    protected $fillable = [
        'user_id',       // ID user yang menulis
        'program_id',    // ID program yang direview
        'order_id',      // ID pesanan terkait
        'rating',        // Rating bintang (1-5)
        'comment',       // Komentar/review
        'is_approved'    // Status approval oleh admin
    ];

    protected $casts = [
        'is_approved' => 'boolean',
        'created_at' => 'datetime',
    ];

    /**
     * Relasi ke User - User yang menulis testimoni
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Program - Program yang direview
     */
    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    /**
     * Relasi ke Order - Pesanan yang terkait dengan testimoni ini
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Scope - Filter hanya testimoni yang sudah diapprove admin
     * Usage: Testimonial::approved()->get()
     */
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    /**
     * Scope - Filter testimoni berdasarkan rating tertentu
     * Usage: Testimonial::byRating(5)->get() untuk rating bintang 5
     */
    public function scopeByRating($query, $rating)
    {
        return $query->where('rating', $rating);
    }
}

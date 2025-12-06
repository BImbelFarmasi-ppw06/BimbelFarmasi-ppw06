<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Order> $orders
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Testimonial> $testimonials
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'university',
        'interest',
        'password',
        'profile_photo',
        'is_admin',
        'is_suspended',
        'suspended_at',
        'suspended_by',
        'suspend_reason',
        'last_login_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
            'is_suspended' => 'boolean',
            'suspended_at' => 'datetime',
            'last_login_at' => 'datetime',
        ];
    }

    /**
     * Relasi ke Order - Semua pesanan yang dibuat user
     * Relasi: One to Many (1 user bisa punya banyak orders)
     */
    public function orders()
    {
        return $this->hasMany(\App\Models\Order::class);
    }

    /**
     * Relasi ke Testimonial - Semua testimoni yang dibuat user
     * Relasi: One to Many (1 user bisa punya banyak testimonials)
     */
    public function testimonials()
    {
        return $this->hasMany(\App\Models\Testimonial::class);
    }

    /**
     * Relasi ke QuizAttempt - Semua hasil tryout/quiz user
     * Relasi: One to Many (1 user bisa punya banyak quiz attempts)
     */
    public function quizAttempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }
}

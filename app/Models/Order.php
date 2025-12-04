<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Model Order - Mengelola data pesanan/transaksi pembelian program
 */
class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',   // Nomor pesanan unik
        'user_id',        // ID user yang memesan
        'program_id',     // ID program yang dipesan
        'amount',         // Total harga
        'status',         // Status pesanan (pending, waiting_verification, processing, completed, cancelled)
        'notes',          // Catatan tambahan dari user
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    /**
     * Relasi ke User - User yang membuat pesanan
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Program - Program yang dipesan
     */
    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    /**
     * Relasi ke Payment - Data pembayaran pesanan
     */
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    /**
     * Relasi ke Testimonial - Testimoni untuk pesanan ini
     */
    public function testimonial()
    {
        return $this->hasOne(Testimonial::class);
    }

    /**
     * Generate nomor pesanan unik dengan format: ORD-YYYYMMDD-XXXXXX
     * Contoh: ORD-20251204-A3F2B1
     */
    public static function generateOrderNumber()
    {
        return 'ORD-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));
    }
}

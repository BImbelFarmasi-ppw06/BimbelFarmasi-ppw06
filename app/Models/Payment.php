<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Model Payment - Mengelola data pembayaran pesanan
 */
class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',         // ID pesanan yang dibayar
        'payment_method',   // Metode pembayaran (bank_transfer, ewallet, qris, midtrans)
        'amount',           // Jumlah yang dibayarkan
        'status',           // Status pembayaran (pending, paid, approved, rejected, failed)
        'proof_url',        // URL bukti pembayaran (untuk manual transfer)
        'paid_at',          // Tanggal & waktu pembayaran
        'notes',            // Catatan admin (alasan approve/reject)
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    /**
     * Relasi ke Order - Pesanan yang dibayar
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Model Program - Mengelola data program/paket belajar
 * Contoh: UKOM D3 Farmasi, CPNS/P3K Farmasi, Joki Tugas
 */
class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',              // Nama program
        'slug',              // URL-friendly identifier
        'type',              // Tipe program (bimbel, joki, tryout)
        'description',       // Deskripsi lengkap program
        'features',          // Fitur-fitur program (JSON array)
        'price',             // Harga program
        'duration_months',   // Durasi akses (dalam bulan)
        'total_sessions',    // Total sesi pertemuan
        'is_active',         // Status aktif/nonaktif
    ];

    protected $casts = [
        'features' => 'array',
        'is_active' => 'boolean',
        'price' => 'decimal:2',
    ];

    /**
     * Relasi ke Order - Semua pesanan untuk program ini
     * Relasi: One to Many (1 program bisa dibeli banyak user)
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}

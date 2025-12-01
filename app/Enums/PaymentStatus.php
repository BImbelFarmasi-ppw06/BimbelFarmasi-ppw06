<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case PENDING = 'pending';
    case PAID = 'paid';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
    case FAILED = 'failed';

    /**
     * Get all status values
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get label for display
     */
    public function label(): string
    {
        return match($this) {
            self::PENDING => 'Menunggu Konfirmasi',
            self::PAID => 'Terbayar',
            self::APPROVED => 'Disetujui',
            self::REJECTED => 'Ditolak',
            self::FAILED => 'Gagal',
        };
    }

    /**
     * Get badge color class
     */
    public function badgeClass(): string
    {
        return match($this) {
            self::PENDING => 'bg-yellow-100 text-yellow-800',
            self::PAID, self::APPROVED => 'bg-green-100 text-green-800',
            self::REJECTED, self::FAILED => 'bg-red-100 text-red-800',
        };
    }
}

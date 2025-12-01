<?php

namespace App\Enums;

enum OrderStatus: string
{
    case PENDING = 'pending';
    case WAITING_VERIFICATION = 'waiting_verification';
    case PROCESSING = 'processing';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';
    case REJECTED = 'rejected';

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
            self::PENDING => 'Menunggu Pembayaran',
            self::WAITING_VERIFICATION => 'Menunggu Verifikasi',
            self::PROCESSING => 'Sedang Diproses',
            self::COMPLETED => 'Selesai',
            self::CANCELLED => 'Dibatalkan',
            self::REJECTED => 'Ditolak',
        };
    }

    /**
     * Get badge color class
     */
    public function badgeClass(): string
    {
        return match($this) {
            self::PENDING => 'bg-yellow-100 text-yellow-800',
            self::WAITING_VERIFICATION => 'bg-blue-100 text-blue-800',
            self::PROCESSING => 'bg-green-100 text-green-800',
            self::COMPLETED => 'bg-gray-100 text-gray-800',
            self::CANCELLED, self::REJECTED => 'bg-red-100 text-red-800',
        };
    }
}

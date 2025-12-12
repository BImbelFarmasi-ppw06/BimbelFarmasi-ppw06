@extends('layouts.app')

@section('title', 'Pembayaran Berhasil')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-50 py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-2xl mx-auto">
            <!-- Success Icon -->
            <div class="text-center mb-8">
                @if($order->payment->status === 'paid')
                <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6 animate-bounce">
                    <svg class="w-12 h-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Pembayaran Berhasil!</h1>
                <p class="text-gray-600">Terima kasih! Pembayaran Anda telah berhasil diproses.</p>
                @else
                <div class="w-24 h-24 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Order Berhasil Dibuat!</h1>
                <p class="text-gray-600">Silakan selesaikan pembayaran untuk mengakses layanan.</p>
                @endif
            </div>

            <!-- Order Details -->
            <div class="bg-white rounded-2xl shadow-xl p-8 mb-6">
                <div class="flex items-center justify-between mb-6 pb-6 border-b">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Nomor Order</p>
                        <p class="text-xl font-bold text-[#2D3C8C]">#{{ $order->order_number }}</p>
                    </div>
                    <span class="px-4 py-2 {{ $order->payment->status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }} rounded-full text-sm font-semibold">
                        {{ $order->payment->status === 'paid' ? 'Lunas' : 'Menunggu Pembayaran' }}
                    </span>
                </div>

                <!-- Program Info -->
                <div class="mb-6 pb-6 border-b">
                    <p class="text-sm text-gray-600 mb-3">Program yang Dibeli</p>
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-[#2D3C8C] to-[#1e2761] flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 mb-1">{{ $order->program->name }}</h3>
                            @if($order->program->type !== 'joki')
                                <p class="text-sm text-gray-600">Durasi {{ $order->program->duration_months }} bulan • {{ $order->program->total_sessions }} pertemuan</p>
                            @else
                                <p class="text-sm text-gray-600">Layanan Project-Based • Harga & durasi custom</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Payment Info -->
                <div class="mb-6 pb-6 border-b">
                    <p class="text-sm text-gray-600 mb-3">Detail Pembayaran</p>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-700">Metode Pembayaran</span>
                            <span class="font-semibold text-gray-900">
                                @if($order->payment->payment_method === 'bank_transfer')
                                    Transfer Bank
                                @elseif($order->payment->payment_method === 'ewallet')
                                    E-Wallet
                                @else
                                    QRIS
                                @endif
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-700">Tanggal Pembayaran</span>
                            <span class="font-semibold text-gray-900">{{ $order->payment->created_at->format('d M Y, H:i') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Total -->
                <div class="flex justify-between items-center">
                    <span class="text-gray-700 font-semibold">Total Pembayaran</span>
                    <span class="text-2xl font-bold text-[#2D3C8C]">Rp {{ number_format($order->amount, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- Next Steps -->
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 mb-6">
                <h3 class="font-bold text-gray-900 mb-3 flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#2D3C8C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Langkah Selanjutnya
                </h3>
                @if($order->payment->status === 'paid')
                <ol class="space-y-2 text-sm text-gray-700">
                    <li class="flex gap-2">
                        <span class="font-semibold">1.</span>
                        <span>Pembayaran Anda sudah diterima dan diproses</span>
                    </li>
                    <li class="flex gap-2">
                        <span class="font-semibold">2.</span>
                        <span>Tim kami akan menghubungi Anda untuk pengaturan jadwal</span>
                    </li>
                    <li class="flex gap-2">
                        <span class="font-semibold">3.</span>
                        <span>Akses layanan tersedia di menu "Layanan Saya"</span>
                    </li>
                </ol>
                @else
                <ol class="space-y-2 text-sm text-gray-700">
                    <li class="flex gap-2">
                        <span class="font-semibold">1.</span>
                        <span>Selesaikan pembayaran melalui metode yang Anda pilih</span>
                    </li>
                    <li class="flex gap-2">
                        <span class="font-semibold">2.</span>
                        <span>Status pembayaran akan otomatis diupdate setelah pembayaran berhasil</span>
                    </li>
                    <li class="flex gap-2">
                        <span class="font-semibold">3.</span>
                        <span>Akses layanan akan tersedia setelah pembayaran dikonfirmasi</span>
                    </li>
                </ol>
                @endif
            </div>

            <!-- Action Buttons -->
            <div class="grid sm:grid-cols-2 gap-4">
                <a href="{{ route('user.services') }}" class="bg-gradient-to-r from-[#2D3C8C] to-[#1e2761] text-white font-bold py-3 rounded-xl hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 text-center">
                    Lihat Layanan Saya
                </a>
                <a href="{{ route('home') }}" class="bg-white border-2 border-[#2D3C8C] text-[#2D3C8C] font-bold py-3 rounded-xl hover:bg-blue-50 transition-all duration-200 text-center">
                    Kembali ke Beranda
                </a>
            </div>

            <!-- Help -->
            <div class="mt-6 text-center">
                <p class="text-gray-600 text-sm">
                    Ada pertanyaan? 
                    <a href="{{ route('kontak') }}" class="text-[#2D3C8C] font-semibold hover:underline">Hubungi Kami</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Pesanan Saya')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-50 py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-5xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Pesanan Saya</h1>
                <p class="text-gray-600 mt-2">Kelola semua pesanan program bimbel dan joki tugas Anda</p>
            </div>

            @if($orders->isEmpty())
                <!-- Empty State -->
                <div class="bg-white rounded-2xl shadow-xl p-12 text-center">
                    <div class="w-24 h-24 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-[#2D3C8C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Pesanan</h3>
                    <p class="text-gray-600 mb-6">Anda belum memiliki pesanan apapun. Mulai jelajahi layanan kami!</p>
                    <a href="{{ route('layanan') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-[#2D3C8C] to-[#1e2761] text-white font-bold px-6 py-3 rounded-xl hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        Lihat Layanan
                    </a>
                </div>
            @else
                <!-- Orders List -->
                <div class="space-y-6">
                    @foreach($orders as $order)
                    <div class="bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition-shadow">
                        <!-- Order Header -->
                        <div class="bg-gradient-to-r from-[#2D3C8C] to-[#1e2761] px-6 py-4">
                            <div class="flex flex-wrap items-center justify-between gap-3">
                                <div>
                                    <p class="text-white/80 text-sm">Order #{{ $order->order_number }}</p>
                                    <p class="text-white text-xs mt-1">{{ $order->created_at->format('d M Y, H:i') }}</p>
                                </div>
                                @if($order->payment)
                                    @if($order->payment->status === 'paid')
                                        <span class="px-4 py-2 bg-green-500 text-white rounded-full text-sm font-semibold">
                                            ✓ Lunas
                                        </span>
                                    @elseif($order->payment->status === 'pending')
                                        <span class="px-4 py-2 bg-yellow-400 text-gray-900 rounded-full text-sm font-semibold">
                                            ⏳ Menunggu Verifikasi
                                        </span>
                                    @elseif($order->payment->status === 'rejected')
                                        <span class="px-4 py-2 bg-red-500 text-white rounded-full text-sm font-semibold">
                                            ✗ Ditolak
                                        </span>
                                    @endif
                                @else
                                    <span class="px-4 py-2 bg-gray-400 text-white rounded-full text-sm font-semibold">
                                        Belum Bayar
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Order Body -->
                        <div class="p-6">
                            <div class="flex items-start gap-4 mb-4">
                                <div class="w-16 h-16 rounded-xl bg-gradient-to-br from-[#2D3C8C] to-[#1e2761] flex items-center justify-center flex-shrink-0">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-bold text-gray-900 text-lg mb-1">{{ $order->program->name }}</h3>
                                    <p class="text-sm text-gray-600 mb-2">{{ $order->program->description }}</p>
                                    @if($order->program->type !== 'joki')
                                    <div class="flex flex-wrap gap-3 text-sm text-gray-600">
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            {{ $order->program->duration_months }} bulan
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                            </svg>
                                            {{ $order->program->total_sessions }} sesi
                                        </span>
                                    </div>
                                    @else
                                    <div class="flex items-center gap-2 text-sm">
                                        <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full font-semibold">
                                            📋 Project-Based
                                        </span>
                                        <span class="text-gray-600">Harga & durasi custom</span>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            @if($order->notes)
                            <div class="bg-gray-50 rounded-lg p-3 mb-4">
                                <p class="text-sm text-gray-600"><span class="font-semibold">Catatan:</span> {{ $order->notes }}</p>
                            </div>
                            @endif

                            <!-- Total & Actions -->
                            <div class="flex flex-wrap items-center justify-between gap-4 pt-4 border-t">
                                <div>
                                    <p class="text-sm text-gray-600">Total Pembayaran</p>
                                    <p class="text-2xl font-bold text-[#2D3C8C]">Rp {{ number_format($order->amount, 0, ',', '.') }}</p>
                                </div>
                                <div class="flex flex-wrap gap-3">
                                    @if($order->payment)
                                        @if($order->payment->status === 'paid')
                                            <a href="{{ route('user.services') }}" class="inline-flex items-center gap-2 bg-[#2D3C8C] text-white font-semibold px-4 py-2 rounded-lg hover:bg-[#1e2761] transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                                </svg>
                                                Akses Layanan
                                            </a>
                                            
                                            @php
                                                $hasTestimonial = $order->testimonial()->exists();
                                            @endphp
                                            
                                            @if($hasTestimonial)
                                                <a href="{{ route('testimonials.edit', $order->testimonial->id) }}" class="inline-flex items-center gap-2 bg-green-600 text-white font-semibold px-4 py-2 rounded-lg hover:bg-green-700 transition">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                    </svg>
                                                    Edit Testimoni
                                                </a>
                                            @else
                                                <a href="{{ route('testimonials.create', $order->order_number) }}" class="inline-flex items-center gap-2 bg-yellow-500 text-white font-semibold px-4 py-2 rounded-lg hover:bg-yellow-600 transition">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                                    </svg>
                                                    Beri Testimoni
                                                </a>
                                            @endif
                                        @elseif($order->payment->status === 'pending')
                                            <span class="inline-flex items-center gap-2 text-gray-600 text-sm">
                                                <svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                                </svg>
                                                Menunggu verifikasi admin
                                            </span>
                                        @elseif($order->payment->status === 'rejected')
                                            <a href="{{ route('order.payment', $order->order_number) }}" class="inline-flex items-center gap-2 bg-red-500 text-white font-semibold px-4 py-2 rounded-lg hover:bg-red-600 transition">
                                                Upload Ulang
                                            </a>
                                        @endif
                                    @else
                                        <a href="{{ route('order.payment', $order->order_number) }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-[#2D3C8C] to-[#1e2761] text-white font-semibold px-4 py-2 rounded-lg hover:shadow-lg transition">
                                            Lanjut Bayar
                                        </a>
                                    @endif
                                    <a href="{{ route('kontak') }}" class="inline-flex items-center gap-2 border-2 border-[#2D3C8C] text-[#2D3C8C] font-semibold px-4 py-2 rounded-lg hover:bg-blue-50 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                                        </svg>
                                        Hubungi Admin
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

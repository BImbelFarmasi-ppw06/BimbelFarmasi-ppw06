@extends('layouts.admin')

@section('title', 'Detail Pembayaran')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Detail Pembayaran</h1>
                <p class="text-gray-600">Informasi pembayaran dan status transaksi</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.payments.index') }}" class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
                <span class="px-6 py-2 rounded-full text-sm font-bold
                    @if($payment->status === 'pending') bg-yellow-100 text-yellow-800
                    @elseif($payment->status === 'paid') bg-green-100 text-green-800
                    @else bg-red-100 text-red-800
                    @endif">
                    @if($payment->status === 'pending') 
                        <i class="fas fa-clock mr-1"></i>Menunggu Pembayaran
                    @elseif($payment->status === 'paid') 
                        <i class="fas fa-check-circle mr-1"></i>Lunas
                    @else 
                        <i class="fas fa-times-circle mr-1"></i>Gagal
                    @endif
                </span>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid gap-6 lg:grid-cols-3">
            <!-- Payment Summary Card (Left) -->
            <div class="lg:col-span-1">
                <div class="rounded-xl bg-white p-6 shadow-sm">
                    <!-- Payment Amount -->
                    <div class="mb-6">
                        <p class="text-sm font-medium text-gray-600 mb-2">Jumlah Pembayaran</p>
                        <p class="text-3xl font-bold text-gray-900">Rp {{ number_format($payment->amount, 0, ',', '.') }}</p>
                        <p class="text-xs text-gray-500 mt-1">Order #{{ $payment->order->order_number }}</p>
                    </div>

                    <!-- Order Info Section -->
                    <div class="border-t pt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Order</h3>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Nomor Order:</span>
                                <span class="font-medium">#{{ $payment->order->order_number }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Program:</span>
                                <span class="font-medium text-right">{{ $payment->order->program->name }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tanggal Order:</span>
                                <span class="font-medium">{{ $payment->order->created_at->format('d M Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Status Order:</span>
                                <span class="inline-flex items-center rounded-full {{ $payment->order->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }} px-2 py-1 text-xs font-semibold">
                                    {{ ucfirst($payment->order->status) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Info Section -->
                    <div class="border-t pt-6 mt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Pembayaran</h3>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Metode:</span>
                                <span class="font-medium">
                                    @if($payment->payment_method === 'bank_transfer')
                                        🏦 Transfer Bank
                                    @elseif($payment->payment_method === 'ewallet')
                                        💳 E-Wallet
                                    @else
                                        📱 QRIS
                                    @endif
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tanggal:</span>
                                <span class="font-medium">{{ $payment->created_at->format('d M Y, H:i') }}</span>
                            </div>
                            @if($payment->status === 'paid')
                            <div class="flex justify-between">
                                <span class="text-gray-600">Dikonfirmasi:</span>
                                <span class="font-medium text-green-600">{{ $payment->paid_at?->format('d M Y, H:i') ?? 'N/A' }}</span>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Status Info -->
                    <div class="mt-6 border-t pt-6">
                        <div class="p-4 rounded-lg {{ $payment->status === 'paid' ? 'bg-green-50 border border-green-200' : ($payment->status === 'rejected' ? 'bg-red-50 border border-red-200' : 'bg-yellow-50 border border-yellow-200') }}">
                            <p class="text-xs font-semibold {{ $payment->status === 'paid' ? 'text-green-700' : ($payment->status === 'rejected' ? 'text-red-700' : 'text-yellow-700') }} mb-1 uppercase">Status Pembayaran</p>
                            <p class="font-bold {{ $payment->status === 'paid' ? 'text-green-900' : ($payment->status === 'rejected' ? 'text-red-900' : 'text-yellow-900') }}">
                                @if($payment->status === 'pending')
                                    Menunggu Pembayaran (Midtrans)
                                @elseif($payment->status === 'paid')
                                    Lunas
                                @else
                                    Gagal
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Details & Actions (Right) -->
            <div class="lg:col-span-2 space-y-6">
                <!-- User Information -->
                <div class="rounded-xl bg-white p-6 shadow-sm">
                    <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
                        <i class="fas fa-user text-blue-600"></i>
                        Informasi Peserta
                    </h3>
                    <div class="flex items-start gap-4">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($payment->order->user->name) }}&background=random&size=100" 
                             class="h-20 w-20 rounded-full border-4 border-gray-100">
                        <div class="flex-1">
                            <h4 class="text-lg font-bold text-gray-900">{{ $payment->order->user->name }}</h4>
                            <p class="text-gray-600 text-sm">{{ $payment->order->user->email }}</p>
                            @if($payment->order->user->phone)
                            <div class="mt-2 flex items-center gap-2 text-sm text-gray-500">
                                <i class="fas fa-phone"></i>
                                <span>{{ $payment->order->user->phone }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="grid gap-4 sm:grid-cols-3">
                    <div class="rounded-lg bg-white p-4 shadow-sm">
                        <div class="flex items-center">
                            <div class="rounded-lg bg-blue-100 p-2">
                                <i class="fas fa-receipt text-blue-600"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-600">Order ID</p>
                                <p class="text-lg font-bold text-gray-900">#{{ $payment->order->id }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-lg bg-white p-4 shadow-sm">
                        <div class="flex items-center">
                            <div class="rounded-lg bg-purple-100 p-2">
                                <i class="fas fa-credit-card text-purple-600"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-600">Payment ID</p>
                                <p class="text-lg font-bold text-gray-900">#{{ $payment->id }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-lg bg-white p-4 shadow-sm">
                        <div class="flex items-center">
                            <div class="rounded-lg bg-orange-100 p-2">
                                <i class="fas fa-clock text-orange-600"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-600">Waktu Pembayaran</p>
                                <p class="text-lg font-bold text-gray-900">{{ $payment->created_at->format('d M Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                @if($payment->order->notes)
                <!-- Order Notes -->
                <div class="rounded-xl bg-white p-6 shadow-sm">
                    <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
                        <i class="fas fa-sticky-note text-gray-600"></i>
                        Catatan Order
                    </h3>
                    <p class="text-gray-700 leading-relaxed">{{ $payment->order->notes }}</p>
                </div>
                @endif

                <!-- Payment Info Notice -->
                <div class="rounded-xl bg-white p-6 shadow-sm {{ $payment->status === 'paid' ? 'border-2 border-green-200' : 'border-2 border-red-200' }}">
                    <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
                        {{ $payment->status === 'paid' ? '✅' : '❌' }}
                        @if($payment->status === 'paid')
                            Pembayaran Terkonfirmasi
                        @else
                            Pembayaran Ditolak
                        @endif
                    </h3>
                    <div class="p-4 {{ $payment->status === 'paid' ? 'bg-green-50' : 'bg-red-50' }} rounded-lg">
                        @if($payment->status === 'paid')
                            <p class="text-sm text-green-700"><strong>Tanggal Konfirmasi:</strong> {{ $payment->paid_at?->format('d M Y, H:i') ?? 'N/A' }}</p>
                            <p class="text-xs text-green-600 mt-2">Pembayaran dikonfirmasi otomatis melalui Midtrans</p>
                        @else
                            <p class="text-sm font-medium text-red-700"><strong>Alasan Penolakan:</strong></p>
                            <p class="text-sm text-red-700 mt-1">{{ $payment->notes ?? 'Pembayaran gagal diproses melalui Midtrans' }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

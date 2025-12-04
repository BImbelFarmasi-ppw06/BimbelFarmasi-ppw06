@extends('layouts.admin')

@section('title', 'Detail Peserta')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.students.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-600 hover:text-gray-900 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke Daftar Peserta
        </a>
    </div>

    <!-- Student Profile Card -->
    <div class="mb-8 rounded-2xl bg-gradient-to-br from-white to-blue-50 shadow-lg border border-gray-200 overflow-hidden">
        <div class="bg-gradient-to-r from-[#2D3C8C] to-[#1e2761] px-8 py-6">
            <div class="flex items-center gap-6">
                <div class="flex-shrink-0">
                    <div class="w-24 h-24 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center text-white text-4xl font-bold ring-4 ring-white/30">
                        {{ strtoupper(substr($student->name, 0, 1)) }}
                    </div>
                </div>
                <div class="flex-1 text-white">
                    <h2 class="text-3xl font-bold mb-2">{{ $student->name }}</h2>
                    <div class="flex items-center gap-4 text-blue-100">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            {{ $student->email }}
                        </span>
                        @if($student->phone)
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            {{ $student->phone }}
                        </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Grid -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 p-8">
            <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <p class="text-xs text-gray-500 font-medium">Terdaftar Sejak</p>
                </div>
                <p class="text-lg font-bold text-gray-900">{{ $student->created_at->format('d M Y') }}</p>
            </div>

            <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </div>
                    <p class="text-xs text-gray-500 font-medium">Total Pembelian</p>
                </div>
                <p class="text-lg font-bold text-gray-900">{{ $student->orders->count() }} <span class="text-sm font-normal text-gray-500">program</span></p>
            </div>

            <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <p class="text-xs text-gray-500 font-medium">Pembayaran Lunas</p>
                </div>
                <p class="text-lg font-bold text-gray-900">{{ $student->orders->filter(function($order) { return $order->payment && $order->payment->status === 'paid'; })->count() }} <span class="text-sm font-normal text-gray-500">dari {{ $student->orders->count() }}</span></p>
            </div>

            <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 rounded-lg bg-emerald-100 flex items-center justify-center">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <p class="text-xs text-gray-500 font-medium">Total Pembayaran</p>
                </div>
                <p class="text-lg font-bold text-emerald-600">Rp {{ number_format($student->orders->filter(function($order) { return $order->payment && $order->payment->status === 'paid'; })->sum('amount'), 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    <!-- Orders History -->
    <div class="rounded-2xl bg-white shadow-lg border border-gray-200 overflow-hidden">
        <div class="bg-gradient-to-r from-gray-50 to-blue-50 border-b border-gray-200 px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Riwayat Pembelian</h3>
                    <p class="text-sm text-gray-600 mt-1">Daftar semua transaksi pembelian program</p>
                </div>
                <div class="text-right">
                    <p class="text-2xl font-bold text-[#2D3C8C]">{{ $student->orders->count() }}</p>
                    <p class="text-xs text-gray-500">Total Order</p>
                </div>
            </div>
        </div>

        @if($student->orders->count() > 0)
            <div class="divide-y divide-gray-100">
                @foreach($student->orders as $index => $order)
                    <div class="p-6 hover:bg-gray-50 transition-colors">
                        <div class="flex items-start justify-between gap-6">
                            <div class="flex-1">
                                <!-- Order Header -->
                                <div class="flex items-start gap-4 mb-4">
                                    <div class="flex-shrink-0">
                                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold">
                                            {{ $index + 1 }}
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center gap-3 mb-2">
                                            <h4 class="text-lg font-bold text-gray-900">{{ $order->program->name }}</h4>
                                            @if($order->payment)
                                                @if($order->payment->status === 'paid')
                                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700 ring-1 ring-green-600/20">
                                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                        </svg>
                                                        Lunas
                                                    </span>
                                                @elseif($order->payment->status === 'pending')
                                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-700 ring-1 ring-yellow-600/20">
                                                        <svg class="w-3 h-3 animate-spin" fill="none" viewBox="0 0 24 24">
                                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                        </svg>
                                                        Menunggu Verifikasi
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700 ring-1 ring-red-600/20">
                                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                                        </svg>
                                                        Ditolak
                                                    </span>
                                                @endif
                                            @endif
                                        </div>
                                        <p class="text-sm text-gray-600">{{ $order->program->description }}</p>
                                    </div>
                                </div>

                                <!-- Order Details Grid -->
                                <div class="grid grid-cols-2 gap-6 bg-gray-50 rounded-xl p-4">
                                    <div>
                                        <div class="mb-2">
                                            <svg class="w-4 h-4 text-gray-400 mb-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </div>
                                        <p class="text-xs text-gray-500 mb-1.5">Total Pembayaran</p>
                                        <p class="font-bold text-emerald-600 text-sm">Rp {{ number_format($order->amount, 0, ',', '.') }}</p>
                                    </div>
                                    <div>
                                        <div class="mb-2">
                                            <svg class="w-4 h-4 text-gray-400 mb-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                        <p class="text-xs text-gray-500 mb-1.5">Tanggal Pembelian</p>
                                        <p class="font-semibold text-gray-900 text-sm">{{ $order->created_at->format('d M Y, H:i') }}</p>
                                    </div>
                                </div>

                                @if($order->payment)
                                    <div class="mt-4 flex items-center gap-4 text-sm">
                                        <div class="flex items-center gap-2 text-gray-600">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                            </svg>
                                            <span class="font-medium">{{ ucfirst(str_replace('_', ' ', $order->payment->payment_method)) }}</span>
                                        </div>
                                        @if($order->payment->paid_at)
                                            <div class="flex items-center gap-2 text-green-600">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                <span class="font-medium">Dibayar: {{ $order->payment->paid_at->format('d M Y, H:i') }}</span>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            @if($order->payment)
                                <a href="{{ route('admin.payments.show', $order->payment->id) }}" 
                                   class="flex-shrink-0 inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-[#2D3C8C] to-[#1e2761] hover:from-[#1e2761] hover:to-[#2D3C8C] text-white rounded-xl text-sm font-semibold shadow-md hover:shadow-lg transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    Lihat Detail
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="p-16 text-center">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gray-100 mb-4">
                    <svg class="w-10 h-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum Ada Pembelian</h3>
                <p class="text-sm text-gray-500">Peserta ini belum melakukan pembelian program apapun</p>
            </div>
        @endif
    </div>
@endsection

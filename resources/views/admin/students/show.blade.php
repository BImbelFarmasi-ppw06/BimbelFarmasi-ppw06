@extends('layouts.admin')

@section('title', 'Detail Peserta')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.students.index') }}" class="text-sm text-gray-600 hover:text-gray-900 flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke Daftar Peserta
        </a>
        <h1 class="mt-2 text-2xl font-bold text-gray-900">Detail Peserta</h1>
        <p class="mt-1 text-sm text-gray-500">Informasi lengkap peserta dan riwayat pembelian</p>
    </div>

    <!-- Student Profile -->
    <div class="mb-6 rounded-xl bg-white shadow-sm border border-gray-200 p-6">
        <div class="flex items-start gap-6">
            <div class="flex-shrink-0">
                <div class="w-24 h-24 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white text-3xl font-bold">
                    {{ strtoupper(substr($student->name, 0, 1)) }}
                </div>
            </div>
            <div class="flex-1">
                <h2 class="text-2xl font-bold text-gray-900">{{ $student->name }}</h2>
                <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Email</p>
                        <p class="font-medium text-gray-900">{{ $student->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">No. Telepon</p>
                        <p class="font-medium text-gray-900">{{ $student->phone ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Terdaftar Sejak</p>
                        <p class="font-medium text-gray-900">{{ $student->created_at->format('d M Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total Pembelian</p>
                        <p class="font-medium text-gray-900">{{ $student->orders->count() }} program</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders History -->
    <div class="rounded-xl bg-white shadow-sm border border-gray-200">
        <div class="border-b border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900">Riwayat Pembelian</h3>
        </div>

        @if($student->orders->count() > 0)
            <div class="divide-y divide-gray-200">
                @foreach($student->orders as $order)
                    <div class="p-6">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2">
                                    <h4 class="font-semibold text-gray-900">{{ $order->program->name }}</h4>
                                    @if($order->payment)
                                        @if($order->payment->status === 'paid')
                                            <span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">
                                                Lunas
                                            </span>
                                        @elseif($order->payment->status === 'pending')
                                            <span class="inline-flex items-center rounded-full bg-yellow-100 px-2.5 py-0.5 text-xs font-medium text-yellow-800">
                                                Menunggu Verifikasi
                                            </span>
                                        @else
                                            <span class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800">
                                                Ditolak
                                            </span>
                                        @endif
                                    @endif
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-3">
                                    <div>
                                        <p class="text-sm text-gray-500">No. Pesanan</p>
                                        <p class="font-medium text-gray-900">{{ $order->order_number }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Tanggal Pembelian</p>
                                        <p class="font-medium text-gray-900">{{ $order->created_at->format('d M Y, H:i') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Total Pembayaran</p>
                                        <p class="font-medium text-gray-900">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                                @if($order->payment)
                                    <div class="mt-3 pt-3 border-t border-gray-100">
                                        <p class="text-sm text-gray-500 mb-1">Metode Pembayaran</p>
                                        <p class="font-medium text-gray-900">{{ $order->payment->payment_method }}</p>
                                        @if($order->payment->payment_date)
                                            <p class="text-sm text-gray-500 mt-2">Tanggal Transfer: {{ \Carbon\Carbon::parse($order->payment->payment_date)->format('d M Y') }}</p>
                                        @endif
                                    </div>
                                @endif
                            </div>
                            @if($order->payment)
                                <a href="{{ route('admin.payments.show', $order->payment->id) }}" 
                                   class="ml-4 inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 text-sm font-medium">
                                    Lihat Detail
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="p-12 text-center">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum Ada Pembelian</h3>
                <p class="text-sm text-gray-500">Peserta ini belum melakukan pembelian program apapun</p>
            </div>
        @endif
    </div>
@endsection

@extends('layouts.app')

@section('title', 'Riwayat Transaksi')

@section('content')
    <section class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50 py-12">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Riwayat Transaksi</h1>
                <p class="mt-2 text-gray-600">Lihat semua transaksi dan pembayaran Anda</p>
            </div>

            <!-- Total Spending Card -->
            @if(count($transactions) > 0)
            @php
                $verifiedTransactions = array_filter($transactions, function($t) { return $t['status'] === 'verified'; });
                $totalVerified = array_sum(array_column($verifiedTransactions, 'amount'));
                $verifiedCount = count($verifiedTransactions);
                $pendingCount = count(array_filter($transactions, function($t) { return $t['status'] === 'pending'; }));
            @endphp
            <div class="mb-8 rounded-2xl bg-gradient-to-br from-blue-600 to-purple-700 p-8 text-white shadow-2xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-blue-100">Total Pengeluaran (Terverifikasi)</p>
                        <p class="mt-2 text-4xl font-bold">Rp {{ number_format($totalVerified, 0, ',', '.') }}</p>
                        <p class="mt-2 text-sm text-blue-100">
                            {{ $verifiedCount }} transaksi lunas
                            @if($pendingCount > 0)
                                • {{ $pendingCount }} menunggu konfirmasi
                            @endif
                        </p>
                    </div>
                    <div class="rounded-full bg-white/20 p-6">
                        <svg class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>
            </div>
            @endif

            <!-- Transactions List -->
            <div class="rounded-2xl bg-white shadow-lg">
                @if(count($transactions) > 0)
                <div class="border-b border-gray-200 p-6">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-bold text-gray-900">Semua Transaksi</h2>
                        <button class="flex items-center gap-2 rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                            </svg>
                            Filter
                        </button>
                    </div>
                </div>
                @endif

                <div class="divide-y divide-gray-200">
                    @forelse($transactions as $transaction)
                        <div class="p-6 transition hover:bg-gray-50">
                            <div class="flex items-start justify-between">
                                <div class="flex gap-4">
                                    <!-- Icon -->
                                    @if($transaction['status'] === 'verified')
                                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-green-100">
                                            <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                    @elseif($transaction['status'] === 'pending')
                                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-yellow-100">
                                            <svg class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                    @elseif($transaction['status'] === 'rejected')
                                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-red-100">
                                            <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                    @endif

                                    <!-- Transaction Details -->
                                    <div>
                                        <h3 class="font-bold text-gray-900">{{ $transaction['program'] }}</h3>
                                        <div class="mt-2 space-y-1 text-sm text-gray-600">
                                            <div class="flex items-center gap-2">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                                </svg>
                                                <span>ID: {{ $transaction['id'] }}</span>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                <span>{{ \Carbon\Carbon::parse($transaction['date'])->format('d M Y, H:i') }}</span>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                                </svg>
                                                <span>{{ $transaction['payment_method'] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Amount & Status -->
                                <div class="text-right">
                                    <p class="text-xl font-bold text-gray-900">Rp {{ number_format($transaction['amount'], 0, ',', '.') }}</p>
                                    
                                    @if($transaction['status'] === 'verified')
                                        <span class="mt-2 inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-800">
                                            ✓ Lunas
                                        </span>
                                    @elseif($transaction['status'] === 'pending')
                                        <span class="mt-2 inline-flex items-center rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-800">
                                            ⏳ Menunggu Konfirmasi
                                        </span>
                                    @elseif($transaction['status'] === 'rejected')
                                        <span class="mt-2 inline-flex items-center rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-800">
                                            ✗ Ditolak
                                        </span>
                                    @endif
                                    
                                    @if($transaction['status'] === 'verified')
                                    <div class="mt-3">
                                        <a href="{{ $transaction['invoice_url'] }}" class="flex items-center gap-1 text-sm font-medium text-[#2D3C8C] hover:underline">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            Invoice
                                        </a>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-12 text-center">
                            <div class="mx-auto mb-4 flex h-20 w-20 items-center justify-center rounded-full bg-gray-100">
                                <svg class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900">Belum Ada Transaksi</h3>
                            <p class="mt-2 text-sm text-gray-600">Anda belum memiliki riwayat transaksi</p>
                            <div class="mt-6 flex justify-center gap-3">
                                <a href="{{ route('bimbel.ukom') }}" class="inline-flex items-center gap-2 rounded-lg bg-[#2D3C8C] px-6 py-3 text-white font-semibold hover:bg-blue-900 transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                    Bimbel UKOM
                                </a>
                                <a href="{{ route('cpns.p3k') }}" class="inline-flex items-center gap-2 rounded-lg border-2 border-[#2D3C8C] px-6 py-3 text-[#2D3C8C] font-semibold hover:bg-blue-50 transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    CPNS & P3K
                                </a>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Info Box -->
            <div class="mt-8 rounded-xl border border-blue-200 bg-blue-50 p-6">
                <div class="flex gap-4">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-blue-900">Butuh Bantuan?</h3>
                        <p class="mt-1 text-sm text-blue-700">Jika ada pertanyaan terkait transaksi, silakan hubungi tim support kami melalui WhatsApp di <a href="https://wa.me/6281536908359" class="font-semibold underline">+62 815-3690-8359</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

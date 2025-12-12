@extends('layouts.admin')

@section('title', 'Manajemen Pembayaran')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Manajemen Pembayaran</h1>
        <p class="mt-1 text-sm text-gray-500">Kelola transaksi dan konfirmasi pembayaran peserta</p>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="mb-6 rounded-lg bg-green-50 border border-green-200 p-4">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 rounded-lg bg-red-50 border border-red-200 p-4">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    <!-- Summary Cards -->
    <div class="mb-6 grid gap-4 sm:grid-cols-3">
        <div class="rounded-xl bg-white p-4 shadow-sm">
            <p class="text-sm text-gray-500">Pending</p>
            <p class="mt-2 text-2xl font-bold text-yellow-600">{{ $stats['pending'] }}</p>
            <p class="text-sm text-gray-500">Rp {{ number_format($stats['pending_amount'], 0, ',', '.') }}</p>
        </div>
        <div class="rounded-xl bg-white p-4 shadow-sm">
            <p class="text-sm text-gray-500">Terkonfirmasi Bulan Ini</p>
            <p class="mt-2 text-2xl font-bold text-green-600">{{ $stats['confirmed_this_month'] }}</p>
            <p class="text-sm text-gray-500">Rp {{ number_format($stats['confirmed_amount_this_month'], 0, ',', '.') }}</p>
        </div>
        <div class="rounded-xl bg-white p-4 shadow-sm">
            <p class="text-sm text-gray-500">Total Pendapatan</p>
            <p class="mt-2 text-2xl font-bold text-gray-900">Rp {{ number_format($stats['total_revenue'] / 1000000, 1, ',', '.') }}M</p>
            <p class="text-sm text-gray-500">Sepanjang waktu</p>
        </div>
    </div>

    <!-- Payments Table -->
    <div class="rounded-xl bg-white shadow-sm">
        <div class="border-b border-gray-200 p-4">
            <form method="GET" class="flex items-center gap-4">
                <select name="status" class="rounded-lg border-gray-300 text-sm">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Terkonfirmasi</option>
                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                </select>
                <input type="date" name="date" value="{{ request('date') }}" class="rounded-lg border-gray-300 text-sm">
                <button type="submit" class="rounded-lg bg-gray-100 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-200">
                    Filter
                </button>
                @if(request()->hasAny(['status', 'date']))
                    <a href="{{ route('admin.payments.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Reset Filter</a>
                @endif
            </form>
        </div>

        @if($payments->isEmpty())
            <div class="p-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada pembayaran</h3>
                <p class="mt-1 text-sm text-gray-500">Belum ada transaksi pembayaran di sistem.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-200 bg-gray-50">
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">Peserta</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">Program</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">Order</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">Jumlah</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">Status</th>
                            <th class="px-6 py-3 text-center text-xs font-semibold uppercase tracking-wide text-gray-600">Detail</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($payments as $payment)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($payment->order->user->name) }}&background=random" class="h-10 w-10 rounded-full">
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $payment->order->user->name }}</p>
                                        <p class="text-sm text-gray-500">{{ $payment->order->user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $payment->order->program->name }}</td>
                            <td class="px-6 py-4">
                                <span class="font-mono text-xs text-gray-600">#{{ $payment->order->order_number }}</span>
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-900">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $payment->created_at->format('d M Y, H:i') }}</td>
                            <td class="px-6 py-4">
                                @if($payment->status === 'pending')
                                    <span class="inline-flex items-center rounded-full bg-yellow-100 px-2.5 py-0.5 text-xs font-medium text-yellow-800">
                                        Pending
                                    </span>
                                @elseif($payment->status === 'paid')
                                    <span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">
                                        Terkonfirmasi
                                    </span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800">
                                        Ditolak
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($payment->status !== 'pending')
                                    <a href="{{ route('admin.payments.show', $payment->id) }}" 
                                       class="rounded p-1 text-gray-600 hover:bg-gray-100 inline-block" title="Lihat Detail">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                @else
                                    <span class="text-xs text-gray-400 italic">-</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="border-t border-gray-200 px-4 py-3">
                {{ $payments->links() }}
            </div>
        @endif
    </div>
@endsection

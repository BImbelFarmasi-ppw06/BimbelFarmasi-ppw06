<!-- Modal Header -->
<div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between bg-gradient-to-r from-blue-50 to-indigo-50">
    <div>
        <h3 class="text-lg font-bold text-gray-900">Detail Pembayaran</h3>
        <p class="text-sm text-gray-600 mt-0.5">Order #{{ $payment->order->order_number }}</p>
    </div>
    <button onclick="closePaymentModal()" class="text-gray-400 hover:text-gray-600">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </button>
</div>

<!-- Modal Body -->
<div class="px-6 py-6 max-h-[calc(100vh-200px)] overflow-y-auto">
    <!-- Order Info -->
    <div class="mb-5">
        <div class="flex items-center gap-2 mb-3">
            <svg class="w-5 h-5 text-[#2D3C8C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <h4 class="text-sm font-bold text-gray-800">Informasi Order</h4>
        </div>
        <div class="bg-gray-50 rounded-lg p-4 space-y-2.5">
            <div class="flex justify-between text-sm">
                <span class="text-gray-600">Nomor Order</span>
                <span class="font-semibold text-[#2D3C8C]">#{{ $payment->order->order_number }}</span>
            </div>
            <div class="border-t border-gray-200"></div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-600">Program</span>
                <span class="font-semibold text-gray-900 text-right">{{ $payment->order->program->name }}</span>
            </div>
            <div class="border-t border-gray-200"></div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-600">Total Harga</span>
                <span class="font-bold text-green-600">Rp {{ number_format($payment->amount, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    <!-- User Info -->
    <div class="mb-5">
        <div class="flex items-center gap-2 mb-3">
            <svg class="w-5 h-5 text-[#2D3C8C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            <h4 class="text-sm font-bold text-gray-800">Informasi Peserta</h4>
        </div>
        <div class="bg-white rounded-lg p-4 border border-gray-200">
            <div class="flex items-center gap-3">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($payment->order->user->name) }}&background=2D3C8C&color=fff&size=64" 
                     class="h-12 w-12 rounded-full">
                <div>
                    <p class="font-semibold text-gray-900">{{ $payment->order->user->name }}</p>
                    <p class="text-sm text-gray-600">{{ $payment->order->user->email }}</p>
                    @if($payment->order->user->phone)
                    <p class="text-sm text-gray-600">{{ $payment->order->user->phone }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Method -->
    <div class="mb-5">
        <div class="flex items-center gap-2 mb-3">
            <svg class="w-5 h-5 text-[#2D3C8C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
            </svg>
            <h4 class="text-sm font-bold text-gray-800">Metode Pembayaran</h4>
        </div>
        <div class="bg-gray-50 rounded-lg p-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-900">{{ ucwords(str_replace('_', ' ', $payment->payment_method)) }}</p>
                    <p class="text-xs text-gray-500">Dibayar: {{ $payment->created_at->format('d M Y, H:i') }} WIB</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Proof -->
    <div class="mb-5">
        <div class="flex items-center gap-2 mb-3">
            <svg class="w-5 h-5 text-[#2D3C8C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <h4 class="text-sm font-bold text-gray-800">Bukti Pembayaran</h4>
        </div>
        <div class="bg-white rounded-lg border-2 border-gray-200 overflow-hidden">
            <img src="{{ asset('storage/' . $payment->proof_url) }}" 
                 alt="Bukti Pembayaran" 
                 class="w-full h-auto cursor-pointer hover:opacity-90 transition"
                 onclick="window.open('{{ asset('storage/' . $payment->proof_url) }}', '_blank')">
            <p class="text-xs text-center text-gray-500 py-2 bg-gray-50">Klik gambar untuk melihat ukuran penuh</p>
        </div>
    </div>
</div>

<!-- Modal Footer -->
<div class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex gap-3 justify-end">
    <button onclick="closePaymentModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
        Tutup
    </button>
    @if($payment->status === 'pending')
    <form action="{{ route('admin.payments.reject', $payment->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menolak pembayaran ini?')">
        @csrf
        @method('PATCH')
        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700">
            Tolak Pembayaran
        </button>
    </form>
    <form action="{{ route('admin.payments.approve', $payment->id) }}" method="POST" class="inline" onsubmit="return confirm('Konfirmasi pembayaran ini?')">
        @csrf
        @method('PATCH')
        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700">
            Setujui Pembayaran
        </button>
    </form>
    @endif
</div>

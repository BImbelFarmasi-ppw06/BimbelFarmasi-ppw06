@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('admin.payments.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke Daftar Pembayaran
            </a>
        </div>

        <!-- Payment Detail Card -->
        <div class="bg-white rounded-xl shadow-lg">
            <!-- Header -->
            <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-t-xl">
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Detail Pembayaran</h3>
                    <p class="text-sm text-gray-600 mt-1">Order #{{ $payment->order->order_number }}</p>
                </div>
            </div>

            <!-- Content -->
            <div class="px-6 py-6">
        <!-- Order Info -->
        <div class="mb-6">
            <div class="flex items-center gap-2 mb-4">
                <svg class="w-5 h-5 text-[#2D3C8C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <h4 class="text-base font-bold text-gray-800">Informasi Order</h4>
            </div>
            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-5 border border-blue-100 shadow-sm">
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600 font-medium">Nomor Order</span>
                        <span class="text-sm font-bold text-[#2D3C8C] bg-white px-3 py-1 rounded-lg">#{{ $payment->order->order_number }}</span>
                    </div>
                    <div class="h-px bg-blue-200"></div>
                    <div class="flex justify-between items-start">
                        <span class="text-sm text-gray-600 font-medium">Program</span>
                        <span class="text-sm font-semibold text-gray-900 text-right max-w-xs">{{ $payment->order->program->name }}</span>
                    </div>
                    <div class="h-px bg-blue-200"></div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600 font-medium">Total Harga</span>
                        <span class="text-lg font-bold text-green-600">Rp {{ number_format($payment->amount, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Info -->
        <div class="mb-6">
            <div class="flex items-center gap-2 mb-4">
                <svg class="w-5 h-5 text-[#2D3C8C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                <h4 class="text-base font-bold text-gray-800">Informasi Peserta</h4>
            </div>
            <div class="bg-white rounded-xl p-5 border-2 border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center gap-4">
                    <div class="relative">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($payment->order->user->name) }}&background=2D3C8C&color=fff&size=80&bold=true" 
                             class="h-16 w-16 rounded-full ring-4 ring-blue-100">
                        <div class="absolute -bottom-1 -right-1 h-5 w-5 bg-green-500 border-2 border-white rounded-full"></div>
                    </div>
                    <div class="flex-1">
                        <p class="font-bold text-gray-900 text-lg">{{ $payment->order->user->name }}</p>
                        <div class="flex items-center gap-2 text-sm text-gray-600 mt-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <span>{{ $payment->order->user->email }}</span>
                        </div>
                        @if($payment->order->user->phone)
                        <div class="flex items-center gap-2 text-sm text-gray-600 mt-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <span>{{ $payment->order->user->phone }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Method -->
        <div class="mb-6">
            <div class="flex items-center gap-2 mb-4">
                <svg class="w-5 h-5 text-[#2D3C8C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                </svg>
                <h4 class="text-base font-bold text-gray-800">Metode Pembayaran</h4>
            </div>
            <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl p-5 border border-purple-100 shadow-sm">
                <div class="flex items-center gap-3">
                    @if($payment->payment_method === 'bank_transfer')
                        <div class="h-12 w-12 rounded-full bg-blue-500 flex items-center justify-center">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/>
                            </svg>
                        </div>
                    @elseif($payment->payment_method === 'ewallet')
                        <div class="h-12 w-12 rounded-full bg-green-500 flex items-center justify-center">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    @else
                        <div class="h-12 w-12 rounded-full bg-purple-500 flex items-center justify-center">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                            </svg>
                        </div>
                    @endif
                    <div>
                        <p class="text-base font-bold text-gray-900">
                            @if($payment->payment_method === 'bank_transfer')
                                Transfer Bank
                            @elseif($payment->payment_method === 'ewallet')
                                E-Wallet (OVO, GoPay, Dana)
                            @else
                                QRIS
                            @endif
                        </p>
                        <div class="flex items-center gap-2 text-xs text-gray-600 mt-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>Dibayar {{ $payment->created_at->format('d M Y, H:i') }} WIB</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Proof -->
        <div class="mb-6">
            <div class="flex items-center gap-2 mb-4">
                <svg class="w-5 h-5 text-[#2D3C8C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <h4 class="text-base font-bold text-gray-800">Bukti Pembayaran</h4>
            </div>
            <div class="bg-white rounded-xl p-4 border-2 border-dashed border-gray-200 hover:border-blue-300 transition-colors">
                @if($payment->proof_url)
                    <div class="relative group">
                        <img src="{{ asset('storage/' . $payment->proof_url) }}" 
                             alt="Bukti Pembayaran" 
                             class="w-full rounded-lg shadow-lg cursor-pointer transform transition-transform group-hover:scale-[1.02]"
                             onclick="openImageModal('{{ asset('storage/' . $payment->proof_url) }}')"
                             onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'400\' height=\'300\'%3E%3Crect width=\'400\' height=\'300\' fill=\'%23f3f4f6\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' dominant-baseline=\'middle\' text-anchor=\'middle\' font-family=\'sans-serif\' font-size=\'18\' fill=\'%23666\'%3EGambar tidak ditemukan%3C/text%3E%3C/svg%3E';">
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 rounded-lg transition-opacity flex items-center justify-center">
                            <div class="opacity-0 group-hover:opacity-100 transition-opacity">
                                <div class="bg-white rounded-full p-3 shadow-lg">
                                    <svg class="w-8 h-8 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 flex items-center justify-center gap-2 text-sm text-gray-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        <span class="font-medium">Klik untuk memperbesar</span>
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="w-20 h-20 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p class="text-base font-semibold text-gray-700">Bukti pembayaran belum diupload</p>
                        <p class="text-sm text-gray-500 mt-1">Customer belum mengunggah bukti transfer</p>
                    </div>
                @endif
            </div>
        </div>

        @if($payment->order->notes)
        <!-- Order Notes -->
        <div class="mb-6">
            <div class="flex items-center gap-2 mb-4">
                <svg class="w-5 h-5 text-[#2D3C8C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                </svg>
                <h4 class="text-base font-bold text-gray-800">Catatan dari Customer</h4>
            </div>
            <div class="bg-amber-50 border-l-4 border-amber-400 rounded-r-xl p-5 shadow-sm">
                <p class="text-sm text-gray-800 leading-relaxed italic">"{{ $payment->order->notes }}"</p>
            </div>
        </div>
        @endif
    </div>

    <!-- Footer Actions -->
    @if($payment->status === 'pending')
    <div class="px-6 py-5 bg-gradient-to-r from-gray-50 to-gray-100 border-t-2 border-gray-200 rounded-b-xl">
        <div class="flex gap-3 justify-end">
            <button 
                onclick="showRejectForm()" 
                class="px-6 py-3 border-2 border-red-300 text-red-700 rounded-xl hover:bg-red-50 font-semibold text-sm transition-all transform hover:scale-105 shadow-sm hover:shadow-md flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                Tolak Pembayaran
            </button>
            <form method="POST" action="{{ route('admin.payments.approve', $payment->id) }}" class="inline">
                @csrf
                <button 
                    type="submit" 
                    onclick="return confirm('Yakin ingin menyetujui pembayaran ini?')"
                    class="px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-xl hover:from-green-700 hover:to-green-800 font-semibold text-sm transition-all transform hover:scale-105 shadow-md hover:shadow-lg flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Setujui Pembayaran
                </button>
            </form>
        </div>
    </div>

    <!-- Reject Form (hidden by default) -->
    <div id="rejectForm" class="hidden px-6 py-5 bg-gradient-to-r from-red-50 to-pink-50 border-t-2 border-red-200">
        <form method="POST" action="{{ route('admin.payments.reject', $payment->id) }}">
            @csrf
            <label class="block text-sm font-bold text-gray-800 mb-3 flex items-center gap-2">
                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                Alasan Penolakan
            </label>
            <textarea 
                name="reason" 
                rows="3" 
                required
                placeholder="Contoh: Bukti pembayaran tidak jelas, jumlah tidak sesuai, dll."
                class="w-full rounded-xl border-2 border-red-200 focus:border-red-400 focus:ring-2 focus:ring-red-200 text-sm mb-4 shadow-sm"></textarea>
            <div class="flex gap-3 justify-end">
                <button 
                    type="button" 
                    onclick="hideRejectForm()"
                    class="px-5 py-2.5 text-gray-700 text-sm font-semibold bg-white border-2 border-gray-300 rounded-xl hover:bg-gray-50 transition-colors shadow-sm">
                    Batal
                </button>
                <button 
                    type="submit"
                    class="px-5 py-2.5 bg-gradient-to-r from-red-600 to-red-700 text-white text-sm font-semibold rounded-xl hover:from-red-700 hover:to-red-800 transition-all transform hover:scale-105 shadow-md hover:shadow-lg flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Tolak Pembayaran
                </button>
            </div>
        </form>
    </div>
    @else
    <div class="px-6 py-5 bg-gradient-to-r from-gray-50 to-gray-100 border-t-2 border-gray-200 rounded-b-xl">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="text-sm font-medium text-gray-600">Status Pembayaran:</span>
                @if($payment->status === 'paid')
                    <span class="px-4 py-2 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-xl text-sm font-semibold shadow-md flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Disetujui
                    </span>
                @else
                    <span class="px-4 py-2 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-xl text-sm font-semibold shadow-md flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Ditolak
                    </span>
                @endif
            </div>
            @if($payment->paid_at)
            <div class="flex items-center gap-2 text-sm text-gray-600 bg-white px-4 py-2 rounded-lg shadow-sm">
                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="font-medium">{{ $payment->paid_at->format('d M Y, H:i') }}</span>
            </div>
            @elseif($payment->notes)
            <div class="bg-red-50 px-4 py-2 rounded-lg border border-red-200">
                <p class="text-sm text-red-700 font-medium">{{ $payment->notes }}</p>
            </div>
            @endif
        </div>
        </div>
    </div>
    @endif
        </div>
        <!-- End Payment Detail Card -->
    </div>
</div>

<script>
    function showRejectForm() {
        document.getElementById('rejectForm').classList.remove('hidden');
    }
    
    function hideRejectForm() {
        document.getElementById('rejectForm').classList.add('hidden');
    }

    // Image modal/lightbox function
    function openImageModal(imageUrl) {
        // Create modal overlay
        const modal = document.createElement('div');
        modal.id = 'imageLightbox';
        modal.className = 'fixed inset-0 bg-black bg-opacity-90 z-[9999] flex items-center justify-center p-4';
        modal.onclick = function(e) {
            if (e.target === modal) closeImageModal();
        };

        // Create modal content
        modal.innerHTML = `
            <div class="relative max-w-6xl max-h-full">
                <button onclick="closeImageModal()" 
                        class="absolute -top-10 right-0 text-white hover:text-gray-300 text-3xl font-bold">
                    ✕
                </button>
                <img src="${imageUrl}" 
                     alt="Bukti Pembayaran" 
                     class="max-w-full max-h-[90vh] rounded-lg shadow-2xl">
                <div class="text-center mt-4">
                    <a href="${imageUrl}" 
                       target="_blank" 
                       download
                       class="inline-block px-4 py-2 bg-white text-gray-800 rounded-lg hover:bg-gray-100 text-sm font-medium">
                        📥 Download Gambar
                    </a>
                </div>
            </div>
        `;

        document.body.appendChild(modal);
        document.body.style.overflow = 'hidden';
    }

    function closeImageModal() {
        const modal = document.getElementById('imageLightbox');
        if (modal) {
            modal.remove();
            document.body.style.overflow = 'auto';
        }
    }

    // Close on ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeImageModal();
    });
</script>
@endsection

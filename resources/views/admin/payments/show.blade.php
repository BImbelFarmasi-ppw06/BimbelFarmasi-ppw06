<!-- Payment Detail Modal Content -->
<div class="bg-white">
    <!-- Header -->
    <div class="px-6 py-4 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-900">Detail Pembayaran</h3>
            <button onclick="closePaymentModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>

    <!-- Content -->
    <div class="px-6 py-4 max-h-[70vh] overflow-y-auto">
        <!-- Order Info -->
        <div class="mb-6">
            <h4 class="text-sm font-semibold text-gray-700 mb-3">Informasi Order</h4>
            <div class="bg-gray-50 rounded-lg p-4 space-y-2">
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Nomor Order</span>
                    <span class="text-sm font-semibold text-gray-900">#{{ $payment->order->order_number }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Program</span>
                    <span class="text-sm font-semibold text-gray-900">{{ $payment->order->program->name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Harga</span>
                    <span class="text-sm font-semibold text-gray-900">Rp {{ number_format($payment->amount, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- User Info -->
        <div class="mb-6">
            <h4 class="text-sm font-semibold text-gray-700 mb-3">Informasi Peserta</h4>
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="flex items-center gap-4 mb-3">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($payment->order->user->name) }}&background=random" 
                         class="h-12 w-12 rounded-full">
                    <div>
                        <p class="font-semibold text-gray-900">{{ $payment->order->user->name }}</p>
                        <p class="text-sm text-gray-600">{{ $payment->order->user->email }}</p>
                    </div>
                </div>
                @if($payment->order->user->phone)
                    <p class="text-sm text-gray-600">📱 {{ $payment->order->user->phone }}</p>
                @endif
            </div>
        </div>

        <!-- Payment Method -->
        <div class="mb-6">
            <h4 class="text-sm font-semibold text-gray-700 mb-3">Metode Pembayaran</h4>
            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-sm font-semibold text-gray-900">
                    @if($payment->payment_method === 'bank_transfer')
                        🏦 Transfer Bank
                    @elseif($payment->payment_method === 'ewallet')
                        💳 E-Wallet
                    @else
                        📱 QRIS
                    @endif
                </p>
                <p class="text-xs text-gray-500 mt-1">Dibayar pada {{ $payment->created_at->format('d M Y, H:i') }} WIB</p>
            </div>
        </div>

        <!-- Payment Proof -->
        <div class="mb-6">
            <h4 class="text-sm font-semibold text-gray-700 mb-3">Bukti Pembayaran</h4>
            <div class="bg-gray-50 rounded-lg p-4">
                @if($payment->proof_url)
                    <img src="{{ route('admin.payments.proof', $payment->id) }}" 
                         alt="Bukti Pembayaran" 
                         class="w-full rounded-lg border border-gray-200 cursor-pointer hover:shadow-lg transition-shadow"
                         onclick="openImageModal('{{ route('admin.payments.proof', $payment->id) }}')"
                         onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'400\' height=\'300\'%3E%3Crect width=\'400\' height=\'300\' fill=\'%23f3f4f6\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' dominant-baseline=\'middle\' text-anchor=\'middle\' font-family=\'sans-serif\' font-size=\'18\' fill=\'%23666\'%3EGambar tidak ditemukan%3C/text%3E%3C/svg%3E';">
                    <p class="text-xs text-gray-500 mt-2 text-center">Klik gambar untuk memperbesar</p>
                @else
                    <div class="text-center py-8 text-gray-400">
                        <svg class="w-16 h-16 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p class="text-sm">Bukti pembayaran belum diupload</p>
                    </div>
                @endif
            </div>
        </div>

        @if($payment->order->notes)
        <!-- Order Notes -->
        <div class="mb-6">
            <h4 class="text-sm font-semibold text-gray-700 mb-3">Catatan dari User</h4>
            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-sm text-gray-700">{{ $payment->order->notes }}</p>
            </div>
        </div>
        @endif
    </div>

    <!-- Footer Actions -->
    @if($payment->status === 'pending')
    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex gap-3 justify-end">
        <button 
            onclick="showRejectForm()" 
            class="px-4 py-2 border border-red-300 text-red-700 rounded-lg hover:bg-red-50 font-medium text-sm">
            Tolak Pembayaran
        </button>
        <form method="POST" action="{{ route('admin.payments.approve', $payment->id) }}" class="inline">
            @csrf
            <button 
                type="submit" 
                onclick="return confirm('Yakin ingin menyetujui pembayaran ini?')"
                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-medium text-sm">
                Setujui Pembayaran
            </button>
        </form>
    </div>

    <!-- Reject Form (hidden by default) -->
    <div id="rejectForm" class="hidden px-6 py-4 bg-red-50 border-t border-red-200">
        <form method="POST" action="{{ route('admin.payments.reject', $payment->id) }}">
            @csrf
            <label class="block text-sm font-semibold text-gray-700 mb-2">Alasan Penolakan</label>
            <textarea 
                name="reason" 
                rows="3" 
                required
                placeholder="Contoh: Bukti pembayaran tidak jelas, jumlah tidak sesuai, dll."
                class="w-full rounded-lg border-gray-300 text-sm mb-3"></textarea>
            <div class="flex gap-2 justify-end">
                <button 
                    type="button" 
                    onclick="hideRejectForm()"
                    class="px-4 py-2 text-gray-700 text-sm font-medium">
                    Batal
                </button>
                <button 
                    type="submit"
                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm font-medium">
                    Tolak Pembayaran
                </button>
            </div>
        </form>
    </div>
    @else
    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold text-gray-700">Status Pembayaran</p>
                <p class="text-xs text-gray-500 mt-1">
                    @if($payment->status === 'paid')
                        Disetujui pada {{ $payment->paid_at?->format('d M Y, H:i') ?? 'N/A' }}
                    @else
                        Ditolak • {{ $payment->notes }}
                    @endif
                </p>
            </div>
            <span class="px-4 py-2 rounded-full text-sm font-semibold
                {{ $payment->status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                {{ $payment->status === 'paid' ? 'Terkonfirmasi' : 'Ditolak' }}
            </span>
        </div>
    </div>
    @endif
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

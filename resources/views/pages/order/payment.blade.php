@extends('layouts.app')

@section('title', 'Pembayaran Order #' . $order->order_number)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-50 py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <!-- Order Summary -->
            <div class="bg-white rounded-2xl shadow-xl p-8 mb-8">
                <div class="flex items-center justify-between mb-6 pb-6 border-b">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 mb-2">Pembayaran</h1>
                        <p class="text-gray-600">Order #{{ $order->order_number }}</p>
                    </div>
                    <span class="px-4 py-2 bg-yellow-100 text-yellow-800 rounded-full text-sm font-semibold">
                        Menunggu Pembayaran
                    </span>
                </div>

                <!-- Program Info -->
                <div class="flex items-start gap-4 mb-6 pb-6 border-b">
                    <div class="w-16 h-16 rounded-xl bg-gradient-to-br from-[#2D3C8C] to-[#1e2761] flex items-center justify-center flex-shrink-0">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-bold text-gray-900 text-lg mb-1">{{ $order->program->name }}</h3>
                        <p class="text-gray-600 text-sm">{{ $order->program->description }}</p>
                        @if($order->notes)
                        <div class="mt-3 bg-gray-50 rounded-lg p-3">
                            <p class="text-sm text-gray-600"><span class="font-semibold">Catatan:</span> {{ $order->notes }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Total -->
                <div class="flex justify-between items-center">
                    <span class="text-gray-700 font-semibold">Total Pembayaran</span>
                    <span class="text-3xl font-bold text-[#2D3C8C]">Rp {{ number_format($order->amount, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- Payment Form -->
            <div class="bg-white rounded-2xl shadow-xl p-8">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Lakukan Pembayaran</h2>

                <!-- Payment Info -->
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6 mb-6">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-full bg-white shadow-md flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-[#2D3C8C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-bold text-gray-900 mb-2">Pembayaran Aman & Terpercaya</h3>
                            <p class="text-sm text-gray-600">Kami menggunakan Midtrans sebagai payment gateway yang aman dan terpercaya. Pilih metode pembayaran favorit Anda!</p>
                        </div>
                    </div>
                </div>

                <!-- Available Payment Methods -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <svg class="w-8 h-8 mx-auto mb-2 text-[#2D3C8C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                        <p class="text-xs text-gray-600 font-semibold">Transfer Bank</p>
                    </div>
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <svg class="w-8 h-8 mx-auto mb-2 text-[#2D3C8C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                        <p class="text-xs text-gray-600 font-semibold">E-Wallet</p>
                    </div>
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <svg class="w-8 h-8 mx-auto mb-2 text-[#2D3C8C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                        <p class="text-xs text-gray-600 font-semibold">Kartu Kredit</p>
                    </div>
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <svg class="w-8 h-8 mx-auto mb-2 text-[#2D3C8C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                        </svg>
                        <p class="text-xs text-gray-600 font-semibold">QRIS</p>
                    </div>
                </div>

                <!-- Midtrans Payment Button -->
                <button type="button" id="pay-button" class="w-full bg-gradient-to-r from-[#2D3C8C] to-[#1e2761] hover:from-[#1e2761] hover:to-[#2D3C8C] text-white font-bold py-5 px-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 flex items-center justify-center gap-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                    <span class="text-lg">Bayar Sekarang</span>
                </button>
                <p class="text-sm text-gray-500 text-center mt-4">Klik tombol di atas untuk memilih metode pembayaran</p>

                <!-- Security Badge -->
                <div class="mt-8 pt-6 border-t flex items-center justify-center gap-6 text-sm text-gray-500">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span>Aman</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span>Terverifikasi</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                        </svg>
                        <span>Real-time</span>
                    </div>
                </div>


            </div>

            <!-- Help -->
            <div class="mt-6 text-center">
                <p class="text-gray-600 text-sm">
                    Butuh bantuan? 
                    <a href="{{ route('kontak') }}" class="text-[#2D3C8C] font-semibold hover:underline">Hubungi Kami</a>
                </p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Midtrans Snap Integration
const payButton = document.getElementById('pay-button');
payButton.addEventListener('click', function() {
    payButton.disabled = true;
    payButton.innerHTML = '<svg class="animate-spin h-6 w-6 text-white mx-auto" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Loading...';
    
    // Get Snap Token from backend
    fetch('{{ route("order.snap-token", $order->order_number) }}')
        .then(response => response.json())
        .then(data => {
            if (data.snap_token) {
                // Trigger Snap popup
                window.snap.pay(data.snap_token, {
                    onSuccess: function(result) {
                        console.log('Payment success:', result);
                        
                        // Check payment status dari Midtrans server
                        fetch('{{ route("order.check-status", $order->order_number) }}')
                            .then(response => response.json())
                            .then(statusData => {
                                console.log('Status updated:', statusData);
                                window.location.href = '{{ route("order.success", $order->order_number) }}';
                            })
                            .catch(error => {
                                console.error('Status check error:', error);
                                // Tetap redirect ke success page meskipun check status gagal
                                window.location.href = '{{ route("order.success", $order->order_number) }}';
                            });
                    },
                    onPending: function(result) {
                        console.log('Payment pending:', result);
                        alert('Pembayaran Anda sedang diproses. Mohon selesaikan pembayaran.');
                    },
                    onError: function(result) {
                        console.log('Payment error:', result);
                        alert('Terjadi kesalahan saat memproses pembayaran. Silakan coba lagi.');
                        payButton.disabled = false;
                        payButton.innerHTML = '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg><span class="text-lg">Bayar Sekarang</span>';
                    },
                    onClose: function() {
                        console.log('Payment popup closed');
                        payButton.disabled = false;
                        payButton.innerHTML = '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg><span class="text-lg">Bayar Sekarang</span>';
                    }
                });
            } else {
                alert('Gagal mendapatkan token pembayaran: ' + (data.error || 'Unknown error'));
                payButton.disabled = false;
                payButton.innerHTML = '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg><span class="text-lg">Bayar Sekarang</span>';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Gagal menghubungi server. Silakan coba lagi.');
            payButton.disabled = false;
            payButton.innerHTML = '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg><span class="text-lg">Bayar Sekarang</span>';
        });
});
</script>

<!-- Midtrans Snap Script -->
<script src="https://app.{{ config('midtrans.is_production') ? '' : 'sandbox.' }}midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
@endpush
@endsection

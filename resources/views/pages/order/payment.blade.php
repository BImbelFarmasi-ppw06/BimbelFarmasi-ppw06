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
                <h2 class="text-xl font-bold text-gray-900 mb-6">Informasi Pembayaran</h2>

                <!-- Bank Account Info -->
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6 mb-6">
                    <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#2D3C8C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                        Transfer ke Rekening Berikut:
                    </h3>
                    <div class="space-y-3 bg-white rounded-lg p-4">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Bank</span>
                            <span class="font-bold text-gray-900">BCA</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">No. Rekening</span>
                            <span class="font-bold text-gray-900 text-lg">1234567890</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Atas Nama</span>
                            <span class="font-bold text-gray-900">Bimbel Farmasi</span>
                        </div>
                        <div class="flex justify-between items-center pt-3 border-t">
                            <span class="text-gray-600">Jumlah Transfer</span>
                            <span class="font-bold text-[#2D3C8C] text-xl">Rp {{ number_format($order->amount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Upload Proof Form -->
                @if($order->payment && $order->payment->status === 'paid')
                    <!-- Pembayaran Sudah Diverifikasi Admin -->
                    <div class="bg-green-50 border border-green-200 rounded-xl p-6 text-center">
                        <svg class="w-16 h-16 mx-auto mb-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <h3 class="text-xl font-bold text-green-900 mb-2">Pembayaran Terverifikasi</h3>
                        <p class="text-green-700">Pembayaran Anda telah dikonfirmasi oleh admin.</p>
                    </div>
                @elseif($order->payment && $order->payment->proof_url)
                    <!-- Sudah Upload, Menunggu Verifikasi Admin -->
                    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6 text-center">
                        <svg class="w-16 h-16 mx-auto mb-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <h3 class="text-xl font-bold text-yellow-900 mb-2">Menunggu Verifikasi</h3>
                        <p class="text-yellow-700 mb-4">Bukti pembayaran Anda sedang dalam proses verifikasi oleh admin.</p>
                        
                        <!-- Preview Bukti yang Sudah Diupload -->
                        <div class="mt-4">
                            <img src="{{ asset('storage/' . $order->payment->proof_url) }}" alt="Bukti Pembayaran" class="max-w-sm mx-auto rounded-lg shadow-md">
                        </div>
                    </div>
                @else
                    <!-- Belum Upload - Tampilkan Form -->
                    <form action="{{ route('payment.upload', $order->order_number) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Payment Method Selection -->
                        <div class="mb-6">
                            <label class="block text-gray-700 font-semibold mb-3">Metode Pembayaran</label>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="payment_method" value="bank_transfer" required class="peer hidden">
                                    <div class="border-2 border-gray-300 peer-checked:border-[#2D3C8C] peer-checked:bg-blue-50 rounded-lg p-4 text-center transition-all">
                                        <svg class="w-8 h-8 mx-auto mb-2 text-gray-600 peer-checked:text-[#2D3C8C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                        </svg>
                                        <p class="text-sm font-semibold">Transfer Bank</p>
                                    </div>
                                </label>
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="payment_method" value="ewallet" class="peer hidden">
                                    <div class="border-2 border-gray-300 peer-checked:border-[#2D3C8C] peer-checked:bg-blue-50 rounded-lg p-4 text-center transition-all">
                                        <svg class="w-8 h-8 mx-auto mb-2 text-gray-600 peer-checked:text-[#2D3C8C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                        </svg>
                                        <p class="text-sm font-semibold">E-Wallet</p>
                                    </div>
                                </label>
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="payment_method" value="qris" class="peer hidden">
                                    <div class="border-2 border-gray-300 peer-checked:border-[#2D3C8C] peer-checked:bg-blue-50 rounded-lg p-4 text-center transition-all">
                                        <svg class="w-8 h-8 mx-auto mb-2 text-gray-600 peer-checked:text-[#2D3C8C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                                        </svg>
                                        <p class="text-sm font-semibold">QRIS</p>
                                    </div>
                                </label>
                            </div>
                            @error('payment_method')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Upload Bukti -->
                        <div class="mb-6">
                            <label class="block text-gray-700 font-semibold mb-3">Upload Bukti Pembayaran</label>
                            <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-[#2D3C8C] transition-colors">
                                <input type="file" name="proof" id="payment_proof" accept="image/*" required class="hidden">
                                <label for="payment_proof" class="cursor-pointer">
                                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                    </svg>
                                    <p class="text-gray-600 mb-2">Klik untuk upload bukti transfer</p>
                                    <p class="text-sm text-gray-500">Format: JPG, PNG (Max. 2MB)</p>
                                </label>
                                <div id="file-name" class="mt-4 text-sm text-gray-600"></div>
                            </div>
                            @error('proof')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="w-full bg-gradient-to-r from-[#2D3C8C] to-[#1e2761] hover:from-[#1e2761] hover:to-[#2D3C8C] text-white font-bold py-4 px-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 flex items-center justify-center gap-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-lg">Kirim Bukti Pembayaran</span>
                        </button>
                    </form>
                @endif

                <!-- Instructions -->
                <div class="mt-6 bg-blue-50 rounded-lg p-4">
                    <h4 class="font-semibold text-gray-900 mb-2 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Petunjuk Pembayaran:
                    </h4>
                    <ol class="text-sm text-gray-700 space-y-1 ml-7 list-decimal">
                        <li>Transfer sesuai jumlah yang tertera ke rekening di atas</li>
                        <li>Ambil screenshot/foto bukti transfer</li>
                        <li>Upload bukti transfer menggunakan form di atas</li>
                        <li>Tunggu konfirmasi dari admin (maksimal 1x24 jam)</li>
                    </ol>
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
// File upload preview
const fileInput = document.getElementById('payment_proof');
const fileName = document.getElementById('file-name');

if (fileInput) {
    fileInput.addEventListener('change', function(e) {
        if (e.target.files.length > 0) {
            const file = e.target.files[0];
            const fileSize = (file.size / 1024 / 1024).toFixed(2); // MB
            
            if (fileSize > 2) {
                alert('Ukuran file terlalu besar. Maksimal 2MB');
                e.target.value = '';
                fileName.textContent = '';
                return;
            }
            
            fileName.innerHTML = `<strong>${file.name}</strong> (${fileSize} MB)`;
        }
    });
}
</script>
@endpush
@endsection

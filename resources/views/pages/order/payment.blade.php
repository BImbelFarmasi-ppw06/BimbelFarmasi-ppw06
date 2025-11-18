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
                <h2 class="text-xl font-bold text-gray-900 mb-6">Pilih Metode Pembayaran</h2>

                <form action="{{ route('order.payment.process', $order->order_number) }}" method="POST" enctype="multipart/form-data" x-data="{ selectedMethod: '' }">
                    @csrf

                    <!-- Payment Methods -->
                    <div class="space-y-4 mb-8">
                        <!-- Bank Transfer -->
                        <label class="block cursor-pointer">
                            <input type="radio" name="payment_method" value="bank_transfer" class="peer sr-only" x-model="selectedMethod" required>
                            <div class="border-2 border-gray-200 peer-checked:border-[#2D3C8C] peer-checked:bg-blue-50 rounded-xl p-4 transition-all hover:border-gray-300">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-bold text-gray-900">Transfer Bank</p>
                                        <p class="text-sm text-gray-600">BCA, BNI, Mandiri, BRI</p>
                                    </div>
                                    <svg class="w-6 h-6 text-[#2D3C8C] hidden peer-checked:block" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            </div>
                        </label>

                        <!-- E-Wallet -->
                        <label class="block cursor-pointer">
                            <input type="radio" name="ethod" value="ewallet" class="peer sr-only" x-model="selectedMethod">
                            <div class="border-2 border-gray-200 peer-checked:border-[#2D3C8C] peer-checked:bg-blue-50 rounded-xl p-4 transition-all hover:border-gray-300">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-bold text-gray-900">E-Wallet</p>
                                        <p class="text-sm text-gray-600">GoPay, OVO, DANA, ShopeePay</p>
                                    </div>
                                    <svg class="w-6 h-6 text-[#2D3C8C] hidden peer-checked:block" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            </div>
                        </label>

                        <!-- QRIS -->
                        <label class="block cursor-pointer">
                            <i="radio" name="payment_method" value="qris" class="peer sr-only" x-model="selectedMethod">
                            <div class="border-2 border-gray-200 peer-checked:border-[#2D3C8C] peer-checked:bg-blue-50 rounded-xl p-4 transition-all hover:border-gray-300">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-bold text-gray-900">QRIS</p>
                                        <p class="text-sm text-gray-600">Scan QR Code untuk bayar</p>
                                    </div>
                                    <svg class="w-6 h-6 text-[#2D3C8C] hidden peer-checked:block" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            </div>
                        </label>
                    </div>
                    @error('payment_method')
                        <p class="text-red-500 text-sm mb-4">{{ $message }}</p>
                    @enderror

                    <!-- Payment Instructions (shown when method selected) -->
                    <div x-show="selectedMethod" x-transition class="bg-blue-50 border border-blue-200 rounded-xl p-6 mb-8">
                        <h3 class="font-bold text-gray-900 mb-3">Instruksi Pembayaran</h3>
                        
                        <div x-show="selectedMethod === 'bank_transfer'">
                            <p class="text-sm text-gray-700 mb-3">Transfer ke salah satu rekening berikut:</p>
                            <div class="space-y-2 text-sm">
                                <div class="bg-white rounded-lg p-3">
                                    <p class="font-semibold text-gray-900">BCA - 1234567890</p>
                                    <p class="text-gray-600">a.n. PT Bimble Farmasi Indonesia</p>
                                </div>
                                <div class="bg-white rounded-lg p-3">
                                    <p class="font-semibold text-gray-900">Mandiri - 9876543210</p>
                                    <p class="text-gray-600">a.n. PT Bimble Farmasi Indonesia</p>
                                </div>
                            </div>
                        </div>

                        <div x-show="selectedMethod === 'ewallet'">
                            <p class="text-sm text-gray-700 mb-3">Transfer ke nomor e-wallet:</p>
                            <div class="bg-white rounded-lg p-3">
                                <p class="font-semibold text-gray-900">0812-3456-7890</p>
                                <p class="text-gray-600">a.n. Bimble Farmasi</p>
                            </div>
                        </div>

                        <div x-show="selectedMethod === 'qris'">
                            <p class="text-sm text-gray-700 mb-3">Scan QR Code berikut untuk melakukan pembayaran:</p>
                            <div class="bg-white rounded-lg p-4 inline-block">
                                <img src="https://via.placeholder.com/200x200?text=QR+Code" alt="QRIS" class="w-48 h-48">
                            </div>
                        </div>
                    </div>

                    <!-- Upload Proof -->
                    <div class="mb-8">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            Upload Bukti Pembayaran <span class="text-red-500">*</span>
                        </label>
                        
                        <!-- Upload Button -->
                        <div class="flex items-center gap-4 mb-4">
                            <button type="button" onclick="document.getElementById('proof-input').click()" class="inline-flex items-center gap-2 px-6 py-3 bg-[#2D3C8C] text-white font-semibold rounded-lg hover:bg-blue-900 transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                </svg>
                                Pilih File
                            </button>
                            <input type="file" name="proof" accept="image/png,image/jpeg,image/jpg" class="hidden" id="proof-input" onchange="showPreview(this)" required>
                            <span class="text-sm text-gray-500">Format: PNG, JPG, JPEG (Max: 2MB)</span>
                        </div>

                        <!-- File Preview Area -->
                        <div id="file-preview-area" style="display:none" class="mt-4 border-2 border-green-300 bg-green-50 rounded-lg p-4">
                            <div class="flex items-start gap-4">
                                <!-- Thumbnail Preview -->
                                <div class="flex-shrink-0">
                                    <img id="preview-thumbnail" src="" class="w-24 h-24 object-cover rounded-lg border-2 border-gray-300" alt="Preview">
                                </div>
                                <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                                <p class="text-gray-600 mb-1">Klik untuk upload gambar</p>
                                <p class="text-sm text-gray-500">PNG, JPG maksimal 2MB</p>
                            </label>
                        </div>
                        @error('proof')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full bg-gradient-to-r from-[#2D3C8C] to-[#1e2761] text-white font-bold py-4 rounded-xl hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                        Kirim Bukti Pembayaran
                        <svg class="w-5 h-5 inline-block ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </button>
                </form>
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
function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview-image').src = e.target.result;
            document.getElementById('preview-container').classList.remove('hidden');
        }
        reader.readAsDataURL(file);
    }
}
</script>
@endpush
@endsection

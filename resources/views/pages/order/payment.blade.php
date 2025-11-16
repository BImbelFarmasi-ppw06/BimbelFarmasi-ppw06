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
                            <input type="radio" name="payment_method" value="ewallet" class="peer sr-only" x-model="selectedMethod" required>
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
                            <input type="radio" name="payment_method" value="qris" class="peer sr-only" x-model="selectedMethod" required>
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
                                
                                <!-- File Info -->
                                <div class="flex-1">
                                    <div class="flex items-start justify-between">
                                        <div>
                                            <div class="flex items-center gap-2 mb-1">
                                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                <span class="font-bold text-green-800">File berhasil dipilih</span>
                                            </div>
                                            <p class="text-sm text-gray-700 font-medium" id="preview-filename"></p>
                                            <p class="text-xs text-gray-600" id="preview-filesize"></p>
                                        </div>
                                        <button type="button" onclick="removeFile()" class="text-red-600 hover:text-red-800 p-2 hover:bg-red-100 rounded-lg transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="mt-3 bg-white rounded-lg p-3 border border-green-200">
                                        <p class="text-xs text-gray-600 mb-2">Preview:</p>
                                        <img id="preview-full" src="" class="max-w-full max-h-48 rounded border border-gray-200" alt="Preview Full">
                                    </div>
                                </div>
                            </div>
                        </div>

                        @error('proof')
                            <div class="mt-3 bg-red-50 border border-red-200 rounded-lg p-3 flex items-center gap-2">
                                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <p class="text-red-700 text-sm font-semibold">{{ $message }}</p>
                            </div>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" id="submit-btn" disabled class="w-full bg-gray-400 text-white font-bold py-4 rounded-xl cursor-not-allowed transition-all duration-200">
                        <span id="submit-text">Upload Bukti Pembayaran Dulu</span>
                        <svg class="w-5 h-5 inline-block ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
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
// Global variables
var hasFileUploaded = false;

function showPreview(input) {
    console.log('showPreview called', input.files);
    var file = input.files[0];
    
    if (!file) {
        console.log('No file selected');
        hidePreview();
        return;
    }
    
    console.log('File selected:', file.name, file.type, file.size);
    
    // Validate file type
    var validTypes = ['image/jpeg', 'image/jpg', 'image/png'];
    if (!validTypes.includes(file.type)) {
        alert('❌ File harus berupa gambar!\n\nFormat yang diizinkan: PNG, JPG, atau JPEG');
        input.value = '';
        hidePreview();
        return;
    }
    
    // Validate file size (max 2MB)
    var maxSize = 2 * 1024 * 1024;
    if (file.size > maxSize) {
        alert('❌ Ukuran file terlalu besar!\n\nUkuran maksimal: 2MB\nUkuran file Anda: ' + (file.size / 1024 / 1024).toFixed(2) + ' MB');
        input.value = '';
        hidePreview();
        return;
    }
    
    // Show file info
    document.getElementById('preview-filename').textContent = '📄 ' + file.name;
    document.getElementById('preview-filesize').textContent = '💾 ' + formatFileSize(file.size);
    
    // Read and display image
    var reader = new FileReader();
    
    reader.onload = function(e) {
        console.log('Image loaded successfully');
        var imageData = e.target.result;
        document.getElementById('preview-thumbnail').src = imageData;
        document.getElementById('preview-full').src = imageData;
        document.getElementById('file-preview-area').style.display = 'block';
        hasFileUploaded = true;
        updateSubmitButton();
    };
    
    reader.onerror = function() {
        console.error('Failed to read file');
        alert('❌ Gagal membaca file. Silakan coba lagi.');
        hidePreview();
    };
    
    reader.readAsDataURL(file);
}

function removeFile() {
    if (hasFileUploaded && !confirm('Apakah Anda yakin ingin menghapus file ini?')) {
        return;
    }
    hidePreview();
}

function hidePreview() {
    document.getElementById('proof-input').value = '';
    document.getElementById('file-preview-area').style.display = 'none';
    document.getElementById('preview-thumbnail').src = '';
    document.getElementById('preview-full').src = '';
    document.getElementById('preview-filename').textContent = '';
    document.getElementById('preview-filesize').textContent = '';
    hasFileUploaded = false;
    updateSubmitButton();
}

function updateSubmitButton() {
    var submitBtn = document.getElementById('submit-btn');
    var submitText = document.getElementById('submit-text');
    var submitIcon = submitBtn.querySelector('svg path');
    
    console.log('Updating submit button, hasFileUploaded:', hasFileUploaded);
    
    if (hasFileUploaded) {
        submitBtn.disabled = false;
        submitBtn.className = 'w-full bg-gradient-to-r from-[#2D3C8C] to-[#1e2761] text-white font-bold py-4 rounded-xl hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200';
        submitText.textContent = 'Kirim Bukti Pembayaran';
        submitIcon.setAttribute('d', 'M5 13l4 4L19 7');
    } else {
        submitBtn.disabled = true;
        submitBtn.className = 'w-full bg-gray-400 text-white font-bold py-4 rounded-xl cursor-not-allowed transition-all duration-200';
        submitText.textContent = 'Upload Bukti Pembayaran Dulu';
        submitIcon.setAttribute('d', 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z');
    }
}

function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    var k = 1024;
    var sizes = ['Bytes', 'KB', 'MB'];
    var i = Math.floor(Math.log(bytes) / Math.log(k));
    return Math.round((bytes / Math.pow(k, i)) * 100) / 100 + ' ' + sizes[i];
}

// Initialize on page load
window.addEventListener('DOMContentLoaded', function() {
    console.log('Payment page script loaded');
    updateSubmitButton();
});
</script>
@endpush
@endsection

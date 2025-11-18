@extends('layouts.app')

@section('title', 'Beri Testimoni - ' . $order->program->name)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-50 py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto">
            <!-- Header -->
            <div class="mb-8 text-center">
                <h1 class="text-4xl font-bold text-gray-900 mb-3">Beri Testimoni</h1>
                <p class="text-gray-600">Bagikan pengalaman Anda mengikuti program ini</p>
            </div>

            <!-- Program Info -->
            <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
                <div class="flex items-start gap-4">
                    <div class="w-16 h-16 rounded-xl bg-gradient-to-br from-[#2D3C8C] to-[#1e2761] flex items-center justify-center flex-shrink-0">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-bold text-gray-900 text-lg">{{ $order->program->name }}</h3>
                        <p class="text-sm text-gray-600 mt-1">Order #{{ $order->order_number }}</p>
                        <p class="text-sm text-gray-500 mt-1">Tanggal Order: {{ $order->created_at->format('d M Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- Testimonial Form -->
            <div class="bg-white rounded-2xl shadow-lg p-8">
                <form action="{{ route('testimonials.store', $order->order_number) }}" method="POST" x-data="{ rating: 0, comment: '' }">
                    @csrf

                    <!-- Rating -->
                    <div class="mb-8">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            Rating <span class="text-red-500">*</span>
                        </label>
                        <p class="text-sm text-gray-600 mb-4">Berikan rating untuk program ini</p>
                        
                        <div class="flex items-center gap-2">
                            @for($i = 1; $i <= 5; $i++)
                            <label class="cursor-pointer">
                                <input type="radio" name="rating" value="{{ $i }}" class="sr-only" x-model="rating" required>
                                <svg x-bind:class="rating >= {{ $i }} ? 'text-yellow-400' : 'text-gray-300'" class="w-12 h-12 transition-colors hover:text-yellow-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            </label>
                            @endfor
                        </div>
                        
                        <p x-show="rating > 0" x-cloak class="mt-3 text-sm font-semibold text-[#2D3C8C]">
                            Rating: <span x-text="rating"></span> dari 5 bintang
                        </p>

                        @error('rating')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Comment -->
                    <div class="mb-8">
                        <label for="comment" class="block text-sm font-semibold text-gray-700 mb-3">
                            Komentar / Kesan & Pesan <span class="text-red-500">*</span>
                        </label>
                        <p class="text-sm text-gray-600 mb-4">Ceritakan pengalaman Anda mengikuti program ini (minimal 10 karakter)</p>
                        
                        <textarea 
                            name="comment" 
                            id="comment" 
                            rows="6" 
                            x-model="comment"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-[#2D3C8C] focus:ring-2 focus:ring-blue-100 transition-all"
                            placeholder="Contoh: Program sangat membantu dalam persiapan UKOM. Materi lengkap, mentor ramah dan responsif. Saya jadi lebih percaya diri menghadapi ujian..."
                            required
                        ></textarea>

                        <div class="mt-2 flex justify-between text-sm">
                            <p class="text-gray-500">
                                <span x-text="comment.length"></span> / 1000 karakter
                            </p>
                            <p x-show="comment.length < 10" x-cloak class="text-red-500">
                                Minimal 10 karakter
                            </p>
                            <p x-show="comment.length >= 10" x-cloak class="text-green-600">
                                ✓ Sudah cukup
                            </p>
                        </div>

                        @error('comment')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Info Box -->
                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-8">
                        <div class="flex gap-3">
                            <svg class="w-6 h-6 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div class="text-sm text-blue-800">
                                <p class="font-semibold mb-1">Catatan Penting:</p>
                                <ul class="space-y-1 list-disc list-inside">
                                    <li>Testimoni Anda akan ditinjau oleh admin terlebih dahulu</li>
                                    <li>Testimoni yang disetujui akan ditampilkan di halaman publik</li>
                                    <li>Pastikan testimoni sesuai dengan pengalaman yang sebenarnya</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-4">
                        <a href="{{ route('order.myOrders') }}" class="flex-1 bg-gray-200 text-gray-700 font-bold py-4 rounded-xl text-center hover:bg-gray-300 transition-all">
                            Batal
                        </a>
                        <button 
                            type="submit" 
                            x-bind:disabled="rating === 0 || comment.length < 10"
                            x-bind:class="rating > 0 && comment.length >= 10 ? 'bg-gradient-to-r from-[#2D3C8C] to-[#1e2761] hover:shadow-xl cursor-pointer' : 'bg-gray-400 cursor-not-allowed'"
                            class="flex-1 text-white font-bold py-4 rounded-xl transition-all duration-200"
                        >
                            <span x-show="rating > 0 && comment.length >= 10">Kirim Testimoni</span>
                            <span x-show="rating === 0 || comment.length < 10" x-cloak>Lengkapi Form Dulu</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    [x-cloak] { display: none !important; }
</style>
@endsection

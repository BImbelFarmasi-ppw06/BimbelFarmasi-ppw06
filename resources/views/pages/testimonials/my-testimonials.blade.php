@extends('layouts.app')

@section('title', 'Testimoni Saya')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-50 py-16">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="max-w-4xl mx-auto mb-12">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">Testimoni Saya</h1>
                    <p class="text-gray-600">Kelola semua testimoni yang Anda berikan</p>
                </div>
                <a href="{{ route('order.myOrders') }}" class="bg-gradient-to-r from-[#2D3C8C] to-[#1e2761] text-white font-bold px-6 py-3 rounded-xl hover:shadow-xl transition-all">
                    Buat Testimoni Baru
                </a>
            </div>
        </div>

        <div class="max-w-4xl mx-auto">
            @if($testimonials->isEmpty())
                <!-- Empty State -->
                <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Belum Ada Testimoni</h3>
                    <p class="text-gray-600 mb-6">Anda belum memberikan testimoni untuk program apapun</p>
                    <a href="{{ route('order.myOrders') }}" class="inline-block bg-gradient-to-r from-[#2D3C8C] to-[#1e2761] text-white font-bold px-6 py-3 rounded-xl hover:shadow-xl transition-all">
                        Lihat Order Saya
                    </a>
                </div>
            @else
                <!-- Success Message -->
                @if(session('success'))
                    <div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-6">
                        <div class="flex items-center gap-2 text-green-800">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="font-semibold">{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                <!-- Testimonials List -->
                <div class="space-y-6">
                    @foreach($testimonials as $testimonial)
                    <div class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-xl transition-all">
                        <!-- Header -->
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2">
                                    <h3 class="font-bold text-gray-900 text-lg">{{ $testimonial->program->name }}</h3>
                                    
                                    @if($testimonial->is_approved)
                                        <span class="inline-flex items-center gap-1 bg-green-50 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            Disetujui
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 bg-yellow-50 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            Menunggu Persetujuan
                                        </span>
                                    @endif
                                </div>
                                
                                <p class="text-sm text-gray-500">
                                    Order #{{ $testimonial->order->order_number }} • 
                                    Dibuat {{ $testimonial->created_at->format('d M Y') }}
                                    @if($testimonial->updated_at != $testimonial->created_at)
                                        • Diupdate {{ $testimonial->updated_at->diffForHumans() }}
                                    @endif
                                </p>
                            </div>

                            <!-- Rating -->
                            <div class="flex gap-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-5 h-5 {{ $i <= $testimonial->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                            </div>
                        </div>

                        <!-- Comment -->
                        <div class="bg-gray-50 rounded-xl p-4 mb-4">
                            <p class="text-gray-700 leading-relaxed">
                                "{{ $testimonial->comment }}"
                            </p>
                        </div>

                        <!-- Actions -->
                        <div class="flex gap-3">
                            <a href="{{ route('testimonials.edit', $testimonial->id) }}" class="flex-1 bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg text-center hover:bg-blue-700 transition-all">
                                Edit Testimoni
                            </a>
                            
                            <form action="{{ route('testimonials.destroy', $testimonial->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Apakah Anda yakin ingin menghapus testimoni ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full bg-red-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-red-700 transition-all">
                                    Hapus Testimoni
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($testimonials->hasPages())
                    <div class="mt-8">
                        {{ $testimonials->links() }}
                    </div>
                @endif
            @endif
        </div>

        <!-- Info Box -->
        <div class="max-w-4xl mx-auto mt-12">
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
                <div class="flex gap-4">
                    <svg class="w-6 h-6 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div class="text-sm text-blue-800">
                        <p class="font-semibold mb-2">Tentang Testimoni</p>
                        <ul class="space-y-1 list-disc list-inside">
                            <li>Testimoni Anda akan ditinjau oleh admin sebelum ditampilkan secara publik</li>
                            <li>Anda dapat mengedit atau menghapus testimoni kapan saja</li>
                            <li>Testimoni yang disetujui akan muncul di halaman publik dan membantu mahasiswa lain</li>
                            <li>Perubahan pada testimoni yang sudah disetujui mungkin memerlukan persetujuan ulang</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

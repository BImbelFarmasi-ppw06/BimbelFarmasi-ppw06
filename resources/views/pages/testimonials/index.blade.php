@extends('layouts.app')

@section('title', 'Testimoni Mahasiswa')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-50 py-16">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="max-w-4xl mx-auto mb-12 text-center">
            <h1 class="text-5xl font-bold text-gray-900 mb-4">Testimoni Mahasiswa</h1>
            <p class="text-xl text-gray-600">Apa kata mereka yang sudah mengikuti program kami</p>
        </div>

        @if($testimonials->isEmpty())
            <!-- Empty State -->
            <div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-lg p-12 text-center">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Belum Ada Testimoni</h3>
                <p class="text-gray-600">Jadilah yang pertama memberikan testimoni untuk program kami!</p>
            </div>
        @else
            <!-- Statistics -->
            <div class="max-w-4xl mx-auto mb-12">
                <div class="bg-white rounded-2xl shadow-lg p-8">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <!-- Average Rating -->
                        <div class="text-center">
                            <div class="text-5xl font-bold text-[#2D3C8C] mb-2">
                                {{ number_format($averageRating, 1) }}
                            </div>
                            <div class="flex justify-center gap-1 mb-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-6 h-6 {{ $i <= round($averageRating) ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                            </div>
                            <p class="text-gray-600 text-sm">Rating Rata-rata</p>
                        </div>

                        <!-- Total Testimonials -->
                        <div class="text-center border-l border-r border-gray-200">
                            <div class="text-5xl font-bold text-[#2D3C8C] mb-2">
                                {{ $testimonials->total() }}
                            </div>
                            <p class="text-gray-600 text-sm">Total Testimoni</p>
                        </div>

                        <!-- Satisfaction Rate -->
                        <div class="text-center">
                            <div class="text-5xl font-bold text-[#2D3C8C] mb-2">
                                {{ $satisfactionRate }}%
                            </div>
                            <p class="text-gray-600 text-sm">Tingkat Kepuasan</p>
                            <p class="text-xs text-gray-500 mt-1">(Rating ≥ 4)</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Testimonials Grid -->
            <div class="max-w-6xl mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    @foreach($testimonials as $testimonial)
                    <div class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-xl transition-all duration-300">
                        <!-- Header -->
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-[#2D3C8C] to-[#1e2761] flex items-center justify-center text-white font-bold text-lg">
                                    {{ strtoupper(substr($testimonial->user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900">{{ $testimonial->user->name }}</h3>
                                    <p class="text-sm text-gray-500">{{ $testimonial->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            
                            <!-- Rating Stars -->
                            <div class="flex gap-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-5 h-5 {{ $i <= $testimonial->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                            </div>
                        </div>

                        <!-- Program Badge -->
                        <div class="inline-flex items-center gap-2 bg-blue-50 text-[#2D3C8C] px-3 py-1 rounded-full text-sm font-semibold mb-4">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            {{ $testimonial->program->name }}
                        </div>

                        <!-- Comment -->
                        <p class="text-gray-700 leading-relaxed">
                            "{{ $testimonial->comment }}"
                        </p>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($testimonials->hasPages())
                <div class="mt-12 flex justify-center">
                    <div class="bg-white rounded-xl shadow-lg p-2">
                        {{ $testimonials->links() }}
                    </div>
                </div>
                @endif
            </div>
        @endif

        <!-- CTA Section -->
        @auth
        <div class="max-w-4xl mx-auto mt-16">
            <div class="bg-gradient-to-r from-[#2D3C8C] to-[#1e2761] rounded-2xl shadow-xl p-8 text-center text-white">
                <h2 class="text-3xl font-bold mb-4">Sudah Mengikuti Program Kami?</h2>
                <p class="text-lg mb-6 text-blue-100">Bagikan pengalaman Anda dan bantu mahasiswa lain menentukan pilihan!</p>
                <a href="{{ route('order.my-orders') }}" class="inline-block bg-white text-[#2D3C8C] font-bold px-8 py-4 rounded-xl hover:shadow-xl transition-all">
                    Lihat Order Saya
                </a>
            </div>
        </div>
        @endauth
    </div>
</div>
@endsection

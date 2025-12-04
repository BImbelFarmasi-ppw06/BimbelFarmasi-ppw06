@extends('layouts.admin')

@section('title', 'Detail Program')

@section('content')
<div class="p-6">
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Detail Program</h1>
                <p class="text-sm text-gray-500">{{ $program->name }}</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.programs.edit', $program) }}" class="inline-flex items-center gap-2 rounded-lg bg-yellow-600 px-4 py-2 text-sm font-medium text-white hover:bg-yellow-700 transition">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                </a>
                <a href="{{ route('admin.programs.index') }}" class="inline-flex items-center gap-2 rounded-lg bg-gray-600 px-4 py-2 text-sm font-medium text-white hover:bg-gray-700 transition">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <!-- Program Info -->
            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex items-start justify-between mb-4">
                    <h2 class="text-xl font-semibold text-gray-900">{{ $program->name }}</h2>
                    <div class="flex space-x-2">
                        <span class="inline-flex px-3 py-1 text-sm font-medium rounded-full {{ $program->type == 'bimbel' ? 'bg-blue-100 text-blue-800' : ($program->type == 'joki' ? 'bg-green-100 text-green-800' : 'bg-purple-100 text-purple-800') }}">
                            {{ strtoupper($program->type) }}
                        </span>
                        @if($program->is_active)
                            <span class="inline-flex items-center px-3 py-1 text-sm font-medium rounded-full bg-green-100 text-green-800">
                                <svg class="h-3 w-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                Aktif
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 text-sm font-medium rounded-full bg-gray-100 text-gray-800">
                                <svg class="h-3 w-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                                Nonaktif
                            </span>
                        @endif
                    </div>
                </div>
                
                <div class="mb-6">
                    <h3 class="text-sm font-medium text-gray-700 mb-2">Deskripsi</h3>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-gray-900 leading-relaxed">{{ $program->description }}</p>
                    </div>
                </div>

                <div>
                    <h3 class="text-sm font-medium text-gray-700 mb-3">Fitur Program</h3>
                    <ul class="space-y-2">
                        @foreach($program->features as $feature)
                        <li class="flex items-start">
                            <svg class="h-5 w-5 text-green-500 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-gray-900">{{ $feature }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Statistics -->
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    <svg class="h-5 w-5 inline mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    Statistik Orders
                </h3>
                @php
                    $orderCount = \App\Models\Order::where('program_id', $program->id)->count();
                    $completedOrders = \App\Models\Order::where('program_id', $program->id)->where('status', 'completed')->count();
                    $totalRevenue = \App\Models\Order::where('program_id', $program->id)
                                                   ->where('status', 'completed')
                                                   ->sum('total_amount');
                @endphp
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-blue-50 rounded-lg p-4">
                        <div class="text-blue-600">
                            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div class="mt-2">
                            <p class="text-2xl font-semibold text-blue-900">{{ $orderCount }}</p>
                            <p class="text-sm text-blue-600">Total Orders</p>
                        </div>
                    </div>
                    <div class="bg-green-50 rounded-lg p-4">
                        <div class="text-green-600">
                            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="mt-2">
                            <p class="text-2xl font-semibold text-green-900">{{ $completedOrders }}</p>
                            <p class="text-sm text-green-600">Completed Orders</p>
                        </div>
                    </div>
                    <div class="bg-yellow-50 rounded-lg p-4">
                        <div class="text-yellow-600">
                            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                            </svg>
                        </div>
                        <div class="mt-2">
                            <p class="text-2xl font-semibold text-yellow-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                            <p class="text-sm text-yellow-600">Total Revenue</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <!-- Price Card -->
            <div class="bg-gradient-to-r from-[#2D3C8C] to-blue-600 rounded-lg p-6 text-white">
                <div class="flex items-center mb-2">
                    <svg class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                    <h3 class="text-lg font-medium">Harga Program</h3>
                </div>
                <p class="text-3xl font-bold mb-4">Rp {{ number_format($program->price, 0, ',', '.') }}</p>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div class="flex items-center">
                        <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        {{ $program->duration_months }} bulan
                    </div>
                    <div class="flex items-center">
                        <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        {{ $program->total_sessions }} sesi
                    </div>
                </div>
            </div>

            <!-- System Info -->
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    <svg class="h-5 w-5 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                    </svg>
                    Informasi Sistem
                </h3>
                <dl class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <dt class="font-medium text-gray-500">ID Program:</dt>
                        <dd class="text-gray-900">{{ $program->id }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="font-medium text-gray-500">Slug:</dt>
                        <dd class="text-gray-900"><code class="bg-gray-100 px-2 py-1 rounded text-xs">{{ $program->slug }}</code></dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="font-medium text-gray-500">Dibuat:</dt>
                        <dd class="text-gray-900">{{ $program->created_at->format('d M Y, H:i') }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="font-medium text-gray-500">Diupdate:</dt>
                        <dd class="text-gray-900">{{ $program->updated_at->format('d M Y, H:i') }}</dd>
                    </div>
                </dl>
            </div>

            <!-- Actions -->
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Aksi</h3>
                <div class="space-y-3">
                    <a href="{{ route('admin.programs.edit', $program) }}" class="w-full inline-flex justify-center items-center gap-2 rounded-lg bg-yellow-600 px-4 py-2 text-sm font-medium text-white hover:bg-yellow-700">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit Program
                    </a>
                    <form action="{{ route('admin.programs.destroy', $program) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus program ini? Semua data terkait akan ikut terhapus!')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full inline-flex justify-center items-center gap-2 rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Hapus Program
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
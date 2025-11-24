@extends('layouts.admin')

@section('title', 'Detail Program')

@section('content')
    <div class="mb-6">
        <div class="flex items-center gap-2 text-sm text-gray-600 mb-4">
            <a href="{{ route('admin.classes.index') }}" class="hover:text-gray-900">Kelas / Program</a>
            <span>/</span>
            <span class="text-gray-900 font-medium">Detail Program</span>
        </div>
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $program->name }}</h1>
                <p class="mt-1 text-sm text-gray-500">{{ $program->duration }} • {{ $program->orders_count ?? 0 }} Peserta Terdaftar</p>
            </div>
            <a href="{{ route('admin.classes.edit', $program->id) }}" 
               class="inline-flex items-center gap-2 rounded-lg bg-[#2D3C8C] px-4 py-2 text-sm font-semibold text-white hover:bg-blue-900">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit Program
            </a>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
        <!-- Left Column: Program Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Basic Info -->
            <div class="rounded-lg bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Program</h3>
                
                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-500">Deskripsi</label>
                        <p class="mt-1 text-gray-900">{{ $program->description }}</p>
                    </div>

                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <label class="text-sm font-medium text-gray-500">Harga</label>
                            <p class="mt-1 text-lg font-semibold text-gray-900">Rp {{ number_format($program->price, 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Durasi</label>
                            <p class="mt-1 text-gray-900">{{ $program->duration }}</p>
                        </div>
                    </div>

                    @if($program->tutor)
                    <div>
                        <label class="text-sm font-medium text-gray-500">Pengajar</label>
                        <p class="mt-1 text-gray-900">{{ $program->tutor }}</p>
                    </div>
                    @endif

                    @if($program->schedule)
                    <div>
                        <label class="text-sm font-medium text-gray-500">Jadwal</label>
                        <p class="mt-1 text-gray-900">{{ $program->schedule }}</p>
                    </div>
                    @endif

                    <div>
                        <label class="text-sm font-medium text-gray-500">Status</label>
                        <div class="mt-1">
                            <span class="inline-flex rounded-full px-3 py-1 text-sm font-semibold
                                {{ $program->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                                {{ $program->status === 'active' ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Features -->
            @php
                $features = json_decode($program->features ?? '[]', true);
            @endphp
            @if(!empty($features))
            <div class="rounded-lg bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Fitur & Benefit</h3>
                <ul class="space-y-2">
                    @foreach($features as $feature)
                        @if($feature)
                        <li class="flex items-start gap-2">
                            <svg class="h-5 w-5 text-green-500 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span class="text-gray-700">{{ $feature }}</span>
                        </li>
                        @endif
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- Enrolled Students -->
            @if($program->orders->isNotEmpty())
            <div class="rounded-lg bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Peserta Terdaftar ({{ $program->orders->count() }})</h3>
                <div class="space-y-3">
                    @foreach($program->orders->take(10) as $order)
                    <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-0">
                        <div class="flex items-center gap-3">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($order->user->name) }}&background=random" 
                                 class="h-10 w-10 rounded-full">
                            <div>
                                <p class="font-medium text-gray-900">{{ $order->user->name }}</p>
                                <p class="text-sm text-gray-500">{{ $order->user->email }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-medium 
                                {{ $order->status === 'processing' ? 'text-green-600' : 
                                   ($order->status === 'pending' ? 'text-yellow-600' : 'text-gray-600') }}">
                                {{ ucfirst($order->status) }}
                            </p>
                            <p class="text-xs text-gray-500">{{ $order->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                    @endforeach
                    
                    @if($program->orders->count() > 10)
                    <p class="text-sm text-gray-500 text-center pt-2">
                        dan {{ $program->orders->count() - 10 }} peserta lainnya
                    </p>
                    @endif
                </div>
            </div>
            @endif
        </div>

        <!-- Right Column: Statistics -->
        <div class="space-y-6">
            <!-- Quick Stats -->
            <div class="rounded-lg bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistik</h3>
                <div class="space-y-4">
                    <div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Total Peserta</span>
                            <span class="text-2xl font-bold text-gray-900">{{ $program->orders_count ?? 0 }}</span>
                        </div>
                    </div>
                    <div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Pendapatan</span>
                            <span class="text-lg font-semibold text-green-600">
                                Rp {{ number_format(($program->orders_count ?? 0) * $program->price, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                    <div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Order Aktif</span>
                            <span class="text-lg font-semibold text-blue-600">
                                {{ $program->orders->where('status', 'processing')->count() }}
                            </span>
                        </div>
                    </div>
                    <div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Pending</span>
                            <span class="text-lg font-semibold text-yellow-600">
                                {{ $program->orders->where('status', 'pending')->count() }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Program Meta -->
            <div class="rounded-lg bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Lainnya</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Dibuat</span>
                        <span class="text-gray-900">{{ $program->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Update Terakhir</span>
                        <span class="text-gray-900">{{ $program->updated_at->format('d M Y') }}</span>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="rounded-lg bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi</h3>
                <div class="space-y-2">
                    <a href="{{ route('admin.classes.edit', $program->id) }}" 
                       class="block w-full text-center px-4 py-2 bg-[#2D3C8C] text-white rounded-lg hover:bg-blue-900 font-medium">
                        Edit Program
                    </a>
                    <form action="{{ route('admin.classes.destroy', $program->id) }}" method="POST" 
                          onsubmit="return confirm('Yakin ingin menghapus program ini?')">
                        @csrf
                        @method('DELETE')
                        <button 
                            type="submit" 
                            class="w-full px-4 py-2 border border-red-300 text-red-700 rounded-lg hover:bg-red-50 font-medium">
                            Hapus Program
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('title', 'Jadwal Kelas')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50 py-12">
    <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('program.access', $program->id) }}" class="inline-flex items-center gap-2 text-[#2D3C8C] hover:text-[#1e2761] mb-4 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali ke Dashboard
            </a>
            <h1 class="text-3xl font-bold text-gray-900">{{ $program->name }} - Jadwal Kelas</h1>
            <p class="mt-2 text-gray-600">Jadwal pertemuan dan sesi pembelajaran</p>
        </div>

        <!-- Schedule List -->
        @if($schedules->count() > 0)
            <div class="space-y-4">
                @foreach($schedules as $schedule)
                    <div class="rounded-xl bg-white p-6 shadow-md">
                        <div class="flex items-start justify-between">
                            <div class="flex gap-4">
                                <div class="flex flex-col items-center justify-center rounded-lg bg-gradient-to-br from-[#2D3C8C] to-[#1e2761] px-4 py-3 text-white">
                                    <span class="text-2xl font-bold">{{ \Carbon\Carbon::parse($schedule->date)->format('d') }}</span>
                                    <span class="text-xs uppercase">{{ \Carbon\Carbon::parse($schedule->date)->format('M') }}</span>
                                </div>
                                
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-2">
                                        <h3 class="text-lg font-bold text-gray-900">{{ $schedule->title }}</h3>
                                        @if($schedule->status === 'scheduled')
                                            <span class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-800">
                                                Terjadwal
                                            </span>
                                        @elseif($schedule->status === 'ongoing')
                                            <span class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-800">
                                                Sedang Berlangsung
                                            </span>
                                        @elseif($schedule->status === 'completed')
                                            <span class="inline-flex items-center rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-600">
                                                Selesai
                                            </span>
                                        @else
                                            <span class="inline-flex items-center rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-800">
                                                Dibatalkan
                                            </span>
                                        @endif
                                        
                                        @if($schedule->type === 'online')
                                            <span class="inline-flex items-center rounded-full bg-purple-100 px-3 py-1 text-xs font-semibold text-purple-800">
                                                📹 Online
                                            </span>
                                        @else
                                            <span class="inline-flex items-center rounded-full bg-orange-100 px-3 py-1 text-xs font-semibold text-orange-800">
                                                📍 Offline
                                            </span>
                                        @endif
                                    </div>
                                    
                                    @if($schedule->description)
                                        <p class="text-sm text-gray-600 mb-2">{{ $schedule->description }}</p>
                                    @endif
                                    
                                    <div class="space-y-1 text-sm text-gray-600">
                                        <div class="flex items-center gap-2">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span>{{ \Carbon\Carbon::parse($schedule->start_time, 'UTC')->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_time, 'UTC')->format('H:i') }} WIB</span>
                                        </div>
                                        @if($schedule->type === 'offline' && $schedule->location)
                                            <div class="flex items-center gap-2">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                                <span>{{ $schedule->location }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            @if($schedule->status === 'scheduled' || $schedule->status === 'ongoing')
                                @if($schedule->type === 'online' && $schedule->meeting_link)
                                    <a href="{{ $schedule->meeting_link }}" target="_blank" class="rounded-lg bg-[#2D3C8C] px-6 py-2 text-sm font-semibold text-white transition hover:bg-blue-900">
                                        Join Kelas
                                    </a>
                                @endif
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="rounded-xl bg-white p-12 text-center shadow-md">
                <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <h3 class="mt-4 text-lg font-semibold text-gray-900">Belum Ada Jadwal</h3>
                <p class="mt-2 text-gray-600">Jadwal kelas akan segera ditambahkan oleh admin.</p>
            </div>
        @endif
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Materi Pembelajaran')

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
            <h1 class="text-3xl font-bold text-gray-900">{{ $program->name }} - Materi</h1>
            <p class="mt-2 text-gray-600">Akses semua materi video dan dokumen</p>
        </div>

        <!-- Materials List -->
        @if($materials->count() > 0)
            <div class="space-y-4">
                @foreach($materials as $material)
                    <div class="rounded-xl bg-white p-6 shadow-md hover:shadow-lg transition-shadow">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                @if($material->video_url)
                                    <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-red-100">
                                        <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                @else
                                    <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-blue-100">
                                        <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                                
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900">{{ $material->title }}</h3>
                                    @if($material->description)
                                        <p class="text-sm text-gray-600 mt-1">{{ Str::limit($material->description, 80) }}</p>
                                    @endif
                                    <p class="text-sm text-gray-500 mt-1">
                                        @if($material->video_url)
                                            <span class="inline-flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                Durasi: {{ $material->duration ?? '-' }}
                                            </span>
                                        @endif
                                        @if($material->file_path)
                                            <span class="inline-flex items-center gap-1 ml-3">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                                </svg>
                                                File tersedia
                                            </span>
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                @if($material->video_url)
                                    <a href="{{ $material->video_url }}" target="_blank" class="rounded-lg bg-[#2D3C8C] px-6 py-2 text-sm font-semibold text-white transition hover:bg-blue-900">
                                        Tonton Video
                                    </a>
                                @endif
                                @if($material->file_path)
                                    <a href="{{ Storage::url($material->file_path) }}" download class="rounded-lg border-2 border-[#2D3C8C] text-[#2D3C8C] px-6 py-2 text-sm font-semibold transition hover:bg-blue-50">
                                        Download File
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="rounded-xl bg-white p-12 text-center shadow-md">
                <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="mt-4 text-lg font-semibold text-gray-900">Belum Ada Materi</h3>
                <p class="mt-2 text-gray-600">Materi pembelajaran akan segera ditambahkan oleh admin.</p>
            </div>
        @endif
    </div>
</div>
@endsection

@extends('layouts.admin')

@section('title', 'Manajemen Kelas')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Manajemen Kelas & Program</h1>
            <p class="mt-1 text-sm text-gray-500">Kelola semua program pembelajaran dan jadwal kelas</p>
        </div>
        <a href="{{ route('admin.classes.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-[#2D3C8C] px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-900">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Program
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 rounded-lg bg-green-50 border border-green-200 p-4">
            <div class="flex">
                <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <div class="ml-3">
                    <p class="text-sm text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 rounded-lg bg-red-50 border border-red-200 p-4">
            <div class="flex">
                <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <div class="ml-3">
                    <p class="text-sm text-red-800">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if($programs->isEmpty())
        <div class="rounded-xl bg-white p-12 shadow-sm text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
            <h3 class="mt-2 text-sm font-semibold text-gray-900">Belum ada program</h3>
            <p class="mt-1 text-sm text-gray-500">Mulai dengan menambahkan program pembelajaran pertama Anda.</p>
            <div class="mt-6">
                <a href="{{ route('admin.classes.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-[#2D3C8C] px-4 py-2 text-sm font-semibold text-white hover:bg-blue-900">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Program
                </a>
            </div>
        </div>
    @else
        <!-- Classes Grid -->
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach ($programs as $program)
            <div class="rounded-xl bg-white p-6 shadow-sm hover:shadow-md transition-shadow">
                <div class="mb-4 flex items-start justify-between">
                    <h3 class="font-semibold text-gray-900 flex-1 pr-2">{{ $program->name }}</h3>
                    <span class="rounded-full px-2 py-1 text-xs font-semibold whitespace-nowrap
                        {{ $program->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                        {{ $program->status === 'active' ? 'Active' : 'Inactive' }}
                    </span>
                </div>
                <div class="space-y-3 text-sm mb-4">
                    <div class="flex items-center gap-2 text-gray-600">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <span>{{ $program->orders_count ?? 0 }} Peserta</span>
                    </div>
                    @if($program->tutor)
                    <div class="flex items-center gap-2 text-gray-600">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span>{{ $program->tutor }}</span>
                    </div>
                    @endif
                    @if($program->schedule)
                    <div class="flex items-center gap-2 text-gray-600">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span>{{ $program->schedule }}</span>
                    </div>
                    @endif
                    <div class="flex items-center gap-2 text-gray-600">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="font-semibold text-gray-900">Rp {{ number_format($program->price, 0, ',', '.') }}</span>
                    </div>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('admin.classes.edit', $program->id) }}" 
                       class="flex-1 rounded-lg border border-gray-300 px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 text-center">
                        Edit
                    </a>
                    <a href="{{ route('admin.classes.show', $program->id) }}" 
                       class="flex-1 rounded-lg bg-[#2D3C8C] px-3 py-2 text-sm font-medium text-white hover:bg-blue-900 text-center">
                        Detail
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    @endif
@endsection

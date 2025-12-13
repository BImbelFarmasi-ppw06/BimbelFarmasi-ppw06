@extends('layouts.admin')

@section('title', 'Daftar Penjoki')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-2xl font-bold text-slate-800">Daftar Penjoki Tugas</h1>
        <a href="{{ route('admin.joki.create') }}" class="inline-flex items-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
            <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Penjoki
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 rounded-lg bg-green-100 p-4 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if($jokiPersons->isEmpty())
        <div class="rounded-lg bg-white p-8 text-center shadow">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
            <h3 class="mt-2 text-lg font-medium text-gray-900">Belum ada penjoki</h3>
            <p class="mt-1 text-sm text-gray-500">Mulai dengan menambahkan penjoki pertama Anda.</p>
            <div class="mt-6">
                <a href="{{ route('admin.joki.create') }}" class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
                    <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Penjoki
                </a>
            </div>
        </div>
    @else
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach($jokiPersons as $joki)
                <div class="rounded-lg bg-white p-6 shadow hover:shadow-lg transition-shadow">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-slate-800">{{ $joki->name }}</h3>
                            @if($joki->expertise)
                                <p class="mt-1 text-sm text-blue-600">{{ $joki->expertise }}</p>
                            @endif
                        </div>
                        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $joki->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $joki->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </div>

                    @if($joki->description)
                        <p class="mt-3 text-sm text-slate-600">{{ Str::limit($joki->description, 100) }}</p>
                    @endif

                    <div class="mt-4 flex items-center text-sm text-slate-500">
                        <svg class="mr-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                        </svg>
                        WhatsApp: {{ Str::limit($joki->wa_link, 30) }}
                    </div>

                    <div class="mt-4 flex gap-2">
                        <a href="{{ $joki->wa_link }}" target="_blank" class="flex-1 rounded-lg bg-green-600 px-3 py-2 text-center text-sm font-medium text-white hover:bg-green-700">
                            Test WA
                        </a>
                        <a href="{{ route('admin.joki.edit', $joki->id) }}" class="flex-1 rounded-lg border border-slate-300 px-3 py-2 text-center text-sm font-medium text-slate-700 hover:bg-slate-50">
                            Edit
                        </a>
                        <form action="{{ route('admin.joki.destroy', $joki->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus penjoki ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="rounded-lg border border-red-300 px-3 py-2 text-sm font-medium text-red-700 hover:bg-red-50">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

@extends('layouts.admin')

@section('title', 'Bank Soal')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Bank Soal & Materi</h1>
            <p class="mt-1 text-sm text-gray-500">Kelola bank soal untuk setiap program layanan</p>
        </div>
        <a href="{{ route('admin.questions.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-[#2D3C8C] px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-900">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Buat Bank Soal Baru
        </a>
    </div>

    <!-- Stats Overview -->
    <div class="mb-6 grid gap-4 sm:grid-cols-4">
        <div class="rounded-xl bg-white p-4 shadow-sm">
            <p class="text-sm text-gray-500">Total Bank Soal</p>
            <p class="mt-2 text-2xl font-bold text-gray-900">{{ $quizBanks->total() }}</p>
        </div>
        <div class="rounded-xl bg-white p-4 shadow-sm">
            <p class="text-sm text-gray-500">Farmakologi</p>
            <p class="mt-2 text-2xl font-bold text-gray-900">{{ $stats['Farmakologi'] ?? 0 }}</p>
        </div>
        <div class="rounded-xl bg-white p-4 shadow-sm">
            <p class="text-sm text-gray-500">Farmasi Klinik</p>
            <p class="mt-2 text-2xl font-bold text-gray-900">{{ $stats['Farmasi Klinik'] ?? 0 }}</p>
        </div>
        <div class="rounded-xl bg-white p-4 shadow-sm">
            <p class="text-sm text-gray-500">UKOM</p>
            <p class="mt-2 text-2xl font-bold text-gray-900">{{ $stats['UKOM'] ?? 0 }}</p>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="mb-4 rounded-lg bg-green-50 p-4 text-sm text-green-800">
        {{ session('success') }}
    </div>
    @endif

    <!-- Filter & Table -->
    <div class="rounded-xl bg-white shadow-sm">
        <div class="border-b border-gray-200 p-4">
            <form method="GET" action="{{ route('admin.questions.index') }}" class="grid gap-4 sm:grid-cols-4">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari bank soal..." class="rounded-lg border-gray-300 text-sm">
                <select name="category" class="rounded-lg border-gray-300 text-sm">
                    <option value="">Semua Kategori</option>
                    <option value="Farmakologi" {{ request('category') == 'Farmakologi' ? 'selected' : '' }}>Farmakologi</option>
                    <option value="Farmasi Klinik" {{ request('category') == 'Farmasi Klinik' ? 'selected' : '' }}>Farmasi Klinik</option>
                    <option value="Farmasetika" {{ request('category') == 'Farmasetika' ? 'selected' : '' }}>Farmasetika</option>
                    <option value="Kimia Farmasi" {{ request('category') == 'Kimia Farmasi' ? 'selected' : '' }}>Kimia Farmasi</option>
                    <option value="UKOM" {{ request('category') == 'UKOM' ? 'selected' : '' }}>UKOM</option>
                    <option value="CPNS" {{ request('category') == 'CPNS' ? 'selected' : '' }}>CPNS</option>
                </select>
                <div></div>
                <button type="submit" class="rounded-lg bg-gray-100 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-200">
                    Filter
                </button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-200 bg-gray-50">
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">Judul Bank Soal</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">Program</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">Jumlah Soal</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">Durasi</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($quizBanks as $bank)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <p class="font-medium text-gray-900">{{ $bank->title }}</p>
                            <p class="text-sm text-gray-500">{{ Str::limit($bank->description, 50) }}</p>
                        </td>
                        <td class="px-6 py-4">
                            @if($bank->program)
                                <span class="inline-flex items-center rounded-full bg-purple-100 px-2.5 py-0.5 text-xs font-medium text-purple-800">
                                    {{ $bank->program->name }}
                                </span>
                            @else
                                <span class="text-sm text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800">
                                {{ $bank->category }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            {{ $bank->questions->count() }} soal
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            {{ $bank->duration_minutes }} menit
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.questions.show', $bank) }}" class="rounded p-1 text-gray-600 hover:bg-gray-100" title="Lihat Detail">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>
                                <a href="{{ route('admin.questions.edit', $bank) }}" class="rounded p-1 text-gray-600 hover:bg-gray-100" title="Edit">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <form action="{{ route('admin.questions.destroy', $bank) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus bank soal ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded p-1 text-red-600 hover:bg-red-50" title="Hapus">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                            Belum ada bank soal. <a href="{{ route('admin.questions.create') }}" class="text-blue-600 hover:underline">Buat bank soal pertama</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="flex items-center justify-between border-t border-gray-200 px-6 py-4">
            <p class="text-sm text-gray-500">
                Menampilkan {{ $quizBanks->firstItem() ?? 0 }}-{{ $quizBanks->lastItem() ?? 0 }} dari {{ $quizBanks->total() }} bank soal
            </p>
            <div class="flex gap-2">
                {{ $quizBanks->links() }}
            </div>
        </div>
    </div>
@endsection

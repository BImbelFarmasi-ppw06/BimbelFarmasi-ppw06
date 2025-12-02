@extends('layouts.admin')

@section('title', 'Data Peserta')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Data Peserta</h1>
            <p class="mt-1 text-sm text-gray-500">Kelola semua peserta yang terdaftar di platform</p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="mb-6 grid gap-4 sm:grid-cols-3">
        <div class="rounded-xl bg-white p-4 shadow-sm">
            <p class="text-sm text-gray-500">Total Peserta</p>
            <p class="mt-2 text-2xl font-bold text-gray-900">{{ $stats['total_students'] }}</p>
            <p class="text-sm text-gray-500">Terdaftar di sistem</p>
        </div>
        <div class="rounded-xl bg-white p-4 shadow-sm">
            <p class="text-sm text-gray-500">Peserta Aktif</p>
            <p class="mt-2 text-2xl font-bold text-green-600">{{ $stats['active_students'] }}</p>
            <p class="text-sm text-gray-500">Sudah bayar & aktif</p>
        </div>
        <div class="rounded-xl bg-white p-4 shadow-sm">
            <p class="text-sm text-gray-500">Pending</p>
            <p class="mt-2 text-2xl font-bold text-yellow-600">{{ $stats['pending_students'] }}</p>
            <p class="text-sm text-gray-500">Menunggu pembayaran</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="mb-6 rounded-xl bg-white p-4 shadow-sm">
        <form method="GET" class="grid gap-4 sm:grid-cols-4">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama/email..." class="rounded-lg border-gray-300 text-sm">
            <select name="program" class="rounded-lg border-gray-300 text-sm">
                <option value="">Semua Program</option>
                <option value="bimbel-ukom-d3-farmasi" {{ request('program') === 'bimbel-ukom-d3-farmasi' ? 'selected' : '' }}>UKOM D3 Farmasi</option>
                <option value="cpns-p3k-farmasi" {{ request('program') === 'cpns-p3k-farmasi' ? 'selected' : '' }}>CPNS Farmasi</option>
                <option value="joki-tugas-farmasi" {{ request('program') === 'joki-tugas-farmasi' ? 'selected' : '' }}>Joki Tugas</option>
            </select>
            <select name="status" class="rounded-lg border-gray-300 text-sm">
                <option value="">Semua Status</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Lunas (Approved)</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
            </select>
            <div class="flex gap-2">
                <button type="submit" class="flex-1 rounded-lg bg-gray-100 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-200">
                    Filter
                </button>
                @if(request()->hasAny(['search', 'program', 'status']))
                    <a href="{{ route('admin.students.index') }}" class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Students Table -->
    <div class="rounded-xl bg-white shadow-sm">
        @if($students->isEmpty())
            <div class="p-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada peserta</h3>
                <p class="mt-1 text-sm text-gray-500">Belum ada user yang terdaftar di sistem.</p>
            </div>
        @else
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-200 bg-gray-50">
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">Peserta</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">Program</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">Total Order</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">Tgl Daftar</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($students as $student)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($student->name) }}&background=random" class="h-10 w-10 rounded-full">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $student->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $student->email }}</p>
                                    @if($student->phone)
                                        <p class="text-xs text-gray-400">📱 {{ $student->phone }}</p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($student->orders->isNotEmpty())
                                @php
                                    $latestOrder = $student->orders->first();
                                    $programType = $latestOrder->program->type;
                                    $colorMap = [
                                        'ukom' => 'bg-blue-100 text-blue-800',
                                        'cpns' => 'bg-purple-100 text-purple-800',
                                        'joki' => 'bg-yellow-100 text-yellow-800',
                                    ];
                                    $color = $colorMap[$programType] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="inline-flex items-center rounded-full {{ $color }} px-2.5 py-0.5 text-xs font-medium">
                                    {{ $latestOrder->program->name }}
                                </span>
                                @if($student->orders->count() > 1)
                                    <span class="ml-1 text-xs text-gray-500">+{{ $student->orders->count() - 1 }} lainnya</span>
                                @endif
                            @else
                                <span class="text-sm text-gray-400">Belum order</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-semibold text-gray-900">{{ $student->orders_count }}</span>
                            <span class="text-sm text-gray-500">order</span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $student->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.students.show', $student->id) }}" 
                                   class="rounded p-1 text-gray-600 hover:bg-gray-100"
                                   title="Lihat Detail">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="border-t border-gray-200 px-4 py-3">
            {{ $students->links() }}
        </div>
        @endif
    </div>
@endsection

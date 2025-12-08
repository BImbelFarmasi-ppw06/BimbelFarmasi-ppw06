@extends('layouts.admin')

@section('title', 'Detail Peserta - ' . $student->name)

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Detail Peserta</h1>
            <p class="mt-2 text-sm text-gray-600">Informasi lengkap peserta dan pesanan mereka</p>
        </div>
        <a href="{{ route('admin.students.index') }}" class="inline-flex items-center gap-2 rounded-lg bg-gray-100 px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-200">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali
        </a>
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
        <!-- Informasi Peserta -->
        <div class="lg:col-span-2">
            <!-- Profile Card -->
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <div class="flex items-start justify-between border-b border-gray-200 pb-6">
                    <div class="flex items-center gap-4">
                        <div class="flex h-16 w-16 items-center justify-center rounded-full bg-gradient-to-br from-[#2D3C8C] to-blue-600">
                            <span class="text-xl font-bold text-white">{{ strtoupper(substr($student->name, 0, 1)) }}</span>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">{{ $student->name }}</h2>
                            <p class="text-sm text-gray-500">ID: {{ $student->id }}</p>
                        </div>
                    </div>
                    <span class="inline-flex items-center rounded-full {{ $student->is_suspended ? 'bg-red-100 px-3 py-1 text-xs font-semibold text-red-800' : 'bg-green-100 px-3 py-1 text-xs font-semibold text-green-800' }}">
                        {{ $student->is_suspended ? '🔒 Suspended' : '✓ Aktif' }}
                    </span>
                </div>

                <!-- Informasi Personal -->
                <div class="space-y-4 py-6">
                    <div>
                        <label class="text-xs font-semibold uppercase tracking-wide text-gray-500">Email</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $student->email }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-semibold uppercase tracking-wide text-gray-500">Nomor Handphone</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $student->phone ?? '-' }}</p>
                    </div>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="text-xs font-semibold uppercase tracking-wide text-gray-500">Universitas</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $student->university ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="text-xs font-semibold uppercase tracking-wide text-gray-500">Tertarik Dengan</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $student->interest ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-200 pt-6">
                    <label class="text-xs font-semibold uppercase tracking-wide text-gray-500">Terdaftar Sejak</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $student->created_at->format('d M Y H:i') }}</p>
                </div>
            </div>

            <!-- Pesanan Section -->
            <div class="mt-6 rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-bold text-gray-900 mb-6">Riwayat Pesanan</h3>

                @if($student->orders->count() > 0)
                    <div class="space-y-4">
                        @foreach($student->orders as $order)
                            <div class="rounded-lg border border-gray-200 bg-gray-50 p-4">
                                <div class="flex items-start justify-between mb-3">
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $order->program->name ?? 'Program tidak ditemukan' }}</p>
                                        <p class="text-xs text-gray-500">Order: {{ $order->order_number }}</p>
                                    </div>
                                    <!-- Status Badge -->
                                    <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold
                                        @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($order->status === 'waiting_verification') bg-blue-100 text-blue-800
                                        @elseif($order->status === 'processing') bg-purple-100 text-purple-800
                                        @elseif($order->status === 'completed') bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800
                                        @endif
                                    ">
                                        @if($order->status === 'pending') ⏳ Pending
                                        @elseif($order->status === 'waiting_verification') 👁️ Verifikasi
                                        @elseif($order->status === 'processing') ⚙️ Diproses
                                        @elseif($order->status === 'completed') ✓ Selesai
                                        @else ❌ Batal
                                        @endif
                                    </span>
                                </div>

                                <!-- Informasi Pembayaran -->
                                @if($order->payment)
                                    <div class="space-y-2 border-t border-gray-200 pt-3">
                                        <div class="flex items-center justify-between text-sm">
                                            <span class="text-gray-600">Metode Pembayaran:</span>
                                            <span class="font-medium text-gray-900">{{ ucfirst(str_replace('_', ' ', $order->payment->payment_method)) }}</span>
                                        </div>
                                        <div class="flex items-center justify-between text-sm">
                                            <span class="text-gray-600">Jumlah:</span>
                                            <span class="font-medium text-gray-900">Rp {{ number_format($order->payment->amount, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="flex items-center justify-between text-sm">
                                            <span class="text-gray-600">Status Pembayaran:</span>
                                            <span class="inline-flex items-center rounded-full px-2 py-1 text-xs font-semibold
                                                @if($order->payment->status === 'paid') bg-green-100 text-green-800
                                                @elseif($order->payment->status === 'pending') bg-yellow-100 text-yellow-800
                                                @else bg-red-100 text-red-800
                                                @endif
                                            ">
                                                @if($order->payment->status === 'paid') ✓ Terbayar
                                                @elseif($order->payment->status === 'pending') ⏳ Pending
                                                @else ❌ Gagal
                                                @endif
                                            </span>
                                        </div>
                                        @if($order->payment->paid_at)
                                            <div class="flex items-center justify-between text-sm">
                                                <span class="text-gray-600">Tanggal Pembayaran:</span>
                                                <span class="font-medium text-gray-900">{{ $order->payment->paid_at->format('d M Y H:i') }}</span>
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <p class="text-xs text-gray-500 border-t border-gray-200 pt-3">Belum ada data pembayaran</p>
                                @endif

                                <div class="mt-3 flex items-center justify-between border-t border-gray-200 pt-3 text-xs text-gray-500">
                                    <span>Dipesan: {{ $order->created_at->format('d M Y H:i') }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="rounded-lg border border-dashed border-gray-300 bg-gray-50 py-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        <p class="mt-4 text-sm text-gray-600">Peserta ini belum memiliki pesanan</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Sidebar Stats -->
        <div class="space-y-6">
            <!-- Quick Stats -->
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Statistik</h3>

                <div class="mt-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Total Pesanan</span>
                        <span class="text-2xl font-bold text-[#2D3C8C]">{{ $student->orders->count() }}</span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Pesanan Terbayar</span>
                        <span class="text-2xl font-bold text-green-600">{{ $student->orders->filter(function($o) { return $o->payment && $o->payment->status === 'paid'; })->count() }}</span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Total Pembayaran</span>
                        <span class="text-2xl font-bold text-blue-600">Rp {{ number_format($student->orders->filter(function($o) { return $o->payment; })->sum('amount'), 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Aksi</h3>

                <div class="mt-6 space-y-3">
                    @if(!$student->is_suspended)
                        <button onclick="suspendStudent({{ $student->id }})" class="w-full rounded-lg bg-orange-100 px-4 py-2 text-sm font-medium text-orange-700 transition hover:bg-orange-200">
                            🔒 Suspend Peserta
                        </button>
                    @else
                        <button onclick="activateStudent({{ $student->id }})" class="w-full rounded-lg bg-green-100 px-4 py-2 text-sm font-medium text-green-700 transition hover:bg-green-200">
                            ✓ Aktifkan Peserta
                        </button>
                    @endif

                    <button onclick="deleteStudent({{ $student->id }})" class="w-full rounded-lg bg-red-100 px-4 py-2 text-sm font-medium text-red-700 transition hover:bg-red-200">
                        🗑️ Hapus Peserta
                    </button>
                </div>
            </div>

            <!-- Timestamp -->
            <div class="rounded-xl border border-gray-200 bg-gray-50 p-6 shadow-sm">
                <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Informasi Sistem</h3>
                <div class="space-y-2 text-xs">
                    <p><span class="font-medium text-gray-600">Dibuat:</span> <br>{{ $student->created_at->format('d M Y H:i:s') }}</p>
                    <p><span class="font-medium text-gray-600">Diperbarui:</span> <br>{{ $student->updated_at->format('d M Y H:i:s') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        function suspendStudent(studentId) {
            if (!confirm('Yakin ingin suspend peserta ini? Mereka tidak bisa login sementara.')) return;

            fetch(`/admin/students/${studentId}/suspend`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({})
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert('Peserta berhasil disuspend');
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(err => alert('Error: ' + err.message));
        }

        function activateStudent(studentId) {
            if (!confirm('Yakin ingin mengaktifkan peserta ini kembali?')) return;

            fetch(`/admin/students/${studentId}/activate`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({})
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert('Peserta berhasil diaktifkan');
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(err => alert('Error: ' + err.message));
        }

        function deleteStudent(studentId) {
            if (!confirm('⚠️ PERHATIAN: Ini akan menghapus peserta dan SEMUA data pesanan mereka secara permanen. Yakin?')) return;

            fetch(`/admin/students/${studentId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({})
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    window.location.href = '/admin/students';
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(err => alert('Error: ' + err.message));
        }
    </script>
@endsection

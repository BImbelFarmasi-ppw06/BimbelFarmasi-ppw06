@extends('layouts.admin')

@section('title', 'Detail Peserta')

@section('content')
    <div class="mb-4">
        <p class="text-sm text-gray-600">Informasi lengkap peserta dan pesanan mereka</p>
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
        <!-- Informasi Peserta -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Profile Card -->
            <div class="rounded-xl bg-white p-8 shadow-sm">
                <div class="flex items-center gap-4 mb-6">
                    <div class="flex h-20 w-20 items-center justify-center rounded-full bg-blue-600 text-white text-3xl font-bold">
                        {{ strtoupper(substr($student->name, 0, 1)) }}
                    </div>
                    <div>
                        <h2 class="text-3xl font-bold text-gray-900">{{ $student->name }}</h2>
                        <p class="text-gray-500">ID: {{ $student->id }}</p>
                        <span class="mt-2 inline-block rounded-full {{ $student->is_suspended ? 'bg-red-100 px-3 py-1 text-xs font-medium text-red-600' : 'bg-green-100 px-3 py-1 text-xs font-medium text-green-600' }}">
                            {{ $student->is_suspended ? 'Suspended' : '✓ Aktif' }}
                        </span>
                    </div>
                </div>

                <!-- Informasi Detail -->
                <div class="space-y-3">
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase">Email</p>
                        <p class="text-gray-900">{{ $student->email }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase">Nomor Handphone</p>
                        <p class="text-gray-900">{{ $student->phone ?? '-' }}</p>
                    </div>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase">Universitas</p>
                            <p class="text-gray-900">{{ $student->university ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase">Tertarik Dengan</p>
                            <p class="text-gray-900">{{ $student->interest ?? '-' }}</p>
                        </div>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase">Terdaftar Sejak</p>
                        <p class="text-gray-900">{{ $student->created_at->format('d M Y H:i:s') }}</p>
                    </div>
                </div>
            </div>

            <!-- Pesanan Section -->
            <div class="rounded-xl bg-white p-8 shadow-sm">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Riwayat Pesanan</h3>

                @php
                    $activeOrders = $student->orders->filter(function($o) {
                        return $o->payment && ($o->payment->status === 'paid' || $o->payment->status === 'pending');
                    });
                @endphp

                @if($activeOrders->count() > 0)
                    <div class="space-y-4">
                        @foreach($activeOrders as $order)
                            <div class="border-l-4 {{ $order->payment->status === 'paid' ? 'border-green-500' : ($order->payment->status === 'pending' ? 'border-yellow-500' : 'border-red-500') }} bg-gray-50 p-4">
                                <div class="flex items-center justify-between mb-2">
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $order->order_number }}</p>
                                        <p class="text-sm text-gray-500">{{ $order->created_at->format('d M Y, H:i') }}</p>
                                    </div>
                                    <span class="rounded-full px-3 py-1 text-xs font-medium
                                        {{ $order->payment->status === 'paid' ? 'bg-green-100 text-green-700' :
                                           ($order->payment->status === 'pending' ? 'bg-yellow-100 text-yellow-700' :
                                           'bg-red-100 text-red-700') }}">
                                        {{ $order->payment->status === 'paid' ? 'Lunas' : ($order->payment->status === 'pending' ? 'Pending' : 'Dibatalkan') }}
                                    </span>
                                </div>
                                
                                <div class="mt-3 space-y-1 text-sm">
                                    <p><span class="font-medium">Program:</span> {{ $order->program->name ?? '-' }}</p>
                                    @if($order->payment)
                                        <p><span class="font-medium">Metode Pembayaran:</span> {{ ucfirst(str_replace('_', ' ', $order->payment->payment_method)) }}</p>
                                        <p><span class="font-medium">Total:</span> <span class="text-blue-600 font-semibold">Rp {{ number_format($order->payment->amount, 0, ',', '.') }}</span></p>
                                    @else
                                        <p class="text-gray-400 italic">Belum ada pembayaran</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <p>Belum ada pesanan</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Statistik -->
            <div class="rounded-xl bg-white p-6 shadow-sm">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Statistik</h3>

                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                        <span class="text-sm text-gray-700">Total Pesanan</span>
                        <span class="text-xl font-bold text-blue-600">{{ $student->orders->count() }}</span>
                    </div>

                    <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                        <span class="text-sm text-gray-700">Pesanan Terbayar</span>
                        <span class="text-xl font-bold text-green-600">{{ $student->orders->filter(function($o) { return $o->payment && $o->payment->status === 'paid'; })->count() }}</span>
                    </div>

                    <div class="flex items-center justify-between p-3 bg-purple-50 rounded-lg">
                        <span class="text-sm text-gray-700">Total Pembayaran</span>
                        <span class="text-xl font-bold text-purple-600">Rp {{ number_format($student->orders->filter(function($o) { return $o->payment && $o->payment->status === 'paid'; })->sum(function($o) { return $o->payment->amount; }), 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="rounded-xl bg-white p-6 shadow-sm">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Aksi</h3>

                <div class="space-y-3">
                    @if(!$student->is_suspended)
                        <button onclick="suspendStudent({{ $student->id }})" class="w-full rounded-lg bg-orange-500 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-orange-600">
                            Suspend Peserta
                        </button>
                    @else
                        <button onclick="activateStudent({{ $student->id }})" class="w-full rounded-lg bg-green-500 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-green-600">
                            Aktifkan Peserta
                        </button>
                    @endif

                    <button onclick="deleteStudent({{ $student->id }})" class="w-full rounded-lg bg-red-500 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-red-600">
                        Hapus Peserta
                    </button>
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

<<<<<<< HEAD
=======
@extends('layouts.admin')

@section('title', 'Detail Peserta')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Detail Peserta</h1>
                <p class="text-gray-600">Informasi lengkap peserta dan riwayat transaksi</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.students.index') }}" class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
                <button onclick="deleteStudent({{ $student->id }}, '{{ $student->name }}')" class="rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700">
                    <i class="fas fa-trash mr-2"></i>Hapus Peserta
                </button>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-3">
            <!-- Student Profile -->
            <div class="lg:col-span-1">
                <div class="rounded-xl bg-white p-6 shadow-sm">
                    <div class="flex flex-col items-center text-center">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($student->name) }}&background=random&size=120" 
                             class="h-24 w-24 rounded-full border-4 border-gray-100">
                        <h2 class="mt-4 text-xl font-bold text-gray-900">{{ $student->name }}</h2>
                        <p class="text-gray-600">{{ $student->email }}</p>
                        
                        @if($student->phone)
                        <div class="mt-2 flex items-center gap-2 text-sm text-gray-500">
                            <i class="fas fa-phone"></i>
                            <span>{{ $student->phone }}</span>
                        </div>
                        @endif

                        @if($student->whatsapp)
                        <div class="mt-1 flex items-center gap-2 text-sm text-gray-500">
                            <i class="fab fa-whatsapp"></i>
                            <span>{{ $student->whatsapp }}</span>
                        </div>
                        @endif

                        <!-- Account Status -->
                        <div class="mt-4">
                            @if(!$student->is_suspended)
                            <span class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-sm font-medium text-green-800">
                                <i class="fas fa-check-circle mr-2"></i>Akun Aktif
                            </span>
                            @else
                            <span class="inline-flex items-center rounded-full bg-red-100 px-3 py-1 text-sm font-medium text-red-800">
                                <i class="fas fa-ban mr-2"></i>Akun Suspended
                            </span>
                            @if($student->suspend_reason)
                            <p class="mt-2 text-xs text-red-600">Alasan: {{ $student->suspend_reason }}</p>
                            @endif
                            @endif
                        </div>
                    </div>

                    <!-- Account Info -->
                    <div class="mt-6 border-t pt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Akun</h3>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">ID Peserta:</span>
                                <span class="font-medium">#{{ $student->id }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tgl Daftar:</span>
                                <span class="font-medium">{{ $student->created_at->format('d M Y, H:i') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Terakhir Update:</span>
                                <span class="font-medium">{{ $student->updated_at->format('d M Y, H:i') }}</span>
                            </div>
                            @if($student->last_login_at)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Login Terakhir:</span>
                                <span class="font-medium">{{ $student->last_login_at->format('d M Y, H:i') }}</span>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="mt-6 border-t pt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Aksi Cepat</h3>
                        <div class="space-y-2">
                            @if(!$student->is_suspended)
                            <button onclick="suspendStudent({{ $student->id }})" class="w-full rounded-lg bg-orange-100 px-4 py-2 text-sm font-medium text-orange-800 hover:bg-orange-200">
                                <i class="fas fa-ban mr-2"></i>Suspend Akun
                            </button>
                            @else
                            <button onclick="activateStudent({{ $student->id }})" class="w-full rounded-lg bg-green-100 px-4 py-2 text-sm font-medium text-green-800 hover:bg-green-200">
                                <i class="fas fa-check mr-2"></i>Aktifkan Akun
                            </button>
                            @endif
                            
                            @if($student->whatsapp)
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $student->whatsapp) }}" target="_blank" 
                               class="w-full block rounded-lg bg-green-100 px-4 py-2 text-sm font-medium text-green-800 hover:bg-green-200 text-center">
                                <i class="fab fa-whatsapp mr-2"></i>Chat WhatsApp
                            </a>
                            @endif
                            
                            <a href="mailto:{{ $student->email }}" 
                               class="w-full block rounded-lg bg-blue-100 px-4 py-2 text-sm font-medium text-blue-800 hover:bg-blue-200 text-center">
                                <i class="fas fa-envelope mr-2"></i>Kirim Email
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Orders & Payments -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Statistics Cards -->
                <div class="grid gap-4 sm:grid-cols-3">
                    <div class="rounded-lg bg-white p-4 shadow-sm">
                        <div class="flex items-center">
                            <div class="rounded-lg bg-blue-100 p-2">
                                <i class="fas fa-shopping-cart text-blue-600"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-600">Total Order</p>
                                <p class="text-xl font-bold text-gray-900">{{ $student->orders->count() }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-lg bg-white p-4 shadow-sm">
                        <div class="flex items-center">
                            <div class="rounded-lg bg-green-100 p-2">
                                <i class="fas fa-check-circle text-green-600"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-600">Order Berhasil</p>
                                <p class="text-xl font-bold text-gray-900">{{ $student->orders->count() }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-lg bg-white p-4 shadow-sm">
                        <div class="flex items-center">
                            <div class="rounded-lg bg-purple-100 p-2">
                                <i class="fas fa-graduation-cap text-purple-600"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-600">Program Diikuti</p>
                                <p class="text-xl font-bold text-gray-900">
                                    {{ $student->orders->pluck('program.name')->unique()->count() }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Orders List -->
                <div class="rounded-xl bg-white shadow-sm">
                    <div class="border-b px-6 py-4">
                        <h3 class="text-lg font-medium text-gray-900">Riwayat Order</h3>
                        <p class="text-sm text-gray-600">Daftar semua program yang pernah diorder peserta (pembayaran diproses via Midtrans)</p>
                    </div>

                    @if($student->orders->isEmpty())
                    <div class="p-12 text-center">
                        <i class="fas fa-shopping-cart text-4xl text-gray-300 mb-4"></i>
                        <h4 class="text-lg font-medium text-gray-900">Belum ada order</h4>
                        <p class="text-gray-600">Peserta belum pernah melakukan order apapun.</p>
                    </div>
                    @else
                    <div class="divide-y">
                        @foreach($student->orders as $order)
                        <div class="p-6">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        <h4 class="text-lg font-medium text-gray-900">{{ $order->program->name }}</h4>
                                        @php
                                            $colors = [
                                                'bimbel-ukom-d3-farmasi' => 'bg-blue-100 text-blue-800',
                                                'cpns-p3k-farmasi' => 'bg-purple-100 text-purple-800',
                                                'joki-tugas-farmasi' => 'bg-yellow-100 text-yellow-800'
                                            ];
                                            $color = $colors[$order->program->slug] ?? 'bg-gray-100 text-gray-800';
                                        @endphp
                                        <span class="inline-flex items-center rounded-full {{ $color }} px-2.5 py-0.5 text-xs font-medium">
                                            {{ $order->program->slug }}
                                        </span>
                                    </div>
                                    
                                    <p class="text-sm text-gray-600 mb-2">{{ $order->program->description }}</p>
                                    
                                    <div class="grid gap-2 sm:grid-cols-2 text-sm">
                                        <div>
                                            <span class="font-medium text-gray-700">Order ID:</span>
                                            <span class="text-gray-600">#{{ $order->id }}</span>
                                        </div>
                                        <div>
                                            <span class="font-medium text-gray-700">Tanggal Order:</span>
                                            <span class="text-gray-600">{{ $order->created_at->format('d M Y, H:i') }}</span>
                                        </div>
                                        <div>
                                            <span class="font-medium text-gray-700">Harga:</span>
                                            <span class="font-bold text-gray-900">Rp {{ number_format($order->program->price, 0, ',', '.') }}</span>
                                        </div>
                                        <div>
                                            <span class="font-medium text-gray-700">Status Order:</span>
                                            @php
                                                $orderStatusColors = [
                                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                                    'waiting_verification' => 'bg-blue-100 text-blue-800',
                                                    'processing' => 'bg-purple-100 text-purple-800',
                                                    'completed' => 'bg-green-100 text-green-800',
                                                    'cancelled' => 'bg-red-100 text-red-800',
                                                ];
                                                $statusColor = $orderStatusColors[$order->status] ?? 'bg-gray-100 text-gray-800';
                                                $statusLabel = ucfirst(str_replace('_', ' ', $order->status));
                                            @endphp
                                            <span class="inline-flex items-center rounded-full {{ $statusColor }} px-2 py-0.5 text-xs font-medium">
                                                {{ $statusLabel }}
                                            </span>
                                        </div>
                                        @if($order->payment)
                                        <div>
                                            <span class="font-medium text-gray-700">Status Pembayaran:</span>
                                            @php
                                                $paymentStatusColors = [
                                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                                    'paid' => 'bg-green-100 text-green-800',
                                                    'rejected' => 'bg-red-100 text-red-800',
                                                    'failed' => 'bg-red-100 text-red-800',
                                                ];
                                                $paymentColor = $paymentStatusColors[$order->payment->status] ?? 'bg-gray-100 text-gray-800';
                                                $paymentLabel = ucfirst($order->payment->status);
                                            @endphp
                                            <span class="inline-flex items-center rounded-full {{ $paymentColor }} px-2 py-0.5 text-xs font-medium">
                                                {{ $paymentLabel }}
                                            </span>
                                        </div>
                                        <div>
                                            <span class="font-medium text-gray-700">Metode:</span>
                                            <span class="text-gray-600">
                                                @if($order->payment->payment_method === 'bank_transfer')
                                                    🏦 Transfer Bank
                                                @elseif($order->payment->payment_method === 'ewallet')
                                                    💳 E-Wallet
                                                @elseif($order->payment->payment_method === 'qris')
                                                    📱 QRIS
                                                @else
                                                    {{ ucfirst($order->payment->payment_method) }}
                                                @endif
                                            </span>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>


                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        // Reuse functions from students index
        function deleteStudent(studentId, studentName) {
            if (confirm(`Apakah Anda yakin ingin menghapus peserta "${studentName}"? Semua data terkait akan terhapus permanen.`)) {
                fetch(`/admin/students/${studentId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        window.location.href = '/admin/students';
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menghapus peserta.');
                });
            }
        }

        function suspendStudent(studentId) {
            const reason = prompt('Alasan suspend akun (opsional):');
            if (reason === null) return; // User cancelled
            
            fetch(`/admin/students/${studentId}/suspend`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    reason: reason || null
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat suspend akun.');
            });
        }

        function activateStudent(studentId) {
            if (confirm('Apakah Anda yakin ingin mengaktifkan kembali akun peserta ini?')) {
                fetch(`/admin/students/${studentId}/activate`, {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        location.reload();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat mengaktifkan akun.');
                });
            }
        }
    </script>
@endsection
>>>>>>> a1eea46653b14b9b7c95983801c2a2f75c910c20

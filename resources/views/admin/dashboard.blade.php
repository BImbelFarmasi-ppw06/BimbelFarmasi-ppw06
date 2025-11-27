@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <!-- Stats Cards -->
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-xl bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Peserta Aktif</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900">{{ $activeUsers }}</p>
                    <p class="mt-1 text-xs text-gray-600">dari {{ $totalUsers }} total user</p>
                </div>
                <div class="rounded-full bg-blue-100 p-3">
                    <svg class="h-8 w-8 text-[#2D3C8C]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="rounded-xl bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Program Tersedia</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900">{{ $totalPrograms }}</p>
                    <p class="mt-1 text-xs text-gray-500">Program aktif</p>
                </div>
                <div class="rounded-full bg-purple-100 p-3">
                    <svg class="h-8 w-8 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="rounded-xl bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Pembayaran Pending</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900">{{ $pendingPaymentsCount }}</p>
                    <p class="mt-1 text-xs text-orange-600">Menunggu konfirmasi</p>
                </div>
                <div class="rounded-full bg-orange-100 p-3">
                    <svg class="h-8 w-8 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="rounded-xl bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Pendapatan Bulan Ini</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900">Rp {{ number_format($revenueThisMonth / 1000000, 1) }}jt</p>
                    <p class="mt-1 text-xs text-gray-600">Total: Rp {{ number_format($totalRevenue / 1000000, 1) }}jt</p>
                </div>
                <div class="rounded-full bg-yellow-100 p-3">
                    <svg class="h-8 w-8 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="mt-6 grid gap-6 lg:grid-cols-2">
        <!-- Activity Chart -->
        <div class="rounded-xl bg-white p-6 shadow-sm">
            <div class="mb-4 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Aktivitas Mingguan</h3>
                <select class="rounded-lg border-gray-300 text-sm">
                    <option>7 Hari Terakhir</option>
                    <option>30 Hari Terakhir</option>
                    <option>3 Bulan Terakhir</option>
                </select>
            </div>
            <div class="relative h-64">
                <canvas id="activityChart"></canvas>
            </div>
        </div>

        <!-- Student Distribution -->
        <div class="rounded-xl bg-white p-6 shadow-sm">
            <div class="mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Distribusi Peserta per Program</h3>
            </div>
            <div class="relative h-64">
                <canvas id="distributionChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Laporan & Statistik Section -->
    <div class="mt-8 mb-4">
        <h2 class="text-xl font-bold text-gray-900">Laporan & Statistik</h2>
        <p class="mt-1 text-sm text-gray-500">Analisis tren dan performa platform</p>
    </div>

    <!-- Statistics Charts Row 1 -->
    <div class="mb-6 grid gap-6 lg:grid-cols-2">
        <!-- Enrollment Trend -->
        <div class="rounded-xl bg-white p-6 shadow-sm">
            <h3 class="mb-4 text-lg font-semibold text-gray-900">Tren Pendaftaran</h3>
            <div class="relative h-64">
                <canvas id="enrollmentChart"></canvas>
            </div>
        </div>

        <!-- Revenue Trend -->
        <div class="rounded-xl bg-white p-6 shadow-sm">
            <h3 class="mb-4 text-lg font-semibold text-gray-900">Pendapatan</h3>
            <div class="relative h-64">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Statistics Charts Row 2 -->
    <div class="mb-6 grid gap-6 lg:grid-cols-2">
        <!-- Program Performance -->
        <div class="rounded-xl bg-white p-6 shadow-sm">
            <h3 class="mb-4 text-lg font-semibold text-gray-900">Performa Program</h3>
            <div class="relative h-64">
                <canvas id="programPerformanceChart"></canvas>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="rounded-xl bg-white p-6 shadow-sm">
            <h3 class="mb-4 text-lg font-semibold text-gray-900">Statistik Kunci</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                    <span class="text-sm font-medium text-gray-700">Tingkat Kelulusan</span>
                    <span class="text-lg font-bold text-green-600">87.5%</span>
                </div>
                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                    <span class="text-sm font-medium text-gray-700">Rata-rata Nilai</span>
                    <span class="text-lg font-bold text-blue-600">82.3</span>
                </div>
                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                    <span class="text-sm font-medium text-gray-700">Tingkat Penyelesaian</span>
                    <span class="text-lg font-bold text-purple-600">78.4%</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium text-gray-700">Kepuasan Peserta</span>
                    <span class="text-lg font-bold text-yellow-600">4.6/5</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity & Pending Actions -->
    <div class="mt-6 grid gap-6 lg:grid-cols-2">
        <!-- Recent Students -->
        <div class="rounded-xl bg-white p-6 shadow-sm">
            <div class="mb-4 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Pendaftar Terbaru</h3>
                <a href="{{ route('admin.students.index') }}" class="text-sm font-medium text-[#2D3C8C] hover:underline">Lihat Semua →</a>
            </div>
            <div class="space-y-4">
                @forelse($recentUsers as $user)
                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                    <div class="flex items-center gap-3">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random" alt="" class="h-10 w-10 rounded-full">
                        <div>
                            <p class="font-medium text-gray-900">{{ $user->name }}</p>
                            <p class="text-xs text-gray-500">
                                @if($user->orders->isNotEmpty())
                                    {{ $user->orders->first()->program->name ?? 'Belum ada order' }}
                                @else
                                    Belum ada order
                                @endif
                            </p>
                        </div>
                    </div>
                    @php
                        $hasPaidOrder = $user->orders->filter(function($order) {
                            return $order->payment && $order->payment->status === 'paid';
                        })->isNotEmpty();
                    @endphp
                    <span class="rounded-full {{ $hasPaidOrder ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }} px-3 py-1 text-xs font-semibold">
                        {{ $hasPaidOrder ? 'Aktif' : 'Baru' }}
                    </span>
                </div>
                @empty
                <p class="text-sm text-gray-500 text-center py-4">Belum ada pendaftar</p>
                @endforelse
            </div>
        </div>

        <!-- Pending Payments -->
        <div class="rounded-xl bg-white p-6 shadow-sm">
            <div class="mb-4 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Pembayaran Pending</h3>
                <a href="{{ route('admin.payments.index') }}" class="text-sm font-medium text-[#2D3C8C] hover:underline">Lihat Semua →</a>
            </div>
            <div class="space-y-4">
                @forelse($pendingPayments as $payment)
                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                    <div>
                        <p class="font-medium text-gray-900">{{ $payment->order->user->name }}</p>
                        <p class="text-xs text-gray-500">{{ $payment->order->program->name }}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-semibold text-gray-900">Rp {{ number_format($payment->amount, 0, ',', '.') }}</p>
                        <a href="{{ route('admin.payments.show', $payment->id) }}" class="mt-1 text-xs font-medium text-[#2D3C8C] hover:underline">Konfirmasi</a>
                    </div>
                </div>
                @empty
                <p class="text-sm text-gray-500 text-center py-4">Tidak ada pembayaran pending</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Activity Chart
        const activityCtx = document.getElementById('activityChart');
        if (activityCtx) {
            new Chart(activityCtx, {
                type: 'line',
                data: {
                    labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
                    datasets: [{
                        label: 'Login Peserta',
                        data: [65, 78, 85, 81, 92, 88, 70],
                        borderColor: '#2D3C8C',
                        backgroundColor: 'rgba(45, 60, 140, 0.1)',
                        tension: 0.4,
                        fill: true
                    }, {
                        label: 'Soal Dikerjakan',
                        data: [45, 62, 70, 65, 75, 68, 55],
                        borderColor: '#8b5cf6',
                        backgroundColor: 'rgba(139, 92, 246, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        // Distribution Chart
        const distributionCtx = document.getElementById('distributionChart');
        if (distributionCtx) {
            const programData = @json($programDistribution);
            new Chart(distributionCtx, {
                type: 'doughnut',
                data: {
                    labels: programData.map(p => p.name),
                    datasets: [{
                        data: programData.map(p => p.count),
                        backgroundColor: ['#2D3C8C', '#8b5cf6', '#10b981', '#f59e0b', '#ef4444', '#06b6d4', '#f97316', '#84cc16'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        }

        // Enrollment Trend Chart
        const enrollmentCtx = document.getElementById('enrollmentChart');
        if (enrollmentCtx) {
            const enrollmentData = @json($monthlyEnrollment);
            new Chart(enrollmentCtx, {
                type: 'line',
                data: {
                    labels: enrollmentData.map(e => e.month),
                    datasets: [{
                        label: 'Peserta Baru',
                        data: enrollmentData.map(e => e.count),
                        borderColor: '#2D3C8C',
                        backgroundColor: 'rgba(45, 60, 140, 0.1)',
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        // Revenue Trend Chart
        const revenueCtx = document.getElementById('revenueChart');
        if (revenueCtx) {
            const revenueData = @json($monthlyRevenue);
            new Chart(revenueCtx, {
                type: 'bar',
                data: {
                    labels: revenueData.map(r => r.month),
                    datasets: [{
                        label: 'Pendapatan (Juta Rp)',
                        data: revenueData.map(r => r.revenue.toFixed(1)),
                        backgroundColor: '#10b981',
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        // Program Performance Chart
        const programCtx = document.getElementById('programPerformanceChart');
        if (programCtx) {
            new Chart(programCtx, {
                type: 'radar',
                data: {
                    labels: ['UKOM D3', 'CPNS', 'P3K', 'Joki Tugas'],
                    datasets: [{
                        label: 'Tingkat Kelulusan (%)',
                        data: [88, 82, 90, 85],
                        borderColor: '#2D3C8C',
                        backgroundColor: 'rgba(45, 60, 140, 0.2)',
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        r: {
                            beginAtZero: true,
                            max: 100
                        }
                    }
                }
            });
        }
    });
</script>
@endpush

@extends('layouts.admin')

@section('title', 'Statistik & Laporan')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Statistik & Laporan</h1>
        <p class="mt-1 text-sm text-gray-500">Analisis data dan performa platform</p>
    </div>

    <!-- Date Filter -->
    <div class="mb-6 flex gap-2">
        <button class="rounded-lg bg-[#2D3C8C] px-4 py-2 text-sm font-medium text-white">Bulan Ini</button>
        <button class="rounded-lg bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">3 Bulan</button>
        <button class="rounded-lg bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">6 Bulan</button>
        <button class="rounded-lg bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">1 Tahun</button>
    </div>

    <!-- Charts Row 1 -->
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

    <!-- Stats Grid -->
    <div class="mb-6 grid gap-4 sm:grid-cols-4">
        <div class="rounded-xl bg-white p-4 shadow-sm">
            <p class="text-sm text-gray-500">Tingkat Kelulusan</p>
            <p class="mt-2 text-3xl font-bold text-green-600">{{ $stats['passRate'] }}%</p>
            <p class="mt-1 text-xs text-gray-500">
                @if($stats['passRateChange'] >= 0)
                    ↑ {{ $stats['passRateChange'] }}% dari bulan lalu
                @else
                    ↓ {{ abs($stats['passRateChange']) }}% dari bulan lalu
                @endif
            </p>
        </div>
        <div class="rounded-xl bg-white p-4 shadow-sm">
            <p class="text-sm text-gray-500">Rata-rata Nilai</p>
            <p class="mt-2 text-3xl font-bold text-blue-600">{{ $stats['avgScore'] }}</p>
            <p class="mt-1 text-xs text-gray-500">
                @if($stats['avgScoreChange'] >= 0)
                    ↑ {{ $stats['avgScoreChange'] }} poin
                @else
                    ↓ {{ abs($stats['avgScoreChange']) }} poin
                @endif
            </p>
        </div>
        <div class="rounded-xl bg-white p-4 shadow-sm">
            <p class="text-sm text-gray-500">Tingkat Penyelesaian</p>
            <p class="mt-2 text-3xl font-bold text-purple-600">{{ $stats['completionRate'] }}%</p>
            <p class="mt-1 text-xs text-gray-500">
                @if($stats['completionRateChange'] >= 0)
                    ↑ {{ $stats['completionRateChange'] }}% dari bulan lalu
                @else
                    ↓ {{ abs($stats['completionRateChange']) }}% dari bulan lalu
                @endif
            </p>
        </div>
        <div class="rounded-xl bg-white p-4 shadow-sm">
            <p class="text-sm text-gray-500">Kepuasan Peserta</p>
            <p class="mt-2 text-3xl font-bold text-yellow-600">{{ $stats['satisfaction'] }}/5</p>
            <p class="mt-1 text-xs text-gray-500">Dari {{ $stats['totalReviews'] }} review</p>
        </div>
    </div>

    <!-- Charts Row 2 -->
    <div class="mb-6 grid gap-6 lg:grid-cols-2">
        <!-- Program Performance -->
        <div class="rounded-xl bg-white p-6 shadow-sm">
            <h3 class="mb-4 text-lg font-semibold text-gray-900">Performa Program</h3>
            <div class="relative h-64">
                <canvas id="programPerformanceChart"></canvas>
            </div>
        </div>

        <!-- Top Categories -->
        <div class="rounded-xl bg-white p-6 shadow-sm">
            <h3 class="mb-4 text-lg font-semibold text-gray-900">Kategori Soal Terpopuler</h3>
            @if($topCategories->count() > 0)
            <div class="space-y-4">
                @foreach($topCategories as $category)
                <div>
                    <div class="mb-1 flex justify-between text-sm">
                        <span class="font-medium text-gray-700">{{ $category['name'] }}</span>
                        <span class="text-gray-500">{{ number_format($category['count']) }} soal</span>
                    </div>
                    <div class="h-2 rounded-full bg-gray-200">
                        <div class="h-2 rounded-full bg-[#2D3C8C]" style="width: {{ $category['percentage'] }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="py-8 text-center text-gray-500">
                <p>Belum ada data kategori soal</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Latest Activity Table -->
    <div class="rounded-xl bg-white p-6 shadow-sm">
        <h3 class="mb-4 text-lg font-semibold text-gray-900">Aktivitas Terbaru</h3>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-600">Peserta</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-600">Program</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-600">Aktivitas</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-600">Nilai</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-600">Waktu</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($latestActivities as $activity)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($activity['name']) }}&background=random" class="h-8 w-8 rounded-full">
                                <span class="font-medium text-gray-900">{{ $activity['name'] }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $activity['program'] }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $activity['activity'] }}</td>
                        <td class="px-4 py-3">
                            <span class="font-semibold text-gray-900">{{ $activity['score'] }}</span>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $activity['time'] }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-gray-500">
                            Belum ada aktivitas terbaru
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @push('scripts')
    <script>
        // Enrollment Trend Chart
        const enrollmentCtx = document.getElementById('enrollmentChart').getContext('2d');
        new Chart(enrollmentCtx, {
            type: 'line',
            data: {
                labels: @json($enrollmentTrend['labels']),
                datasets: [{
                    label: 'Peserta Baru',
                    data: @json($enrollmentTrend['data']),
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
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });

        // Revenue Trend Chart
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        new Chart(revenueCtx, {
            type: 'bar',
            data: {
                labels: @json($revenueTrend['labels']),
                datasets: [{
                    label: 'Pendapatan (Juta Rp)',
                    data: @json($revenueTrend['data']),
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

        // Program Performance Chart
        const programCtx = document.getElementById('programPerformanceChart').getContext('2d');
        new Chart(programCtx, {
            type: 'radar',
            data: {
                labels: @json($programPerformance['labels']),
                datasets: [{
                    label: 'Tingkat Kelulusan (%)',
                    data: @json($programPerformance['data']),
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
    </script>
    @endpush
@endsection

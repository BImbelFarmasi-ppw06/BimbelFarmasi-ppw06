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
            <p class="text-sm text-gray-500">Pendaftar Baru</p>
            <p class="mt-2 text-2xl font-bold text-blue-600">{{ $stats['recent_signups'] }}</p>
            <p class="text-sm text-gray-500">7 hari terakhir</p>
        </div>
    </div>

    <!-- Action Toolbar -->
    <div class="mb-4 flex flex-wrap items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <!-- Bulk Actions -->
            <div class="flex items-center gap-2" id="bulkActions" style="display: none;">
                <span class="text-sm text-gray-600">Aksi untuk <span id="selectedCount">0</span> peserta:</span>
                <button onclick="bulkDelete()" class="rounded-lg bg-red-600 px-3 py-2 text-sm font-medium text-white hover:bg-red-700">
                    <i class="fas fa-trash mr-1"></i> Hapus Semua
                </button>
            </div>
        </div>
        
        <div class="flex items-center gap-3">
            <!-- Export Button -->
            <button onclick="exportData()" class="rounded-lg bg-green-600 px-4 py-2 text-sm font-medium text-white hover:bg-green-700">
                <i class="fas fa-download mr-2"></i>Export CSV
            </button>
            
            <!-- Select All Toggle -->
            <button onclick="toggleSelectAll()" id="selectAllBtn" class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                <i class="fas fa-check-square mr-2"></i>Pilih Semua
            </button>
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
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Akun Aktif</option>
                <option value="suspended" {{ request('status') === 'suspended' ? 'selected' : '' }}>Akun Suspended</option>
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
                        <th class="px-6 py-3 text-left">
                            <input type="checkbox" id="selectAllCheckbox" onchange="toggleSelectAll()" class="rounded border-gray-300">
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">Peserta</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">Program</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">Total Order</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">Tgl Daftar</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($students as $student)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <input type="checkbox" class="student-checkbox rounded border-gray-300" value="{{ $student->id }}" onchange="updateBulkActions()">
                        </td>
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
                            @if($student->is_suspended)
                                <span class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800">
                                    <i class="fas fa-ban mr-2"></i>Suspended
                                </span>
                                @if($student->suspend_reason)
                                    <p class="mt-1 text-xs text-gray-500">{{ Str::limit($student->suspend_reason, 30) }}</p>
                                @endif
                            @else
                                <span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">
                                    <i class="fas fa-check-circle mr-2"></i>Aktif
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-1">
                                <!-- View Detail -->
                                <a href="{{ route('admin.students.show', $student->id) }}" 
                                   class="rounded p-1 text-blue-600 hover:bg-blue-50"
                                   title="Lihat Detail">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>

                                <!-- Suspend/Activate -->
                                @if(!$student->is_suspended)
                                <button onclick="suspendStudent({{ $student->id }})"
                                        class="rounded p-1 text-orange-600 hover:bg-orange-50"
                                        title="Suspend Akun">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728" />
                                    </svg>
                                </button>
                                @else
                                <button onclick="activateStudent({{ $student->id }})"
                                        class="rounded p-1 text-green-600 hover:bg-green-50"
                                        title="Aktifkan Akun">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </button>
                                @endif

                                <!-- Delete -->
                                <button onclick="deleteStudent({{ $student->id }}, '{{ $student->name }}')"
                                        class="rounded p-1 text-red-600 hover:bg-red-50"
                                        title="Hapus Peserta">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
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

    <!-- JavaScript for student management -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        let selectedStudents = [];

        // Toggle select all
        function toggleSelectAll() {
            const selectAllCheckbox = document.getElementById('selectAllCheckbox');
            const checkboxes = document.querySelectorAll('.student-checkbox');
            
            checkboxes.forEach(checkbox => {
                checkbox.checked = selectAllCheckbox.checked;
            });
            
            updateBulkActions();
        }

        // Update bulk actions visibility
        function updateBulkActions() {
            const checkboxes = document.querySelectorAll('.student-checkbox:checked');
            selectedStudents = Array.from(checkboxes).map(cb => cb.value);
            
            const bulkActions = document.getElementById('bulkActions');
            const selectedCount = document.getElementById('selectedCount');
            
            if (selectedStudents.length > 0) {
                bulkActions.style.display = 'flex';
                selectedCount.textContent = selectedStudents.length;
            } else {
                bulkActions.style.display = 'none';
            }

            // Update select all checkbox
            const allCheckboxes = document.querySelectorAll('.student-checkbox');
            const selectAllCheckbox = document.getElementById('selectAllCheckbox');
            selectAllCheckbox.checked = allCheckboxes.length > 0 && selectedStudents.length === allCheckboxes.length;
        }

        // Delete single student
        function deleteStudent(studentId, studentName) {
            if (confirm(`Apakah Anda yakin ingin menghapus peserta "${studentName}"? Semua data terkait (order, payment) akan terhapus permanen.`)) {
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
                        location.reload();
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

        // Bulk delete students
        function bulkDelete() {
            if (selectedStudents.length === 0) return;

            if (confirm(`Apakah Anda yakin ingin menghapus ${selectedStudents.length} peserta? Semua data terkait akan terhapus permanen.`)) {
                fetch('/admin/students/bulk-delete', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        student_ids: selectedStudents
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
                    alert('Terjadi kesalahan saat menghapus peserta.');
                });
            }
        }

        // Suspend student with reason
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

        // Activate student
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

        // Export data
        function exportData() {
            const currentUrl = new URL(window.location);
            const exportUrl = new URL('/admin/students/export', window.location.origin);
            
            // Copy current filters to export
            ['search', 'program', 'status'].forEach(param => {
                if (currentUrl.searchParams.has(param)) {
                    exportUrl.searchParams.set(param, currentUrl.searchParams.get(param));
                }
            });

            window.location.href = exportUrl.toString();
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            updateBulkActions();
        });
    </script>
@endsection

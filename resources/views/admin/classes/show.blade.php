@extends('layouts.admin')

@section('title', 'Detail Program')

@section('content')
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center gap-2 text-sm text-gray-600 mb-4">
            <a href="{{ route('admin.classes.index') }}" class="hover:text-gray-900">Kelas</a>
            <span>/</span>
            <span class="text-gray-900 font-medium">{{ $program->name }}</span>
        </div>
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $program->name }}</h1>
                <p class="mt-1 text-sm text-gray-500">
                    {{ $program->duration }} • {{ $students->count() }} Peserta Aktif
                </p>
            </div>
            <a href="{{ route('admin.classes.edit', $program->id) }}" 
               class="inline-flex items-center gap-2 rounded-lg bg-[#2D3C8C] px-4 py-2 text-sm font-semibold text-white hover:bg-blue-900">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit Program
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 rounded-lg bg-green-50 p-4 text-green-800">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 rounded-lg bg-red-50 p-4 text-red-800">
            {{ session('error') }}
        </div>
    @endif

    <!-- Tabs -->
    <div class="mb-6">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8 overflow-x-auto">
                <button onclick="switchTab('info')" id="tab-info" class="tab-button border-b-2 border-[#2D3C8C] py-4 px-1 text-sm font-medium text-[#2D3C8C] whitespace-nowrap">
                    📊 Informasi Program
                </button>
                <button onclick="switchTab('students')" id="tab-students" class="tab-button border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700 whitespace-nowrap">
                    👥 Peserta ({{ $students->count() }})
                </button>
                <button onclick="switchTab('materials')" id="tab-materials" class="tab-button border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700 whitespace-nowrap">
                    📚 Materi Pembelajaran ({{ $program->courses->count() }})
                </button>
                <button onclick="switchTab('schedule')" id="tab-schedule" class="tab-button border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700 whitespace-nowrap">
                    📅 Jadwal Kelas ({{ $program->classSchedules->count() }})
                </button>
                <button onclick="switchTab('exercises')" id="tab-exercises" class="tab-button border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700 whitespace-nowrap">
                    📝 Latihan Soal ({{ $program->quizBanks->where('type', 'practice')->count() }})
                </button>
                <button onclick="switchTab('tryout')" id="tab-tryout" class="tab-button border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700 whitespace-nowrap">
                    🎯 Try Out ({{ $program->quizBanks->where('type', 'tryout')->count() }})
                </button>
            </nav>
        </div>
    </div>

    <!-- Tab Content: Info -->
    <div id="content-info" class="tab-content">
        <div class="grid gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2">
                <div class="rounded-lg bg-white p-6 shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Detail Program</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="text-sm font-medium text-gray-500">Deskripsi</label>
                            <p class="mt-1 text-gray-900">{{ $program->description }}</p>
                        </div>
                        <div class="grid gap-4 md:grid-cols-2">
                            <div>
                                <label class="text-sm font-medium text-gray-500">Harga</label>
                                <p class="mt-1 text-lg font-semibold text-gray-900">Rp {{ number_format($program->price, 0, ',', '.') }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Durasi</label>
                                <p class="mt-1 text-gray-900">{{ $program->duration }}</p>
                            </div>
                        </div>
                        @if($program->features && count($program->features) > 0)
                        <div>
                            <label class="text-sm font-medium text-gray-500 block mb-2">Fitur Program</label>
                            <ul class="space-y-2">
                                @foreach($program->features as $feature)
                                <li class="flex items-center gap-2 text-gray-900">
                                    <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $feature }}
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div>
                <div class="rounded-lg bg-white p-6 shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistik</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Total Peserta</span>
                            <span class="text-xl font-bold text-gray-900">{{ $students->count() }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Materi & Tugas</span>
                            <span class="text-xl font-bold text-gray-900">{{ $program->courses->count() }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Bank Soal</span>
                            <span class="text-xl font-bold text-gray-900">0</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Status</span>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $program->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $program->status === 'active' ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tab Content: Students -->
    <div id="content-students" class="tab-content hidden">
        <div class="rounded-lg bg-white shadow-sm overflow-hidden">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900">Daftar Peserta</h3>
                <p class="mt-1 text-sm text-gray-500">Peserta yang sudah melakukan pembayaran</p>
            </div>
            
            @if($students->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Telepon</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Daftar</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Bayar</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($students as $index => $order)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $index + 1 }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 flex-shrink-0">
                                        <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                            <span class="text-sm font-medium text-blue-700">{{ substr($order->user->name, 0, 1) }}</span>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $order->user->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-500">{{ $order->user->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-500">{{ $order->user->phone ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $order->created_at->format('d M Y, H:i') }} WIB
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-gray-900">Rp {{ number_format($order->payment->amount ?? 0, 0, ',', '.') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($order->payment && $order->payment->status === 'paid')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    ✓ Lunas
                                </span>
                                @elseif($order->payment && $order->payment->status === 'pending')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    ⏳ Pending
                                </span>
                                @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                    - Belum Bayar
                                </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('admin.students.show', $order->user->id) }}" class="text-blue-600 hover:text-blue-900">Lihat Detail</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Summary -->
            <div class="mt-4 flex items-center justify-between px-6 py-3 bg-gray-50 rounded-lg">
                <div class="text-sm text-gray-700">
                    Total <span class="font-semibold">{{ $students->count() }}</span> peserta terdaftar
                </div>
                <div class="text-sm font-semibold text-gray-900">
                    Total Pendapatan: Rp {{ number_format($students->sum(function($o) { return $o->payment->amount ?? 0; }), 0, ',', '.') }}
                </div>
            </div>
            @else
            <div class="p-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada peserta</h3>
                <p class="mt-1 text-sm text-gray-500">Belum ada siswa yang mendaftar di program ini.</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Tab Content: Materials -->
    <div id="content-materials" class="tab-content hidden">
        <div class="grid gap-6">
            <!-- Upload Form -->
            <div class="rounded-lg bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">📤 Tambah Materi Pembelajaran Baru</h3>
                <form action="{{ route('admin.classes.materials.store', $program->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div class="grid gap-4 md:grid-cols-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Judul Materi <span class="text-red-500">*</span></label>
                            <input type="text" name="title" required placeholder="Contoh: Pengenalan Farmakologi" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#2D3C8C] focus:ring-[#2D3C8C]">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tipe Materi <span class="text-red-500">*</span></label>
                            <select name="type" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#2D3C8C] focus:ring-[#2D3C8C]">
                                <option value="">Pilih Tipe</option>
                                <option value="video">📹 Video</option>
                                <option value="material">📄 Dokumen/PDF</option>
                                <option value="assignment">📝 Tugas</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Durasi (menit)</label>
                            <input type="number" name="duration_minutes" placeholder="60" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#2D3C8C] focus:ring-[#2D3C8C]">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Materi</label>
                        <textarea name="description" rows="3" placeholder="Jelaskan tentang materi ini..." class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#2D3C8C] focus:ring-[#2D3C8C]"></textarea>
                    </div>
                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Link Video (opsional)</label>
                            <input type="url" name="video_url" placeholder="https://youtube.com/..." class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#2D3C8C] focus:ring-[#2D3C8C]">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">File (PDF, DOC, PPT, ZIP - Max 10MB)</label>
                            <input type="file" name="file" accept=".pdf,.doc,.docx,.ppt,.pptx,.zip" class="w-full border border-gray-300 rounded-lg p-2 text-sm">
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-[#2D3C8C] px-6 py-2.5 text-sm font-semibold text-white hover:bg-blue-900">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Simpan Materi
                        </button>
                        <button type="reset" class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-6 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                            Reset
                        </button>
                    </div>
                </form>
            </div>

            <!-- Materials List -->
            <div class="rounded-lg bg-white shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">📚 Daftar Materi Pembelajaran</h3>
                    <p class="mt-1 text-sm text-gray-500">Total: {{ $program->courses->count() }} materi</p>
                </div>
                
                @if($program->courses->count() > 0)
                <div class="divide-y divide-gray-200">
                    @foreach($program->courses->sortByDesc('created_at') as $index => $course)
                    <div class="p-5 hover:bg-gray-50 transition">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex items-start gap-4 flex-1">
                                <!-- Icon -->
                                <div class="p-3 rounded-lg flex-shrink-0
                                    {{ $course->type === 'video' ? 'bg-purple-100' : ($course->type === 'material' ? 'bg-blue-100' : 'bg-orange-100') }}">
                                    @if($course->type === 'video')
                                        <svg class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    @elseif($course->type === 'material')
                                        <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    @else
                                        <svg class="h-6 w-6 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                        </svg>
                                    @endif
                                </div>
                                
                                <!-- Content -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-3 mb-1">
                                        <span class="text-sm font-semibold text-gray-400">#{{ $program->courses->count() - $index }}</span>
                                        <h4 class="font-semibold text-gray-900">{{ $course->title }}</h4>
                                        <span class="px-2 py-0.5 text-xs font-medium rounded-full
                                            {{ $course->type === 'video' ? 'bg-purple-100 text-purple-700' : ($course->type === 'material' ? 'bg-blue-100 text-blue-700' : 'bg-orange-100 text-orange-700') }}">
                                            {{ $course->type === 'video' ? '📹 Video' : ($course->type === 'material' ? '📄 Materi' : '📝 Tugas') }}
                                        </span>
                                    </div>
                                    
                                    @if($course->description)
                                    <p class="mt-1 text-sm text-gray-600 line-clamp-2">{{ $course->description }}</p>
                                    @endif
                                    
                                    <div class="mt-3 flex flex-wrap items-center gap-3 text-xs text-gray-500">
                                        @if($course->video_url)
                                        <span class="flex items-center gap-1">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                            </svg>
                                            Video Link
                                        </span>
                                        @endif
                                        @if($course->file_name)
                                        <span>📎 {{ $course->file_name }}</span>
                                        <span>{{ number_format(($course->file_size ?? 0) / 1024, 1) }} KB</span>
                                        @endif
                                        @if($course->duration_minutes)
                                        <span>⏱️ {{ $course->duration_minutes }} menit</span>
                                        @endif
                                        <span>📅 {{ $course->created_at->format('d M Y, H:i') }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Actions -->
                            <div class="flex items-center gap-2 flex-shrink-0">
                                @if($course->video_url)
                                <a href="{{ $course->video_url }}" target="_blank" class="p-2 text-purple-600 hover:text-purple-800 hover:bg-purple-50 rounded-lg" title="Buka Video">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </a>
                                @endif
                                @if($course->file_path)
                                <a href="{{ Storage::url($course->file_path) }}" target="_blank" class="p-2 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg" title="Download File">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                    </svg>
                                </a>
                                @endif
                                <button onclick="editMaterial({{ $course->id }})" class="p-2 text-gray-600 hover:text-[#2D3C8C] hover:bg-gray-100 rounded-lg" title="Edit">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </button>
                                <form action="{{ route('admin.classes.materials.destroy', [$program->id, $course->id]) }}" method="POST" onsubmit="return confirm('Yakin hapus materi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-gray-600 hover:text-red-600 hover:bg-red-50 rounded-lg" title="Hapus">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="p-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada materi</h3>
                    <p class="mt-1 text-sm text-gray-500">Upload materi atau tugas menggunakan form di atas.</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Tab Content: Schedule -->
    <div id="content-schedule" class="tab-content hidden">
        <div class="rounded-lg bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Jadwal Kelas</h3>
                    <p class="mt-1 text-sm text-gray-500">Atur jadwal pertemuan dan kelas online/offline</p>
                </div>
                <button onclick="openScheduleModal()" class="inline-flex items-center gap-2 rounded-lg bg-[#2D3C8C] px-4 py-2 text-sm font-semibold text-white hover:bg-blue-900">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Jadwal
                </button>
            </div>

            @if($program->classSchedules->count() > 0)
            <div class="space-y-3">
                @foreach($program->classSchedules as $schedule)
                <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                @if($schedule->type === 'online')
                                <span class="px-2 py-1 text-xs font-semibold rounded bg-blue-100 text-blue-700">Online</span>
                                @else
                                <span class="px-2 py-1 text-xs font-semibold rounded bg-green-100 text-green-700">Offline</span>
                                @endif
                                
                                @if($schedule->status === 'scheduled')
                                <span class="px-2 py-1 text-xs font-semibold rounded bg-gray-100 text-gray-700">Terjadwal</span>
                                @elseif($schedule->status === 'ongoing')
                                <span class="px-2 py-1 text-xs font-semibold rounded bg-yellow-100 text-yellow-700">Berlangsung</span>
                                @elseif($schedule->status === 'completed')
                                <span class="px-2 py-1 text-xs font-semibold rounded bg-green-100 text-green-700">Selesai</span>
                                @else
                                <span class="px-2 py-1 text-xs font-semibold rounded bg-red-100 text-red-700">Dibatalkan</span>
                                @endif
                                
                                <h4 class="font-semibold text-gray-900">{{ $schedule->title }}</h4>
                            </div>
                            
                            @if($schedule->description)
                            <p class="text-sm text-gray-600 mb-2">{{ $schedule->description }}</p>
                            @endif
                            
                            <div class="flex items-center gap-4 text-sm text-gray-600">
                                <span>📅 {{ \Carbon\Carbon::parse($schedule->date)->locale('id')->isoFormat('dddd, D MMM YYYY') }}</span>
                                <span>🕐 {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }} WIB</span>
                                @if($schedule->type === 'online' && $schedule->meeting_link)
                                <a href="{{ $schedule->meeting_link }}" target="_blank" class="text-blue-600 hover:text-blue-800 font-medium">📍 Link Meeting</a>
                                @elseif($schedule->location)
                                <span>📍 {{ $schedule->location }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <button onclick="openEditScheduleModal({{ $schedule->id }})" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Edit</button>
                            <button onclick="deleteSchedule({{ $schedule->id }})" class="text-red-600 hover:text-red-800 text-sm font-medium">Hapus</button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="p-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada jadwal</h3>
                <p class="mt-1 text-sm text-gray-500">Tambahkan jadwal pertemuan kelas.</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Tab Content: Exercises -->
    <div id="content-exercises" class="tab-content hidden">
        <div class="rounded-lg bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Latihan Soal</h3>
                    <p class="mt-1 text-sm text-gray-500">Bank soal latihan untuk peserta</p>
                </div>
                <button onclick="openExerciseModal()" class="inline-flex items-center gap-2 rounded-lg bg-[#2D3C8C] px-4 py-2 text-sm font-semibold text-white hover:bg-blue-900">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Latihan
                </button>
            </div>

            @php
                $practiceQuizzes = $program->quizBanks->where('type', 'practice');
            @endphp
            @if($practiceQuizzes->count() > 0)
            <div class="grid gap-4">
                @foreach($practiceQuizzes as $quiz)
                <div class="border border-gray-200 rounded-lg p-4 hover:border-[#2D3C8C] transition">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <span class="px-2 py-1 text-xs font-semibold rounded bg-purple-100 text-purple-700">{{ ucfirst($quiz->category) }}</span>
                                <h4 class="font-semibold text-gray-900">{{ $quiz->title }}</h4>
                            </div>
                            @if($quiz->description)
                            <p class="mt-1 text-sm text-gray-600">{{ $quiz->description }}</p>
                            @endif
                            <div class="mt-3 flex items-center gap-4 text-sm text-gray-500">
                                <span>📝 {{ $quiz->questions_count }} Soal</span>
                                <span>⏱️ {{ $quiz->duration_minutes ? $quiz->duration_minutes . ' menit' : 'Tidak terbatas' }}</span>
                                <span>🏆 Nilai min: {{ $quiz->passing_score }}</span>
                                <span>📅 {{ $quiz->created_at->format('d M Y') }}</span>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('admin.classes.quizzes.questions', [$program->id, $quiz->id]) }}" class="text-green-600 hover:text-green-800 text-sm font-medium">Kelola Soal</a>
                            <button onclick="openEditExerciseModal({{ $quiz->id }})" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Edit</button>
                            <button onclick="deleteExercise({{ $quiz->id }})" class="text-red-600 hover:text-red-800 text-sm font-medium">Hapus</button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada latihan soal</h3>
                <p class="mt-1 text-sm text-gray-500">Tambahkan latihan soal untuk program ini</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Tab Content: Try Out -->
    <div id="content-tryout" class="tab-content hidden">
        <div class="rounded-lg bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Try Out</h3>
                    <p class="mt-1 text-sm text-gray-500">Ujian simulasi untuk menguji kemampuan peserta</p>
                </div>
                <button onclick="openTryoutModal()" class="inline-flex items-center gap-2 rounded-lg bg-[#2D3C8C] px-4 py-2 text-sm font-semibold text-white hover:bg-blue-900">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Try Out
                </button>
            </div>

            @php
                $tryoutQuizzes = $program->quizBanks->where('type', 'tryout');
            @endphp
            @if($tryoutQuizzes->count() > 0)
            <div class="grid gap-4">
                @foreach($tryoutQuizzes as $quiz)
                <div class="border-2 border-yellow-200 rounded-lg p-4 bg-yellow-50 hover:border-yellow-400 transition">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <span class="px-2 py-1 text-xs font-semibold rounded bg-yellow-100 text-yellow-700">🎯 Try Out - {{ ucfirst($quiz->category) }}</span>
                                <h4 class="font-semibold text-gray-900">{{ $quiz->title }}</h4>
                            </div>
                            @if($quiz->description)
                            <p class="mt-1 text-sm text-gray-600">{{ $quiz->description }}</p>
                            @endif
                            <div class="mt-3 flex items-center gap-4 text-sm text-gray-600">
                                <span>📝 {{ $quiz->questions_count }} Soal</span>
                                <span>⏱️ {{ $quiz->duration_minutes ? $quiz->duration_minutes . ' menit' : 'Tidak terbatas' }}</span>
                                <span>🏆 Nilai min: {{ $quiz->passing_score }}</span>
                                <span>📅 {{ $quiz->created_at->format('d M Y') }}</span>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('admin.classes.quizzes.questions', [$program->id, $quiz->id]) }}" class="text-green-600 hover:text-green-800 text-sm font-medium">Kelola Soal</a>
                            <button onclick="openEditTryoutModal({{ $quiz->id }})" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Edit</button>
                            <button onclick="deleteTryout({{ $quiz->id }})" class="text-red-600 hover:text-red-800 text-sm font-medium">Hapus</button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada Try Out</h3>
                <p class="mt-1 text-sm text-gray-500">Buat try out baru untuk menguji kemampuan peserta</p>
            </div>
            @endif
        </div>
    </div>

    <script>
        function switchTab(tabName) {
            console.log('Switching to tab:', tabName);
            
            // Hide all content
            document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
            
            // Remove active styles from all buttons
            document.querySelectorAll('.tab-button').forEach(el => {
                el.classList.remove('border-[#2D3C8C]', 'text-[#2D3C8C]');
                el.classList.add('border-transparent', 'text-gray-500');
            });
            
            // Show selected content
            const contentElement = document.getElementById('content-' + tabName);
            if (contentElement) {
                contentElement.classList.remove('hidden');
                console.log('Content shown for:', tabName);
            } else {
                console.error('Content element not found for:', tabName);
            }
            
            // Add active styles to selected button
            const activeButton = document.getElementById('tab-' + tabName);
            if (activeButton) {
                activeButton.classList.remove('border-transparent', 'text-gray-500');
                activeButton.classList.add('border-[#2D3C8C]', 'text-[#2D3C8C]');
            } else {
                console.error('Button not found for:', tabName);
            }
        }

        function openScheduleModal() {
            document.getElementById('scheduleModal').classList.remove('hidden');
            document.getElementById('scheduleForm').reset();
            document.getElementById('scheduleModalTitle').textContent = 'Tambah Jadwal Kelas';
            document.getElementById('scheduleForm').action = "{{ route('admin.classes.schedules.store', $program->id) }}";
            document.getElementById('scheduleMethod').value = 'POST';
        }

        function openEditScheduleModal(scheduleId) {
            // Get schedule data
            const schedule = @json($program->classSchedules);
            const scheduleData = schedule.find(s => s.id === scheduleId);
            
            if (scheduleData) {
                document.getElementById('scheduleModal').classList.remove('hidden');
                document.getElementById('scheduleModalTitle').textContent = 'Edit Jadwal Kelas';
                document.getElementById('scheduleForm').action = `/admin/classes/{{ $program->id }}/schedules/${scheduleId}`;
                document.getElementById('scheduleMethod').value = 'PUT';
                
                // Fill form
                document.getElementById('schedule_title').value = scheduleData.title;
                document.getElementById('schedule_description').value = scheduleData.description || '';
                document.getElementById('schedule_date').value = scheduleData.date;
                document.getElementById('schedule_start_time').value = scheduleData.start_time;
                document.getElementById('schedule_end_time').value = scheduleData.end_time;
                document.getElementById('schedule_type').value = scheduleData.type;
                document.getElementById('schedule_meeting_link').value = scheduleData.meeting_link || '';
                document.getElementById('schedule_location').value = scheduleData.location || '';
                document.getElementById('schedule_status').value = scheduleData.status;
                
                // Show/hide status field for edit mode
                document.getElementById('statusField').classList.remove('hidden');
            }
        }

        function closeScheduleModal() {
            document.getElementById('scheduleModal').classList.add('hidden');
            document.getElementById('scheduleForm').reset();
            document.getElementById('statusField').classList.add('hidden');
        }

        function deleteSchedule(scheduleId) {
            if (confirm('Apakah Anda yakin ingin menghapus jadwal ini?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/classes/{{ $program->id }}/schedules/${scheduleId}`;
                
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = '{{ csrf_token() }}';
                
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                
                form.appendChild(csrfInput);
                form.appendChild(methodInput);
                document.body.appendChild(form);
                form.submit();
            }
        }

        function openExerciseModal() {
            document.getElementById('quizModal').classList.remove('hidden');
            document.getElementById('quizForm').reset();
            document.getElementById('quizModalTitle').textContent = 'Tambah Latihan Soal';
            document.getElementById('quizForm').action = "{{ route('admin.classes.quizzes.store', $program->id) }}";
            document.getElementById('quizMethod').value = 'POST';
            document.getElementById('quiz_type').value = 'practice';
        }

        function openEditExerciseModal(quizId) {
            openQuizModalEdit(quizId, 'practice');
        }

        function openTryoutModal() {
            document.getElementById('quizModal').classList.remove('hidden');
            document.getElementById('quizForm').reset();
            document.getElementById('quizModalTitle').textContent = 'Tambah Try Out';
            document.getElementById('quizForm').action = "{{ route('admin.classes.quizzes.store', $program->id) }}";
            document.getElementById('quizMethod').value = 'POST';
            document.getElementById('quiz_type').value = 'tryout';
        }

        function openEditTryoutModal(quizId) {
            openQuizModalEdit(quizId, 'tryout');
        }

        function openQuizModalEdit(quizId, type) {
            const quizzes = @json($program->quizBanks);
            const quizData = quizzes.find(q => q.id === quizId);
            
            if (quizData) {
                document.getElementById('quizModal').classList.remove('hidden');
                document.getElementById('quizModalTitle').textContent = type === 'practice' ? 'Edit Latihan Soal' : 'Edit Try Out';
                document.getElementById('quizForm').action = `/admin/classes/{{ $program->id }}/quizzes/${quizId}`;
                document.getElementById('quizMethod').value = 'PUT';
                
                // Fill form
                document.getElementById('quiz_title').value = quizData.title;
                document.getElementById('quiz_description').value = quizData.description || '';
                document.getElementById('quiz_category').value = quizData.category;
                document.getElementById('quiz_type').value = quizData.type;
                document.getElementById('quiz_duration_minutes').value = quizData.duration_minutes || '';
                document.getElementById('quiz_passing_score').value = quizData.passing_score;
            }
        }

        function closeQuizModal() {
            document.getElementById('quizModal').classList.add('hidden');
            document.getElementById('quizForm').reset();
        }

        function deleteExercise(quizId) {
            if (confirm('Apakah Anda yakin ingin menghapus latihan soal ini? Semua soal di dalamnya juga akan terhapus.')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/classes/{{ $program->id }}/quizzes/${quizId}`;
                
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = '{{ csrf_token() }}';
                
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                
                form.appendChild(csrfInput);
                form.appendChild(methodInput);
                document.body.appendChild(form);
                form.submit();
            }
        }

        function deleteTryout(quizId) {
            if (confirm('Apakah Anda yakin ingin menghapus try out ini? Semua soal di dalamnya juga akan terhapus.')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/classes/{{ $program->id }}/quizzes/${quizId}`;
                
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = '{{ csrf_token() }}';
                
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                
                form.appendChild(csrfInput);
                form.appendChild(methodInput);
                document.body.appendChild(form);
                form.submit();
            }
        }

        function editMaterial(materialId) {
            alert('Fitur edit materi akan segera ditambahkan (ID: ' + materialId + ')');
        }

        function deleteConfirm(type, id) {
            if (confirm('Yakin ingin menghapus ' + type + ' ini?')) {
                // Delete logic here
                alert('Fitur hapus akan segera ditambahkan');
            }
        }
    </script>

    <!-- Modal: Add/Edit Schedule -->
    <div id="scheduleModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-md bg-white">
            <div class="flex items-center justify-between mb-4">
                <h3 id="scheduleModalTitle" class="text-lg font-semibold text-gray-900">Tambah Jadwal Kelas</h3>
                <button onclick="closeScheduleModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <form id="scheduleForm" method="POST" action="{{ route('admin.classes.schedules.store', $program->id) }}">
                @csrf
                <input type="hidden" id="scheduleMethod" name="_method" value="POST">

                <div class="space-y-4">
                    <!-- Title -->
                    <div>
                        <label for="schedule_title" class="block text-sm font-medium text-gray-700">Judul Pertemuan <span class="text-red-500">*</span></label>
                        <input type="text" id="schedule_title" name="title" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               placeholder="Contoh: Pertemuan 1: Pengenalan Materi">
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="schedule_description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <textarea id="schedule_description" name="description" rows="2"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                  placeholder="Penjelasan singkat tentang pertemuan ini"></textarea>
                    </div>

                    <!-- Date and Time -->
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label for="schedule_date" class="block text-sm font-medium text-gray-700">Tanggal <span class="text-red-500">*</span></label>
                            <input type="date" id="schedule_date" name="date" required
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="schedule_start_time" class="block text-sm font-medium text-gray-700">Jam Mulai <span class="text-red-500">*</span></label>
                            <input type="time" id="schedule_start_time" name="start_time" required
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="schedule_end_time" class="block text-sm font-medium text-gray-700">Jam Selesai <span class="text-red-500">*</span></label>
                            <input type="time" id="schedule_end_time" name="end_time" required
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                    </div>

                    <!-- Type -->
                    <div>
                        <label for="schedule_type" class="block text-sm font-medium text-gray-700">Tipe Kelas <span class="text-red-500">*</span></label>
                        <select id="schedule_type" name="type" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="online">Online (Zoom/Google Meet)</option>
                            <option value="offline">Offline (Lokasi Fisik)</option>
                        </select>
                    </div>

                    <!-- Meeting Link (for online) -->
                    <div>
                        <label for="schedule_meeting_link" class="block text-sm font-medium text-gray-700">Link Meeting (untuk kelas online)</label>
                        <input type="url" id="schedule_meeting_link" name="meeting_link"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               placeholder="https://zoom.us/j/... atau https://meet.google.com/...">
                    </div>

                    <!-- Location (for offline) -->
                    <div>
                        <label for="schedule_location" class="block text-sm font-medium text-gray-700">Lokasi (untuk kelas offline)</label>
                        <input type="text" id="schedule_location" name="location"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               placeholder="Contoh: Ruang Kelas A, Gedung B">
                    </div>

                    <!-- Status (only for edit) -->
                    <div id="statusField" class="hidden">
                        <label for="schedule_status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select id="schedule_status" name="status"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="scheduled">Terjadwal</option>
                            <option value="ongoing">Berlangsung</option>
                            <option value="completed">Selesai</option>
                            <option value="cancelled">Dibatalkan</option>
                        </select>
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="closeScheduleModal()"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                        Batal
                    </button>
                    <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-[#2D3C8C] rounded-md hover:bg-blue-900">
                        Simpan Jadwal
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal: Add/Edit Quiz/Exercise -->
    <div id="quizModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-md bg-white">
            <div class="flex items-center justify-between mb-4">
                <h3 id="quizModalTitle" class="text-lg font-semibold text-gray-900">Tambah Bank Soal</h3>
                <button onclick="closeQuizModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <form id="quizForm" method="POST" action="{{ route('admin.classes.quizzes.store', $program->id) }}">
                @csrf
                <input type="hidden" id="quizMethod" name="_method" value="POST">
                <input type="hidden" id="quiz_type" name="type" value="practice">

                <div class="space-y-4">
                    <!-- Title -->
                    <div>
                        <label for="quiz_title" class="block text-sm font-medium text-gray-700">Judul Bank Soal <span class="text-red-500">*</span></label>
                        <input type="text" id="quiz_title" name="title" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               placeholder="Contoh: Latihan Farmakologi Dasar">
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="quiz_description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <textarea id="quiz_description" name="description" rows="2"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                  placeholder="Penjelasan tentang bank soal ini"></textarea>
                    </div>

                    <!-- Category -->
                    <div>
                        <label for="quiz_category" class="block text-sm font-medium text-gray-700">Kategori <span class="text-red-500">*</span></label>
                        <select id="quiz_category" name="category" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Pilih Kategori</option>
                            <option value="farmakologi">Farmakologi</option>
                            <option value="farmasi-klinik">Farmasi Klinik</option>
                            <option value="kimia-farmasi">Kimia Farmasi</option>
                            <option value="farmasetika">Farmasetika</option>
                            <option value="farmakognosi">Farmakognosi</option>
                            <option value="farmasi-komunitas">Farmasi Komunitas</option>
                            <option value="manajemen-farmasi">Manajemen Farmasi</option>
                            <option value="umum">Umum</option>
                        </select>
                    </div>

                    <!-- Duration and Passing Score -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="quiz_duration_minutes" class="block text-sm font-medium text-gray-700">Durasi (menit)</label>
                            <input type="number" id="quiz_duration_minutes" name="duration_minutes" min="1"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                   placeholder="Kosongkan jika tidak terbatas">
                            <p class="mt-1 text-xs text-gray-500">Kosongkan untuk tidak ada batas waktu</p>
                        </div>
                        <div>
                            <label for="quiz_passing_score" class="block text-sm font-medium text-gray-700">Nilai Kelulusan <span class="text-red-500">*</span></label>
                            <input type="number" id="quiz_passing_score" name="passing_score" required min="0" max="100" value="70"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <p class="mt-1 text-xs text-gray-500">Nilai minimal (0-100)</p>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="closeQuizModal()"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                        Batal
                    </button>
                    <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-[#2D3C8C] rounded-md hover:bg-blue-900">
                        Simpan Bank Soal
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

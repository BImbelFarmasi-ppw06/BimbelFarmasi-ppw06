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
            <nav class="-mb-px flex space-x-8">
                <button onclick="switchTab('info')" id="tab-info" class="tab-button border-b-2 border-[#2D3C8C] py-4 px-1 text-sm font-medium text-[#2D3C8C]">
                    Informasi Program
                </button>
                <button onclick="switchTab('students')" id="tab-students" class="tab-button border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">
                    Peserta ({{ $students->count() }})
                </button>
                <button onclick="switchTab('materials')" id="tab-materials" class="tab-button border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">
                    Materi & Tugas ({{ $program->courses->count() }})
                </button>
                <button onclick="switchTab('quizzes')" id="tab-quizzes" class="tab-button border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">
                    Bank Soal ({{ $program->quizBanks->count() }})
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
                            <span class="text-xl font-bold text-gray-900">{{ $program->quizBanks->count() }}</span>
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
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Telepon</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Daftar</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Bayar</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($students as $order)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $order->user->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-500">{{ $order->user->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-500">{{ $order->user->phone ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $order->created_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Lunas
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
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
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Upload Materi / Tugas</h3>
                <form action="{{ route('admin.classes.materials.store', $program->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Judul</label>
                            <input type="text" name="title" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#2D3C8C] focus:ring-[#2D3C8C]">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tipe</label>
                            <select name="type" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#2D3C8C] focus:ring-[#2D3C8C]">
                                <option value="material">Materi</option>
                                <option value="assignment">Tugas</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                        <textarea name="description" rows="2" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#2D3C8C] focus:ring-[#2D3C8C]"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">File (PDF, DOC, PPT, ZIP - Max 10MB)</label>
                        <input type="file" name="file" accept=".pdf,.doc,.docx,.ppt,.pptx,.zip" required class="w-full border border-gray-300 rounded-lg p-2">
                    </div>
                    <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-[#2D3C8C] px-4 py-2 text-sm font-semibold text-white hover:bg-blue-900">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        Upload Materi
                    </button>
                </form>
            </div>

            <!-- Materials List -->
            <div class="rounded-lg bg-white shadow-sm overflow-hidden">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900">Daftar Materi & Tugas</h3>
                </div>
                
                @if($program->courses->count() > 0)
                <div class="divide-y divide-gray-200">
                    @foreach($program->courses as $course)
                    <div class="p-6 flex items-start justify-between hover:bg-gray-50">
                        <div class="flex items-start gap-4 flex-1">
                            <div class="p-3 rounded-lg {{ $course->type === 'material' ? 'bg-blue-100' : 'bg-orange-100' }}">
                                <svg class="h-6 w-6 {{ $course->type === 'material' ? 'text-blue-600' : 'text-orange-600' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    @if($course->type === 'material')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    @else
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                                    @endif
                                </svg>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center gap-2">
                                    <h4 class="font-semibold text-gray-900">{{ $course->title }}</h4>
                                    <span class="px-2 py-1 text-xs rounded-full {{ $course->type === 'material' ? 'bg-blue-100 text-blue-800' : 'bg-orange-100 text-orange-800' }}">
                                        {{ $course->type === 'material' ? 'Materi' : 'Tugas' }}
                                    </span>
                                </div>
                                @if($course->description)
                                <p class="mt-1 text-sm text-gray-600">{{ $course->description }}</p>
                                @endif
                                <div class="mt-2 flex items-center gap-4 text-xs text-gray-500">
                                    <span>📎 {{ $course->file_name }}</span>
                                    <span>{{ number_format($course->file_size / 1024, 1) }} KB</span>
                                    <span>{{ $course->created_at->format('d M Y') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <a href="{{ Storage::url($course->file_path) }}" target="_blank" class="p-2 text-gray-400 hover:text-[#2D3C8C]">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                            </a>
                            <form action="{{ route('admin.classes.materials.destroy', [$program->id, $course->id]) }}" method="POST" onsubmit="return confirm('Hapus materi ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-gray-400 hover:text-red-600">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
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

    <!-- Tab Content: Quizzes -->
    <div id="content-quizzes" class="tab-content hidden">
        <div class="rounded-lg bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Bank Soal</h3>
                    <p class="mt-1 text-sm text-gray-500">Kelola soal-soal untuk program ini</p>
                </div>
                <a href="{{ route('admin.questions.index') }}" class="inline-flex items-center gap-2 rounded-lg bg-[#2D3C8C] px-4 py-2 text-sm font-semibold text-white hover:bg-blue-900">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Buat Bank Soal Baru
                </a>
            </div>

            @if($program->quizBanks->count() > 0)
            <div class="grid gap-4">
                @foreach($program->quizBanks as $quiz)
                <div class="border border-gray-200 rounded-lg p-4 hover:border-[#2D3C8C] transition">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h4 class="font-semibold text-gray-900">{{ $quiz->title }}</h4>
                            @if($quiz->description)
                            <p class="mt-1 text-sm text-gray-600">{{ $quiz->description }}</p>
                            @endif
                            <div class="mt-3 flex items-center gap-4 text-sm text-gray-500">
                                <span>📝 {{ $quiz->questions_count }} Soal</span>
                                <span>⏱️ {{ $quiz->duration }} menit</span>
                                <span>📅 {{ $quiz->created_at->format('d M Y') }}</span>
                            </div>
                        </div>
                        <a href="{{ route('admin.questions.index') }}" class="text-[#2D3C8C] hover:text-blue-900 text-sm font-medium">
                            Kelola →
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada bank soal</h3>
                <p class="mt-1 text-sm text-gray-500">Buat bank soal baru untuk program ini.</p>
            </div>
            @endif
        </div>
    </div>

    <script>
        function switchTab(tabName) {
            // Hide all content
            document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
            // Remove active styles from all buttons
            document.querySelectorAll('.tab-button').forEach(el => {
                el.classList.remove('border-[#2D3C8C]', 'text-[#2D3C8C]');
                el.classList.add('border-transparent', 'text-gray-500');
            });
            
            // Show selected content
            document.getElementById('content-' + tabName).classList.remove('hidden');
            // Add active styles to selected button
            const activeButton = document.getElementById('tab-' + tabName);
            activeButton.classList.remove('border-transparent', 'text-gray-500');
            activeButton.classList.add('border-[#2D3C8C]', 'text-[#2D3C8C]');
        }
    </script>
@endsection

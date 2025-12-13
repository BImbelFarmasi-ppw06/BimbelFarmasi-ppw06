@extends('layouts.admin')

@section('title', 'Edit Program')

@section('content')
    <div class="mb-6">
        <div class="flex items-center gap-2 text-sm text-gray-600 mb-4">
            <a href="{{ route('admin.classes.index') }}" class="hover:text-gray-900">Kelas / Program</a>
            <span>/</span>
            <span class="text-gray-900 font-medium">Edit Program</span>
        </div>
        <h1 class="text-2xl font-bold text-gray-900">Edit Program: {{ $program->name }}</h1>
        <p class="mt-1 text-sm text-gray-500">Update informasi program pembelajaran</p>
    </div>

    @if(session('error'))
        <div class="mb-6 rounded-lg bg-red-50 border border-red-200 p-4">
            <div class="flex">
                <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <div class="ml-3">
                    <p class="text-sm text-red-800">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif

    <form id="editProgramForm" action="{{ route('admin.classes.update', $program->id) }}" method="POST" class="space-y-6" onsubmit="return handleFormSubmit(event)">
        @csrf
        @method('PUT')

        <div class="rounded-lg bg-white p-6 shadow-sm">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Dasar</h3>
            
            <div class="mb-4">
                <label for="class_category" class="block text-sm font-medium text-gray-700 mb-2">
                    Kategori Kelas <span class="text-red-500">*</span>
                </label>
                <select 
                    name="class_category" 
                    id="class_category" 
                    required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500 @error('class_category') border-red-500 @enderror">
                    <option value="">Pilih Kategori Kelas</option>
                    <option value="bimbel-ukom" {{ old('class_category', $program->class_category) === 'bimbel-ukom' ? 'selected' : '' }}>Bimbel UKOM D3 Farmasi</option>
                    <option value="cpns-p3k" {{ old('class_category', $program->class_category) === 'cpns-p3k' ? 'selected' : '' }}>CPNS & P3K Farmasi</option>
                    <option value="joki-tugas" {{ old('class_category', $program->class_category) === 'joki-tugas' ? 'selected' : '' }}>Joki Tugas Farmasi</option>
                </select>
                @error('class_category')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Program <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    name="name" 
                    id="name" 
                    value="{{ old('name', $program->name) }}"
                    required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500 @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Deskripsi Program <span class="text-red-500">*</span>
                </label>
                <textarea 
                    name="description" 
                    id="description" 
                    rows="4"
                    required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500 @error('description') border-red-500 @enderror">{{ old('description', $program->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid gap-4 md:grid-cols-2 mb-4">
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                        Harga (Rp) <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="number" 
                        name="price" 
                        id="price" 
                        value="{{ old('price', $program->price) }}"
                        required
                        min="0"
                        step="1000"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500 @error('price') border-red-500 @enderror">
                    @error('price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="duration" class="block text-sm font-medium text-gray-700 mb-2">
                        Durasi <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="duration" 
                        id="duration" 
                        value="{{ old('duration', $program->duration) }}"
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500 @error('duration') border-red-500 @enderror">
                    @error('duration')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="rounded-lg bg-white p-6 shadow-sm">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Detail Kelas</h3>
            
            <div class="mb-4">
                <label for="tutor" class="block text-sm font-medium text-gray-700 mb-2">
                    Pengajar / Tutor
                </label>
                <input 
                    type="text" 
                    name="tutor" 
                    id="tutor" 
                    value="{{ old('tutor', $program->tutor) }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label for="schedule" class="block text-sm font-medium text-gray-700 mb-2">
                    Jadwal Kelas
                </label>
                <input 
                    type="text" 
                    name="schedule" 
                    id="schedule" 
                    value="{{ old('schedule', $program->schedule) }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                    Status <span class="text-red-500">*</span>
                </label>
                <select 
                    name="status" 
                    id="status" 
                    required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500">
                    <option value="active" {{ old('status', $program->status) === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status', $program->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
        </div>

        <div class="rounded-lg bg-white p-6 shadow-sm">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Fitur Program</h3>
            
            @php
                // Get features from old input first (after validation error)
                if (old('features')) {
                    $existingFeatures = old('features');
                } else {
                    // Otherwise get from database - model casting handles JSON automatically
                    $rawFeatures = $program->features ?? [];
                    // After model casts, features should already be an array
                    $existingFeatures = is_array($rawFeatures) ? $rawFeatures : [];
                }
                // Ensure it's never empty for form display
                if (empty($existingFeatures) || !is_array($existingFeatures)) {
                    $existingFeatures = [''];
                }
            @endphp

            <div id="featuresContainer" class="space-y-3">
                @foreach($existingFeatures as $feature)
                <div class="flex gap-2 feature-item">
                    <input 
                        type="text" 
                        name="features[]" 
                        value="{{ $feature }}"
                        class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500">
                    <button 
                        type="button" 
                        onclick="removeFeature(this)"
                        class="px-3 py-2 text-red-600 hover:bg-red-50 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                @endforeach
            </div>

            <button 
                type="button" 
                onclick="addFeature()"
                class="mt-3 inline-flex items-center gap-2 text-sm font-medium text-blue-600 hover:text-blue-700">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Fitur
            </button>
        </div>

        <div class="flex gap-3 justify-end">
            <a 
                href="{{ route('admin.classes.index') }}" 
                class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium">
                Batal
            </a>
            <button 
                type="submit" 
                onclick="return confirm('Apakah Anda yakin ingin memperbarui program ini?')"
                class="px-4 py-2 bg-[#2D3C8C] text-white rounded-lg hover:bg-blue-900 font-medium">
                Update Program
            </button>
        </div>
    </form>

    <!-- Delete Form (Separate from Update Form) -->
    <div class="mt-8 pt-6 border-t border-gray-200">
        <div class="rounded-lg bg-red-50 p-6">
            <h3 class="text-lg font-semibold text-red-900 mb-2">Zona Berbahaya</h3>
            <p class="text-sm text-red-700 mb-4">Menghapus program akan menghapus semua data terkait termasuk materi, jadwal, dan soal latihan.</p>
            <form action="{{ route('admin.classes.destroy', $program->id) }}" method="POST" 
                  onsubmit="return confirm('⚠️ PERINGATAN: Apakah Anda YAKIN ingin menghapus program ini? Semua data akan hilang PERMANEN dan tidak dapat dikembalikan!')">
                @csrf
                @method('DELETE')
                <button 
                    type="submit" 
                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium">
                    🗑️ Hapus Program Permanen
                </button>
            </form>
        </div>
    </div>

    <script>
        let isSubmitting = false;

        function handleFormSubmit(event) {
            if (isSubmitting) {
                event.preventDefault();
                return false;
            }
            
            isSubmitting = true;
            const submitButton = event.target.querySelector('button[type="submit"]');
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.innerHTML = '<svg class="animate-spin h-5 w-5 mr-2 inline" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Memproses...';
            }
            
            return true;
        }

        function addFeature() {
            const container = document.getElementById('featuresContainer');
            const newItem = document.createElement('div');
            newItem.className = 'flex gap-2 feature-item';
            newItem.innerHTML = `
                <input 
                    type="text" 
                    name="features[]" 
                    class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500">
                <button 
                    type="button" 
                    onclick="removeFeature(this)"
                    class="px-3 py-2 text-red-600 hover:bg-red-50 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            `;
            container.appendChild(newItem);
        }

        function removeFeature(button) {
            const container = document.getElementById('featuresContainer');
            if (container.children.length > 1) {
                button.closest('.feature-item').remove();
            }
        }
    </script>
@endsection

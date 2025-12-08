@extends('layouts.admin')

@section('title', 'Edit Program')

@section('content')
<div class="p-6">
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Edit Program</h1>
                <p class="text-sm text-gray-500">{{ $program->name }}</p>
            </div>
            <a href="{{ route('admin.programs.index') }}" class="inline-flex items-center gap-2 rounded-lg bg-gray-600 px-4 py-2 text-sm font-medium text-white hover:bg-gray-700 transition">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <div class="bg-white shadow rounded-lg">
        <form action="{{ route('admin.programs.update', $program) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="lg:col-span-2 space-y-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Program <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#2D3C8C] focus:border-[#2D3C8C] @error('name') border-red-300 @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $program->name) }}" 
                                   required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                                Tipe Program <span class="text-red-500">*</span>
                            </label>
                            <select class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#2D3C8C] focus:border-[#2D3C8C] @error('type') border-red-300 @enderror" 
                                    id="type" 
                                    name="type" 
                                    required>
                                <option value="">Pilih Tipe Program</option>
                                <option value="bimbel" {{ old('type', $program->type) == 'bimbel' ? 'selected' : '' }}>Bimbel</option>
                                <option value="joki" {{ old('type', $program->type) == 'joki' ? 'selected' : '' }}>Joki Tugas</option>
                                <option value="konsultasi" {{ old('type', $program->type) == 'konsultasi' ? 'selected' : '' }}>Konsultasi</option>
                            </select>
                            @error('type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                Deskripsi <span class="text-red-500">*</span>
                            </label>
                            <textarea class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#2D3C8C] focus:border-[#2D3C8C] @error('description') border-red-300 @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="4" 
                                      required>{{ old('description', $program->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Fitur Program <span class="text-red-500">*</span>
                            </label>
                            <div id="features-container" class="space-y-3">
                                @php
                                    $features = old('features', $program->features ?? []);
                                @endphp
                                @foreach($features as $index => $feature)
                                <div class="flex gap-2 feature-item">
                                    <input type="text" 
                                           class="flex-1 px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#2D3C8C] focus:border-[#2D3C8C] @error('features.' . $index) border-red-300 @enderror" 
                                           name="features[]" 
                                           value="{{ $feature }}" 
                                           required>
                                    <button class="px-3 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 remove-feature" type="button">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                    @error('features.' . $index)
                                        <p class="text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                @endforeach
                            </div>
                            <button type="button" class="mt-3 inline-flex items-center gap-2 rounded-lg bg-green-600 px-3 py-2 text-sm font-medium text-white hover:bg-green-700" id="add-feature">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Tambah Fitur
                            </button>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Detail Program</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                                        Harga <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">Rp</span>
                                        </div>
                                        <input type="number" 
                                               class="w-full pl-12 pr-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#2D3C8C] focus:border-[#2D3C8C] @error('price') border-red-300 @enderror" 
                                               id="price" 
                                               name="price" 
                                               value="{{ old('price', $program->price) }}" 
                                               min="0"
                                               required>
                                    </div>
                                    @error('price')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="duration_months" class="block text-sm font-medium text-gray-700 mb-2">
                                        Durasi (Bulan) <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#2D3C8C] focus:border-[#2D3C8C] @error('duration_months') border-red-300 @enderror" 
                                           id="duration_months" 
                                           name="duration_months" 
                                           value="{{ old('duration_months', $program->duration_months) }}" 
                                           min="1"
                                           required>
                                    @error('duration_months')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="total_sessions" class="block text-sm font-medium text-gray-700 mb-2">
                                        Total Sesi <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#2D3C8C] focus:border-[#2D3C8C] @error('total_sessions') border-red-300 @enderror" 
                                           id="total_sessions" 
                                           name="total_sessions" 
                                           value="{{ old('total_sessions', $program->total_sessions) }}" 
                                           min="1"
                                           required>
                                    @error('total_sessions')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="flex items-center">
                                    <input type="checkbox" 
                                           class="h-4 w-4 text-[#2D3C8C] focus:ring-[#2D3C8C] border-gray-300 rounded" 
                                           id="is_active" 
                                           name="is_active" 
                                           {{ old('is_active', $program->is_active) ? 'checked' : '' }}>
                                    <label for="is_active" class="ml-2 block text-sm text-gray-900">
                                        Program Aktif
                                    </label>
                                </div>
                                <p class="text-xs text-gray-500">Program yang aktif akan ditampilkan di website</p>
                            </div>
                        </div>

                        <div class="bg-blue-50 border border-blue-200 p-4 rounded-lg">
                            <h4 class="text-sm font-medium text-blue-900 mb-2">
                                <svg class="h-5 w-5 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                                Info Program
                            </h4>
                            <div class="text-xs text-blue-700 space-y-1">
                                <div><strong>Dibuat:</strong> {{ $program->created_at->format('d M Y, H:i') }}</div>
                                <div><strong>Diupdate:</strong> {{ $program->updated_at->format('d M Y, H:i') }}</div>
                                <div><strong>Slug:</strong> <code class="bg-blue-100 px-1 rounded">{{ $program->slug }}</code></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="flex justify-end space-x-3 px-6 py-4 bg-gray-50 border-t">
                <a href="{{ route('admin.programs.show', $program) }}" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    Lihat Detail
                </a>
                <a href="{{ route('admin.programs.index') }}" class="inline-flex items-center gap-2 rounded-lg bg-gray-600 px-4 py-2 text-sm font-medium text-white hover:bg-gray-700">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Batal
                </a>
                <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-[#2D3C8C] px-4 py-2 text-sm font-medium text-white hover:bg-[#1e2a6b]">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3-3m0 0l-3 3m3-3v12" />
                    </svg>
                    Update Program
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add new feature
    document.getElementById('add-feature').addEventListener('click', function() {
        const featureHtml = `
            <div class="flex gap-2 feature-item">
                <input type="text" 
                       class="flex-1 px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#2D3C8C] focus:border-[#2D3C8C]" 
                       name="features[]" 
                       placeholder="Contoh: Materi lengkap sesuai kisi-kisi terbaru"
                       required>
                <button class="px-3 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 remove-feature" type="button">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            </div>
        `;
        document.getElementById('features-container').insertAdjacentHTML('beforeend', featureHtml);
    });

    // Remove feature
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-feature')) {
            if (document.querySelectorAll('.feature-item').length > 1) {
                e.target.closest('.feature-item').remove();
            } else {
                alert('Minimal harus ada 1 fitur');
            }
        }
    });

    // Format price input
    document.getElementById('price').addEventListener('input', function(e) {
        const value = e.target.value;
        if (value) {
            // Remove existing preview
            const existingPreview = e.target.parentNode.parentNode.querySelector('.price-preview');
            if (existingPreview) {
                existingPreview.remove();
            }
            
            // Add new preview
            const preview = document.createElement('p');
            preview.className = 'mt-1 text-sm text-gray-500 price-preview';
            preview.textContent = 'Preview: Rp ' + parseInt(value).toLocaleString('id-ID');
            e.target.parentNode.parentNode.appendChild(preview);
        }
    });
});
</script>
@endsection
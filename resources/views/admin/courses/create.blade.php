@extends('layouts.admin')

@section('title', 'Upload Materi Baru')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <div class="mb-8">
        <a href="{{ route('admin.courses.index') }}" class="text-[#2D3C8C] hover:underline flex items-center gap-2 mb-4">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke Daftar Materi
        </a>
        <h1 class="text-3xl font-bold text-gray-900">Upload Materi Pembelajaran</h1>
        <p class="text-gray-600 mt-2">Upload materi untuk peserta yang sudah membayar</p>
    </div>

    <div class="bg-white rounded-xl shadow-lg p-8">
        <form action="{{ route('admin.courses.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Select Order -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Pesanan *</label>
                <select name="order_id" id="order_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#2D3C8C] focus:border-transparent" required>
                    <option value="">-- Pilih Pesanan --</option>
                    @foreach($orders as $order)
                        <option value="{{ $order->id }}" {{ old('order_id', $selectedOrder?->id) == $order->id ? 'selected' : '' }}>
                            {{ $order->order_number }} - {{ $order->user->name }} ({{ $order->program->name }})
                        </option>
                    @endforeach
                </select>
                @error('order_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                @if($orders->isEmpty())
                    <p class="text-yellow-600 text-sm mt-2">⚠️ Tidak ada pesanan yang sudah dibayar dan belum memiliki materi</p>
                @endif
            </div>

            <!-- Title -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Judul Materi *</label>
                <input type="text" name="title" value="{{ old('title') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#2D3C8C] focus:border-transparent" placeholder="Contoh: Modul Farmakologi Dasar" required>
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi</label>
                <textarea name="description" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#2D3C8C] focus:border-transparent" placeholder="Deskripsi singkat tentang materi ini">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Content -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Konten Materi *</label>
                <textarea name="content" rows="10" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#2D3C8C] focus:border-transparent" placeholder="Isi materi pembelajaran lengkap..." required>{{ old('content') }}</textarea>
                @error('content')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-sm text-gray-500 mt-1">Anda bisa menggunakan Markdown untuk formatting</p>
            </div>

            <!-- Video URL -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">URL Video (Opsional)</label>
                <input type="url" name="video_url" value="{{ old('video_url') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#2D3C8C] focus:border-transparent" placeholder="https://youtube.com/watch?v=...">
                @error('video_url')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-sm text-gray-500 mt-1">Link ke video pembelajaran (YouTube, Vimeo, dll)</p>
            </div>

            <!-- Duration -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Durasi (Menit)</label>
                <input type="number" name="duration_minutes" value="{{ old('duration_minutes') }}" min="1" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#2D3C8C] focus:border-transparent" placeholder="60">
                @error('duration_minutes')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- File Upload -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Upload File Pendukung (Opsional)</label>
                <input type="file" name="files[]" multiple class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#2D3C8C] focus:border-transparent" accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.zip">
                @error('files.*')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-sm text-gray-500 mt-1">Maks 10MB per file. Format: PDF, DOC, PPT, XLS, ZIP</p>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end gap-4 pt-6 border-t">
                <a href="{{ route('admin.courses.index') }}" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                    Batal
                </a>
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-[#2D3C8C] to-[#1e2761] text-white rounded-lg hover:shadow-lg transition-all">
                    Upload Materi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@extends('layouts.admin')

@section('title', 'Buat Bank Soal Baru')

@section('content')
    <div class="mb-6">
        <div class="flex items-center gap-2 text-sm text-gray-500 mb-4">
            <a href="{{ route('admin.questions.index') }}" class="hover:text-gray-700">Bank Soal</a>
            <span>/</span>
            <span class="text-gray-900">Buat Baru</span>
        </div>
        <h1 class="text-2xl font-bold text-gray-900">Buat Bank Soal Baru</h1>
        <p class="mt-1 text-sm text-gray-500">Buat bank soal untuk program layanan tertentu</p>
    </div>

    <div class="rounded-xl bg-white shadow-sm">
        <form action="{{ route('admin.questions.store') }}" method="POST" class="p-6">
            @csrf
            
            <div class="space-y-6">
                <!-- Program Selection -->
                <div>
                    <label for="program_id" class="block text-sm font-medium text-gray-700">Program Layanan <span class="text-red-500">*</span></label>
                    <select id="program_id" name="program_id" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Pilih Program</option>
                        @foreach($programs as $program)
                            <option value="{{ $program->id }}" {{ old('program_id') == $program->id ? 'selected' : '' }}>
                                {{ $program->name }} - {{ $program->type }}
                            </option>
                        @endforeach
                    </select>
                    @error('program_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Judul Bank Soal <span class="text-red-500">*</span></label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="contoh: Latihan Farmakologi UKOM Batch 1">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                    <textarea id="description" name="description" rows="3" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Deskripsi singkat tentang bank soal ini...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category -->
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700">Kategori <span class="text-red-500">*</span></label>
                    <select id="category" name="category" required class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Pilih Kategori</option>
                        <option value="Farmakologi" {{ old('category') == 'Farmakologi' ? 'selected' : '' }}>Farmakologi</option>
                        <option value="Farmasi Klinik" {{ old('category') == 'Farmasi Klinik' ? 'selected' : '' }}>Farmasi Klinik</option>
                        <option value="Farmasetika" {{ old('category') == 'Farmasetika' ? 'selected' : '' }}>Farmasetika</option>
                        <option value="Kimia Farmasi" {{ old('category') == 'Kimia Farmasi' ? 'selected' : '' }}>Kimia Farmasi</option>
                        <option value="UKOM" {{ old('category') == 'UKOM' ? 'selected' : '' }}>UKOM</option>
                        <option value="CPNS" {{ old('category') == 'CPNS' ? 'selected' : '' }}>CPNS</option>
                    </select>
                    @error('category')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Duration and Passing Score -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="duration_minutes" class="block text-sm font-medium text-gray-700">Durasi (menit) <span class="text-red-500">*</span></label>
                        <input type="number" id="duration_minutes" name="duration_minutes" value="{{ old('duration_minutes', 60) }}" required min="1" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('duration_minutes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="passing_score" class="block text-sm font-medium text-gray-700">Nilai Lulus (%) <span class="text-red-500">*</span></label>
                        <input type="number" id="passing_score" name="passing_score" value="{{ old('passing_score', 70) }}" required min="0" max="100" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('passing_score')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end gap-3">
                <a href="{{ route('admin.questions.index') }}" class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                    Batal
                </a>
                <button type="submit" class="rounded-lg bg-[#2D3C8C] px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-900">
                    Buat Bank Soal
                </button>
            </div>
        </form>
    </div>
@endsection

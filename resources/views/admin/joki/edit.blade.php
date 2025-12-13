@extends('layouts.admin')

@section('title', 'Edit Penjoki')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Edit Penjoki</h1>
        <p class="mt-1 text-sm text-slate-600">Perbarui informasi penjoki tugas.</p>
    </div>

    <div class="rounded-lg bg-white p-6 shadow">
        <form action="{{ route('admin.joki.update', $joki->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <!-- Nama Penjoki -->
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700">Nama Penjoki <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name', $joki->name) }}" required
                           class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('name') border-red-300 @enderror">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Keahlian -->
                <div>
                    <label for="expertise" class="block text-sm font-medium text-slate-700">Keahlian / Spesialisasi</label>
                    <input type="text" name="expertise" id="expertise" value="{{ old('expertise', $joki->expertise) }}"
                           placeholder="Contoh: Farmakologi & Farmakoterapi"
                           class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('expertise') border-red-300 @enderror">
                    @error('expertise')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Link WhatsApp -->
                <div>
                    <label for="wa_link" class="block text-sm font-medium text-slate-700">Link WhatsApp <span class="text-red-500">*</span></label>
                    <input type="url" name="wa_link" id="wa_link" value="{{ old('wa_link', $joki->wa_link) }}" required
                           placeholder="https://wa.me/628123456789?text=Halo..."
                           class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('wa_link') border-red-300 @enderror">
                    <p class="mt-1 text-xs text-slate-500">Format: https://wa.me/628xxxxxxxxx (gunakan kode negara tanpa +)</p>
                    @error('wa_link')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div>
                    <label for="description" class="block text-sm font-medium text-slate-700">Deskripsi Singkat</label>
                    <textarea name="description" id="description" rows="4"
                              class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('description') border-red-300 @enderror"
                              placeholder="Pengalaman, bidang yang dikuasai, dll...">{{ old('description', $joki->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label for="is_active" class="block text-sm font-medium text-slate-700">Status</label>
                    <select name="is_active" id="is_active" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="1" {{ old('is_active', $joki->is_active) ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ !old('is_active', $joki->is_active) ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                    @error('is_active')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Urutan Tampilan -->
                <div>
                    <label for="order" class="block text-sm font-medium text-slate-700">Urutan Tampilan</label>
                    <input type="number" name="order" id="order" value="{{ old('order', $joki->order) }}" min="0"
                           class="mt-1 block w-24 rounded-md border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('order') border-red-300 @enderror">
                    <p class="mt-1 text-xs text-slate-500">Semakin kecil angka, semakin di depan urutannya</p>
                    @error('order')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex gap-3">
                <button type="submit" class="inline-flex justify-center rounded-md border border-transparent bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Perbarui
                </button>
                <a href="{{ route('admin.joki.index') }}" class="inline-flex justify-center rounded-md border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

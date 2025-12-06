@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
    <section class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50 py-12">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Profil Saya</h1>
                <p class="mt-2 text-gray-600">Kelola informasi profil dan data pribadi Anda</p>
            </div>

            @if(session('success'))
                <div class="mb-6 rounded-lg bg-green-100 border border-green-200 p-4 text-green-800 flex items-center gap-3">
                    <svg class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Profile Form -->
            <div class="rounded-2xl bg-white p-8 shadow-lg">
                <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <!-- Profile Photo Section -->
                    <div class="mb-8 flex items-center gap-6">
                        <div class="relative">
                            @if($user->profile_photo)
                                <img src="{{ asset('storage/' . $user->profile_photo) }}" 
                                     alt="{{ $user->name }}" 
                                     class="h-24 w-24 rounded-full object-cover border-4 border-blue-200"
                                     id="preview-image">
                            @else
                                <div class="flex h-24 w-24 items-center justify-center rounded-full bg-gradient-to-br from-blue-500 to-purple-600 text-3xl font-bold text-white border-4 border-blue-200" id="preview-initials">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </div>
                                <img src="" 
                                     alt="{{ $user->name }}" 
                                     class="h-24 w-24 rounded-full object-cover border-4 border-blue-200 hidden"
                                     id="preview-image">
                            @endif
                            
                            <!-- Upload Button Overlay -->
                            <label for="profile_photo" class="absolute bottom-0 right-0 cursor-pointer rounded-full bg-blue-600 p-2 text-white shadow-lg hover:bg-blue-700 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                </svg>
                            </label>
                            <input type="file" 
                                   id="profile_photo" 
                                   name="profile_photo" 
                                   accept="image/jpeg,image/jpg,image/png,image/gif"
                                   class="hidden"
                                   onchange="previewProfilePhoto(event)">
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">{{ $user->name }}</h2>
                            <p class="text-sm text-gray-500">Member sejak {{ $user->created_at->format('d M Y') }}</p>
                            <p class="text-xs text-gray-400 mt-1">Klik ikon kamera untuk ganti foto</p>
                            @error('profile_photo')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="space-y-6">
                        <!-- Nama Lengkap -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="mt-2 w-full rounded-lg border border-gray-300 px-4 py-3 text-sm focus:border-[#2D3C8C] focus:outline-none focus:ring-2 focus:ring-blue-200 @error('name') border-red-300 @enderror" required>
                            @error('name')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700">Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="mt-2 w-full rounded-lg border border-gray-300 px-4 py-3 text-sm focus:border-[#2D3C8C] focus:outline-none focus:ring-2 focus:ring-blue-200 @error('email') border-red-300 @enderror" required>
                            @error('email')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- No. Handphone -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700">No. Handphone</label>
                            <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}" class="mt-2 w-full rounded-lg border border-gray-300 px-4 py-3 text-sm focus:border-[#2D3C8C] focus:outline-none focus:ring-2 focus:ring-blue-200 @error('phone') border-red-300 @enderror" required>
                            @error('phone')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Universitas -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700">Universitas (Opsional)</label>
                            <input type="text" name="university" value="{{ old('university', $user->university) }}" class="mt-2 w-full rounded-lg border border-gray-300 px-4 py-3 text-sm focus:border-[#2D3C8C] focus:outline-none focus:ring-2 focus:ring-blue-200" placeholder="Nama institusi">
                        </div>

                        <!-- Tertarik Dengan -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700">Tertarik Dengan</label>
                            <select name="interest" class="mt-2 w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm focus:border-[#2D3C8C] focus:outline-none focus:ring-2 focus:ring-blue-200">
                                <option value="">Pilih layanan</option>
                                <option value="Bimbel UKOM D3 Farmasi" {{ old('interest', $user->interest) == 'Bimbel UKOM D3 Farmasi' ? 'selected' : '' }}>Bimbel UKOM D3 Farmasi</option>
                                <option value="CPNS & P3K Farmasi" {{ old('interest', $user->interest) == 'CPNS & P3K Farmasi' ? 'selected' : '' }}>CPNS & P3K Farmasi</option>
                                <option value="Joki Tugas Akademik" {{ old('interest', $user->interest) == 'Joki Tugas Akademik' ? 'selected' : '' }}>Joki Tugas Akademik</option>
                                <option value="Konsultasi Akademik" {{ old('interest', $user->interest) == 'Konsultasi Akademik' ? 'selected' : '' }}>Konsultasi Akademik</option>
                            </select>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-8 flex gap-4">
                        <button type="submit" class="rounded-lg bg-[#2D3C8C] px-6 py-3 text-sm font-semibold text-white shadow-lg transition hover:bg-blue-900">
                            Simpan Perubahan
                        </button>
                        <a href="{{ route('home') }}" class="rounded-lg border border-gray-300 px-6 py-3 text-sm font-semibold text-gray-700 transition hover:bg-gray-50">
                            Batal
                        </a>
                    </div>
                </form>
            </div>

            <!-- Quick Links -->
            <div class="mt-6 grid gap-4 sm:grid-cols-3">
                <a href="{{ route('user.services') }}" class="rounded-xl bg-white p-4 shadow-md transition hover:shadow-lg">
                    <div class="flex items-center gap-3">
                        <div class="rounded-full bg-blue-100 p-3">
                            <svg class="h-6 w-6 text-[#2D3C8C]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900">Layanan Saya</p>
                            <p class="text-xs text-gray-500">Akses program Anda</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('user.transactions') }}" class="rounded-xl bg-white p-4 shadow-md transition hover:shadow-lg">
                    <div class="flex items-center gap-3">
                        <div class="rounded-full bg-green-100 p-3">
                            <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900">Riwayat Transaksi</p>
                            <p class="text-xs text-gray-500">Lihat pembayaran</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('user.settings') }}" class="rounded-xl bg-white p-4 shadow-md transition hover:shadow-lg">
                    <div class="flex items-center gap-3">
                        <div class="rounded-full bg-purple-100 p-3">
                            <svg class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900">Pengaturan</p>
                            <p class="text-xs text-gray-500">Ubah password</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- JavaScript untuk Preview Foto -->
    <script>
        function previewProfilePhoto(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewImage = document.getElementById('preview-image');
                    const previewInitials = document.getElementById('preview-initials');
                    
                    previewImage.src = e.target.result;
                    previewImage.classList.remove('hidden');
                    
                    if (previewInitials) {
                        previewInitials.classList.add('hidden');
                    }
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
@endsection

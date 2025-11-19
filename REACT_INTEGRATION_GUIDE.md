# React.js Integration Guide - Bimbel Farmasi

## ✅ Status: React.js Sudah Terintegrasi

Website Bimbel Farmasi sekarang sudah menggunakan **React.js** untuk komponen-komponen interaktif.

## 📦 Instalasi Dependencies

Sebelum menjalankan project, install dependencies terlebih dahulu:

```bash
# Install Node.js dependencies (termasuk React)
npm install

# Atau menggunakan Yarn
yarn install
```

Dependencies yang diinstall:
- `react` (^18.3.1)
- `react-dom` (^18.3.1)
- `@vitejs/plugin-react` (^4.3.4)

## 🚀 Cara Menjalankan

### Development Mode

```bash
# Terminal 1: Jalankan Laravel server
php artisan serve

# Terminal 2: Jalankan Vite dev server untuk React
npm run dev
```

### Production Build

```bash
# Build assets untuk production
npm run build

# Jalankan Laravel server
php artisan serve
```

## 📂 Struktur File React

```
resources/
├── js/
│   ├── app.jsx                     # Entry point React
│   ├── app.js                      # Vanilla JS (backward compatibility)
│   ├── bootstrap.js                # Bootstrap configuration
│   └── components/                 # React Components
│       ├── Hero.jsx                # Hero section component
│       ├── ProgramCard.jsx         # Program cards with dynamic data
│       ├── TestimonialSlider.jsx   # Testimonial slider
│       ├── ContactForm.jsx         # Contact form with validation
│       └── OrderForm.jsx           # Order form component
```

## 🎯 Komponen React yang Tersedia

### 1. Hero Component
**File:** `resources/js/components/Hero.jsx`

Hero section untuk landing page dengan animasi dan CTA buttons.

**Penggunaan di Blade:**
```blade
<div id="react-hero"></div>
@vite(['resources/js/app.jsx'])
```

### 2. ProgramCard Component
**File:** `resources/js/components/ProgramCard.jsx`

Menampilkan kartu program dengan data dinamis, fitur:
- Loading state
- Fetch data dari API/mock
- Responsive grid layout
- Hover effects

**Penggunaan di Blade:**
```blade
<div id="react-programs"></div>
@vite(['resources/js/app.jsx'])
```

### 3. TestimonialSlider Component
**File:** `resources/js/components/TestimonialSlider.jsx`

Slider testimoni dengan kontrol navigasi:
- Auto-play optional
- Navigation buttons
- Dot indicators
- Rating stars

**Penggunaan di Blade:**
```blade
<div id="react-testimonials"></div>
@vite(['resources/js/app.jsx'])
```

### 4. ContactForm Component
**File:** `resources/js/components/ContactForm.jsx`

Form kontak dengan validasi dan feedback:
- Form validation
- Loading state
- Success/error messages
- CSRF token handling

**Penggunaan di Blade:**
```blade
<div id="react-contact-form"></div>
@vite(['resources/js/app.jsx'])
```

### 5. OrderForm Component
**File:** `resources/js/components/OrderForm.jsx`

Form pemesanan dengan informasi program:
- Dynamic price display
- Notes field
- Security information
- Submit handling

**Penggunaan di Blade:**
```blade
<div id="react-order-form"></div>
<script>
    window.programData = @json($program);
    window.userEmail = '{{ Auth::user()->email }}';
</script>
@vite(['resources/js/app.jsx'])
```

## 🔄 Integrasi dengan Laravel Blade

### Hybrid Approach

Project ini menggunakan pendekatan hybrid:
- **Blade Templates**: Untuk SEO, routing, dan struktur halaman
- **React Components**: Untuk interaktivitas dan dynamic UI

### Contoh Integrasi

```blade
<!-- layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Bimbel Farmasi</title>
    @vite(['resources/css/app.css', 'resources/js/app.jsx'])
</head>
<body>
    @include('components.navbar')
    
    @yield('content')
    
    @include('components.footer')
</body>
</html>
```

```blade
<!-- pages/home.blade.php -->
@extends('layouts.app')

@section('content')
    <!-- React Hero Component -->
    <div id="react-hero"></div>
    
    <!-- Program Section -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Program Kami</h2>
            <div id="react-programs"></div>
        </div>
    </section>
    
    <!-- Testimonial Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Testimoni</h2>
            <div id="react-testimonials"></div>
        </div>
    </section>
@endsection
```

## 🛠️ Konfigurasi

### vite.config.js

```javascript
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js', 'resources/js/app.jsx'],
            refresh: true,
        }),
        react(),
        tailwindcss(),
    ],
});
```

### package.json

Dependencies sudah dikonfigurasi dengan:
- React 18.3.1
- React DOM 18.3.1
- Vite React Plugin
- Tailwind CSS

## 📝 Best Practices

### 1. State Management
```jsx
import { useState, useEffect } from 'react';

const MyComponent = () => {
    const [data, setData] = useState([]);
    const [loading, setLoading] = useState(true);
    
    useEffect(() => {
        fetchData();
    }, []);
    
    const fetchData = async () => {
        try {
            const response = await fetch('/api/data');
            const result = await response.json();
            setData(result);
        } catch (error) {
            console.error('Error:', error);
        } finally {
            setLoading(false);
        }
    };
    
    return <div>{/* Component JSX */}</div>;
};
```

### 2. CSRF Token
```jsx
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

fetch('/api/endpoint', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken
    },
    body: JSON.stringify(data)
});
```

### 3. Props dari Laravel
```blade
<div id="react-component"></div>
<script>
    window.appData = @json($data);
</script>
```

```jsx
const MyComponent = () => {
    const data = window.appData;
    return <div>{/* Use data */}</div>;
};
```

## 🎨 Styling dengan Tailwind CSS

Semua komponen React menggunakan Tailwind CSS:

```jsx
<div className="bg-white rounded-xl shadow-lg p-6 hover:shadow-2xl transition-all">
    <h3 className="text-2xl font-bold text-gray-900 mb-4">
        Title
    </h3>
    <button className="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700">
        Button
    </button>
</div>
```

## 🔍 Debugging

### React DevTools
Install React DevTools extension:
- Chrome: https://chrome.google.com/webstore/detail/react-developer-tools
- Firefox: https://addons.mozilla.org/en-US/firefox/addon/react-devtools/

### Console Logging
```jsx
useEffect(() => {
    console.log('Component mounted');
    console.log('Data:', data);
}, [data]);
```

## 📊 Performance

### Code Splitting
```jsx
import { lazy, Suspense } from 'react';

const HeavyComponent = lazy(() => import('./HeavyComponent'));

const App = () => (
    <Suspense fallback={<div>Loading...</div>}>
        <HeavyComponent />
    </Suspense>
);
```

### Memo untuk Optimization
```jsx
import { memo } from 'react';

const MyComponent = memo(({ data }) => {
    return <div>{data}</div>;
});
```

## ⚠️ Troubleshooting

### Error: "npm is not recognized"
**Solusi:** Install Node.js dari https://nodejs.org/

### Error: "Module not found"
```bash
# Hapus node_modules dan install ulang
rm -rf node_modules
npm install
```

### Error: Vite not building
```bash
# Clear cache
npm run build -- --force

# Atau
rm -rf node_modules/.vite
npm run dev
```

### React tidak muncul di browser
1. Cek apakah `npm run dev` berjalan
2. Pastikan `@vite(['resources/js/app.jsx'])` ada di template
3. Cek console browser untuk error
4. Pastikan element dengan ID yang benar ada di HTML

## 🎓 Resources

- [React Documentation](https://react.dev/)
- [Vite Documentation](https://vitejs.dev/)
- [Laravel Vite Documentation](https://laravel.com/docs/vite)
- [Tailwind CSS Documentation](https://tailwindcss.com/)

## ✅ Checklist Implementation

- [x] Install React & React DOM
- [x] Configure Vite for React
- [x] Create React components
- [x] Setup entry point (app.jsx)
- [x] Integrate with Blade templates
- [x] Add Tailwind CSS styling
- [x] Handle CSRF tokens
- [x] Implement state management
- [x] Add loading states
- [x] Create reusable components
- [x] Documentation

## 📞 Support

Jika ada pertanyaan atau masalah:
1. Check console browser untuk error
2. Review dokumentasi ini
3. Check Laravel logs: `storage/logs/laravel.log`
4. Gunakan React DevTools untuk debugging

---

**Status:** ✅ React.js Integration Complete
**Version:** React 18.3.1
**Build Tool:** Vite 7.0.7
**Styling:** Tailwind CSS 4.0.0

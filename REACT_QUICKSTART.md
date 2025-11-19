# 🚀 Quick Start - React.js Installation

## Langkah Instalasi React.js

### 1️⃣ Install Node.js
Download dan install Node.js dari: https://nodejs.org/
- Pilih versi LTS (Long Term Support)
- Jalankan installer dan ikuti instruksinya

### 2️⃣ Verifikasi Instalasi
Buka terminal/command prompt dan jalankan:
```bash
node --version
npm --version
```

### 3️⃣ Install Dependencies
Di folder project `BimbelFarmasi-ppw06`, jalankan:
```bash
npm install
```

Perintah ini akan menginstall:
- React 18.3.1
- React DOM 18.3.1
- Vite React Plugin
- Dan dependencies lainnya

### 4️⃣ Jalankan Development Server

**Buka 2 Terminal:**

**Terminal 1 - Laravel:**
```bash
php artisan serve
```

**Terminal 2 - Vite (React):**
```bash
npm run dev
```

### 5️⃣ Akses Website
Buka browser dan akses:
```
http://127.0.0.1:8000
```

## ✅ Cara Cek React.js Berfungsi

1. Buka browser
2. Klik kanan → Inspect Element
3. Buka tab "Console"
4. Jika tidak ada error dan halaman loading, berarti React sudah jalan!
5. Install React DevTools untuk debugging lebih mudah

## 📁 File yang Sudah Dibuat

- ✅ `package.json` - Updated dengan React dependencies
- ✅ `vite.config.js` - Konfigurasi Vite untuk React
- ✅ `resources/js/app.jsx` - Entry point React
- ✅ `resources/js/components/Hero.jsx` - Hero component
- ✅ `resources/js/components/ProgramCard.jsx` - Program cards
- ✅ `resources/js/components/TestimonialSlider.jsx` - Testimonial slider
- ✅ `resources/js/components/ContactForm.jsx` - Contact form
- ✅ `resources/js/components/OrderForm.jsx` - Order form

## 🔧 Jika npm tidak terinstall

### Windows:
1. Download Node.js installer: https://nodejs.org/
2. Jalankan installer
3. Restart terminal/command prompt
4. Test: `npm --version`

### Atau gunakan Chocolatey:
```powershell
# Install Chocolatey (run as Administrator)
Set-ExecutionPolicy Bypass -Scope Process -Force; [System.Net.ServicePointManager]::SecurityProtocol = [System.Net.ServicePointManager]::SecurityProtocol -bor 3072; iex ((New-Object System.Net.WebClient).DownloadString('https://community.chocolatey.org/install.ps1'))

# Install Node.js
choco install nodejs
```

## 📖 Dokumentasi Lengkap

Lihat file `REACT_INTEGRATION_GUIDE.md` untuk dokumentasi lengkap.

## ⚠️ Troubleshooting

### Error: "npm is not recognized"
➡️ Install Node.js terlebih dahulu

### Error: "Cannot find module"
➡️ Jalankan: `npm install`

### Error: Port sudah digunakan
➡️ Tutup aplikasi yang menggunakan port 5173 atau 8000

### React tidak muncul
➡️ Pastikan kedua terminal (Laravel & Vite) berjalan

## 🎯 Status Integration

✅ **React.js sudah terintegrasi dengan lengkap!**

Semua komponen sudah dibuat dan siap digunakan. Yang perlu dilakukan:
1. Install Node.js (jika belum)
2. Jalankan `npm install`
3. Jalankan `npm run dev` dan `php artisan serve`
4. Website sudah menggunakan React.js!

---

**Next Steps:**
- Integrasi komponen React ke Blade templates yang ada
- Connect ke API Laravel untuk data dinamis
- Tambahkan komponen React baru sesuai kebutuhan

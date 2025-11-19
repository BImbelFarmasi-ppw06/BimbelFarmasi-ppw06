# 🚀 INSTALASI NODE.JS & NPM - Panduan Lengkap

## ⚠️ NPM Tidak Ditemukan? Ikuti Langkah Ini!

### Metode 1: Download Manual (RECOMMENDED)

1. **Download Node.js:**
   - Buka: https://nodejs.org/
   - Klik tombol hijau "LTS" (Long Term Support)
   - Download installer untuk Windows

2. **Install Node.js:**
   - Jalankan file installer yang sudah didownload
   - Klik "Next" → "Next" → "Install"
   - **PENTING:** Centang "Automatically install necessary tools"
   - Tunggu hingga selesai
   - Klik "Finish"

3. **Restart Terminal:**
   - Tutup semua terminal/PowerShell yang terbuka
   - Buka PowerShell baru
   - Test instalasi:
   ```powershell
   node --version
   npm --version
   ```

4. **Install React Dependencies:**
   ```bash
   cd D:\BimbelFarmasi-ppw06
   npm install
   ```

### Metode 2: Menggunakan Winget (Windows 10/11)

```powershell
# Jalankan sebagai Administrator
winget install OpenJS.NodeJS.LTS

# Restart terminal
# Test
node --version
npm --version

# Install dependencies
cd D:\BimbelFarmasi-ppw06
npm install
```

### Metode 3: Menggunakan Chocolatey

```powershell
# Install Chocolatey terlebih dahulu (run as Administrator)
Set-ExecutionPolicy Bypass -Scope Process -Force
[System.Net.ServicePointManager]::SecurityProtocol = [System.Net.ServicePointManager]::SecurityProtocol -bor 3072
iex ((New-Object System.Net.WebClient).DownloadString('https://community.chocolatey.org/install.ps1'))

# Install Node.js
choco install nodejs-lts -y

# Restart terminal
# Install dependencies
npm install
```

## ✅ Setelah Node.js Terinstall

### 1. Verifikasi Instalasi
```bash
node --version
# Harus muncul: v20.x.x atau lebih

npm --version
# Harus muncul: v10.x.x atau lebih
```

### 2. Install Dependencies Project
```bash
cd D:\BimbelFarmasi-ppw06
npm install
```

Output yang diharapkan:
```
added 245 packages in 30s
```

### 3. Jalankan Development Server

**Terminal 1 - Laravel:**
```bash
php artisan serve
```

**Terminal 2 - Vite/React (PowerShell baru):**
```bash
npm run dev
```

Output yang diharapkan:
```
VITE v7.0.7  ready in 500 ms

➜  Local:   http://localhost:5173/
➜  Network: use --host to expose
➜  press h + enter to show help
```

### 4. Akses Website
```
http://127.0.0.1:8000
```

## 🔧 Troubleshooting

### Problem: "npm is not recognized"
**Solution:**
1. Pastikan Node.js sudah terinstall
2. Restart terminal/PowerShell
3. Jika masih error, restart komputer
4. Check PATH environment variable

### Problem: "Module not found"
**Solution:**
```bash
rm -rf node_modules
npm install
```

### Problem: "Permission denied"
**Solution:** Jalankan PowerShell sebagai Administrator

### Problem: Port 5173 sudah digunakan
**Solution:**
```bash
# Tutup aplikasi yang menggunakan port atau
npm run dev -- --port 5174
```

## 📊 Progress Checklist

- [ ] Download Node.js dari nodejs.org
- [ ] Install Node.js
- [ ] Restart terminal
- [ ] Verify: `node --version`
- [ ] Verify: `npm --version`
- [ ] Navigate to project: `cd D:\BimbelFarmasi-ppw06`
- [ ] Install dependencies: `npm install`
- [ ] Run Laravel: `php artisan serve`
- [ ] Run Vite: `npm run dev`
- [ ] Open browser: http://127.0.0.1:8000
- [ ] Check React components working

## 🎯 Quick Commands

```bash
# Check Node.js version
node --version

# Check npm version
npm --version

# Install all dependencies
npm install

# Run development server
npm run dev

# Build for production
npm run build

# Clear cache
npm cache clean --force
```

## 📞 Need Help?

Jika masih ada masalah:
1. Screenshot error message
2. Check Node.js version: `node --version`
3. Check npm version: `npm --version`
4. Check project location: `pwd`

## 🌐 Links

- Node.js Official: https://nodejs.org/
- NPM Documentation: https://docs.npmjs.com/
- Vite Documentation: https://vitejs.dev/
- React Documentation: https://react.dev/

---

**Status Saat Ini:** ⏳ Waiting for Node.js installation

**Next Step:** Setelah Node.js terinstall → `npm install` → `npm run dev`

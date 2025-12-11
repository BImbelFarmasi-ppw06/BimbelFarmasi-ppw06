# Facebook Login Setup Guide

## ✅ Setup Sudah Selesai!

Facebook Login API sudah di-setup dengan lengkap. Anda tinggal **update credentials di file `.env`** saja.

---

## 📝 Credentials yang Perlu Diisi di `.env`

Buka file `.env` dan pastikan ada 3 baris ini:

```env
FACEBOOK_CLIENT_ID=your_facebook_app_id_here
FACEBOOK_CLIENT_SECRET=your_facebook_app_secret_here
FACEBOOK_REDIRECT_URI=http://localhost:8000/login/facebook/callback
```

---

## 🔧 Cara Mendapatkan Facebook Credentials

### 1. Buat Facebook App

1. Buka [Facebook Developers](https://developers.facebook.com/)
2. Login dengan akun Facebook Anda
3. Klik **"My Apps"** → **"Create App"**
4. Pilih tipe: **"Consumer"** atau **"Business"**
5. Isi nama app: **"Bimbel Farmasi"**
6. Isi email kontak
7. Klik **"Create App"**

### 2. Setup Facebook Login

1. Di dashboard app, cari **"Facebook Login"** di menu kiri
2. Klik **"Settings"** di bawah Facebook Login
3. Di bagian **"Valid OAuth Redirect URIs"**, tambahkan:
   ```
   http://localhost:8000/login/facebook/callback
   http://127.0.0.1:8000/login/facebook/callback
   ```
4. Klik **"Save Changes"**

### 3. Ambil App ID dan App Secret

1. Klik **"Settings"** → **"Basic"** di menu kiri
2. Copy **"App ID"** → paste ke `FACEBOOK_CLIENT_ID` di `.env`
3. Copy **"App Secret"** (klik "Show" dulu) → paste ke `FACEBOOK_CLIENT_SECRET` di `.env`

### 4. Set App Mode ke Live (Untuk Production)

⚠️ **PENTING:** Saat development, app dalam mode "Development". Hanya admin/developer/tester yang bisa login.

Untuk production (agar semua user bisa login):
1. Klik **"Settings"** → **"Basic"**
2. Scroll ke bawah, switch dari **"Development"** ke **"Live"**
3. Facebook akan minta review - isi semua data yang diminta

---

## 🎯 Testing

### Test di Development Mode

1. Pastikan `.env` sudah terisi dengan benar
2. Restart Laravel server: `php artisan serve`
3. Buka halaman login: `http://localhost:8000/login`
4. Klik button **"Masuk dengan Facebook"**
5. Login dengan akun Facebook yang terdaftar sebagai admin/developer app

### Expected Flow

✅ **User baru (email belum pernah daftar):**
- Redirect ke Facebook login
- Approve permissions
- Otomatis buat akun baru
- Redirect ke halaman profil untuk lengkapi data
- Login berhasil

✅ **User existing (email sudah pernah daftar):**
- Redirect ke Facebook login
- Approve permissions
- Langsung login
- Redirect ke homepage

---

## 🔍 Troubleshooting

### Error: "Aplikasi tidak aktif"

**Penyebab:** App Facebook masih dalam mode Development.

**Solusi:**
1. Tambahkan akun Facebook Anda sebagai admin/developer app
2. Atau switch app ke mode "Live" (untuk production)

### Error: "Access denied due to unauthorized redirect URI"

**Penyebab:** Redirect URI di Facebook app settings tidak match dengan yang di kode.

**Solusi:**
1. Pastikan redirect URI di Facebook app settings sama dengan `FACEBOOK_REDIRECT_URI` di `.env`
2. Harus exact match (termasuk http/https, port, trailing slash)

### Error: "Facebook login membutuhkan akses email"

**Penyebab:** User tidak approve permission email saat login.

**Solusi:**
1. User harus approve permission "email" saat login Facebook
2. Atau di Facebook app settings, pastikan "email" permission di-request

---

## 📂 File yang Sudah Dimodifikasi

✅ `app/Http/Controllers/AuthController.php` - Tambah method `redirectToFacebook()` dan `handleFacebookCallback()`
✅ `config/services.php` - Tambah Facebook OAuth config
✅ `routes/web.php` - Tambah routes `/login/facebook` dan `/login/facebook/callback`
✅ `resources/views/pages/login.blade.php` - Tambah button "Masuk dengan Facebook"
✅ `resources/views/pages/register.blade.php` - Tambah button "Daftar dengan Facebook"
✅ `app/Http/Middleware/SecurityHeaders.php` - Sudah allow Midtrans CDN

---

## 🎉 Selesai!

Facebook Login sudah siap digunakan. Tinggal:

1. ✅ Isi credentials di `.env`
2. ✅ Restart server Laravel
3. ✅ Test login

**Happy coding!** 🚀

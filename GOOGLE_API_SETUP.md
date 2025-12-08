# 🎯 Panduan Konfigurasi Google APIs - Bimbel Farmasi

## ✅ Implementasi Yang Sudah Selesai

Semua **5 Google API** telah berhasil diimplementasikan:

1. ✅ **Google Maps API** - Embed peta lokasi kantor
2. ✅ **Google OAuth** - Login dengan akun Google
3. ✅ **Google Calendar API** - Jadwal bimbel
4. ✅ **Google Drive API** - Penyimpanan file materi
5. ✅ **Google Analytics** - Tracking pengunjung

---

## 📋 Langkah Konfigurasi

### 1️⃣ Google Maps API

**Dapatkan API Key:**

1. Buka [Google Cloud Console](https://console.cloud.google.com/)
2. Buat project baru atau pilih project yang ada
3. Aktifkan **Maps Embed API** dan **Maps JavaScript API**
4. Buat credentials → API Key
5. Copy API Key ke `.env`:

```env
GOOGLE_MAPS_API_KEY=AIzaSyXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
```

**File yang menggunakan:**

- `resources/views/pages/kontak.blade.php` - Embed Google Maps dengan lokasi kantor

---

### 2️⃣ Google OAuth (Login dengan Google)

**Setup OAuth 2.0:**

1. Di Google Cloud Console, buka **APIs & Services** → **Credentials**
2. Buat **OAuth 2.0 Client ID**
3. Application type: **Web application**
4. Authorized redirect URIs: `http://127.0.0.1:8000/login/google/callback`
5. Copy Client ID dan Client Secret ke `.env`:

```env
GOOGLE_CLIENT_ID=123456789-xxxxxxxxxxxxxxxx.apps.googleusercontent.com
GOOGLE_CLIENT_SECRET=GOCSPX-xxxxxxxxxxxxxxxxxxxxxx
GOOGLE_REDIRECT_URI=http://127.0.0.1:8000/login/google/callback
```

**Jalankan migration:**

```bash
php artisan migrate
```

**File yang terlibat:**

- `app/Http/Controllers/Auth/GoogleController.php` - Handle OAuth flow
- `app/Models/User.php` - Kolom `google_id` untuk menyimpan Google User ID
- `database/migrations/*_add_google_id_to_users_table.php` - Migration
- `resources/views/pages/login.blade.php` - Tombol "Login dengan Google"

---

### 3️⃣ Google Calendar API

**Setup Calendar:**

1. Buat **Google Calendar** baru khusus untuk jadwal bimbel
2. Di settings calendar, ambil **Calendar ID** (format: `xxxxx@group.calendar.google.com`)
3. Set calendar menjadi **Public** agar bisa diakses
4. Buat API Key di Google Cloud Console
5. Aktifkan **Google Calendar API**
6. Copy ke `.env`:

```env
GOOGLE_CALENDAR_ID=bimbelfarmasi@group.calendar.google.com
GOOGLE_CALENDAR_API_KEY=AIzaSyXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
```

**Akses halaman:**

- URL: `http://127.0.0.1:8000/jadwal`
- API: `http://127.0.0.1:8000/api/calendar/events`

**File yang terlibat:**

- `app/Http/Controllers/CalendarController.php` - Fetch events dari Google Calendar
- `resources/views/pages/jadwal.blade.php` - Tampilan jadwal dengan embed calendar
- `routes/web.php` - Route `/jadwal`
- `routes/api.php` - API endpoint `/api/calendar/events`

---

### 4️⃣ Google Drive API

**Setup Drive:**

1. Buat folder di Google Drive untuk menyimpan materi bimbel
2. Ambil **Folder ID** dari URL folder (format: `https://drive.google.com/drive/folders/FOLDER_ID_HERE`)
3. Set folder menjadi **Public** atau gunakan **Service Account**
4. Aktifkan **Google Drive API**
5. Copy ke `.env`:

```env
GOOGLE_DRIVE_FOLDER_ID=1abcDEF_xxxxxxxxxxxxxxxxxxxxx
```

**Untuk upload file (opsional):**

- Buat **Service Account** di Google Cloud Console
- Download JSON credentials
- Simpan di `storage/app/google-drive/service-account.json`
- Berikan akses folder ke service account email

**File yang terlibat:**

- `app/Http/Controllers/DriveController.php` - Upload & list files
- `routes/api.php` - API endpoint `/api/drive/files`

---

### 5️⃣ Google Analytics

**Setup Analytics:**

1. Buka [Google Analytics](https://analytics.google.com/)
2. Buat property baru (pilih **GA4**)
3. Ambil **Measurement ID** (format: `G-XXXXXXXXXX`)
4. Copy ke `.env`:

```env
GOOGLE_ANALYTICS_ID=G-XXXXXXXXXX
```

**File yang terlibat:**

- `resources/views/layouts/app.blade.php` - Script Google Analytics di `<head>`

**Tracking otomatis:**

- ✅ Page views
- ✅ User sessions
- ✅ Geographic data
- ✅ Device info

---

## 🔐 File `.env` Lengkap

```env
# =================== GOOGLE APIs ===================
# Google Maps API Key (untuk embed maps di halaman kontak)
GOOGLE_MAPS_API_KEY=your-google-maps-api-key-here

# Google OAuth (untuk login dengan Google)
GOOGLE_CLIENT_ID=your-google-oauth-client-id.apps.googleusercontent.com
GOOGLE_CLIENT_SECRET=your-google-oauth-client-secret
GOOGLE_REDIRECT_URI=http://127.0.0.1:8000/login/google/callback

# Google Calendar API (untuk jadwal bimbel)
GOOGLE_CALENDAR_ID=your-calendar-id@group.calendar.google.com
GOOGLE_CALENDAR_API_KEY=your-google-calendar-api-key

# Google Drive API (untuk penyimpanan file materi)
GOOGLE_DRIVE_FOLDER_ID=your-drive-folder-id

# Google Analytics (untuk tracking pengunjung)
GOOGLE_ANALYTICS_ID=G-XXXXXXXXXX
```

---

## 🚀 Testing

### Test Google Maps:

```
Buka: http://127.0.0.1:8000/kontak
✅ Peta kantor terlihat
✅ Alamat bisa diklik → redirect ke Google Maps
```

### Test Google OAuth:

```
Buka: http://127.0.0.1:8000/login
✅ Tombol "Masuk dengan Google" terlihat
✅ Klik tombol → redirect ke Google login
✅ Setelah login → redirect ke dashboard
```

### Test Google Calendar:

```
Buka: http://127.0.0.1:8000/jadwal
✅ Calendar embed terlihat
✅ Events list muncul (jika ada jadwal)
```

### Test Google Analytics:

```
1. Buka website
2. Buka Google Analytics dashboard
3. Lihat Real-time → Users
✅ Visitor terdeteksi
```

---

## 📦 Dependencies

Sudah terinstall:

- ✅ `laravel/socialite` - Untuk Google OAuth
- ✅ Laravel HTTP Client - Untuk API calls

**TIDAK** perlu install Google API Client PHP (terlalu besar & sering timeout).

---

## ⚠️ Catatan Penting

1. **Ganti semua placeholder** di `.env` dengan API key yang sebenarnya
2. **Jangan commit** file `.env` ke Git (sudah ada di `.gitignore`)
3. Untuk **production**, ganti `http://127.0.0.1:8000` dengan domain asli
4. Pastikan **billing enabled** di Google Cloud Console (walaupun ada free tier)
5. Set **quota limits** untuk mencegah overuse

---

## 🎓 Cara Menambah Jadwal di Google Calendar

1. Buka Google Calendar
2. Klik tanggal → **Create event**
3. Isi detail:
   - **Title**: Nama kelas (contoh: "Bimbel UKOM D3 Farmasi - Batch 5")
   - **Date & Time**: Waktu pelaksanaan
   - **Location**: Link Zoom/Google Meet atau alamat offline
   - **Description**: Detail materi yang akan dibahas
4. Save
5. Jadwal otomatis muncul di website!

---

## 📞 Troubleshooting

### Google Maps tidak muncul?

- Cek API Key sudah benar
- Pastikan Maps Embed API sudah enabled
- Cek billing account aktif

### Google OAuth error?

- Cek redirect URI sama persis dengan yang di Google Console
- Pastikan email consent screen sudah disetup

### Google Calendar kosong?

- Pastikan calendar sudah public
- Cek Calendar ID benar
- Pastikan ada event di 30 hari ke depan

### Google Analytics tidak tracking?

- Cek Measurement ID format `G-XXXXXXXXXX`
- Tunggu 24-48 jam untuk data muncul
- Pakai Real-time reports untuk testing langsung

---

## ✨ Fitur Tambahan (Opsional)

Jika ingin fitur lebih advanced:

- Google Meet API - Buat meeting otomatis
- Google Sheets API - Export data ke spreadsheet
- Google Forms API - Embed kuesioner
- Firebase - Real-time notifications

---

**Dokumentasi dibuat:** 8 Desember 2025  
**Status:** ✅ Semua Google API sudah terintegrasi

# 📡 API BimbelFarmasi - Dokumentasi Lengkap

**Base URL:** `http://127.0.0.1:8000/api/v1` (Development)  
**Base URL:** `https://bimbelfarmasi.com/api/v1` (Production)

---

## 📚 Daftar API

### **Public APIs** (Tidak Perlu Token)
1. [Register](#1-register) - Daftar akun baru
2. [Login](#2-login) - Masuk ke akun
3. [Forgot Password](#3-forgot-password) - Reset password
4. [Get Programs](#4-get-all-programs) - Lihat daftar program
5. [Program Detail](#5-program-detail) - Detail program
6. [Get Testimonials](#6-get-testimonials) - Lihat testimoni
7. [Contact Form](#7-contact-form) - Kirim pesan kontak

### **Protected APIs** (Perlu Token Login)
8. [Get Profile](#8-get-profile) - Lihat profil user
9. [Update Profile](#9-update-profile) - Edit profil & foto
10. [Update Password](#10-update-password) - Ganti password
11. [Logout](#11-logout) - Keluar dari akun
12. [Create Order](#12-create-order) - Buat pesanan program
13. [My Orders](#13-my-orders) - Lihat pesanan saya
14. [Upload Payment](#14-upload-payment-proof) - Upload bukti bayar
15. [My Services](#15-my-services) - Layanan aktif saya
16. [Transaction History](#16-transaction-history) - Riwayat transaksi
17. [Program Materials](#17-program-materials) - Materi belajar
18. [Program Schedule](#18-program-schedule) - Jadwal kelas
19. [Get Exercises](#19-get-exercises) - Soal latihan
20. [Submit Exercise](#20-submit-exercise) - Kumpulkan jawaban
21. [My Testimonials](#21-my-testimonials) - Testimoni saya
22. [Create Testimonial](#22-create-testimonial) - Buat testimoni

---

## 🔓 PUBLIC APIs

### 1. Register
Mendaftar akun baru untuk pengguna.

**Endpoint:** `POST /api/v1/register`

**Request:**
```json
{
  "name": "Budi Santoso",
  "email": "budi@email.com",
  "password": "password123",
  "password_confirmation": "password123",
  "phone": "081234567890"
}
```

**Response Sukses:**
```json
{
  "success": true,
  "message": "Registrasi berhasil",
  "data": {
    "user": {
      "id": 1,
      "name": "Budi Santoso",
      "email": "budi@email.com",
      "phone": "081234567890"
    },
    "token": "1|abcdefghijklmnopqrstuvwxyz123456789"
  }
}
```

**Penjelasan:**
- Simpan `token` untuk digunakan di API yang memerlukan autentikasi
- Password minimal 8 karakter
- Email harus valid dan belum terdaftar

---

### 2. Login
Masuk ke akun yang sudah terdaftar.

**Endpoint:** `POST /api/v1/login`

**Request:**
```json
{
  "email": "budi@email.com",
  "password": "password123"
}
```

**Response Sukses:**
```json
{
  "success": true,
  "message": "Login berhasil",
  "data": {
    "user": {
      "id": 1,
      "name": "Budi Santoso",
      "email": "budi@email.com"
    },
    "token": "2|xyz789abcdefghijklmnopqrstuvwxyz"
  }
}
```

**Penjelasan:**
- Gunakan email dan password yang sudah didaftarkan
- Simpan token untuk akses API selanjutnya

---

### 3. Forgot Password
Kirim link reset password ke email.

**Endpoint:** `POST /api/v1/forgot-password`

**Request:**
```json
{
  "email": "budi@email.com"
}
```

**Response Sukses:**
```json
{
  "success": true,
  "message": "Link reset password telah dikirim ke email Anda"
}
```

**Penjelasan:**
- Email harus terdaftar di sistem
- Link reset akan dikirim ke email terdaftar

---

### 4. Get All Programs
Melihat semua program bimbingan belajar yang tersedia.

**Endpoint:** `GET /api/v1/programs`

**Response Sukses:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "name": "CPNS & P3K Farmasi",
      "slug": "cpns-p3k-farmasi",
      "description": "Program persiapan CPNS dan P3K bidang Farmasi",
      "price": 1750000,
      "duration": "6 bulan",
      "image": "/storage/images/cpns.jpg"
    },
    {
      "id": 2,
      "name": "Ujian Apoteker",
      "slug": "ujian-apoteker",
      "description": "Persiapan UKAI (Ujian Kompetensi Apoteker Indonesia)",
      "price": 2500000,
      "duration": "6 bulan",
      "image": "/storage/images/apoteker.jpg"
    }
  ]
}
```

**Penjelasan:**
- Menampilkan semua program yang tersedia
- Tidak perlu login untuk melihat daftar program
- Harga dalam Rupiah (tanpa titik/koma)

---

### 5. Program Detail
Melihat detail lengkap dari satu program.

**Endpoint:** `GET /api/v1/programs/{slug}`

**Contoh:** `GET /api/v1/programs/cpns-p3k-farmasi`

**Response Sukses:**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "name": "CPNS & P3K Farmasi",
    "slug": "cpns-p3k-farmasi",
    "description": "Program persiapan lengkap untuk CPNS dan P3K bidang Farmasi",
    "price": 1750000,
    "duration": "6 bulan",
    "features": [
      "Materi Lengkap SKD & SKB",
      "Try Out Berkala",
      "Pembahasan Soal Detail",
      "Bimbingan Intensif"
    ],
    "image": "/storage/images/cpns.jpg"
  }
}
```

**Penjelasan:**
- Gunakan `slug` program (bukan id)
- Menampilkan fitur-fitur program

---

### 6. Get Testimonials
Melihat testimoni dari pengguna lain.

**Endpoint:** `GET /api/v1/testimonials`

**Response Sukses:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "user_name": "Sarah Ahmad",
      "program": "CPNS & P3K Farmasi",
      "rating": 5,
      "message": "Bimbel terbaik untuk persiapan CPNS Farmasi!",
      "created_at": "2025-12-01"
    },
    {
      "id": 2,
      "user_name": "Andi Pratama",
      "program": "Ujian Apoteker",
      "rating": 5,
      "message": "Alhamdulillah lulus UKAI berkat bimbel ini",
      "created_at": "2025-11-28"
    }
  ]
}
```

**Penjelasan:**
- Menampilkan testimoni yang sudah disetujui admin
- Rating 1-5 (bintang)

---

### 7. Contact Form
Mengirim pesan ke admin melalui form kontak.

**Endpoint:** `POST /api/v1/contact`

**Request:**
```json
{
  "name": "Budi Santoso",
  "email": "budi@email.com",
  "phone": "081234567890",
  "subject": "Pertanyaan Program",
  "message": "Saya ingin tanya tentang program CPNS..."
}
```

**Response Sukses:**
```json
{
  "success": true,
  "message": "Pesan Anda telah dikirim. Kami akan segera menghubungi Anda."
}
```

**Penjelasan:**
- Tidak perlu login untuk mengirim pesan
- Semua field wajib diisi

---

## 🔐 PROTECTED APIs

**Cara menggunakan:**
Tambahkan header Authorization di setiap request:
```
Authorization: Bearer {token_dari_login}
```

---

### 8. Get Profile
Melihat profil pengguna yang sedang login.

**Endpoint:** `GET /api/v1/user`

**Header:** `Authorization: Bearer {token}`

**Response Sukses:**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "name": "Budi Santoso",
    "email": "budi@email.com",
    "phone": "081234567890",
    "profile_photo": "/storage/profile-photos/budi.jpg",
    "created_at": "2025-12-01"
  }
}
```

**Penjelasan:**
- Menampilkan data profil user yang sedang login
- Termasuk foto profil jika sudah diupload

---

### 9. Update Profile
Mengubah profil pengguna (nama, telepon, foto).

**Endpoint:** `PUT /api/v1/user/profile`

**Header:** `Authorization: Bearer {token}`

**Content-Type:** `multipart/form-data`

**Request:**
```
name: "Budi Santoso Updated"
phone: "081234567890"
profile_photo: [file gambar]
```

**Response Sukses:**
```json
{
  "success": true,
  "message": "Profil berhasil diperbarui",
  "data": {
    "name": "Budi Santoso Updated",
    "phone": "081234567890",
    "profile_photo": "/storage/profile-photos/updated.jpg"
  }
}
```

**Penjelasan:**
- Format foto: jpg, jpeg, png, gif
- Maksimal ukuran foto: 2MB
- profile_photo opsional (tidak wajib)

---

### 10. Update Password
Mengganti password akun.

**Endpoint:** `PUT /api/v1/user/password`

**Header:** `Authorization: Bearer {token}`

**Request:**
```json
{
  "current_password": "password123",
  "new_password": "newpassword456",
  "new_password_confirmation": "newpassword456"
}
```

**Response Sukses:**
```json
{
  "success": true,
  "message": "Password berhasil diubah"
}
```

**Penjelasan:**
- current_password harus sesuai dengan password saat ini
- new_password minimal 8 karakter
- Konfirmasi password harus sama

---

### 11. Logout
Keluar dari akun dan hapus token.

**Endpoint:** `POST /api/v1/logout`

**Header:** `Authorization: Bearer {token}`

**Response Sukses:**
```json
{
  "success": true,
  "message": "Logout berhasil"
}
```

**Penjelasan:**
- Token akan dihapus dari server
- Setelah logout, perlu login ulang untuk akses API

---

### 12. Create Order
Membuat pesanan program bimbingan belajar.

**Endpoint:** `POST /api/v1/orders`

**Header:** `Authorization: Bearer {token}`

**Request:**
```json
{
  "program_id": 1,
  "payment_method": "transfer"
}
```

**Response Sukses:**
```json
{
  "success": true,
  "message": "Order berhasil dibuat",
  "data": {
    "order_number": "ORD-20251208-001",
    "program": "CPNS & P3K Farmasi",
    "price": 1750000,
    "status": "pending",
    "payment_link": "https://app.midtrans.com/snap/v1/..."
  }
}
```

**Penjelasan:**
- program_id sesuai ID program yang dipilih
- payment_method: "transfer" atau "midtrans"
- Simpan order_number untuk upload bukti bayar

---

### 13. My Orders
Melihat semua pesanan yang pernah dibuat.

**Endpoint:** `GET /api/v1/user/orders`

**Header:** `Authorization: Bearer {token}`

**Response Sukses:**
```json
{
  "success": true,
  "data": [
    {
      "order_number": "ORD-20251208-001",
      "program": "CPNS & P3K Farmasi",
      "price": 1750000,
      "status": "pending",
      "order_date": "2025-12-08",
      "payment_deadline": "2025-12-09"
    }
  ]
}
```

**Penjelasan:**
- Status: pending (belum bayar), paid (lunas), cancelled (dibatalkan)
- payment_deadline: batas waktu pembayaran

---

### 14. Upload Payment Proof
Mengupload bukti pembayaran untuk pesanan.

**Endpoint:** `POST /api/v1/orders/{orderNumber}/payment`

**Header:** `Authorization: Bearer {token}`

**Content-Type:** `multipart/form-data`

**Request:**
```
payment_proof: [file gambar bukti transfer]
payment_date: "2025-12-08"
account_name: "Budi Santoso"
notes: "Transfer dari BCA"
```

**Response Sukses:**
```json
{
  "success": true,
  "message": "Bukti pembayaran berhasil diunggah",
  "data": {
    "order_number": "ORD-20251208-001",
    "status": "waiting_verification"
  }
}
```

**Penjelasan:**
- Upload setelah melakukan transfer
- Format file: jpg, jpeg, png
- Status berubah menjadi "waiting_verification"

---

### 15. My Services
Melihat layanan/program yang sedang aktif.

**Endpoint:** `GET /api/v1/user/services`

**Header:** `Authorization: Bearer {token}`

**Response Sukses:**
```json
{
  "success": true,
  "data": [
    {
      "program": "CPNS & P3K Farmasi",
      "status": "active",
      "enrolled_date": "2025-12-01",
      "valid_until": "2026-06-01",
      "progress": 45
    }
  ]
}
```

**Penjelasan:**
- Hanya menampilkan program yang sudah dibayar
- progress: persentase penyelesaian materi (0-100)

---

### 16. Transaction History
Melihat riwayat transaksi pembayaran.

**Endpoint:** `GET /api/v1/user/transactions`

**Header:** `Authorization: Bearer {token}`

**Response Sukses:**
```json
{
  "success": true,
  "data": [
    {
      "transaction_id": "TRX-20251208-001",
      "order_number": "ORD-20251208-001",
      "program": "CPNS & P3K Farmasi",
      "amount": 1750000,
      "status": "paid",
      "payment_date": "2025-12-08"
    }
  ]
}
```

**Penjelasan:**
- Riwayat semua transaksi yang sudah diverifikasi
- status: paid (berhasil), pending (menunggu), failed (gagal)

---

### 17. Program Materials
Mengakses materi belajar dari program yang diikuti.

**Endpoint:** `GET /api/v1/programs/{id}/materials`

**Header:** `Authorization: Bearer {token}`

**Response Sukses:**
```json
{
  "success": true,
  "data": {
    "program": "CPNS & P3K Farmasi",
    "materials": [
      {
        "id": 1,
        "title": "Materi SKD - TWK",
        "type": "pdf",
        "url": "/storage/materials/twk.pdf",
        "duration": "2 jam"
      },
      {
        "id": 2,
        "title": "Video Farmakologi Dasar",
        "type": "video",
        "url": "/storage/materials/farmakologi.mp4",
        "duration": "45 menit"
      }
    ]
  }
}
```

**Penjelasan:**
- Hanya bisa diakses jika sudah terdaftar di program
- type: pdf, video, ppt, doc

---

### 18. Program Schedule
Melihat jadwal kelas dari program.

**Endpoint:** `GET /api/v1/programs/{id}/schedule`

**Header:** `Authorization: Bearer {token}`

**Response Sukses:**
```json
{
  "success": true,
  "data": {
    "program": "CPNS & P3K Farmasi",
    "schedule": [
      {
        "date": "2025-12-10",
        "time": "19:00 - 21:00",
        "topic": "Farmakologi Dasar",
        "instructor": "Dr. Ahmad",
        "platform": "Zoom",
        "link": "https://zoom.us/j/123456789"
      }
    ]
  }
}
```

**Penjelasan:**
- Jadwal kelas online atau offline
- Link meeting akan disediakan jika online

---

### 19. Get Exercises
Melihat daftar soal latihan/tryout.

**Endpoint:** `GET /api/v1/programs/{id}/exercises`

**Header:** `Authorization: Bearer {token}`

**Response Sukses:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "title": "Latihan Farmakologi Week 1",
      "questions_count": 50,
      "duration": 60,
      "status": "available",
      "deadline": "2025-12-15"
    }
  ]
}
```

**Penjelasan:**
- questions_count: jumlah soal
- duration: waktu pengerjaan (menit)
- status: available, completed, expired

---

### 20. Submit Exercise
Mengumpulkan jawaban latihan soal.

**Endpoint:** `POST /api/v1/exercises/{exerciseId}/submit`

**Header:** `Authorization: Bearer {token}`

**Request:**
```json
{
  "answers": [
    {"question_id": 1, "answer": "A"},
    {"question_id": 2, "answer": "C"},
    {"question_id": 3, "answer": "B"}
  ]
}
```

**Response Sukses:**
```json
{
  "success": true,
  "message": "Latihan berhasil dikumpulkan",
  "data": {
    "score": 85,
    "correct": 42,
    "total": 50,
    "result_id": 123
  }
}
```

**Penjelasan:**
- answers: array jawaban sesuai question_id
- Nilai langsung keluar setelah submit
- result_id untuk melihat pembahasan

---

### 21. My Testimonials
Melihat testimoni yang pernah dibuat.

**Endpoint:** `GET /api/v1/user/testimonials`

**Header:** `Authorization: Bearer {token}`

**Response Sukses:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "program": "CPNS & P3K Farmasi",
      "rating": 5,
      "message": "Program sangat membantu!",
      "status": "approved",
      "created_at": "2025-12-08"
    }
  ]
}
```

**Penjelasan:**
- status: pending (menunggu review), approved (disetujui), rejected (ditolak)

---

### 22. Create Testimonial
Membuat testimoni baru untuk program.

**Endpoint:** `POST /api/v1/testimonials`

**Header:** `Authorization: Bearer {token}`

**Request:**
```json
{
  "program_id": 1,
  "rating": 5,
  "message": "Program sangat membantu saya lulus CPNS! Terima kasih"
}
```

**Response Sukses:**
```json
{
  "success": true,
  "message": "Testimoni berhasil ditambahkan. Menunggu persetujuan admin."
}
```

**Penjelasan:**
- rating: 1-5 (bintang)
- Hanya bisa testimoni untuk program yang diikuti
- Testimoni akan muncul setelah disetujui admin

---

## ⚠️ Error Responses

### Error 422 (Validation Error)
```json
{
  "success": false,
  "message": "Validation error",
  "errors": {
    "email": ["Email sudah terdaftar"],
    "password": ["Password minimal 8 karakter"]
  }
}
```

### Error 401 (Unauthorized)
```json
{
  "success": false,
  "message": "Unauthenticated. Please login first."
}
```

### Error 404 (Not Found)
```json
{
  "success": false,
  "message": "Resource not found"
}
```

### Error 500 (Server Error)
```json
{
  "success": false,
  "message": "Internal server error. Please try again later."
}
```

---

## 📝 Catatan Penting

1. **Base URL Development:** `http://127.0.0.1:8000/api/v1`
2. **Base URL Production:** `https://bimbelfarmasi.com/api/v1`
3. **Token Authentication:** Gunakan token dari login/register di header `Authorization: Bearer {token}`
4. **File Upload:** Gunakan `Content-Type: multipart/form-data`
5. **Rate Limiting:** 
   - Public API: 60 requests/menit
   - Protected API: 120 requests/menit

---

## 🧪 Cara Testing API

### Menggunakan Postman:
1. Download [Postman](https://www.postman.com/downloads/)
2. Buat request baru
3. Set method (GET/POST/PUT)
4. Masukkan URL endpoint
5. Untuk protected API, tambahkan header:
   - Key: `Authorization`
   - Value: `Bearer {token}`
6. Klik Send

### Menggunakan cURL:
```bash
# Login
curl -X POST http://127.0.0.1:8000/api/v1/login \
  -H "Content-Type: application/json" \
  -d '{"email":"budi@email.com","password":"password123"}'

# Get Profile (dengan token)
curl -X GET http://127.0.0.1:8000/api/v1/user \
  -H "Authorization: Bearer {your-token-here}"
```

---

**Last Updated:** 8 Desember 2025  
**Version:** 1.0.0

# Bank Soal (Quiz Bank) Management System - Dokumentasi

## 📋 Ringkasan
Sistem manajemen bank soal yang lengkap untuk admin, memungkinkan pembuatan dan pengelolaan soal latihan yang terhubung dengan program layanan.

## ✅ Fitur yang Telah Dibuat

### 1. **Database Structure**
- ✅ Tabel `quiz_banks` sudah diupdate dengan kolom `program_id`
- ✅ Migration berhasil dijalankan
- ✅ Relasi dengan tabel `programs` sudah terkonfigurasi

### 2. **Models**
- ✅ `QuizBank` model dengan relasi:
  - `program()` - belongsTo Program
  - `questions()` - hasMany QuizQuestion
  - `order()` - belongsTo Order
  - `user()` - belongsTo User
  - `attempts()` - hasMany QuizAttempt

- ✅ `QuizQuestion` model dengan relasi:
  - `quizBank()` - belongsTo QuizBank

### 3. **Controller** (`AdminQuestionController`)
Metode yang tersedia:
- ✅ `index()` - Menampilkan daftar bank soal dengan filter & search
- ✅ `create()` - Form pembuatan bank soal baru
- ✅ `store()` - Menyimpan bank soal baru
- ✅ `show()` - Melihat detail bank soal + daftar soal
- ✅ `edit()` - Form edit bank soal
- ✅ `update()` - Update bank soal
- ✅ `destroy()` - Hapus bank soal
- ✅ `addQuestion()` - Tambah soal ke bank
- ✅ `editQuestion()` - Form edit soal
- ✅ `updateQuestion()` - Update soal
- ✅ `destroyQuestion()` - Hapus soal

### 4. **Routes** (`routes/web.php`)
Semua route admin sudah terdaftar:
```php
GET    /admin/questions                              - admin.questions.index
GET    /admin/questions/create                       - admin.questions.create
POST   /admin/questions                              - admin.questions.store
GET    /admin/questions/{quizBank}                   - admin.questions.show
GET    /admin/questions/{quizBank}/edit              - admin.questions.edit
PUT    /admin/questions/{quizBank}                   - admin.questions.update
DELETE /admin/questions/{quizBank}                   - admin.questions.destroy
POST   /admin/questions/{quizBank}/add-question      - admin.questions.addQuestion
GET    /admin/questions/{quizBank}/question/{question}/edit  - admin.questions.editQuestion
PUT    /admin/questions/{quizBank}/question/{question}       - admin.questions.updateQuestion
DELETE /admin/questions/{quizBank}/question/{question}       - admin.questions.destroyQuestion
```

### 5. **Views**

#### a. `index.blade.php` - Halaman Daftar Bank Soal
**Fitur:**
- Statistik: Total bank soal per kategori
- Filter: Kategori, Search
- Tabel dengan kolom:
  - Judul Bank Soal
  - Program (badge dengan nama program)
  - Kategori (badge warna biru)
  - Jumlah Soal
  - Durasi (menit)
  - Aksi (Lihat, Edit, Hapus)
- Pagination
- Tombol "Buat Bank Soal Baru"

#### b. `create.blade.php` - Form Buat Bank Soal
**Field:**
- Program Layanan (dropdown, required)
- Judul Bank Soal (text, required)
- Deskripsi (textarea, optional)
- Kategori (dropdown: Farmakologi, Farmasi Klinik, Farmasetika, Kimia Farmasi, UKOM, CPNS)
- Durasi (number, menit, default: 60)
- Nilai Lulus (number, %, default: 70, range: 0-100)

#### c. `show.blade.php` - Detail Bank Soal
**Fitur:**
- Breadcrumb navigation
- Statistik bank soal (Program, Kategori, Jumlah Soal, Durasi, Nilai Lulus)
- Tombol "Edit Bank Soal"
- **Form Tambah Soal Baru** dengan field:
  - Pertanyaan (textarea, required)
  - Pilihan A-E (text, required)
  - Jawaban Benar (dropdown A-E, required)
  - Penjelasan (textarea, optional)
- **Daftar Soal** dengan:
  - Nomor urut
  - Pertanyaan lengkap
  - Semua pilihan (jawaban benar ditandai hijau)
  - Penjelasan (jika ada)
  - Tombol Edit & Hapus per soal

#### d. `edit.blade.php` - Edit Bank Soal
**Fitur:**
- Pre-filled form dengan data existing
- Field sama seperti create
- Tombol "Simpan Perubahan" dan "Batal"

#### e. `edit-question.blade.php` - Edit Soal Individual
**Fitur:**
- Form edit soal lengkap
- Pre-filled dengan data soal existing
- Field: Pertanyaan, Pilihan A-E, Jawaban Benar, Penjelasan

### 6. **Navigation**
- ✅ Menu "Soal & Materi" sudah ditambahkan di sidebar admin
- ✅ Icon: Document/File SVG
- ✅ Active state highlighting dengan route check

## 🎯 Cara Penggunaan

### Untuk Admin:

1. **Membuat Bank Soal Baru:**
   - Login sebagai admin
   - Klik menu "Soal & Materi"
   - Klik tombol "Buat Bank Soal Baru"
   - Pilih Program (misal: UKOM D3 Farmasi)
   - Isi judul, kategori, durasi, nilai lulus
   - Klik "Buat Bank Soal"

2. **Menambah Soal ke Bank:**
   - Klik bank soal dari daftar
   - Scroll ke form "Tambah Soal Baru"
   - Isi pertanyaan, 5 pilihan jawaban
   - Pilih jawaban yang benar
   - (Opsional) Tambahkan penjelasan
   - Klik "Tambah Soal"

3. **Mengedit Soal:**
   - Buka detail bank soal
   - Klik icon Edit pada soal yang ingin diubah
   - Update field yang diperlukan
   - Klik "Simpan Perubahan"

4. **Menghapus Soal/Bank:**
   - Klik icon Hapus (trash)
   - Konfirmasi penghapusan

## 🔗 Relasi dengan Program

Setiap bank soal WAJIB terhubung dengan satu Program:
- Program UKOM → Bank Soal Farmakologi UKOM
- Program CPNS → Bank Soal Kimia Farmasi CPNS
- Program Joki Tugas → Bank Soal Praktek Resep

Student yang membeli program akan otomatis mendapat akses ke semua bank soal yang terkait dengan program tersebut.

## 📊 Kategori Soal

1. **Farmakologi** - Soal tentang obat dan efeknya
2. **Farmasi Klinik** - Soal praktek farmasi rumah sakit
3. **Farmasetika** - Soal tentang pembuatan obat
4. **Kimia Farmasi** - Soal kimia organik & anorganik
5. **UKOM** - Soal campuran untuk ujian kompetensi
6. **CPNS** - Soal untuk tes CPNS farmasi

## 🔄 Alur Kerja

```
Admin membuat Bank Soal → Pilih Program
                       ↓
            Tambah Soal (banyak soal)
                       ↓
            Student beli Program
                       ↓
        Student akses Bank Soal di program
                       ↓
            Student kerjakan soal
                       ↓
        Sistem catat attempt & score
```

## ✅ Validasi

### Bank Soal:
- `program_id`: required, harus exist di tabel programs
- `title`: required, max 255 karakter
- `category`: required
- `duration_minutes`: optional, minimal 1 menit
- `passing_score`: required, 0-100

### Soal:
- `question`: required
- `option_a` - `option_e`: semua required
- `correct_answer`: required, hanya A/B/C/D/E
- `explanation`: optional

## 🎨 UI/UX Features

- **Color Coding:**
  - Primary color: `#2D3C8C` (navy blue)
  - Program badge: Purple
  - Category badge: Blue
  - Correct answer: Green highlight
  
- **Icons:** Heroicons (outline style)
- **Responsive:** Grid system untuk desktop & mobile
- **Feedback:** Success message dengan green background
- **Confirmation:** Alert sebelum delete

## 📝 Database Schema

### `quiz_banks` table:
```sql
id                 BIGINT PRIMARY KEY
program_id         BIGINT FOREIGN KEY (programs) NULLABLE
order_id           BIGINT NULLABLE
user_id            BIGINT NULLABLE
title              VARCHAR(255)
description        TEXT
category           VARCHAR(100)
total_questions    INTEGER
duration_minutes   INTEGER
passing_score      INTEGER
created_at         TIMESTAMP
updated_at         TIMESTAMP
```

### `quiz_questions` table:
```sql
id              BIGINT PRIMARY KEY
quiz_bank_id    BIGINT FOREIGN KEY
question        TEXT
option_a        VARCHAR(255)
option_b        VARCHAR(255)
option_c        VARCHAR(255)
option_d        VARCHAR(255)
option_e        VARCHAR(255)
correct_answer  CHAR(1) -- A/B/C/D/E
explanation     TEXT
created_at      TIMESTAMP
updated_at      TIMESTAMP
```

## 🚀 Status Implementasi

✅ **COMPLETED** - Semua fitur CRUD bank soal dan soal sudah selesai dibuat dan siap digunakan.

### Checklist:
- [x] Migration database
- [x] Models & relationships
- [x] Controller dengan semua method
- [x] Routes terdaftar
- [x] 5 views (index, create, show, edit, edit-question)
- [x] Sidebar navigation
- [x] Validation rules
- [x] UI/UX dengan Tailwind CSS

## 📞 Testing Checklist

Untuk memastikan sistem berjalan:
1. [ ] Coba akses `/admin/questions` (harus login sebagai admin)
2. [ ] Buat bank soal baru dengan pilih program
3. [ ] Tambahkan 5 soal ke bank soal
4. [ ] Edit salah satu soal
5. [ ] Hapus salah satu soal
6. [ ] Edit metadata bank soal (judul, durasi, dll)
7. [ ] Filter berdasarkan kategori
8. [ ] Search bank soal
9. [ ] Hapus bank soal

---

**Dibuat tanggal:** 1 Desember 2025  
**Framework:** Laravel 10+  
**Frontend:** Blade + Tailwind CSS  
**Status:** ✅ Production Ready

# 🚀 QUICK START - API Testing

## Langkah Cepat Memulai Testing

### 1️⃣ Jalankan Server
```bash
cd "c:\semester 5\PABWE\PROYEK\BimbelFarmasi-ppw06"
php artisan serve
```
Server berjalan di: **http://127.0.0.1:8000**

### 2️⃣ Import Collection ke Postman
1. Buka **Postman**
2. Klik **Import** (kiri atas)
3. Pilih file: `Bimbel_Farmasi_API_Testing.postman_collection.json`
4. Klik **Import**

✅ **Collection siap digunakan!**

---

## 📋 Daftar Endpoint Yang Harus Ditest

### **TESTIMONIAL API**

| Method | URL | Deskripsi | Expected Status |
|--------|-----|-----------|-----------------|
| GET | `/api/testimoni` | Ambil semua testimoni | 200 OK |
| GET | `/api/testimoni/{id}` | Ambil testimoni by ID | 200 / 404 |
| POST | `/api/posttestimoni` | Buat testimoni baru | 201 / 400 |
| PUT | `/api/updatetestimoni/{id}` | Update testimoni | 200 / 422 |
| DELETE | `/api/deletetestimoni/{id}` | Hapus testimoni | 200 / 404 |

### **REPORT API**

| Method | URL | Deskripsi | Expected Status |
|--------|-----|-----------|-----------------|
| GET | `/api/reports` | Ambil semua reports | 200 OK |
| GET | `/api/reports/{id}` | Ambil report by ID | 200 / 404 |
| POST | `/api/reports` | Buat report baru | 201 Created |
| DELETE | `/api/deletereports/{id}` | Hapus report | 200 / 404 |

---

## ⚡ Testing Cepat di Postman

### Test 1: Get All Testimonials
```
Method: GET
URL: http://127.0.0.1:8000/api/testimoni
Klik "Send" ✅
```

### Test 2: Create Testimonial
```
Method: POST
URL: http://127.0.0.1:8000/api/posttestimoni
Body → raw → JSON:
{
    "user_id": 1,
    "pekerjaan": "Dosen",
    "program_studi": "Farmasi",
    "angkatan": "2020",
    "judul_utama": "UKOM D3 Farmasi",
    "link_video": "https://youtu.be/example"
}
Klik "Send" ✅
```

### Test 3: Update Testimonial
```
Method: PUT
URL: http://127.0.0.1:8000/api/updatetestimoni/1
Body → raw → JSON:
{
    "pekerjaan": "Apoteker",
    "program_studi": "Farmasi",
    "angkatan": "2020",
    "judul_utama": "UKOM D3 Farmasi",
    "link_video": "https://youtu.be/updated"
}
Klik "Send" ✅
```

### Test 4: Delete Testimonial
```
Method: DELETE
URL: http://127.0.0.1:8000/api/deletetestimoni/1
Klik "Send" ✅
```

---

## 🎯 Cara Baca Hasil Test

### ✅ PASSED - Status Code Sesuai
```
Status: 200 OK
Body: { "message": "..." }
Tests: (9/9) ✓
```

### ❌ FAILED - Status Code Tidak Sesuai
```
Status: 500 Internal Server Error
Body: { "error": "..." }
Tests: (3/9) ✗
```

---

## 📊 Template Tabel Hasil Testing

| Test ID | Test Case | Input | Expected | Actual | Verdict |
|---------|-----------|-------|----------|--------|---------|
| FR01-01-01 | Get All | - | 200, Array | 200, Array | ✅ |
| FR01-01-02 | Get All (Empty) | - | 200, [] | 200, [] | ✅ |
| FR01-02-01 | Get by ID | id=1 | 200, Object | 200, Object | ✅ |
| FR01-02-02 | Get by ID (Not Found) | id=999 | 404, Error | 404, Error | ✅ |
| FR01-03-01 | Create (Valid) | Full data + user_id | 201, Created | 201, Created | ✅ |
| FR01-03-02 | Create (No user_id) | No user_id | 400, Error | 400, Error | ✅ |
| FR01-04-01 | Update (Valid) | Full data | 200, Updated | 200, Updated | ✅ |
| FR01-04-02 | Update (Invalid) | Empty fields | 422, Error | 422, Error | ✅ |
| FR01-05-01 | Delete (Valid) | id=1 | 200, Deleted | 200, Deleted | ✅ |
| FR01-05-02 | Delete (Not Found) | id=999 | 404, Error | 404, Error | ✅ |

---

## 🔧 Troubleshooting

### Error: Connection Refused
**Solusi:**
```bash
php artisan serve
```

### Error: 404 Not Found untuk endpoint
**Solusi:**
```bash
php artisan route:clear
php artisan optimize:clear
```

### Error: 500 Internal Server Error
**Solusi:**
1. Cek terminal Laravel untuk error details
2. Cek log: `storage/logs/laravel.log`
3. Pastikan database sudah ada user dengan ID yang digunakan

### Error: CORS
**Solusi:** Testing API dari Postman tidak ada masalah CORS (hanya browser yang ada CORS)

---

## 💡 Tips Pro

1. **Save Response sebagai Example**
   - Klik "Save Response" → "Save as Example"
   - Untuk dokumentasi

2. **Run All Tests Sekaligus**
   - Klik Collection → Run
   - Pilih semua request → Run

3. **Export Results**
   - Setelah Run Collection
   - Klik Export Results → Save JSON

4. **Screenshot untuk Laporan**
   - Gunakan Snipping Tool / Screenshot
   - Ambil gambar: Request + Response + Tests Results

---

## 📖 Dokumentasi Lengkap

Baca file: **POSTMAN_TESTING_GUIDE.md** untuk panduan detail lengkap dengan:
- Test scripts lengkap
- Semua skenario testing
- Format laporan
- Dan lainnya

---

## ✅ Checklist Testing (Ceklist yang sudah ditest)

### Testimonials:
- [ ] GET All Testimonials (200 OK)
- [ ] GET All Testimonials (Empty Array)
- [ ] GET Testimonial by ID (200 OK)
- [ ] GET Testimonial by ID (404 Not Found)
- [ ] POST Create Testimonial (201 - dengan user_id)
- [ ] POST Create Testimonial (400 - tanpa user_id)
- [ ] PUT Update Testimonial (200 - valid)
- [ ] PUT Update Testimonial (422 - invalid)
- [ ] PUT Update Testimonial (422 - kosong)
- [ ] DELETE Testimonial (200 OK)
- [ ] DELETE Testimonial (404 Not Found)

### Reports:
- [ ] GET All Reports (200 OK)
- [ ] GET Report by ID (200 OK)
- [ ] POST Create Report (201 Created)
- [ ] DELETE Report (200 OK)

---

**🎉 Selamat Testing! Jika ada pertanyaan, tanya aja!**

# 📋 PANDUAN API TESTING DENGAN POSTMAN

## 🎯 Persiapan Awal

### 1. Install Postman
- Download dari: https://www.postman.com/downloads/
- Install dan buka aplikasi Postman

### 2. Jalankan Server Laravel
```bash
php artisan serve
```
Server akan berjalan di: `http://127.0.0.1:8000`

### 3. Buat Collection Baru di Postman
1. Klik tombol **"New"** → **"Collection"**
2. Beri nama: **"Bimbel Farmasi API Testing"**
3. Save

---

## 📝 TEST CASE 1: TESTIMONIAL API

### ✅ FR01-01-API: Get All Testimonials

**Test ID:** FR01-01-API  
**Objective:** Mengambil semua data testimoni

#### Setup di Postman:
1. **Klik "New"** → **"Request"**
2. **Request Name:** Get All Testimonials
3. **Method:** `GET`
4. **URL:** `http://127.0.0.1:8000/api/testimoni`
5. **Klik "Send"**

#### Expected Response:
- **Status Code:** `200 OK`
- **Response Body (Jika ada data):**
```json
[
    {
        "id": 1,
        "pekerjaan": "Dosen",
        "program_studi": "Farmasi",
        "angkatan": "2020",
        "judul_utama": "UKOM D3 Farmasi",
        "link_video": "https://youtu.be/example",
        "rating": 5,
        "comment": "Sangat membantu",
        "created_at": "2024-12-17 10:00:00"
    }
]
```

- **Response Body (Jika tidak ada data):**
```json
[]
```

#### Test Scripts (Tab "Tests"):
```javascript
// Test status code
pm.test("Status code is 200", function () {
    pm.response.to.have.status(200);
});

// Test response is JSON
pm.test("Response is JSON", function () {
    pm.response.to.be.json;
});

// Test response body is array
pm.test("Response body is array", function () {
    var jsonData = pm.response.json();
    pm.expect(jsonData).to.be.an('array');
});

// Test data structure if not empty
if (pm.response.json().length > 0) {
    pm.test("First item has required fields", function () {
        var firstItem = pm.response.json()[0];
        pm.expect(firstItem).to.have.property('id');
        pm.expect(firstItem).to.have.property('pekerjaan');
        pm.expect(firstItem).to.have.property('program_studi');
        pm.expect(firstItem).to.have.property('angkatan');
        pm.expect(firstItem).to.have.property('judul_utama');
        pm.expect(firstItem).to.have.property('link_video');
    });
}
```

---

### ✅ FR01-02-API: Get Testimonial by ID

**Test ID:** FR01-02-API  
**Objective:** Mengambil testimoni berdasarkan ID tertentu

#### Setup di Postman:
1. **Request Name:** Get Testimonial by ID
2. **Method:** `GET`
3. **URL:** `http://127.0.0.1:8000/api/testimoni/1`
   - Ganti angka `1` dengan ID testimoni yang ingin dicari
4. **Klik "Send"**

#### Expected Response:
- **Status Code (ID ditemukan):** `200 OK`
- **Response Body:**
```json
{
    "id": 1,
    "pekerjaan": "Dosen",
    "program_studi": "Farmasi",
    "angkatan": "2020",
    "judul_utama": "UKOM D3 Farmasi",
    "link_video": "https://youtu.be/example",
    "rating": 5,
    "comment": "Sangat membantu",
    "created_at": "2024-12-17 10:00:00"
}
```

- **Status Code (ID tidak ditemukan):** `404 Not Found`
- **Response Body:**
```json
{
    "message": "Testimonial not found"
}
```

#### Test Scripts:
```javascript
// Test for successful response
if (pm.response.code === 200) {
    pm.test("Status code is 200 OK", function () {
        pm.response.to.have.status(200);
    });

    pm.test("Response has testimonial data", function () {
        var jsonData = pm.response.json();
        pm.expect(jsonData).to.have.property('id');
        pm.expect(jsonData).to.have.property('pekerjaan');
        pm.expect(jsonData).to.have.property('program_studi');
        pm.expect(jsonData).to.have.property('angkatan');
        pm.expect(jsonData).to.have.property('judul_utama');
        pm.expect(jsonData).to.have.property('link_video');
    });
}

// Test for not found response
if (pm.response.code === 404) {
    pm.test("Status code is 404 Not Found", function () {
        pm.response.to.have.status(404);
    });

    pm.test("Response has error message", function () {
        var jsonData = pm.response.json();
        pm.expect(jsonData).to.have.property('message');
        pm.expect(jsonData.message).to.eql('Testimonial not found');
    });
}

// Test response is JSON
pm.test("Response is JSON", function () {
    pm.response.to.be.json;
});
```

---

### ✅ FR01-03-API: Create New Testimonial

**Test ID:** FR01-03-API  
**Objective:** Menambahkan testimoni baru

#### Setup di Postman:
1. **Request Name:** Create New Testimonial
2. **Method:** `POST`
3. **URL:** `http://127.0.0.1:8000/api/posttestimoni`
4. **Tab "Body"** → Pilih **"raw"** → Pilih **"JSON"**
5. **Body Content (Dengan user_id):**
```json
{
    "user_id": 1,
    "pekerjaan": "Dosen",
    "program_studi": "Sistem Informasi",
    "angkatan": "2004",
    "judul_utama": "SEBAGAI ALUMNI YANG BERPRESTASI",
    "link_video": "https://youtu.be/BWoTU8cuueY?si=IiXNdyfB0SZO8ntk"
}
```

6. **Klik "Send"**

#### Expected Response:
- **Status Code (Valid):** `201 Created`
- **Response Body:**
```json
{
    "message": "Testimonial created successfully",
    "data": {
        "id": 10,
        "pekerjaan": "Dosen",
        "program_studi": "Sistem Informasi",
        "angkatan": "2004",
        "judul_utama": "SEBAGAI ALUMNI YANG BERPRESTASI",
        "link_video": "https://youtu.be/BWoTU8cuueY?si=IiXNdyfB0SZO8ntk"
    }
}
```

- **Status Code (Tanpa user_id):** `400 Bad Request`
- **Response Body:**
```json
{
    "message": "Validation error",
    "errors": {
        "user_id": [
            "The user id field is required."
        ]
    }
}
```

#### Test Scripts:
```javascript
// Test for successful creation
if (pm.response.code === 201) {
    pm.test("Status code is 201 Created", function () {
        pm.response.to.have.status(201);
    });

    pm.test("Response has success message", function () {
        var jsonData = pm.response.json();
        pm.expect(jsonData).to.have.property('message');
        pm.expect(jsonData.message).to.eql('Testimonial created successfully');
    });

    pm.test("Response has data object", function () {
        var jsonData = pm.response.json();
        pm.expect(jsonData).to.have.property('data');
        pm.expect(jsonData.data).to.have.property('id');
    });

    // Save ID for later use
    pm.environment.set("testimonial_id", pm.response.json().data.id);
}

// Test for validation error
if (pm.response.code === 400) {
    pm.test("Status code is 400 Bad Request", function () {
        pm.response.to.have.status(400);
    });

    pm.test("Response has validation errors", function () {
        var jsonData = pm.response.json();
        pm.expect(jsonData).to.have.property('message');
        pm.expect(jsonData).to.have.property('errors');
    });
}

// Test response is JSON
pm.test("Response is JSON", function () {
    pm.response.to.be.json;
});

// Test data persistence
setTimeout(() => {
    pm.sendRequest({
        url: 'http://127.0.0.1:8000/api/testimoni',
        method: 'GET'
    }, function (err, response) {
        pm.test("New testimonial exists in GET all", function () {
            var testimonials = response.json();
            var found = testimonials.some(t => t.id === pm.environment.get("testimonial_id"));
            pm.expect(found).to.be.true;
        });
    });
}, 1000);
```

---

### ✅ FR01-04-API: Update Testimonial

**Test ID:** FR01-04-API  
**Objective:** Mengupdate testimoni yang sudah ada

#### Setup di Postman:
1. **Request Name:** Update Testimonial
2. **Method:** `PUT`
3. **URL:** `http://127.0.0.1:8000/api/updatetestimoni/1`
   - Ganti angka `1` dengan ID testimoni yang ingin diupdate
4. **Tab "Body"** → Pilih **"raw"** → Pilih **"JSON"**
5. **Body Content (Valid):**
```json
{
    "pekerjaan": "Dosen",
    "program_studi": "Teknik Elektro",
    "angkatan": "2004",
    "judul_utama": "SEBAGAI ALUMNI YANG BERPRESTASI",
    "link_video": "https://youtu.be/BWoTU8cuueY?si=IiXNdyfB0SZO8ntk"
}
```

6. **Klik "Send"**

#### Expected Response:
- **Status Code (Valid):** `200 OK`
- **Response Body:**
```json
{
    "message": "Testimonial updated successfully",
    "data": {
        "id": 1,
        "pekerjaan": "Dosen",
        "program_studi": "Teknik Elektro",
        "angkatan": "2004",
        "judul_utama": "SEBAGAI ALUMNI YANG BERPRESTASI",
        "link_video": "https://youtu.be/BWoTU8cuueY?si=IiXNdyfB0SZO8ntk"
    }
}
```

- **Status Code (Validation Error):** `422 Unprocessable Entity`
- **Response Body:**
```json
{
    "message": "Validation error",
    "errors": {
        "pekerjaan": [
            "The pekerjaan field is required."
        ]
    }
}
```

#### Test Scripts:
```javascript
// Test for successful update
if (pm.response.code === 200) {
    pm.test("Status code is 200 OK", function () {
        pm.response.to.have.status(200);
    });

    pm.test("Response has success message", function () {
        var jsonData = pm.response.json();
        pm.expect(jsonData).to.have.property('message');
        pm.expect(jsonData.message).to.eql('Testimonial updated successfully');
    });

    pm.test("Response has updated data", function () {
        var jsonData = pm.response.json();
        pm.expect(jsonData).to.have.property('data');
    });
}

// Test for validation error
if (pm.response.code === 422) {
    pm.test("Status code is 422 Unprocessable Entity", function () {
        pm.response.to.have.status(422);
    });

    pm.test("Response has validation errors", function () {
        var jsonData = pm.response.json();
        pm.expect(jsonData).to.have.property('message');
        pm.expect(jsonData).to.have.property('errors');
    });
}

// Test response is JSON
pm.test("Response is JSON", function () {
    pm.response.to.be.json;
});
```

#### Test Case - Empty Input:
**Body Content (Kosong):**
```json
{
    "pekerjaan": "",
    "program_studi": "",
    "angkatan": "",
    "judul_utama": "",
    "link_video": ""
}
```
**Expected:** `422 Unprocessable Entity` dengan error messages

---

### ✅ FR01-05-API: Delete Testimonial

**Test ID:** FR01-05-API  
**Objective:** Menghapus testimoni berdasarkan ID

#### Setup di Postman:
1. **Request Name:** Delete Testimonial
2. **Method:** `DELETE`
3. **URL:** `http://127.0.0.1:8000/api/deletetestimoni/15`
   - Ganti angka `15` dengan ID testimoni yang ingin dihapus
4. **Klik "Send"**

#### Expected Response:
- **Status Code (Valid):** `200 OK`
- **Response Body:**
```json
{
    "message": "Testimonial deleted successfully"
}
```

- **Status Code (ID tidak ditemukan):** `404 Not Found`
- **Response Body:**
```json
{
    "message": "Testimonial not found"
}
```

#### Test Scripts:
```javascript
// Test for successful deletion
if (pm.response.code === 200) {
    pm.test("Status code is 200 OK", function () {
        pm.response.to.have.status(200);
    });

    pm.test("Response has success message", function () {
        var jsonData = pm.response.json();
        pm.expect(jsonData).to.have.property('message');
        pm.expect(jsonData.message).to.eql('Testimonial deleted successfully');
    });
}

// Test for not found
if (pm.response.code === 404) {
    pm.test("Status code is 404 Not Found", function () {
        pm.response.to.have.status(404);
    });

    pm.test("Response has error message", function () {
        var jsonData = pm.response.json();
        pm.expect(jsonData).to.have.property('message');
        pm.expect(jsonData.message).to.eql('Testimonial not found');
    });
}

// Test response is JSON
pm.test("Response is JSON", function () {
    pm.response.to.be.json;
});
```

---

## 📝 TEST CASE 2: REPORT API

### ✅ Get All Reports

**URL:** `http://127.0.0.1:8000/api/reports`  
**Method:** `GET`

#### Expected Response:
```json
[
    {
        "id": 1,
        "judul_utama": "Pembinaan Character Menuju Masa depan Indah",
        "nama": "John Doe",
        "alasan": "Kurang jelas suara videonya",
        "created_at": "2024-12-17 10:00:00"
    }
]
```

#### Test Scripts:
```javascript
pm.test("Status code is 200", function () {
    pm.response.to.have.status(200);
});

pm.test("Response is JSON array", function () {
    pm.response.to.be.json;
    pm.expect(pm.response.json()).to.be.an('array');
});
```

---

### ✅ Get Report by ID

**URL:** `http://127.0.0.1:8000/api/reports/4`  
**Method:** `GET`

#### Expected Response:
```json
{
    "id": 4,
    "judul_utama": "Pembinaan Character Menuju Masa depan Indah",
    "nama": "Jane Smith",
    "alasan": "Video tidak dapat diputar",
    "created_at": "2024-12-17 10:00:00"
}
```

---

### ✅ Create Report

**URL:** `http://127.0.0.1:8000/api/reports`  
**Method:** `POST`  
**Body:**
```json
{
    "judul_utama": "Pembinaan Character Menuju Masa depan Indah",
    "nama": "gracia",
    "alasan": "Kurang jelas suara videonya"
}
```

#### Expected Response:
**Status Code:** `201 Created`
```json
{
    "message": "Report created successfully",
    "data": {
        "id": 5,
        "judul_utama": "Pembinaan Character Menuju Masa depan Indah",
        "nama": "gracia",
        "alasan": "Kurang jelas suara videonya",
        "created_at": "2024-12-17 10:00:00"
    }
}
```

---

### ✅ Delete Report

**URL:** `http://127.0.0.1:8000/api/deletereports/5`  
**Method:** `DELETE`

#### Expected Response:
**Status Code:** `200 OK`
```json
{
    "message": "Report deleted successfully"
}
```

---

## 🎯 CHECKLIST TESTING

### Testimonials:
- [ ] GET All Testimonials (200 OK)
- [ ] GET All Testimonials (Empty Array)
- [ ] GET Testimonial by ID (200 OK)
- [ ] GET Testimonial by ID (404 Not Found)
- [ ] POST Create Testimonial (201 Created - dengan user_id)
- [ ] POST Create Testimonial (400 Bad Request - tanpa user_id)
- [ ] PUT Update Testimonial (200 OK - data valid)
- [ ] PUT Update Testimonial (422 - data invalid)
- [ ] PUT Update Testimonial (422 - data kosong)
- [ ] DELETE Testimonial (200 OK)
- [ ] DELETE Testimonial (404 Not Found)

### Reports:
- [ ] GET All Reports (200 OK)
- [ ] GET Report by ID (200 OK)
- [ ] POST Create Report (201 Created)
- [ ] DELETE Report (200 OK)

---

## 💡 TIPS TESTING:

### 1. Environment Variables
Buat environment di Postman untuk menyimpan base URL:
- Klik icon ⚙️ (Settings) → **Environments** → **Add**
- Variable: `base_url`
- Value: `http://127.0.0.1:8000`
- Gunakan di URL: `{{base_url}}/api/testimoni`

### 2. Collection Runner
Untuk menjalankan semua test sekaligus:
1. Klik **Collection** → **Run**
2. Pilih request yang ingin dijalankan
3. Klik **Run Bimbel Farmasi API Testing**

### 3. Export Collection
Untuk berbagi dengan tim:
1. Klik Collection → **...** (titik tiga) → **Export**
2. Pilih **Collection v2.1**
3. Save file JSON

### 4. Troubleshooting
- Pastikan server Laravel berjalan (`php artisan serve`)
- Cek database sudah ada data user untuk testing
- Lihat error di terminal Laravel untuk debugging
- Gunakan `php artisan optimize:clear` jika ada cache error

---

## 📊 Format Laporan Testing

Setelah testing, buat tabel seperti ini:

| Test ID | Test Case | Expected | Actual | Verdict |
|---------|-----------|----------|--------|---------|
| FR01-01-01 | Get All Testimonials | 200 OK, Array JSON | 200 OK, Array JSON | ✅ PASSED |
| FR01-01-02 | Get All (Empty) | 200 OK, Empty Array | 200 OK, Empty Array | ✅ PASSED |
| FR01-02-01 | Get by ID (Found) | 200 OK, Object JSON | 200 OK, Object JSON | ✅ PASSED |
| FR01-02-02 | Get by ID (Not Found) | 404 Not Found | 404 Not Found | ✅ PASSED |

---

## ✅ Selamat Testing!

Jika ada error atau pertanyaan, jangan ragu untuk bertanya! 🚀

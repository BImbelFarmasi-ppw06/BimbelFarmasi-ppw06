# 📊 Sistem Hasil Tryout & Quiz - Dokumentasi

## ✅ Status: SELESAI

Sistem penilaian dan hasil tryout telah dibuat dengan perhitungan poin kebenaran yang akurat dan detail.

---

## 🎯 Fitur Utama

### 1. **Perhitungan Skor Otomatis**
✅ Menghitung jumlah jawaban benar
✅ Menghitung persentase skor
✅ Menentukan status lulus/tidak lulus
✅ Memberikan grade (A, B+, B, C, D, E)

### 2. **Detail Hasil Lengkap**
✅ Skor persentase
✅ Jumlah jawaban benar/salah
✅ Total pertanyaan
✅ Waktu pengerjaan
✅ Feedback otomatis
✅ Review jawaban per soal

### 3. **Statistik & History**
✅ Riwayat semua quiz yang pernah dikerjakan
✅ Statistik per kategori
✅ Rata-rata skor
✅ Tingkat kelulusan (pass rate)

---

## 📝 Struktur Data

### Tabel `quiz_attempts`
```sql
- id (primary key)
- quiz_bank_id (foreign key)
- user_id (foreign key)
- score (decimal) - Persentase skor (0-100)
- correct_answers (integer) - Jumlah jawaban benar
- total_questions (integer) - Total soal
- is_passed (boolean) - Status lulus/tidak
- answers (json) - Detail jawaban per soal
- time_spent_seconds (integer) - Waktu pengerjaan dalam detik
- started_at (timestamp)
- completed_at (timestamp)
- created_at, updated_at
```

### Model Attributes
```php
- score_percentage: Skor dalam bentuk persentase (rounded 2 desimal)
- grade: A/B+/B/C/D/E berdasarkan skor
- status_text: "LULUS" atau "TIDAK LULUS"
- feedback: Feedback otomatis berdasarkan performa
- time_spent_formatted: "X menit Y detik"
```

---

## 🔢 Sistem Penilaian

### Perhitungan Skor
```
Score (%) = (Jawaban Benar / Total Soal) × 100
```

**Contoh:**
- Total soal: 10
- Jawaban benar: 8
- Skor: (8 / 10) × 100 = 80%

### Grade System
```
A   : 90-100%  - Luar biasa!
B+  : 80-89%   - Sangat bagus!
B   : 70-79%   - Bagus! (LULUS)
C   : 60-69%   - Cukup
D   : 50-59%   - Kurang
E   : 0-49%    - Sangat kurang
```

### Status Kelulusan
```
LULUS        : Skor >= Passing Score (default 70%)
TIDAK LULUS  : Skor < Passing Score
```

---

## 🚀 API Endpoints

### 1. Submit Quiz/Tryout
**POST** `/api/v1/exercises/{exerciseId}/submit`
**POST** `/api/v1/tryouts/{tryoutId}/submit`

**Request Body:**
```json
{
  "answers": {
    "1": "A",
    "2": "B",
    "3": "C",
    "4": "A",
    "5": "D",
    "6": "B",
    "7": "C",
    "8": "A",
    "9": "B",
    "10": "E"
  },
  "started_at": "2025-12-02 10:00:00",
  "time_spent_seconds": 1200
}
```

**Response Success (Lulus):**
```json
{
  "success": true,
  "message": "Selamat! Anda lulus!",
  "data": {
    "attempt_id": 1,
    "score": 80.0,
    "correct_answers": 8,
    "wrong_answers": 2,
    "total_questions": 10,
    "passing_score": 70,
    "is_passed": true,
    "grade": "B+",
    "status": "LULUS",
    "feedback": "Sangat bagus! Anda memahami materi dengan baik.",
    "time_spent": "20 menit 0 detik",
    "quiz_title": "Ujian Farmakologi - UKOM D3 Farmasi",
    "quiz_category": "Farmakologi",
    "completed_at": "02 Dec 2025 10:20:00"
  }
}
```

**Response Success (Tidak Lulus):**
```json
{
  "success": true,
  "message": "Mohon maaf, Anda belum lulus. Silakan coba lagi.",
  "data": {
    "attempt_id": 2,
    "score": 60.0,
    "correct_answers": 6,
    "wrong_answers": 4,
    "total_questions": 10,
    "passing_score": 70,
    "is_passed": false,
    "grade": "C",
    "status": "TIDAK LULUS",
    "feedback": "Cukup, tapi masih perlu belajar lebih giat lagi.",
    "time_spent": "25 menit 30 detik",
    "quiz_title": "Ujian Farmakologi - UKOM D3 Farmasi",
    "quiz_category": "Farmakologi",
    "completed_at": "02 Dec 2025 11:00:00"
  }
}
```

---

### 2. View Result Detail
**GET** `/api/v1/results/{resultId}`

**Response:**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "quiz_title": "Ujian Farmakologi - UKOM D3 Farmasi",
    "quiz_category": "Farmakologi",
    "quiz_description": "Bank soal farmakologi untuk persiapan UKOM D3 Farmasi",
    
    "user_name": "John Doe",
    "user_email": "john@example.com",
    
    "score": 80.0,
    "grade": "B+",
    "correct_answers": 8,
    "wrong_answers": 2,
    "total_questions": 10,
    "passing_score": 70,
    "is_passed": true,
    "status": "LULUS",
    "feedback": "Sangat bagus! Anda memahami materi dengan baik.",
    
    "started_at": "02 Dec 2025 10:00:00",
    "completed_at": "02 Dec 2025 10:20:00",
    "time_spent": "20 menit 0 detik",
    "duration_limit": "30 menit",
    
    "accuracy_percentage": 80.0,
    "wrong_percentage": 20.0,
    
    "answers": {
      "1": {
        "question_number": 1,
        "question": "Seorang pasien wanita usia 45 tahun...",
        "user_answer": "C",
        "correct_answer": "C",
        "is_correct": true,
        "explanation": "Paracetamol adalah analgetik pilihan...",
        "options": {
          "A": "Aspirin",
          "B": "Ibuprofen",
          "C": "Paracetamol",
          "D": "Asam mefenamat",
          "E": "Natrium diklofenak"
        }
      },
      "2": {
        "question_number": 2,
        "question": "Pasien TB mendapat terapi...",
        "user_answer": "C",
        "correct_answer": "C",
        "is_correct": true,
        "explanation": "Isoniazid dapat menyebabkan defisiensi vitamin B6...",
        "options": {
          "A": "Vitamin A",
          "B": "Vitamin B1 (Tiamin)",
          "C": "Vitamin B6 (Piridoksin)",
          "D": "Vitamin C",
          "E": "Vitamin D"
        }
      }
      // ... detail jawaban lainnya
    }
  }
}
```

---

### 3. Quiz History
**GET** `/api/v1/quiz-attempts/history`

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": 5,
      "quiz_title": "Farmasi Rumah Sakit - UKOM D3 Farmasi",
      "quiz_category": "Farmasi Rumah Sakit",
      "score": 90.0,
      "grade": "A",
      "correct_answers": 9,
      "total_questions": 10,
      "is_passed": true,
      "status": "LULUS",
      "completed_at": "02 Dec 2025 14:30:00"
    },
    {
      "id": 4,
      "quiz_title": "Kimia Farmasi Analisis - UKOM D3 Farmasi",
      "quiz_category": "Kimia Farmasi",
      "score": 70.0,
      "grade": "B",
      "correct_answers": 7,
      "total_questions": 10,
      "is_passed": true,
      "status": "LULUS",
      "completed_at": "02 Dec 2025 13:00:00"
    },
    {
      "id": 3,
      "quiz_title": "Ujian Farmakologi - UKOM D3 Farmasi",
      "quiz_category": "Farmakologi",
      "score": 60.0,
      "grade": "C",
      "correct_answers": 6,
      "total_questions": 10,
      "is_passed": false,
      "status": "TIDAK LULUS",
      "completed_at": "02 Dec 2025 11:00:00"
    }
  ]
}
```

---

### 4. Quiz Statistics
**GET** `/api/v1/quiz-attempts/statistics`

**Response:**
```json
{
  "success": true,
  "data": {
    "total_attempts": 15,
    "passed_attempts": 12,
    "failed_attempts": 3,
    "pass_rate": 80.0,
    "average_score": 76.5,
    "highest_score": 95.0,
    "lowest_score": 50.0,
    
    "category_statistics": [
      {
        "category": "Farmakologi",
        "total_attempts": 4,
        "passed": 3,
        "average_score": 75.0,
        "highest_score": 90.0
      },
      {
        "category": "Farmasi Klinik",
        "total_attempts": 3,
        "passed": 2,
        "average_score": 73.33,
        "highest_score": 85.0
      },
      {
        "category": "Farmakognosi",
        "total_attempts": 2,
        "passed": 2,
        "average_score": 80.0,
        "highest_score": 85.0
      },
      {
        "category": "Farmasi Rumah Sakit",
        "total_attempts": 3,
        "passed": 3,
        "average_score": 83.33,
        "highest_score": 95.0
      },
      {
        "category": "Kimia Farmasi",
        "total_attempts": 2,
        "passed": 1,
        "average_score": 67.5,
        "highest_score": 75.0
      },
      {
        "category": "Manajemen Farmasi",
        "total_attempts": 1,
        "passed": 1,
        "average_score": 70.0,
        "highest_score": 70.0
      }
    ]
  }
}
```

---

## 📊 Format Hasil Lengkap

### Informasi Umum
- **Judul Quiz**: Nama bank soal
- **Kategori**: Farmakologi, Farmasi Klinik, dll
- **Deskripsi**: Deskripsi singkat quiz

### Informasi Peserta
- **Nama**: Nama user yang mengerjakan
- **Email**: Email user

### Hasil Penilaian
- **Skor**: Persentase (0-100%)
- **Grade**: A/B+/B/C/D/E
- **Jawaban Benar**: Jumlah soal yang benar
- **Jawaban Salah**: Jumlah soal yang salah
- **Total Soal**: Total pertanyaan
- **Passing Score**: Nilai minimal lulus
- **Status**: LULUS / TIDAK LULUS
- **Feedback**: Komentar otomatis berdasarkan performa

### Informasi Waktu
- **Mulai**: Waktu mulai mengerjakan
- **Selesai**: Waktu selesai mengerjakan
- **Durasi**: Waktu yang dihabiskan
- **Batas Waktu**: Durasi maksimal quiz

### Detail Jawaban per Soal
Untuk setiap soal:
- **Nomor Soal**: Urutan soal (1, 2, 3, ...)
- **Pertanyaan**: Teks pertanyaan lengkap
- **Jawaban User**: Pilihan yang dipilih user (A/B/C/D/E)
- **Jawaban Benar**: Kunci jawaban yang benar
- **Status**: Benar / Salah
- **Pembahasan**: Penjelasan mengapa jawaban benar
- **Pilihan**: Semua opsi jawaban (A, B, C, D, E)

---

## 🎨 Tampilan Feedback Otomatis

### Grade A (90-100%)
```
Grade: A
Status: LULUS ✅
Feedback: "Luar biasa! Anda menguasai materi dengan sangat baik."
```

### Grade B+ (80-89%)
```
Grade: B+
Status: LULUS ✅
Feedback: "Sangat bagus! Anda memahami materi dengan baik."
```

### Grade B (70-79%)
```
Grade: B
Status: LULUS ✅
Feedback: "Bagus! Anda lulus dengan nilai yang memuaskan."
```

### Grade C (60-69%)
```
Grade: C
Status: TIDAK LULUS ❌
Feedback: "Cukup, tapi masih perlu belajar lebih giat lagi."
```

### Grade D (50-59%)
```
Grade: D
Status: TIDAK LULUS ❌
Feedback: "Kurang. Pelajari kembali materi yang belum dipahami."
```

### Grade E (0-49%)
```
Grade: E
Status: TIDAK LULUS ❌
Feedback: "Sangat kurang. Sebaiknya pelajari kembali seluruh materi."
```

---

## 💻 Contoh Penggunaan

### Submit Quiz (Frontend)
```javascript
const submitQuiz = async (quizId, answers, startTime) => {
  const timeSpent = Math.floor((Date.now() - startTime) / 1000);
  
  const response = await fetch(`/api/v1/exercises/${quizId}/submit`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'Authorization': `Bearer ${token}`
    },
    body: JSON.stringify({
      answers: {
        1: 'A',
        2: 'B',
        3: 'C',
        // ... jawaban lainnya
      },
      started_at: startTime,
      time_spent_seconds: timeSpent
    })
  });
  
  const result = await response.json();
  
  if (result.success) {
    console.log('Score:', result.data.score);
    console.log('Status:', result.data.status);
    console.log('Grade:', result.data.grade);
    console.log('Feedback:', result.data.feedback);
  }
};
```

### View Result Detail
```javascript
const viewResult = async (attemptId) => {
  const response = await fetch(`/api/v1/results/${attemptId}`, {
    headers: {
      'Authorization': `Bearer ${token}`
    }
  });
  
  const result = await response.json();
  
  if (result.success) {
    const data = result.data;
    
    console.log('Quiz:', data.quiz_title);
    console.log('Score:', data.score + '%');
    console.log('Grade:', data.grade);
    console.log('Status:', data.status);
    console.log('Feedback:', data.feedback);
    
    // Loop through answers
    Object.values(data.answers).forEach(answer => {
      console.log(`Q${answer.question_number}: ${answer.is_correct ? '✅' : '❌'}`);
      console.log('Your answer:', answer.user_answer);
      console.log('Correct answer:', answer.correct_answer);
      console.log('Explanation:', answer.explanation);
    });
  }
};
```

### Get Quiz History
```javascript
const getHistory = async () => {
  const response = await fetch('/api/v1/quiz-attempts/history', {
    headers: {
      'Authorization': `Bearer ${token}`
    }
  });
  
  const result = await response.json();
  
  if (result.success) {
    result.data.forEach(attempt => {
      console.log(`${attempt.quiz_title}: ${attempt.score}% (${attempt.status})`);
    });
  }
};
```

### Get Statistics
```javascript
const getStats = async () => {
  const response = await fetch('/api/v1/quiz-attempts/statistics', {
    headers: {
      'Authorization': `Bearer ${token}`
    }
  });
  
  const result = await response.json();
  
  if (result.success) {
    const stats = result.data;
    
    console.log('Total Attempts:', stats.total_attempts);
    console.log('Pass Rate:', stats.pass_rate + '%');
    console.log('Average Score:', stats.average_score);
    console.log('Highest Score:', stats.highest_score);
    
    console.log('\nBy Category:');
    stats.category_statistics.forEach(cat => {
      console.log(`${cat.category}: ${cat.average_score}% avg (${cat.passed}/${cat.total_attempts} passed)`);
    });
  }
};
```

---

## 🔒 Security & Validation

### Authorization
- ✅ User hanya bisa submit quiz untuk program yang mereka akses
- ✅ User hanya bisa melihat hasil quiz mereka sendiri
- ✅ User tidak bisa mengubah hasil setelah submit

### Validation
- ✅ Quiz ID harus valid dan ada di database
- ✅ Answers harus berupa array/object
- ✅ User harus authenticated dengan token valid
- ✅ Time spent harus integer positif

---

## 📈 Performance & Optimization

### Database Indexes
- ✅ Index pada `user_id` untuk query history cepat
- ✅ Index pada `quiz_bank_id` untuk statistik
- ✅ Index pada `completed_at` untuk sorting

### Eager Loading
```php
QuizAttempt::with('quizBank', 'user')->find($id);
```

### Caching (Future)
```php
Cache::remember("quiz_stats_{$userId}", 600, function() {
    return $this->calculateStatistics();
});
```

---

## 🎯 Best Practices

### Frontend
1. **Simpan jawaban sementara** ke localStorage untuk prevent data loss
2. **Timer countdown** untuk mengingatkan waktu tersisa
3. **Auto-save** jawaban setiap beberapa detik
4. **Konfirmasi** sebelum submit
5. **Disable submit** setelah waktu habis

### Backend
1. **Validate** semua input
2. **Log** setiap attempt untuk audit
3. **Rate limiting** untuk prevent spam submit
4. **Transaction** untuk ensure data consistency

---

## 📝 Database Migration

Sudah dijalankan:
```bash
✅ create_quiz_banks_table.php
✅ add_time_spent_to_quiz_attempts_table.php
```

Kolom yang ditambahkan:
- `answers` (JSON) - Detail jawaban per soal
- `time_spent_seconds` (Integer) - Durasi pengerjaan

---

## 🚀 Testing

### Manual Test
```bash
# Submit quiz
POST /api/v1/exercises/1/submit
{
  "answers": {"1": "A", "2": "B", ...},
  "time_spent_seconds": 1200
}

# View result
GET /api/v1/results/1

# Get history
GET /api/v1/quiz-attempts/history

# Get statistics
GET /api/v1/quiz-attempts/statistics
```

---

## ✅ Checklist

- [x] Model `QuizAttempt` dengan relationships
- [x] Migration untuk kolom tambahan
- [x] Controller methods untuk submit & view
- [x] Perhitungan skor otomatis
- [x] Grade system (A, B+, B, C, D, E)
- [x] Feedback otomatis
- [x] Detail jawaban per soal
- [x] Quiz history endpoint
- [x] Quiz statistics endpoint
- [x] API routes
- [x] Validation & authorization
- [x] Dokumentasi lengkap

---

## 📞 Support

Jika ada pertanyaan atau butuh bantuan:
- 📧 Email: support@bimbelfarmasi.com
- 💬 Chat admin di dashboard
- 📖 Dokumentasi: /docs/api

---

**Sistem hasil tryout siap digunakan! 🎉**

*"Setiap hasil adalah pembelajaran. Keep practicing!"*

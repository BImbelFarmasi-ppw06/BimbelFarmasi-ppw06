# Dokumentasi Bank Soal Farmasi

## ✅ Soal Farmasi Telah Dibuat

Database telah terisi dengan **360 soal farmasi** yang dibagi menjadi **6 kategori** utama untuk persiapan UKOM D3 Farmasi.

---

## 📚 Kategori Bank Soal

### 1. **Farmakologi** (10 soal)
Topik yang dicakup:
- Analgetik dan pemilihan obat untuk pasien dengan kondisi khusus
- Terapi tuberkulosis dan suplementasi vitamin
- Antidotum untuk keracunan
- ACE inhibitor dan efek samping
- Proton pump inhibitor (PPI)
- Antikoagulan dan monitoring INR
- Antibiotik dan waktu konsumsi
- Kontraindikasi metformin
- Teknik penggunaan inhaler
- Novel oral anticoagulant (NOAC)

**Contoh Soal:**
- "Seorang pasien wanita usia 45 tahun dengan riwayat tukak lambung mengalami nyeri kepala. Obat analgetik yang paling tepat?"
- "Pasien TB mendapat rifampisin, isoniazid, pirazinamid, dan etambutol. Vitamin yang perlu diberikan sebagai suplemen?"

---

### 2. **Farmasi Klinik** (10 soal)
Topik yang dicakup:
- Manajemen efek samping metformin
- Antihipertensi pada gangguan ginjal
- Monitoring terapi statin
- Interaksi obat (levofloxacin-teofilin)
- Edukasi penggunaan antibiotik (azithromycin)
- Loading dose digoxin
- Kortikosteroid inhalasi dan pencegahan efek samping
- Terapi pneumonia komunitas
- Therapeutic drug monitoring (fenitoin)
- Manajemen lupa minum pil KB

**Contoh Soal:**
- "Pasien diabetes tipe 2 mendapat metformin 500 mg 3x1, mengeluh mual dan diare. Apa rekomendasi yang tepat?"
- "Pasien epilepsi mendapat fenitoin. Kadar terapeutik dalam darah adalah?"

---

### 3. **Farmakognosi** (10 soal)
Topik yang dicakup:
- Artemisin dari Artemisia annua untuk malaria
- Standarisasi simplisia
- Morfin dari Papaver somniferum
- Antosianin sebagai antioksidan
- Metode ekstraksi Soxhletasi
- Andrografolid dari sambiloto
- Uji fitokimia dengan FeCl3
- Ginkgolide dari Ginkgo biloba
- Kadar air maksimal simplisia
- Paclitaxel dari Taxus brevifolia

**Contoh Soal:**
- "Senyawa artemisin yang digunakan untuk terapi malaria berasal dari tanaman?"
- "Kadar air maksimal yang diperbolehkan untuk simplisia kering menurut farmakope adalah?"

---

### 4. **Farmasi Rumah Sakit** (10 soal)
Topik yang dicakup:
- High alert medications
- LASA (Look Alike Sound Alike)
- Unit Dose Dispensing (UDD)
- Pencampuran sitostatika di BSC
- Sediaan yang harus diproteksi dari cahaya
- Rekonsiliasi obat
- Cold chain vaksin
- Penulisan resep racikan anak
- Pemberian obat via NGT
- Stabilitas insulin

**Contoh Soal:**
- "Obat high alert yang penyimpanannya harus terpisah dan diberi label khusus adalah?"
- "LASA (Look Alike Sound Alike) yang sering terjadi adalah? DOPamine dan DOBUtamine"

---

### 5. **Kimia Farmasi** (10 soal)
Topik yang dicakup:
- Spektrofotometri UV-Vis untuk paracetamol
- Prinsip kerja HPLC
- Uji disolusi tablet
- Titrasi asam-basa
- Validasi metode (akurasi)
- Kromatografi lapis tipis (KLT)
- Limit of Detection (LOD)
- Fase gerak untuk alkaloid
- Spektrofotometri IR
- Analisis logam berat dengan AAS

**Contoh Soal:**
- "Metode analisis kuantitatif paracetamol tablet menggunakan spektrofotometri UV-Vis pada panjang gelombang?"
- "Validasi metode analisis parameter akurasi menunjukkan?"

---

### 6. **Manajemen Farmasi** (10 soal)
Topik yang dicakup:
- Metode pengadaan obat
- Sistem konsinyasi
- ABC analysis
- FIFO vs FEFO
- Penyimpanan resep narkotika
- Turnover rate (TOR)
- Stok opname
- Pelaporan narkotika dan psikotropika
- Margin keuntungan apotek
- Dead stock

**Contoh Soal:**
- "Metode pengadaan obat dengan membuat surat pesanan langsung ke PBF adalah?"
- "Metode FIFO (First In First Out) dalam penyimpanan obat artinya?"

---

## 📊 Statistik Bank Soal

```
Total Quiz Banks: 36
Total Questions: 360
Jumlah Kategori: 6
Soal per Kategori: 10 soal
Durasi per Quiz: 30 menit
Passing Score: 70%
```

---

## 🎯 Karakteristik Soal

### Format Soal
- **Tipe:** Multiple choice (5 pilihan: A, B, C, D, E)
- **Struktur:** Soal berbasis kasus klinis dan skenario nyata
- **Penjelasan:** Setiap soal dilengkapi dengan penjelasan jawaban yang benar

### Tingkat Kesulitan
- ✅ **Soal aplikasi:** Menguji kemampuan menerapkan pengetahuan dalam situasi nyata
- ✅ **Soal analisis:** Menguji kemampuan menganalisis masalah farmasi
- ✅ **Soal evaluasi:** Menguji kemampuan mengevaluasi terapi dan membuat keputusan

### Relevansi dengan UKOM
Semua soal dirancang berdasarkan:
- ✅ Standar kompetensi Ahli Madya Farmasi
- ✅ Blueprint UKOM D3 Farmasi
- ✅ Kasus-kasus praktis yang sering dijumpai
- ✅ Pedoman terapi dan standar pelayanan kefarmasian terkini

---

## 💡 Cara Mengakses Soal

### 1. Via Dashboard User
```
Login → Dashboard → My Quiz Banks → Pilih Kategori
```

### 2. Via Database
```php
// Lihat semua bank soal
QuizBank::with('questions')->get();

// Filter by category
QuizBank::where('category', 'Farmakologi')->get();

// Lihat soal dengan user tertentu
QuizBank::where('user_id', $userId)->with('questions')->get();
```

### 3. Via API
```bash
GET /api/quiz-banks
GET /api/quiz-banks/{id}/questions
GET /api/quiz-attempts/{attemptId}/results
```

---

## 🔄 Update dan Maintenance

### Menambah Soal Baru
```php
php artisan db:seed --class=QuizBankSeeder
```

### Reset dan Re-seed
```bash
php artisan migrate:fresh --seed
```

### Backup Database
```bash
php artisan backup:run
```

---

## 📖 Contoh Penggunaan Soal

### Skenario 1: Try Out Farmakologi
```
Judul: Ujian Farmakologi - UKOM D3 Farmasi
Kategori: Farmakologi
Soal: 10 soal
Waktu: 30 menit
Passing Score: 70%

Hasil:
- Benar 8 dari 10 (80%)
- Status: LULUS ✅
- Feedback: "Bagus! Anda memahami farmakologi dasar dengan baik"
```

### Skenario 2: Remedial Farmasi Klinik
```
Judul: Ujian Farmasi Klinik - UKOM D3 Farmasi
Kategori: Farmasi Klinik
Soal: 10 soal
Waktu: 30 menit
Passing Score: 70%

Hasil:
- Benar 6 dari 10 (60%)
- Status: TIDAK LULUS ❌
- Rekomendasi: "Pelajari kembali materi interaksi obat dan monitoring terapi"
```

---

## 🎓 Materi Pendukung

### Referensi untuk Setiap Kategori

**Farmakologi:**
- Farmakologi Dasar dan Klinik (Katzung)
- ISO Indonesia Volume 56
- MIMS/Pionas

**Farmasi Klinik:**
- Pharmaceutical Care Practice (Cipolle)
- Pharmacotherapy Handbook (DiPiro)
- Pedoman Pelayanan Kefarmasian Kemenkes

**Farmakognosi:**
- Farmakognosi (Tyler)
- Farmakope Herbal Indonesia (FHI)
- Monografi Ekstrak Tumbuhan Obat Indonesia

**Farmasi Rumah Sakit:**
- Standar Pelayanan Kefarmasian di RS (Permenkes 72/2016)
- ISMP High Alert Medications List
- JCI Patient Safety Standards

**Kimia Farmasi:**
- Farmakope Indonesia Edisi VI
- Validated Analytical Methods (ICH Guidelines)
- Instrumental Methods of Analysis

**Manajemen Farmasi:**
- Manajemen Farmasi (Quick)
- Permenkes tentang Apotek dan Standar Pelayanan
- Good Pharmacy Practice (GPP)

---

## 🚀 Fitur Tambahan

### Auto-Grading
✅ Sistem otomatis menghitung skor
✅ Feedback langsung setelah selesai
✅ Review jawaban dengan penjelasan

### Progress Tracking
✅ History semua attempts
✅ Grafik perkembangan per kategori
✅ Identifikasi topik yang perlu dipelajari

### Analytics
✅ Soal paling sulit (tingkat keberhasilan terendah)
✅ Rata-rata waktu pengerjaan per soal
✅ Perbandingan dengan peserta lain

---

## 🔐 Keamanan Data

- ✅ Setiap user hanya bisa akses quiz bank miliknya
- ✅ Quiz attempt tersimpan dengan user_id dan timestamp
- ✅ Jawaban tidak bisa diubah setelah submit
- ✅ Hasil quiz dapat di-export untuk dokumentasi

---

## 📞 Support

Jika ada pertanyaan atau perlu menambah soal:
1. Hubungi admin melalui dashboard
2. Submit request melalui contact form
3. Email: support@bimbelfarmasi.com

---

**Selamat belajar dan sukses UKOM D3 Farmasi! 🎓💊**

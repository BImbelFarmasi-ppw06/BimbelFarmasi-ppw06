# 📤 Fitur Upload Bukti Pembayaran

## 🎯 Overview

Fitur upload bukti pembayaran memungkinkan user untuk mengunggah bukti transfer/pembayaran mereka setelah melakukan order program bimbel atau joki tugas. Admin kemudian dapat memverifikasi pembayaran tersebut.

---

## ✅ Fitur yang Sudah Tersedia

### 1. **Upload Bukti Pembayaran (User)**
- ✅ Form upload dengan validasi file
- ✅ Preview gambar sebelum upload
- ✅ Validasi format: JPG, JPEG, PNG
- ✅ Validasi ukuran maksimal: 2MB
- ✅ UI/UX yang user-friendly dengan drag & drop feel
- ✅ Error handling yang informatif

### 2. **Pilihan Metode Pembayaran**
- ✅ Transfer Bank (BCA, Mandiri, BNI, BRI)
- ✅ E-Wallet (GoPay, OVO, DANA, ShopeePay)
- ✅ QRIS
- ✅ Instruksi pembayaran untuk setiap metode

### 3. **Status Pembayaran**
- ✅ `pending` - Menunggu verifikasi admin
- ✅ `paid` - Sudah diverifikasi dan disetujui
- ✅ `rejected` - Ditolak, perlu upload ulang

### 4. **Panel Admin**
- ✅ Lihat semua pembayaran dengan filter status
- ✅ Lihat detail pembayaran & bukti transfer
- ✅ Approve pembayaran
- ✅ Reject pembayaran dengan alasan
- ✅ Statistics dashboard

---

## 🔄 Flow Pembayaran

### User Side:
1. User memilih program di halaman "Bimbel UKOM", "CPNS P3K", atau "Joki Tugas"
2. Klik "Beli Sekarang"
3. Isi form order (opsional: tambahkan catatan)
4. Pilih metode pembayaran
5. Upload bukti pembayaran (JPG/PNG, max 2MB)
6. Klik "Kirim Bukti Pembayaran"
7. Menunggu verifikasi admin (1x24 jam)

### Admin Side:
1. Login ke admin panel (`/admin/login`)
2. Pergi ke menu "Payments"
3. Lihat list pembayaran pending
4. Klik detail untuk melihat bukti transfer
5. **Approve** → User dapat akses layanan
6. **Reject** → User perlu upload ulang bukti

---

## 📂 File Structure

```
app/
├── Http/Controllers/
│   ├── OrderController.php              # Handle order & upload
│   └── Admin/
│       └── AdminPaymentController.php   # Admin verify payment
├── Models/
│   ├── Order.php
│   └── Payment.php
resources/views/pages/order/
├── create.blade.php                     # Form order
├── payment.blade.php                    # Upload bukti ✨
├── success.blade.php                    # Success page
└── my-orders.blade.php                  # List orders user
storage/app/public/
└── payment-proofs/                      # Folder bukti bayar
```

---

## 🗃️ Database Schema

### Table: `payments`
```sql
- id (bigint)
- order_id (bigint) → FK to orders
- payment_method (enum: bank_transfer, ewallet, qris)
- amount (decimal)
- status (enum: pending, paid, rejected)
- proof_url (string) → Path ke file bukti
- paid_at (timestamp)
- notes (text) → Catatan admin/system
- created_at
- updated_at
```

---

## 🛠️ Technical Details

### File Upload Configuration
```php
// Validation Rules
'proof' => 'required|file|mimes:jpeg,jpg,png|max:2048'

// Storage
Storage::disk('public')->put('payment-proofs', $file);
```

### Storage Setup
```bash
# Symbolic link sudah dibuat
php artisan storage:link

# Folder structure
public/storage → storage/app/public
```

---

## 🎨 UI Features

### Upload Area
- **Pilih File Button** - Modern button design
- **Preview Thumbnail** - Show gambar yang dipilih
- **File Info** - Nama file & ukuran
- **Remove Button** - Hapus file sebelum submit
- **Progress Indicator** - Submit button berubah warna

### Validation Messages
```
❌ File harus berupa gambar!
❌ Ukuran file terlalu besar! (Max 2MB)
✅ File berhasil dipilih
```

---

## 🔐 Security

- ✅ Authentication required (`auth` middleware)
- ✅ User hanya bisa upload untuk order mereka sendiri
- ✅ File type validation (hanya gambar)
- ✅ File size validation (max 2MB)
- ✅ Stored di `storage/app/public` (tidak bisa direct execute)
- ✅ Admin authentication untuk approve/reject

---

## 📱 Routes

### User Routes
```php
GET  /order/{slug}                    # Form order
POST /order                           # Submit order
GET  /order/{orderNumber}/payment     # Upload bukti
POST /order/{orderNumber}/payment     # Process upload
GET  /order/{orderNumber}/success     # Success page
GET  /pesanan-saya                    # My orders
```

### Admin Routes
```php
GET  /admin/payments                  # List payments
GET  /admin/payments/{id}             # Detail payment
POST /admin/payments/{id}/approve     # Approve
POST /admin/payments/{id}/reject      # Reject
GET  /admin/payments/{id}/proof       # View proof image
```

---

## 🧪 Testing

### Manual Testing Checklist
- [ ] Upload file JPG/PNG berhasil
- [ ] Upload file PDF/DOC gagal (error message muncul)
- [ ] Upload file > 2MB gagal (error message muncul)
- [ ] Preview gambar muncul setelah pilih file
- [ ] Submit button disabled sebelum upload file
- [ ] Submit button enabled setelah upload file
- [ ] File tersimpan di `storage/app/public/payment-proofs/`
- [ ] Payment status = `pending` setelah upload
- [ ] Admin bisa lihat bukti pembayaran
- [ ] Admin bisa approve → status jadi `paid`
- [ ] Admin bisa reject → status jadi `rejected`

---

## 🚀 Cara Menggunakan

### Sebagai User:
1. Login ke akun Anda
2. Buka halaman program (contoh: `/bimbel-ukom-d3-farmasi`)
3. Klik "Beli Sekarang"
4. Isi form order
5. Pilih metode pembayaran
6. Lakukan transfer sesuai instruksi
7. Upload bukti transfer (screenshot/foto)
8. Tunggu verifikasi admin

### Sebagai Admin:
1. Login ke `/admin/login`
   - Email: `admin@bimbelfarmasi.com`
   - Password: `admin123`
2. Klik menu "Payments"
3. Lihat pembayaran pending
4. Klik "View Details" untuk melihat bukti
5. Approve jika valid, Reject jika tidak

---

## 📊 Status Flow Diagram

```
User Order → pending
     ↓
Upload Bukti → payment.status = pending
     ↓
Admin Review
     ├─→ Approve → payment.status = paid, order.status = processing
     └─→ Reject  → payment.status = rejected, order.status = cancelled
                   (User dapat upload ulang)
```

---

## ⚙️ Configuration

### Environment Variables
```env
APP_URL=http://localhost:8000
FILESYSTEM_DISK=public
```

### File System Config
```php
// config/filesystems.php
'public' => [
    'driver' => 'local',
    'root' => storage_path('app/public'),
    'url' => env('APP_URL').'/storage',
    'visibility' => 'public',
]
```

---

## 🐛 Troubleshooting

### File tidak tersimpan
```bash
# Pastikan folder ada dan writable
php artisan storage:link
mkdir -p storage/app/public/payment-proofs
chmod -R 775 storage
```

### Gambar tidak muncul di admin
```bash
# Pastikan symbolic link sudah dibuat
php artisan storage:link
```

### Error 404 saat akses gambar
```
# Check APP_URL di .env
APP_URL=http://localhost:8000

# Pastikan path benar
/storage/payment-proofs/xxxxx.jpg
```

---

## 📞 Support

Jika ada masalah atau pertanyaan:
- Hubungi developer
- Check logs: `storage/logs/laravel.log`
- Documentation: README.md

---

## 📝 Changelog

### Version 1.0 (Current)
- ✅ Upload bukti pembayaran
- ✅ Preview gambar
- ✅ Validasi file
- ✅ Admin verification
- ✅ Status tracking
- ✅ UI/UX improvements

### Future Enhancements
- [ ] Multiple file upload
- [ ] Image compression otomatis
- [ ] Email notification setelah approve/reject
- [ ] Export pembayaran ke Excel
- [ ] Payment gateway integration (Midtrans)

---

**Last Updated:** November 16, 2025
**Developer:** GitHub Copilot 🤖

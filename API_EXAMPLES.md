# 📘 API Usage Examples

## Complete Examples untuk Testing API BimbelFarmasi

---

## 1. 🔐 Authentication Flow

### Register New User

**Request:**
```bash
curl -X POST http://127.0.0.1:8000/api/v1/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Maria Purba",
    "email": "maria@example.com",
    "phone": "08123456789",
    "university": "Universitas Sumatera Utara",
    "interest": "UKOM D3 Farmasi",
    "password": "password123",
    "password_confirmation": "password123"
  }'
```

**Response:**
```json
{
  "message": "User registered successfully",
  "user": {
    "id": 5,
    "name": "Maria Purba",
    "email": "maria@example.com",
    "phone": "08123456789",
    "university": "Universitas Sumatera Utara",
    "interest": "UKOM D3 Farmasi",
    "is_admin": false,
    "created_at": "2025-11-20T10:30:00.000000Z"
  },
  "token": "5|abc123xyz789..."
}
```

**💡 Save this token! You'll need it for authenticated requests.**

---

### Login Existing User

**Request:**
```bash
curl -X POST http://127.0.0.1:8000/api/v1/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "maria@example.com",
    "password": "password123"
  }'
```

**Response:**
```json
{
  "message": "Login successful",
  "user": { ... },
  "token": "6|def456uvw012..."
}
```

---

### Logout

**Request:**
```bash
curl -X POST http://127.0.0.1:8000/api/v1/logout \
  -H "Authorization: Bearer 6|def456uvw012..."
```

**Response:**
```json
{
  "message": "Logout successful"
}
```

---

## 2. 👤 User Profile Management

### Get Current User Profile

**Request:**
```bash
curl -X GET http://127.0.0.1:8000/api/v1/user \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

**Response:**
```json
{
  "success": true,
  "data": {
    "id": 5,
    "name": "Maria Purba",
    "email": "maria@example.com",
    "phone": "08123456789",
    "university": "Universitas Sumatera Utara",
    "interest": "UKOM D3 Farmasi"
  }
}
```

---

### Update Profile

**Request:**
```bash
curl -X PUT http://127.0.0.1:8000/api/v1/user/profile \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Maria Magdalena Purba",
    "phone": "08199999999",
    "university": "USU",
    "interest": "CPNS Farmasi"
  }'
```

**Response:**
```json
{
  "success": true,
  "message": "Profile updated successfully",
  "data": {
    "id": 5,
    "name": "Maria Magdalena Purba",
    "phone": "08199999999",
    "university": "USU",
    "interest": "CPNS Farmasi"
  }
}
```

---

### Change Password

**Request:**
```bash
curl -X PUT http://127.0.0.1:8000/api/v1/user/password \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Content-Type: application/json" \
  -d '{
    "current_password": "password123",
    "new_password": "newpassword456",
    "new_password_confirmation": "newpassword456"
  }'
```

**Response:**
```json
{
  "success": true,
  "message": "Password updated successfully"
}
```

---

## 3. 📚 Programs

### Get All Programs (Public)

**Request:**
```bash
curl -X GET http://127.0.0.1:8000/api/v1/programs
```

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "slug": "bimbel-ukom-d3-farmasi",
      "title": "Bimbel UKOM D3 Farmasi",
      "description": "Program persiapan UKOM...",
      "price": 500000,
      "duration": "3 bulan",
      "features": ["Materi Lengkap", "Try Out", "Konsultasi"]
    },
    {
      "id": 2,
      "slug": "cpns-p3k-farmasi",
      "title": "CPNS & P3K Farmasi",
      "price": 750000,
      ...
    }
  ]
}
```

---

### Get Program by Slug

**Request:**
```bash
curl -X GET http://127.0.0.1:8000/api/v1/programs/bimbel-ukom-d3-farmasi
```

**Response:**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "slug": "bimbel-ukom-d3-farmasi",
    "title": "Bimbel UKOM D3 Farmasi",
    "description": "Program persiapan UKOM D3 Farmasi dengan materi lengkap...",
    "price": 500000,
    "duration": "3 bulan",
    "features": [
      "Materi Lengkap sesuai kisi-kisi UKOM",
      "Latihan Soal & Pembahasan",
      "Try Out Berkala",
      "Konsultasi dengan Mentor",
      "Grup Diskusi"
    ],
    "created_at": "2025-10-06T12:00:00.000000Z"
  }
}
```

---

## 4. 🛒 Orders & Payments

### Create Order

**Request:**
```bash
curl -X POST http://127.0.0.1:8000/api/v1/orders \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Content-Type: application/json" \
  -d '{
    "program_id": 1,
    "notes": "Mohon informasi jadwal kelas"
  }'
```

**Response:**
```json
{
  "success": true,
  "message": "Order created successfully",
  "data": {
    "id": 15,
    "user_id": 5,
    "program_id": 1,
    "order_number": "ORD-AB12CD34EF",
    "total_amount": 500000,
    "status": "pending",
    "notes": "Mohon informasi jadwal kelas",
    "created_at": "2025-11-20T11:00:00.000000Z",
    "program": {
      "id": 1,
      "title": "Bimbel UKOM D3 Farmasi",
      "price": 500000
    }
  }
}
```

---

### Upload Payment Proof

**Request:**
```bash
curl -X POST http://127.0.0.1:8000/api/v1/orders/ORD-AB12CD34EF/payment \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -F "payment_method=bca" \
  -F "proof_image=@/path/to/bukti_transfer.jpg" \
  -F "notes=Transfer dari BCA 1234567890"
```

**Response:**
```json
{
  "success": true,
  "message": "Payment proof uploaded successfully. Please wait for admin verification.",
  "data": {
    "id": 10,
    "order_id": 15,
    "payment_method": "bca",
    "proof_path": "payments/abc123.jpg",
    "amount": 500000,
    "status": "pending",
    "notes": "Transfer dari BCA 1234567890",
    "created_at": "2025-11-20T11:05:00.000000Z"
  }
}
```

---

### Get My Orders

**Request:**
```bash
curl -X GET http://127.0.0.1:8000/api/v1/user/orders \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": 15,
      "order_number": "ORD-AB12CD34EF",
      "total_amount": 500000,
      "status": "pending",
      "created_at": "2025-11-20T11:00:00.000000Z",
      "program": {
        "id": 1,
        "title": "Bimbel UKOM D3 Farmasi"
      },
      "payment": {
        "status": "pending",
        "payment_method": "bca",
        "created_at": "2025-11-20T11:05:00.000000Z"
      }
    }
  ]
}
```

---

## 5. 📖 Program Materials (After Payment Approved)

### Get Course Materials

**Request:**
```bash
curl -X GET http://127.0.0.1:8000/api/v1/programs/1/materials \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

**Response (if approved):**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "title": "Farmakologi Dasar",
      "description": "Materi dasar farmakologi...",
      "content": "# Bab 1: Pendahuluan\n\n..."
    },
    {
      "id": 2,
      "title": "Farmasetika",
      "description": "Sediaan obat dan formulasi..."
    }
  ]
}
```

**Response (if not enrolled):**
```json
{
  "success": false,
  "message": "You do not have access to this program"
}
```

---

### Get Exercises

**Request:**
```bash
curl -X GET http://127.0.0.1:8000/api/v1/programs/1/exercises \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "type": "latihan",
      "title": "Latihan Soal Farmakologi Bab 1",
      "program_category": "1",
      "questions": [
        {
          "id": 1,
          "question": "Apa definisi farmakologi?",
          "options": {
            "A": "Ilmu tentang obat",
            "B": "Ilmu tentang penyakit",
            "C": "Ilmu tentang tanaman",
            "D": "Ilmu tentang hewan"
          },
          "correct_answer": "A"
        }
      ]
    }
  ]
}
```

---

### Submit Exercise

**Request:**
```bash
curl -X POST http://127.0.0.1:8000/api/v1/exercises/1/submit \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Content-Type: application/json" \
  -d '{
    "answers": {
      "1": "A",
      "2": "B",
      "3": "C"
    }
  }'
```

**Response:**
```json
{
  "success": true,
  "message": "Exercise submitted successfully",
  "data": {
    "score": 80,
    "correct": 8,
    "total": 10,
    "attempt_id": 25
  }
}
```

---

### View Result

**Request:**
```bash
curl -X GET http://127.0.0.1:8000/api/v1/results/25 \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

**Response:**
```json
{
  "success": true,
  "data": {
    "id": 25,
    "user_id": 5,
    "quiz_bank_id": 1,
    "score": 80,
    "answers": "{\"1\":\"A\",\"2\":\"B\"...}",
    "completed_at": "2025-11-20T12:00:00.000000Z",
    "quizBank": {
      "id": 1,
      "title": "Latihan Soal Farmakologi Bab 1"
    }
  }
}
```

---

## 6. ⭐ Testimonials

### Get All Testimonials (Public)

**Request:**
```bash
curl -X GET http://127.0.0.1:8000/api/v1/testimonials
```

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "user_id": 2,
      "rating": 5,
      "comment": "Sangat membantu! Lulus UKOM dengan nilai memuaskan.",
      "is_approved": true,
      "created_at": "2025-11-15T10:00:00.000000Z",
      "user": {
        "id": 2,
        "name": "Siti Rahma"
      }
    }
  ]
}
```

---

### Create Testimonial

**Request:**
```bash
curl -X POST http://127.0.0.1:8000/api/v1/testimonials \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Content-Type: application/json" \
  -d '{
    "rating": 5,
    "comment": "Program sangat bagus, materinya lengkap dan mudah dipahami!"
  }'
```

**Response:**
```json
{
  "success": true,
  "message": "Testimonial submitted successfully. Waiting for approval.",
  "data": {
    "id": 15,
    "user_id": 5,
    "rating": 5,
    "comment": "Program sangat bagus, materinya lengkap dan mudah dipahami!",
    "is_approved": false,
    "created_at": "2025-11-20T12:30:00.000000Z"
  }
}
```

---

## 7. 📧 Contact Form

### Send Contact Message (Public)

**Request:**
```bash
curl -X POST http://127.0.0.1:8000/api/v1/contact \
  -H "Content-Type: application/json" \
  -d '{
    "name": "John Doe",
    "email": "john@example.com",
    "phone": "08123456789",
    "subject": "Pertanyaan tentang program CPNS",
    "message": "Halo, saya ingin tahu lebih detail tentang program CPNS Farmasi. Apakah ada diskon untuk pendaftaran grup?"
  }'
```

**Response:**
```json
{
  "success": true,
  "message": "Thank you! Your message has been sent successfully. We will contact you soon."
}
```

---

## 8. 🔍 Error Examples

### 401 Unauthorized (Missing Token)

**Request:**
```bash
curl -X GET http://127.0.0.1:8000/api/v1/user
```

**Response:**
```json
{
  "message": "Unauthenticated."
}
```

---

### 403 Forbidden (No Access)

**Request:**
```bash
curl -X GET http://127.0.0.1:8000/api/v1/programs/1/materials \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

**Response:**
```json
{
  "success": false,
  "message": "You do not have access to this program"
}
```

---

### 404 Not Found

**Request:**
```bash
curl -X GET http://127.0.0.1:8000/api/v1/programs/invalid-slug
```

**Response:**
```json
{
  "success": false,
  "message": "Program not found"
}
```

---

### 422 Validation Error

**Request:**
```bash
curl -X POST http://127.0.0.1:8000/api/v1/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Test",
    "email": "invalid-email"
  }'
```

**Response:**
```json
{
  "message": "The email field must be a valid email address. (and 1 more error)",
  "errors": {
    "email": ["The email field must be a valid email address."],
    "password": ["The password field is required."]
  }
}
```

---

## 💡 Tips untuk Testing

### 1. Save Token to Variable (PowerShell)
```powershell
$token = "5|abc123xyz789..."
curl -X GET http://127.0.0.1:8000/api/v1/user `
  -H "Authorization: Bearer $token"
```

### 2. Use Postman Environment
Create environment with:
- `base_url` = `http://127.0.0.1:8000/api/v1`
- `token` = (set after login)

### 3. Test Flow Sequence
1. Register → Get token
2. Login → Get new token
3. Get profile → Verify user data
4. Create order → Get order_number
5. Upload payment → Wait approval (admin panel)
6. Access materials → After approval

### 4. Common Headers
```bash
-H "Content-Type: application/json"           # For JSON data
-H "Authorization: Bearer {token}"             # For auth
-F "file=@path"                                # For file upload
```

---

## 🎯 Complete User Journey Example

```bash
# 1. Register
TOKEN=$(curl -X POST http://127.0.0.1:8000/api/v1/register \
  -H "Content-Type: application/json" \
  -d '{"name":"Test","email":"test@test.com","password":"password123","password_confirmation":"password123"}' \
  | jq -r '.token')

# 2. Get programs
curl -X GET http://127.0.0.1:8000/api/v1/programs

# 3. Create order
ORDER=$(curl -X POST http://127.0.0.1:8000/api/v1/orders \
  -H "Authorization: Bearer $TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"program_id":1}' \
  | jq -r '.data.order_number')

# 4. Upload payment proof
curl -X POST http://127.0.0.1:8000/api/v1/orders/$ORDER/payment \
  -H "Authorization: Bearer $TOKEN" \
  -F "payment_method=bca" \
  -F "proof_image=@bukti.jpg"

# 5. Check my orders
curl -X GET http://127.0.0.1:8000/api/v1/user/orders \
  -H "Authorization: Bearer $TOKEN"
```

---

Selamat mencoba! Semua endpoint sudah siap digunakan. 🚀

# 🔌 Integration API - BimbelFarmasi

Panduan untuk mengintegrasikan BimbelFarmasi dengan proyek lain.

---

## 📋 Daftar Integration API

### **1. Webhook API**
- Menerima notifikasi dari proyek lain
- Mengirim notifikasi ke proyek lain

### **2. Data Sync API**
- Sinkronisasi users
- Sinkronisasi orders
- Sinkronisasi enrollment

### **3. Validation API**
- Validasi user
- Validasi payment

---

## 🔐 Authentication

Semua Integration API menggunakan **API Key** di header:

```
X-API-Key: your-integration-api-key
```

Set di `.env`:
```env
INTEGRATION_API_KEY=your-secret-api-key-here
WEBHOOK_SECRET=your-webhook-secret-here
EXTERNAL_API_URL=https://api.external-project.com
EXTERNAL_API_KEY=external-project-api-key
```

---

## 📡 WEBHOOK API

### 1. Receive Webhook dari Proyek Lain

**Endpoint:** `POST /api/v1/integration/webhook/external`

**Header:**
```
X-Webhook-Signature: sha256_hash
Content-Type: application/json
```

**Request Body:**
```json
{
  "event": "payment.success",
  "data": {
    "order_number": "ORD-20251208-001",
    "payment_id": "PAY-123456",
    "amount": 1750000,
    "status": "paid"
  },
  "timestamp": "2025-12-08T10:00:00Z"
}
```

**Supported Events:**
- `user.created` - User baru dibuat
- `payment.success` - Payment berhasil
- `enrollment.updated` - Enrollment diupdate

**Response:**
```json
{
  "success": true,
  "message": "Webhook processed successfully"
}
```

**Cara Generate Signature:**
```php
$payload = json_encode($data);
$secret = 'your-webhook-secret';
$signature = hash_hmac('sha256', $payload, $secret);
```

---

### 2. Send Webhook ke Proyek Lain

**Endpoint:** `POST /api/v1/integration/webhook/send`

**Header:**
```
Authorization: Bearer {token}
Content-Type: application/json
```

**Request Body:**
```json
{
  "endpoint": "https://external-api.com/webhook",
  "event": "order.created",
  "data": {
    "order_number": "ORD-20251208-001",
    "user_email": "user@example.com",
    "amount": 1750000
  }
}
```

**Response:**
```json
{
  "success": true,
  "message": "Data sent successfully",
  "response": {
    "status": "received"
  }
}
```

---

## 📊 DATA SYNC API

### 3. Sync Users

**Endpoint:** `GET /api/v1/integration/users`

**Header:**
```
X-API-Key: your-integration-api-key
```

**Query Parameters:**
- `since` (optional): Filter users updated after this date (Y-m-d H:i:s)
- `limit` (optional): Limit results (default: 100)

**Example:**
```
GET /api/v1/integration/users?since=2025-12-01&limit=50
```

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "name": "Budi Santoso",
      "email": "budi@example.com",
      "phone": "081234567890",
      "created_at": "2025-12-01T10:00:00Z"
    }
  ],
  "total": 50
}
```

---

### 4. Sync Orders

**Endpoint:** `GET /api/v1/integration/orders`

**Header:**
```
X-API-Key: your-integration-api-key
```

**Query Parameters:**
- `status` (optional): Filter by status (pending, paid, cancelled)
- `since` (optional): Filter orders created after this date
- `limit` (optional): Limit results (default: 100)

**Example:**
```
GET /api/v1/integration/orders?status=paid&since=2025-12-01&limit=100
```

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "order_number": "ORD-20251208-001",
      "user": {
        "id": 1,
        "name": "Budi Santoso",
        "email": "budi@example.com"
      },
      "program": {
        "id": 1,
        "name": "CPNS & P3K Farmasi",
        "price": 1750000
      },
      "total_price": 1750000,
      "status": "paid",
      "created_at": "2025-12-08T10:00:00Z"
    }
  ],
  "total": 25
}
```

---

### 5. Get Statistics

**Endpoint:** `GET /api/v1/integration/statistics`

**Header:**
```
X-API-Key: your-integration-api-key
```

**Response:**
```json
{
  "success": true,
  "data": {
    "users": {
      "total": 500,
      "active": 450,
      "today": 10
    },
    "orders": {
      "total": 200,
      "pending": 15,
      "paid": 180,
      "revenue": 350000000
    },
    "programs": {
      "total": 5,
      "active": 5
    }
  },
  "generated_at": "2025-12-08T15:30:00Z"
}
```

---

## 📥 DATA RECEIVE API

### 6. Receive Enrollment Data

**Endpoint:** `POST /api/v1/integration/enrollment`

**Header:**
```
X-API-Key: your-integration-api-key
Content-Type: application/json
```

**Request Body:**
```json
{
  "user_email": "budi@example.com",
  "program_slug": "cpns-p3k-farmasi",
  "enrolled_at": "2025-12-08",
  "valid_until": "2026-06-08",
  "status": "active"
}
```

**Response:**
```json
{
  "success": true,
  "message": "Enrollment data received and processed"
}
```

---

### 7. Validate User

**Endpoint:** `POST /api/v1/integration/validate-user`

**Header:**
```
X-API-Key: your-integration-api-key
Content-Type: application/json
```

**Request Body:**
```json
{
  "email": "budi@example.com"
}
```

**Response (User Found):**
```json
{
  "success": true,
  "exists": true,
  "data": {
    "id": 1,
    "name": "Budi Santoso",
    "email": "budi@example.com",
    "phone": "081234567890",
    "verified": true
  }
}
```

**Response (User Not Found):**
```json
{
  "success": false,
  "message": "User not found",
  "exists": false
}
```

---

## 🔧 External API Service

Untuk mengirim data ke proyek lain, gunakan `ExternalApiService`:

```php
use App\Services\ExternalApiService;

$externalApi = new ExternalApiService();

// Send user data
$externalApi->sendUser($user);

// Send order data
$externalApi->sendOrder($order);

// Get data from external project
$data = $externalApi->getData('/api/endpoint');

// Sync enrollment
$externalApi->syncEnrollment($userId, $programId, 'active');

// Verify payment
$result = $externalApi->verifyPayment($transactionId);
```

---

## 📝 Contoh Integrasi

### Contoh 1: Kirim Data User ke Proyek Lain saat Register

```php
// app/Http/Controllers/Api/AuthController.php

use App\Services\ExternalApiService;

public function register(Request $request)
{
    // ... create user ...
    
    // Kirim ke proyek lain
    $externalApi = new ExternalApiService();
    $externalApi->sendUser($user);
    
    return response()->json([
        'success' => true,
        'data' => $user
    ]);
}
```

---

### Contoh 2: Terima Webhook Payment dari Proyek Lain

```php
// Setup webhook di proyek lain untuk kirim ke:
// POST https://bimbelfarmasi.com/api/v1/integration/webhook/external

// Payload yang dikirim:
{
  "event": "payment.success",
  "data": {
    "order_number": "ORD-20251208-001",
    "payment_id": "PAY-123456",
    "amount": 1750000,
    "status": "paid"
  }
}
```

---

### Contoh 3: Sync Users dari BimbelFarmasi ke Proyek Lain

```php
// Di proyek lain (external project)
$response = Http::withHeaders([
    'X-API-Key' => 'your-integration-api-key'
])
->get('https://bimbelfarmasi.com/api/v1/integration/users', [
    'since' => '2025-12-01',
    'limit' => 100
]);

$users = $response->json()['data'];
```

---

## 🔒 Security Best Practices

1. **API Key Protection**
   - Simpan API key di environment variable
   - Jangan commit API key ke repository
   - Rotate API key secara berkala

2. **Webhook Signature Verification**
   - Selalu verify signature untuk webhook
   - Gunakan HMAC SHA256
   - Reject request dengan signature invalid

3. **Rate Limiting**
   - Set rate limit untuk prevent abuse
   - Default: 60 requests/minute untuk integration API

4. **HTTPS Only**
   - Gunakan HTTPS untuk semua integration endpoint
   - Redirect HTTP ke HTTPS di production

5. **IP Whitelist (Optional)**
   - Tambahkan IP whitelist untuk extra security
   - Set di middleware atau firewall

---

## 🧪 Testing Integration

### Test dengan cURL:

```bash
# Test Webhook
curl -X POST https://bimbelfarmasi.com/api/v1/integration/webhook/external \
  -H "X-Webhook-Signature: sha256_hash_here" \
  -H "Content-Type: application/json" \
  -d '{
    "event": "payment.success",
    "data": {"order_number": "ORD-001", "status": "paid"}
  }'

# Test Sync Users
curl -X GET "https://bimbelfarmasi.com/api/v1/integration/users?limit=10" \
  -H "X-API-Key: your-api-key"

# Test Validate User
curl -X POST https://bimbelfarmasi.com/api/v1/integration/validate-user \
  -H "X-API-Key: your-api-key" \
  -H "Content-Type: application/json" \
  -d '{"email": "budi@example.com"}'
```

---

## 📞 Support

Jika ada masalah dengan integrasi:
1. Check logs: `storage/logs/laravel.log`
2. Verify API key di `.env`
3. Test endpoint dengan Postman/cURL
4. Contact technical support

---

**Last Updated:** December 8, 2025  
**Version:** 1.0.0

# 📚 Arsitektur Backend & Frontend - Website Bimbel Farmasi

> Dokumentasi lengkap tentang pembagian tanggung jawab Backend dan Frontend dalam sistem

---

## 🎯 Gambaran Umum Sistem

Website Bimbel Farmasi menggunakan **arsitektur hybrid**:

- **Backend**: Laravel 12 (PHP 8.2+) - Server-side processing
- **Frontend**: Blade Templates + React 18 - Hybrid rendering
- **Database**: MySQL - Data persistence
- **Build Tool**: Vite - Asset bundling & hot reload

---

## 🔴 BACKEND (Server-Side)

### **Teknologi Stack:**

```
- PHP 8.2+
- Laravel Framework 12.x
- MySQL Database
- Composer (Dependency Manager)
- File Cache Driver
- Sanctum (API Authentication)
```

### **📂 Struktur Backend**

#### **1. Controllers - Logika Bisnis Aplikasi**

**Lokasi:** `app/Http/Controllers/`

**A. User-Facing Controllers:**

| Controller                    | Fungsi Utama      | Endpoints                                   |
| ----------------------------- | ----------------- | ------------------------------------------- |
| **AuthController.php**        | Autentikasi user  | Login, Register, Logout, Google OAuth       |
| **UserController.php**        | Manajemen user    | Profil, Layanan, Transaksi, Program Access  |
| **OrderController.php**       | Sistem pemesanan  | Create Order, Payment, Midtrans Integration |
| **ContactController.php**     | Form kontak       | Submit & store messages                     |
| **TestimonialController.php** | Kelola testimoni  | CRUD testimonials                           |
| **HealthCheckController.php** | Monitoring sistem | /ping, /health, /metrics                    |

**B. Admin Controllers:**

| Controller                       | Fungsi Utama          | Fitur                              |
| -------------------------------- | --------------------- | ---------------------------------- |
| **AdminAuthController.php**      | Login admin           | Autentikasi admin panel            |
| **AdminDashboardController.php** | Dashboard stats       | Statistik, charts, caching         |
| **AdminPaymentController.php**   | Verifikasi pembayaran | Approve/Reject payments            |
| **AdminStudentController.php**   | Kelola siswa          | CRUD, Suspend, Bulk delete, Export |
| **AdminProgramController.php**   | Kelola program        | Resource controller (CRUD)         |
| **AdminClassController.php**     | Kelola kelas          | Manage classes & schedules         |

**C. API Controllers:**

| Controller                 | Fungsi           | Response Format     |
| -------------------------- | ---------------- | ------------------- |
| **Api/QuizController.php** | Quiz farmasi API | JSON (10 endpoints) |

**Contoh Logika Backend di OrderController:**

```php
// Generate order number unik
public function store(Request $request) {
    $order = Order::create([
        'order_number' => Order::generateOrderNumber(),
        'user_id' => auth()->id(),
        'program_id' => $request->program_id,
        'total_amount' => $program->price
    ]);

    // Redirect ke halaman pembayaran
    return redirect()->route('order.payment', $order->order_number);
}

// Integrasi Midtrans
public function createSnapToken($orderNumber) {
    $order = Order::where('order_number', $orderNumber)->firstOrFail();

    $params = [
        'transaction_details' => [
            'order_id' => $order->order_number,
            'gross_amount' => $order->total_amount,
        ]
    ];

    $snapToken = \Midtrans\Snap::getSnapToken($params);
    return response()->json(['snap_token' => $snapToken]);
}
```

---

#### **2. Models - Database ORM (Eloquent)**

**Lokasi:** `app/Models/`

| Model                | Tabel Database | Relasi                                     | Fungsi Utama                             |
| -------------------- | -------------- | ------------------------------------------ | ---------------------------------------- |
| **User.php**         | users          | hasMany Orders, Testimonials, QuizAttempts | Data user & admin, autentikasi           |
| **Order.php**        | orders         | belongsTo User, Program; hasOne Payment    | Sistem pemesanan, order_number generator |
| **Payment.php**      | payments       | belongsTo Order                            | Status pembayaran (pending/paid/failed)  |
| **Program.php**      | programs       | hasMany Orders, Testimonials               | Program bimbel (UKOM, CPNS, Joki)        |
| **Course.php**       | courses        | belongsTo User, Order                      | Enrollment kelas                         |
| **Testimonial.php**  | testimonials   | belongsTo User, Program, Order             | Review & rating                          |
| **QuizBank.php**     | quiz_banks     | hasMany QuizQuestions, QuizAttempts        | Bank soal farmasi                        |
| **QuizQuestion.php** | quiz_questions | belongsTo QuizBank                         | 360 soal farmasi                         |
| **QuizAttempt.php**  | quiz_attempts  | belongsTo User, QuizBank                   | Hasil pengerjaan quiz, auto-grading      |

**Contoh Relasi Model:**

```php
// User.php
public function orders() {
    return $this->hasMany(Order::class);
}

public function quizAttempts() {
    return $this->hasMany(QuizAttempt::class);
}

// Order.php
public function generateOrderNumber() {
    return 'ORD-' . date('Ymd') . '-' . strtoupper(Str::random(6));
}

// QuizAttempt.php - Auto grading
public function getGradeAttribute() {
    if ($this->score >= 85) return 'A';
    if ($this->score >= 70) return 'B';
    if ($this->score >= 60) return 'C';
    return 'D';
}
```

---

#### **3. Routes - Routing System**

**Lokasi:** `routes/`

**A. Web Routes (`web.php`)** - 60+ routes:

```php
// PUBLIC ROUTES (7 routes)
Route::view('/', 'pages.home')->name('home');
Route::view('/layanan', 'pages.layanan')->name('layanan');
Route::post('/midtrans/notification', [OrderController::class, 'handleNotification']);

// USER AUTH (4 routes)
Route::get('/login', [AuthController::class, 'showLoginForm']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/login/google', [AuthController::class, 'redirectToGoogle']);
Route::get('/login/google/callback', [AuthController::class, 'handleGoogleCallback']);

// USER PROTECTED (34 routes) - middleware: auth
Route::middleware('auth')->group(function () {
    Route::get('/profil', [UserController::class, 'profile']);
    Route::get('/layanan-saya', [UserController::class, 'myServices']);
    Route::get('/program/{id}', [UserController::class, 'accessProgram']);
    Route::get('/program/{id}/latihan-soal', [UserController::class, 'exercises']);
    Route::post('/order', [OrderController::class, 'store']);
    Route::post('/order/{orderNumber}/payment', [OrderController::class, 'processPayment']);
});

// ADMIN ROUTES (17 routes) - middleware: admin
Route::prefix('admin')->middleware('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index']);
    Route::resource('students', AdminStudentController::class);
    Route::resource('programs', AdminProgramController::class);
    Route::post('/payments/{id}/approve', [AdminPaymentController::class, 'approve']);
});
```

**B. API Routes (`api.php`)** - 10 endpoints:

```php
// Program Info APIs
Route::get('/v1/programs', [Api\ProgramController::class, 'index']);
Route::get('/v1/programs/{slug}', [Api\ProgramController::class, 'show']);

// Quiz System APIs (Sanctum protected)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/v1/quiz-banks', [Api\QuizController::class, 'index']);
    Route::get('/v1/quiz-banks/{id}', [Api\QuizController::class, 'show']);
    Route::post('/v1/quiz-banks/{id}/start', [Api\QuizController::class, 'start']);
    Route::post('/v1/quiz-attempts/{id}/submit', [Api\QuizController::class, 'submit']);
    Route::get('/v1/quiz-attempts/{id}/result', [Api\QuizController::class, 'result']);
});
```

---

#### **4. Database Schema**

**Lokasi:** `database/migrations/`

**12 Tabel Utama:**

| Tabel              | Kolom Penting                                           | Fungsi            |
| ------------------ | ------------------------------------------------------- | ----------------- |
| **users**          | name, email, password, role, status                     | User & admin data |
| **orders**         | order_number, user_id, program_id, status, total_amount | Pemesanan         |
| **payments**       | order_id, payment_method, proof_image, status, paid_at  | Pembayaran        |
| **programs**       | name, slug, price, type, description                    | Program bimbel    |
| **courses**        | user_id, order_id, program_id, status                   | Enrollment        |
| **testimonials**   | user_id, program_id, rating, comment, is_approved       | Review            |
| **quiz_banks**     | title, category, difficulty, total_questions            | Bank soal         |
| **quiz_questions** | quiz_bank_id, question, options, correct_answer         | 360 soal          |
| **quiz_attempts**  | user_id, quiz_bank_id, score, answers, started_at       | Hasil quiz        |

---

#### **5. Middleware & Security**

| Middleware  | Fungsi                   | Lokasi            |
| ----------- | ------------------------ | ----------------- |
| **auth**    | Cek user sudah login     | `web` routes      |
| **admin**   | Cek user role = admin    | `admin` routes    |
| **sanctum** | API token authentication | `api` routes      |
| **csrf**    | CSRF protection          | All POST requests |

---

#### **6. External Integrations**

| Service          | Package                | Fungsi                                |
| ---------------- | ---------------------- | ------------------------------------- |
| **Midtrans**     | midtrans/midtrans-php  | Payment gateway (Snap token, webhook) |
| **Google OAuth** | laravel/socialite      | Login dengan Google                   |
| **Swagger**      | darkaonline/l5-swagger | API documentation                     |

**Contoh Integrasi Midtrans:**

```php
// OrderController.php
use Midtrans\Config;
use Midtrans\Snap;

Config::$serverKey = config('midtrans.server_key');
Config::$isProduction = config('midtrans.is_production');

public function createSnapToken($orderNumber) {
    $order = Order::with('program')->where('order_number', $orderNumber)->firstOrFail();

    $params = [
        'transaction_details' => [
            'order_id' => $order->order_number,
            'gross_amount' => $order->total_amount,
        ],
        'customer_details' => [
            'first_name' => auth()->user()->name,
            'email' => auth()->user()->email,
        ]
    ];

    $snapToken = Snap::getSnapToken($params);
    return response()->json(['snap_token' => $snapToken]);
}

// Webhook handler
public function handleNotification(Request $request) {
    $notification = $request->all();
    $order = Order::where('order_number', $notification['order_id'])->first();

    if ($notification['transaction_status'] == 'settlement') {
        $order->update(['status' => 'paid']);
        $order->payment->update(['status' => 'paid', 'paid_at' => now()]);
    }
}
```

---

#### **7. Caching Strategy**

**File:** `app/Http/Controllers/Admin/AdminDashboardController.php`

```php
// Cache dashboard stats selama 5 menit
$stats = Cache::remember('dashboard_stats', 300, function () {
    return [
        'total_students' => User::where('role', 'user')->count(),
        'total_revenue' => Payment::where('status', 'paid')->sum('amount'),
        'pending_payments' => Payment::where('status', 'pending')->count(),
    ];
});

// Invalidate cache saat ada perubahan
// OrderController.php - updatePaymentStatus()
Cache::forget('dashboard_stats');
Cache::forget('program_distribution');
Cache::forget('monthly_enrollment');
Cache::forget('monthly_revenue');
```

---

## 🔵 FRONTEND (Client-Side)

### **Teknologi Stack:**

```
- Blade Template Engine (Laravel)
- React 18.3.1
- Tailwind CSS 4.0
- Vite 7.0 (Build Tool)
- Axios (HTTP Client)
```

### **📂 Struktur Frontend**

#### **1. Blade Templates - Server-Side Rendering**

**Lokasi:** `resources/views/`

**A. Layouts (Template Dasar):**

| File                        | Fungsi               | Komponen                           |
| --------------------------- | -------------------- | ---------------------------------- |
| **layouts/app.blade.php**   | Layout utama website | Navbar, Footer, Flash messages     |
| **layouts/admin.blade.php** | Layout admin panel   | Sidebar, Admin navbar, Breadcrumbs |

**B. Public Pages (52 files total):**

**Homepage & Landing:**

```
pages/home.blade.php          - Homepage dengan hero, program cards, testimonials
pages/layanan.blade.php       - Daftar semua layanan
pages/bimbel-ukom.blade.php   - Detail program UKOM D3 Farmasi
pages/cpns-p3k.blade.php      - Detail program CPNS & P3K Farmasi
pages/joki-tugas.blade.php    - Layanan Joki Tugas Farmasi
pages/kontak.blade.php        - Halaman kontak dengan form
pages/testimoni.blade.php     - Daftar testimoni approved
```

**Authentication:**

```
pages/login.blade.php         - Form login (email/password + Google OAuth)
pages/register.blade.php      - Form registrasi
```

**User Dashboard:**

```
pages/profile.blade.php           - Profil user (edit nama, email, phone)
pages/my-services.blade.php       - Daftar program yang sudah dibeli
pages/transactions.blade.php      - Riwayat transaksi & pembayaran
pages/settings.blade.php          - Pengaturan akun (change password, delete)
pages/user-dashboard.blade.php    - Dashboard overview user
```

**Order & Payment:**

```
pages/order/create.blade.php   - Form pemesanan program (dengan React OrderForm)
pages/order/payment.blade.php  - Halaman pembayaran (Midtrans Snap + Upload bukti)
pages/order/my-orders.blade.php - Daftar semua pesanan
pages/order/success.blade.php  - Success page setelah pembayaran
```

**Program Access:**

```
pages/program/dashboard.blade.php  - Dashboard program yang dibeli
pages/program/materials.blade.php  - Materi pembelajaran
pages/program/exercises.blade.php  - Latihan soal
pages/program/tryout.blade.php     - Try out simulasi
pages/program/results.blade.php    - Hasil & pembahasan
```

**Testimonials:**

```
pages/testimonials/index.blade.php          - Public testimonials
pages/testimonials/my-testimonials.blade.php - Testimoni user sendiri
pages/testimonials/create.blade.php         - Form buat testimoni
pages/testimonials/edit.blade.php           - Edit testimoni
```

**Admin Panel:**

```
admin/login.blade.php              - Login admin (password toggle, session handling)
admin/dashboard.blade.php          - Dashboard stats, charts
admin/students/index.blade.php     - Data siswa (table, filter, export)
admin/students/show.blade.php      - Detail siswa & progress
admin/payments/index.blade.php     - List pembayaran pending
admin/payments/show.blade.php      - Detail pembayaran + bukti transfer
admin/programs/index.blade.php     - Kelola program
admin/programs/form.blade.php      - Form CRUD program
admin/classes/index.blade.php      - Kelola kelas
admin/questions/index.blade.php    - Bank soal
```

**Contoh Blade Template:**

```blade
{{-- layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Bimbel Farmasi')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    @include('partials.navbar')

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @yield('content')

    @include('partials.footer')
</body>
</html>

{{-- pages/home.blade.php --}}
@extends('layouts.app')

@section('content')
    {{-- React Hero Component --}}
    <div data-component="Hero" data-props='{"title": "Bimbel Farmasi Terpercaya"}'></div>

    {{-- Program Cards --}}
    <section class="programs">
        @foreach($programs as $program)
            <div data-component="ProgramCard"
                 data-props='@json($program)'></div>
        @endforeach
    </section>

    {{-- Testimonial Slider --}}
    <div data-component="TestimonialSlider"
         data-props='{"testimonials": @json($testimonials)}'></div>
@endsection
```

---

#### **2. React Components - Interactive UI**

**Lokasi:** `resources/js/components/`

**Component Registry:**

| Component                 | Fungsi                 | Props                    | Usage                     |
| ------------------------- | ---------------------- | ------------------------ | ------------------------- |
| **Hero.jsx**              | Hero section homepage  | title, subtitle, cta     | Homepage banner           |
| **ProgramCard.jsx**       | Card program bimbel    | name, price, image, slug | Daftar program            |
| **TestimonialSlider.jsx** | Carousel testimoni     | testimonials[]           | Homepage & testimoni page |
| **ContactForm.jsx**       | Form kontak interaktif | none                     | Halaman kontak            |
| **OrderForm.jsx**         | Form pemesanan         | programId, price         | Order creation            |

**Auto-Mounting System:**

```javascript
// app.jsx
import React from 'react';
import { createRoot } from 'react-dom/client';

const COMPONENTS = {
  Hero,
  ProgramCard,
  TestimonialSlider,
  ContactForm,
  OrderForm,
};

function mountReactComponents() {
  document.querySelectorAll('[data-component]').forEach((container) => {
    const componentName = container.getAttribute('data-component');
    const Component = COMPONENTS[componentName];

    // Parse props dari data-props attribute
    let props = {};
    try {
      const propsAttr = container.getAttribute('data-props');
      props = propsAttr ? JSON.parse(propsAttr) : {};
    } catch (error) {
      console.error('Failed to parse props:', error);
    }

    // Mount component
    const root = createRoot(container);
    root.render(<Component {...props} />);
  });
}

// Auto-mount saat DOM ready
document.addEventListener('DOMContentLoaded', mountReactComponents);
```

**Contoh React Component:**

```jsx
// OrderForm.jsx
import React, { useState } from 'react';
import axios from 'axios';

export default function OrderForm({ programId, programName, price }) {
  const [loading, setLoading] = useState(false);
  const [notes, setNotes] = useState('');

  const handleSubmit = async (e) => {
    e.preventDefault();
    setLoading(true);

    try {
      const response = await axios.post('/order', {
        program_id: programId,
        notes: notes,
      });

      // Redirect ke payment page
      window.location.href = response.data.payment_url;
    } catch (error) {
      alert('Gagal membuat pesanan: ' + error.response.data.message);
    } finally {
      setLoading(false);
    }
  };

  return (
    <form onSubmit={handleSubmit} className="order-form">
      <h3>{programName}</h3>
      <p className="price">Rp {price.toLocaleString('id-ID')}</p>

      <textarea
        value={notes}
        onChange={(e) => setNotes(e.target.value)}
        placeholder="Catatan tambahan (opsional)"
        className="form-control"
      />

      <button type="submit" disabled={loading}>
        {loading ? 'Memproses...' : 'Beli Sekarang'}
      </button>
    </form>
  );
}
```

---

#### **3. CSS & Styling - Tailwind CSS**

**Lokasi:** `resources/css/app.css`

```css
@import 'tailwindcss';

/* Custom Tailwind Components */
@layer components {
  .btn-primary {
    @apply bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition;
  }

  .card {
    @apply bg-white shadow-lg rounded-lg p-6;
  }

  .form-control {
    @apply w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500;
  }
}
```

**Tailwind Config:**

```javascript
// tailwind.config.js
export default {
  content: ['./resources/**/*.blade.php', './resources/**/*.js', './resources/**/*.jsx'],
  theme: {
    extend: {
      colors: {
        primary: '#3B82F6',
        secondary: '#10B981',
      },
    },
  },
};
```

---

#### **4. Build Configuration - Vite**

**Lokasi:** `vite.config.js`

```javascript
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
  plugins: [
    laravel({
      input: ['resources/css/app.css', 'resources/js/app.js', 'resources/js/app.jsx'],
      refresh: true, // Hot reload
    }),
    react(),
    tailwindcss(),
  ],
});
```

**Build Commands:**

```bash
npm run dev    # Development dengan hot reload
npm run build  # Production build (minified)
```

---

#### **5. Client-Side JavaScript**

**Lokasi:** `resources/js/`

**A. Bootstrap & Axios Setup:**

```javascript
// bootstrap.js
import axios from 'axios';

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// CSRF Token untuk semua request
let token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
  window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
}
```

**B. Shared Components:**

```
components/shared/
    ├── Button.jsx       - Reusable button
    ├── Input.jsx        - Form input component
    ├── Modal.jsx        - Modal dialog
    ├── Card.jsx         - Card container
    └── Spinner.jsx      - Loading spinner
```

---

## 📊 KONTRIBUSI & TANGGUNG JAWAB

### **🔴 Backend Bertanggung Jawab Atas:**

| No  | Tanggung Jawab                     | Implementasi                                       | File/Lokasi                                       |
| --- | ---------------------------------- | -------------------------------------------------- | ------------------------------------------------- |
| 1   | **Authentication & Authorization** | Login, Register, Google OAuth, Session, Middleware | AuthController, User model, auth/admin middleware |
| 2   | **Database Operations**            | CRUD, Relationships, Migrations, Seeders           | Models, migrations/, seeders/                     |
| 3   | **Business Logic**                 | Order processing, Payment flow, Quiz grading       | OrderController, QuizAttempt model                |
| 4   | **Payment Gateway Integration**    | Midtrans Snap token, Webhook handling              | OrderController, Payment model                    |
| 5   | **File Upload & Storage**          | Bukti pembayaran, Profile photos                   | OrderController (processPayment)                  |
| 6   | **Email Notifications**            | Order confirmation, Payment status                 | Mail config, Notifications                        |
| 7   | **Caching**                        | Dashboard stats, Program data                      | AdminDashboardController, Cache facade            |
| 8   | **API Development**                | RESTful endpoints, JSON responses                  | Api/QuizController, api.php routes                |
| 9   | **Data Validation**                | Form validation, Request validation                | FormRequests, Controller validation               |
| 10  | **Security**                       | CSRF protection, SQL injection prevention, XSS     | Middleware, Eloquent ORM                          |
| 11  | **Monitoring & Logging**           | Health checks, Error logging                       | HealthCheckController, logs/                      |
| 12  | **Session Management**             | User sessions, Admin sessions                      | Session driver, middleware                        |

**Contoh Flow Backend - Pemesanan:**

```
1. User submit OrderForm (React)
   ↓
2. POST /order → OrderController@store
   ↓
3. Validasi: program_id ada? User authenticated?
   ↓
4. Generate order_number: ORD-20251204-ABC123
   ↓
5. Insert ke database orders table
   ↓
6. Create payment record (status: pending)
   ↓
7. Invalidate cache: dashboard_stats
   ↓
8. Redirect: /order/ORD-20251204-ABC123/payment
   ↓
9. Load payment page → Create Midtrans Snap token
   ↓
10. Return snap_token ke frontend
```

---

### **🔵 Frontend Bertanggung Jawab Atas:**

| No  | Tanggung Jawab             | Implementasi                           | File/Lokasi                           |
| --- | -------------------------- | -------------------------------------- | ------------------------------------- |
| 1   | **User Interface (UI)**    | Layout, Pages, Components              | 52 Blade files, React components      |
| 2   | **User Experience (UX)**   | Navigation, Forms, Feedback            | Navbar, breadcrumbs, flash messages   |
| 3   | **Responsive Design**      | Mobile, Tablet, Desktop                | Tailwind CSS responsive classes       |
| 4   | **Client-Side Validation** | Form validation before submit          | React state, HTML5 validation         |
| 5   | **Interactive Elements**   | Sliders, Modals, Dropdowns             | React components (Testimonial Slider) |
| 6   | **AJAX Requests**          | Async data fetch tanpa reload          | Axios, fetch API                      |
| 7   | **Dynamic Rendering**      | Conditional rendering, Loops           | Blade directives (@if, @foreach)      |
| 8   | **Payment UI**             | Midtrans Snap integration              | payment.blade.php, Snap.js            |
| 9   | **Real-time Updates**      | Hot reload saat development            | Vite HMR                              |
| 10  | **SEO Optimization**       | Meta tags, Semantic HTML               | Blade layouts, @section               |
| 11  | **Accessibility**          | ARIA labels, Form labels, Keyboard nav | HTML attributes, semantic tags        |
| 12  | **Asset Management**       | CSS/JS bundling, Minification          | Vite build process                    |

**Contoh Flow Frontend - Pembayaran:**

```
1. User klik "Bayar" di payment.blade.php
   ↓
2. JavaScript: Load Midtrans Snap library
   ↓
3. AJAX GET /order/{orderNumber}/snap-token
   ↓
4. Terima snap_token dari backend
   ↓
5. window.snap.pay(snapToken, {
       onSuccess: redirect ke /order/{orderNumber}/success,
       onPending: show "Menunggu pembayaran",
       onError: show error message
   })
   ↓
6. Midtrans modal muncul (iframe)
   ↓
7. User pilih metode bayar & bayar
   ↓
8. Midtrans webhook ke backend → Update status
   ↓
9. Frontend redirect ke success page
   ↓
10. Tampilkan konfirmasi pesanan
```

---

## 🔄 INTERAKSI BACKEND ↔ FRONTEND

### **Alur Data Complete:**

```
┌─────────────────────────────────────────────────────────────────┐
│                         USER ACTION                              │
│                    (Click, Submit, Type)                         │
└────────────────────────────┬────────────────────────────────────┘
                             │
                             ▼
┌─────────────────────────────────────────────────────────────────┐
│                  FRONTEND (Blade/React)                          │
│  • Tampilkan form/button                                         │
│  • Validasi client-side                                          │
│  • Trigger HTTP request (GET/POST/PUT/DELETE)                    │
└────────────────────────────┬────────────────────────────────────┘
                             │
                             ▼
┌─────────────────────────────────────────────────────────────────┐
│                    HTTP REQUEST                                  │
│  Method: POST /order                                             │
│  Headers: X-CSRF-TOKEN, Content-Type                             │
│  Body: { program_id: 1, notes: "..." }                          │
└────────────────────────────┬────────────────────────────────────┘
                             │
                             ▼
┌─────────────────────────────────────────────────────────────────┐
│                    ROUTES (web.php)                              │
│  Route::post('/order', [OrderController::class, 'store'])        │
│  Middleware: auth, csrf                                          │
└────────────────────────────┬────────────────────────────────────┘
                             │
                             ▼
┌─────────────────────────────────────────────────────────────────┐
│              CONTROLLER (OrderController@store)                  │
│  1. Validasi request (required fields)                           │
│  2. Cek authorization (auth()->check())                          │
│  3. Business logic (generate order_number)                       │
│  4. Panggil Model untuk simpan data                              │
└────────────────────────────┬────────────────────────────────────┘
                             │
                             ▼
┌─────────────────────────────────────────────────────────────────┐
│                    MODEL (Order::create)                         │
│  1. Build SQL query (Eloquent)                                   │
│  2. Execute query                                                │
│  3. Return Model instance                                        │
└────────────────────────────┬────────────────────────────────────┘
                             │
                             ▼
┌─────────────────────────────────────────────────────────────────┐
│                    DATABASE (MySQL)                              │
│  INSERT INTO orders (order_number, user_id, ...) VALUES (...)   │
└────────────────────────────┬────────────────────────────────────┘
                             │
                             ▼
┌─────────────────────────────────────────────────────────────────┐
│              CONTROLLER (Lanjutan)                               │
│  5. Invalidate cache                                             │
│  6. Generate response (redirect/json)                            │
└────────────────────────────┬────────────────────────────────────┘
                             │
                             ▼
┌─────────────────────────────────────────────────────────────────┐
│                    HTTP RESPONSE                                 │
│  Status: 302 Redirect                                            │
│  Location: /order/ORD-20251204-ABC123/payment                    │
│  atau                                                            │
│  Status: 200 OK                                                  │
│  Content-Type: application/json                                  │
│  Body: { success: true, order_number: "..." }                   │
└────────────────────────────┬────────────────────────────────────┘
                             │
                             ▼
┌─────────────────────────────────────────────────────────────────┐
│              FRONTEND (Handle Response)                          │
│  • Redirect ke halaman baru                                      │
│  • Update UI (React state)                                       │
│  • Tampilkan success/error message                               │
│  • Vite hot reload (development)                                 │
└────────────────────────────┬────────────────────────────────────┘
                             │
                             ▼
┌─────────────────────────────────────────────────────────────────┐
│                    USER SEES RESULT                              │
│  • Payment page dengan Midtrans Snap                             │
│  • Success message                                               │
│  • Updated data di table                                         │
└─────────────────────────────────────────────────────────────────┘
```

---

## 🎯 CONTOH KASUS LENGKAP

### **Use Case: User Membeli Program UKOM**

#### **1. Frontend - Blade Template (`pages/bimbel-ukom.blade.php`)**

```blade
@extends('layouts.app')

@section('content')
<div class="program-detail">
    <h1>{{ $program->name }}</h1>
    <p>{{ $program->description }}</p>
    <p class="price">Rp {{ number_format($program->price, 0, ',', '.') }}</p>

    @auth
        {{-- React OrderForm Component --}}
        <div data-component="OrderForm"
             data-props='{
                 "programId": {{ $program->id }},
                 "programName": "{{ $program->name }}",
                 "price": {{ $program->price }}
             }'>
        </div>
    @else
        <a href="{{ route('login') }}" class="btn-primary">
            Login untuk Membeli
        </a>
    @endauth
</div>
@endsection
```

#### **2. Frontend - React Component (`OrderForm.jsx`)**

```jsx
import React, { useState } from 'react';
import axios from 'axios';

export default function OrderForm({ programId, programName, price }) {
  const [loading, setLoading] = useState(false);
  const [notes, setNotes] = useState('');
  const [error, setError] = useState('');

  const handleSubmit = async (e) => {
    e.preventDefault();
    setLoading(true);
    setError('');

    try {
      const response = await axios.post('/order', {
        program_id: programId,
        notes: notes,
      });

      // Redirect ke payment
      window.location.href = `/order/${response.data.order_number}/payment`;
    } catch (err) {
      setError(err.response?.data?.message || 'Gagal membuat pesanan');
    } finally {
      setLoading(false);
    }
  };

  return (
    <form onSubmit={handleSubmit} className="space-y-4">
      <div>
        <label className="block mb-2">Program</label>
        <input type="text" value={programName} disabled className="form-control bg-gray-100" />
      </div>

      <div>
        <label className="block mb-2">Harga</label>
        <input
          type="text"
          value={`Rp ${price.toLocaleString('id-ID')}`}
          disabled
          className="form-control bg-gray-100"
        />
      </div>

      <div>
        <label htmlFor="notes" className="block mb-2">
          Catatan (Opsional)
        </label>
        <textarea
          id="notes"
          value={notes}
          onChange={(e) => setNotes(e.target.value)}
          placeholder="Tulis catatan tambahan..."
          className="form-control"
          rows="3"
        />
      </div>

      {error && <div className="bg-red-100 text-red-700 p-3 rounded">{error}</div>}

      <button type="submit" disabled={loading} className="btn-primary w-full disabled:opacity-50">
        {loading ? 'Memproses...' : 'Beli Sekarang'}
      </button>
    </form>
  );
}
```

#### **3. Backend - Route (`routes/web.php`)**

```php
Route::middleware('auth')->group(function () {
    Route::post('/order', [OrderController::class, 'store'])->name('order.store');
});
```

#### **4. Backend - Controller (`OrderController.php`)**

```php
namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class OrderController extends Controller
{
    /**
     * Buat pesanan baru
     */
    public function store(Request $request)
    {
        // 1. Validasi input
        $validated = $request->validate([
            'program_id' => 'required|exists:programs,id',
            'notes' => 'nullable|string|max:500',
        ]);

        // 2. Ambil data program
        $program = Program::findOrFail($validated['program_id']);

        // 3. Cek apakah user sudah punya order aktif untuk program ini
        $existingOrder = Order::where('user_id', auth()->id())
            ->where('program_id', $program->id)
            ->whereIn('status', ['pending', 'processing', 'completed'])
            ->first();

        if ($existingOrder) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah memiliki pesanan aktif untuk program ini'
            ], 400);
        }

        // 4. Buat pesanan baru
        $order = Order::create([
            'order_number' => $this->generateOrderNumber(),
            'user_id' => auth()->id(),
            'program_id' => $program->id,
            'total_amount' => $program->price,
            'status' => 'pending',
            'notes' => $validated['notes'] ?? null,
        ]);

        // 5. Buat record pembayaran
        $order->payment()->create([
            'amount' => $program->price,
            'payment_method' => null,
            'status' => 'pending',
        ]);

        // 6. Invalidate cache dashboard
        Cache::forget('dashboard_stats');
        Cache::forget('program_distribution');

        // 7. Return response
        return response()->json([
            'success' => true,
            'message' => 'Pesanan berhasil dibuat',
            'order_number' => $order->order_number,
        ]);
    }

    /**
     * Generate order number unik
     */
    private function generateOrderNumber()
    {
        do {
            $orderNumber = 'ORD-' . date('Ymd') . '-' . strtoupper(substr(md5(uniqid()), 0, 6));
        } while (Order::where('order_number', $orderNumber)->exists());

        return $orderNumber;
    }
}
```

#### **5. Backend - Model (`Order.php`)**

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'user_id',
        'program_id',
        'total_amount',
        'status',
        'notes',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Program
    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    // Relasi ke Payment (1-to-1)
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
```

#### **6. Database - Migration**

```php
Schema::create('orders', function (Blueprint $table) {
    $table->id();
    $table->string('order_number')->unique();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->foreignId('program_id')->constrained()->onDelete('restrict');
    $table->decimal('total_amount', 10, 2);
    $table->enum('status', ['pending', 'processing', 'completed', 'cancelled'])->default('pending');
    $table->text('notes')->nullable();
    $table->timestamps();
});
```

#### **7. Frontend - Payment Page (`payment.blade.php`)**

```blade
@extends('layouts.app')

@section('content')
<div class="payment-container">
    <h2>Pembayaran Order #{{ $order->order_number }}</h2>

    <div class="order-summary">
        <h3>{{ $order->program->name }}</h3>
        <p class="amount">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
    </div>

    {{-- Midtrans Snap Payment --}}
    <button id="pay-button" class="btn-primary">
        Bayar dengan Midtrans
    </button>

    {{-- Upload Bukti Transfer --}}
    <form action="{{ route('order.payment.process', $order->order_number) }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf
        <select name="payment_method" required>
            <option value="">Pilih Bank</option>
            <option value="bca">BCA</option>
            <option value="mandiri">Mandiri</option>
            <option value="bni">BNI</option>
        </select>

        <input type="file" name="proof_image" accept="image/*" required>
        <button type="submit">Upload Bukti Bayar</button>
    </form>
</div>

@push('scripts')
<script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    document.getElementById('pay-button').addEventListener('click', async () => {
        // Ambil snap token dari backend
        const response = await fetch('/order/{{ $order->order_number }}/snap-token');
        const data = await response.json();

        // Panggil Midtrans Snap
        window.snap.pay(data.snap_token, {
            onSuccess: function(result) {
                window.location.href = '/order/{{ $order->order_number }}/success';
            },
            onPending: function(result) {
                alert('Menunggu pembayaran...');
            },
            onError: function(result) {
                alert('Pembayaran gagal!');
            }
        });
    });
</script>
@endpush
@endsection
```

---

## 📈 SUMMARY

### **Hybrid Architecture Benefits:**

| Aspek                 | Blade (SSR)  | React (CSR)  | Hybrid       |
| --------------------- | ------------ | ------------ | ------------ |
| **SEO**               | ✅ Excellent | ❌ Poor      | ✅ Excellent |
| **Initial Load**      | ✅ Fast      | ❌ Slow      | ✅ Fast      |
| **Interactivity**     | ❌ Limited   | ✅ Excellent | ✅ Excellent |
| **Development Speed** | ✅ Fast      | ❌ Complex   | ⚡ Balanced  |
| **Maintenance**       | ✅ Easy      | ❌ Complex   | ⚡ Moderate  |

### **Pembagian Kerja Ideal:**

**Backend Developer:**

- Setup Laravel, database, migrations
- Buat Models dengan relasi
- Implementasi Controllers & business logic
- API development & documentation
- Security & authentication
- Integrasi payment gateway
- Caching & optimization

**Frontend Developer:**

- Design UI/UX dengan Tailwind
- Buat Blade layouts & pages
- Develop React components
- AJAX handling dengan Axios
- Form validation
- Responsive design
- Asset optimization dengan Vite

**Full-Stack Developer:**

- Integrasi backend ↔ frontend
- Testing end-to-end
- Deployment & DevOps
- Performance monitoring
- Bug fixing

---

## 🚀 Kesimpulan

Website **Bimbel Farmasi** menggunakan **modern full-stack architecture** yang menggabungkan:

1. **Backend (Laravel)** - Robust, secure, scalable
2. **Frontend (Blade + React)** - Fast, interactive, SEO-friendly
3. **Database (MySQL)** - Relational data with Eloquent ORM
4. **Build Tool (Vite)** - Fast development & optimized production

Arsitektur ini memberikan:

- ⚡ **Performance** - SSR untuk halaman statis, CSR untuk interaktivity
- 🔒 **Security** - CSRF, XSS protection, middleware authorization
- 📱 **Responsive** - Mobile-first design dengan Tailwind
- 🎯 **SEO Optimized** - Server-side rendering untuk Google indexing
- 🔧 **Maintainable** - Clear separation of concerns (MVC pattern)

---

**Dokumentasi dibuat:** 4 Desember 2025
**Framework:** Laravel 12 + React 18 + Tailwind CSS 4

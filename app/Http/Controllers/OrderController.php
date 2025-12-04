<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Midtrans\Config;
use Midtrans\Snap;

class OrderController extends Controller
{
    /**
     * Tampilkan halaman form pemesanan program
     * @param string $slug - Slug program yang akan dipesan
     * @return view dengan data program
     */
    public function create($slug)
    {
        $program = Program::where('slug', $slug)->where('is_active', true)->firstOrFail();
        
        return view('pages.order.create', compact('program'));
    }

    /**
     * Simpan pesanan baru ke database
     * Proses: Validasi -> Buat order -> Redirect ke halaman pembayaran
     * @param Request - program_id, notes (opsional)
     * @return redirect ke halaman payment
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'program_id' => ['required', 'exists:programs,id'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        $program = Program::findOrFail($validated['program_id']);

        // Buat pesanan baru dengan nomor pesanan otomatis
        $order = Order::create([
            'order_number' => Order::generateOrderNumber(),
            'user_id' => Auth::id(),
            'program_id' => $program->id,
            'amount' => $program->price,
            'status' => 'pending',
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('order.payment', $order->order_number)
            ->with('success', 'Order berhasil dibuat! Silakan pilih metode pembayaran.');
    }

    /**
     * Tampilkan halaman pembayaran
     * Cek: Jika sudah bayar -> redirect ke success
     * @param string $orderNumber - Nomor pesanan
     * @return view halaman pembayaran dengan metode Midtrans/Manual
     */
    public function payment($orderNumber)
    {
        $order = Order::with('program')
            ->where('order_number', $orderNumber)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Redirect jika sudah dibayar
        if ($order->payment && $order->payment->status === 'paid') {
            return redirect()->route('order.success', $orderNumber);
        }

        return view('pages.order.payment', compact('order'));
    }

    /**
     * Proses upload bukti pembayaran manual (Transfer Bank/E-Wallet/QRIS)
     * Flow: Validasi -> Upload gambar -> Simpan ke database -> Update status order
     * @param Request - payment_method, proof (file gambar)
     * @param string $orderNumber - Nomor pesanan
     * @return redirect ke success page atau error
     */
    public function processPayment(Request $request, $orderNumber)
    {
        try {
            $order = Order::where('order_number', $orderNumber)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            $validated = $request->validate([
                'payment_method' => ['required', 'in:bank_transfer,ewallet,qris'],
                'proof' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'], // 2MB max
            ], [
                'payment_method.required' => 'Metode pembayaran wajib dipilih.',
                'proof.required' => 'Bukti pembayaran wajib diupload.',
                'proof.image' => 'File harus berupa gambar.',
                'proof.mimes' => 'File harus berformat JPEG, PNG, atau JPG.',
                'proof.max' => 'Ukuran file maksimal 2MB.',
            ]);

            // Upload proof
            $proofPath = $request->file('proof')->store('payment-proofs', 'public');

            // Create or update payment
            Payment::updateOrCreate(
                ['order_id' => $order->id],
                [
                    'payment_method' => $validated['payment_method'],
                    'amount' => $order->amount,
                    'status' => 'pending',
                    'proof_url' => $proofPath,
                ]
            );

            // Update order status
            $order->update(['status' => 'waiting_verification']);

            return redirect()->route('order.success', $orderNumber)
                ->with('success', 'Bukti pembayaran berhasil diupload! Kami akan memverifikasi dalam 1x24 jam.');
                
        } catch (\Exception $e) {
            Log::error('Payment upload error: ' . $e->getMessage());
            
            return back()
                ->withInput()
                ->with('error', 'Gagal mengupload bukti pembayaran. Pastikan MySQL/XAMPP sudah running. Error: ' . $e->getMessage());
        }
    }

    /**
     * Tampilkan halaman sukses setelah pembayaran
     * Menampilkan informasi pesanan dan status pembayaran
     * @param string $orderNumber - Nomor pesanan
     * @return view halaman success
     */
    public function success($orderNumber)
    {
        $order = Order::with(['program', 'payment'])
            ->where('order_number', $orderNumber)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('pages.order.success', compact('order'));
    }

    /**
     * Tampilkan daftar semua pesanan user
     * Filter: Hanya pesanan yang sudah ada bukti pembayarannya
     * @return view dengan list pesanan (diurutkan dari terbaru)
     */
    public function myOrders()
    {
        // Hanya tampilkan pesanan yang sudah upload bukti pembayaran
        $orders = Order::with(['program', 'payment'])
            ->where('user_id', Auth::id())
            ->whereHas('payment') // Wajib punya payment record
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages.order.my-orders', compact('orders'));
    }

    /**
     * Generate Midtrans Snap Token untuk pembayaran online
     * Snap Token digunakan oleh frontend untuk menampilkan popup pembayaran Midtrans
     * @param string $orderNumber - Nomor pesanan
     * @return JSON dengan snap_token untuk Midtrans popup
     */
    public function createSnapToken($orderNumber)
    {
        try {
            $order = Order::with('program', 'user')
                ->where('order_number', $orderNumber)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            // Configure Midtrans
            Config::$serverKey = config('midtrans.server_key');
            Config::$isProduction = config('midtrans.is_production');
            Config::$isSanitized = config('midtrans.is_sanitized');
            Config::$is3ds = config('midtrans.is_3ds');

            // Create transaction details
            $params = [
                'transaction_details' => [
                    'order_id' => $order->order_number,
                    'gross_amount' => (int) $order->amount,
                ],
                'customer_details' => [
                    'first_name' => $order->user->name,
                    'email' => $order->user->email,
                    'phone' => $order->user->phone ?? '',
                ],
                'item_details' => [
                    [
                        'id' => $order->program->id,
                        'price' => (int) $order->amount,
                        'quantity' => 1,
                        'name' => $order->program->name,
                    ]
                ],
            ];

            // Get Snap Token
            $snapToken = Snap::getSnapToken($params);

            return response()->json([
                'snap_token' => $snapToken,
                'order_number' => $order->order_number,
            ]);

        } catch (\Exception $e) {
            Log::error('Midtrans Snap Token Error: ' . $e->getMessage());
            
            return response()->json([
                'error' => 'Gagal membuat token pembayaran: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Handle webhook notification dari Midtrans (dipanggil otomatis oleh Midtrans server)
     * Fungsi: Update status pembayaran berdasarkan notifikasi dari Midtrans
     * Status: capture/settlement=paid, pending=pending, deny/expire/cancel=failed
     * @param Request - Otomatis dari Midtrans (order_id, transaction_status, fraud_status)
     * @return JSON response untuk Midtrans
     */
    public function handleNotification(Request $request)
    {
        try {
            // Configure Midtrans
            Config::$serverKey = config('midtrans.server_key');
            Config::$isProduction = config('midtrans.is_production');

            $notification = new \Midtrans\Notification();

            $orderNumber = $notification->order_id;
            $transactionStatus = $notification->transaction_status;
            $fraudStatus = $notification->fraud_status;

            Log::info('Midtrans Notification: ', [
                'order_number' => $orderNumber,
                'transaction_status' => $transactionStatus,
                'fraud_status' => $fraudStatus,
            ]);

            $order = Order::where('order_number', $orderNumber)->firstOrFail();

            // Handle transaction status
            if ($transactionStatus == 'capture') {
                if ($fraudStatus == 'accept') {
                    $this->updatePaymentStatus($order, 'paid');
                }
            } elseif ($transactionStatus == 'settlement') {
                $this->updatePaymentStatus($order, 'paid');
            } elseif ($transactionStatus == 'pending') {
                $this->updatePaymentStatus($order, 'pending');
            } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
                $this->updatePaymentStatus($order, 'failed');
            }

            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            Log::error('Midtrans Notification Error: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Cek status pembayaran ke Midtrans API (dipanggil dari frontend setelah user selesai bayar)
     * Fungsi: Verifikasi real-time status pembayaran ke server Midtrans
     * @param string $orderNumber - Nomor pesanan
     * @return JSON dengan transaction_status dan payment_status
     */
    public function checkPaymentStatus($orderNumber)
    {
        try {
            $order = Order::where('order_number', $orderNumber)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            // Configure Midtrans
            Config::$serverKey = config('midtrans.server_key');
            Config::$isProduction = config('midtrans.is_production');

            // Get transaction status from Midtrans
            $status = \Midtrans\Transaction::status($orderNumber);

            $transactionStatus = $status->transaction_status;
            $fraudStatus = $status->fraud_status ?? null;

            Log::info('Payment Status Check: ', [
                'order_number' => $orderNumber,
                'transaction_status' => $transactionStatus,
                'fraud_status' => $fraudStatus,
            ]);

            // Update payment status based on transaction status
            if ($transactionStatus == 'capture') {
                if ($fraudStatus == 'accept') {
                    $this->updatePaymentStatus($order, 'paid');
                }
            } elseif ($transactionStatus == 'settlement') {
                $this->updatePaymentStatus($order, 'paid');
            } elseif ($transactionStatus == 'pending') {
                $this->updatePaymentStatus($order, 'pending');
            } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
                $this->updatePaymentStatus($order, 'failed');
            }

            return response()->json([
                'status' => 'success',
                'transaction_status' => $transactionStatus,
                'payment_status' => $order->fresh()->payment->status ?? 'pending'
            ]);

        } catch (\Exception $e) {
            Log::error('Payment Status Check Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Helper function - Update status pembayaran dan pesanan
     * Logic: paid->processing, failed->cancelled, invalidate cache
     * @param Order $order - Object pesanan
     * @param string $status - Status baru (paid, pending, failed)
     */
    private function updatePaymentStatus($order, $status)
    {
        Payment::updateOrCreate(
            ['order_id' => $order->id],
            [
                'payment_method' => 'midtrans',
                'amount' => $order->amount,
                'status' => $status,
                'paid_at' => $status === 'paid' ? now() : null,
            ]
        );

        if ($status === 'paid') {
            $order->update(['status' => 'processing']);
        } elseif ($status === 'failed') {
            $order->update(['status' => 'cancelled']);
        }

        // Invalidate dashboard cache when payment status changes
        Cache::forget('dashboard_stats_' . \Carbon\Carbon::now()->format('YmdHi'));
        Cache::forget('program_distribution');
        Cache::forget('monthly_enrollment');
        Cache::forget('monthly_revenue');
    }
}

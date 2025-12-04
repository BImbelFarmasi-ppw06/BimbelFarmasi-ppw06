<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminPaymentController extends Controller
{
    /**
     * Display list of all payments
     */
    public function index(Request $request)
    {
        $query = Payment::with(['order.user', 'order.program'])
            ->orderBy('created_at', 'desc');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $payments = $query->paginate(20);

        // Statistics
        $stats = [
            'pending' => Payment::where('status', 'pending')->count(),
            'pending_amount' => Payment::where('status', 'pending')->sum('amount'),
            'confirmed_this_month' => Payment::where('status', 'paid')
                ->whereMonth('paid_at', now()->month)
                ->count(),
            'confirmed_amount_this_month' => Payment::where('status', 'paid')
                ->whereMonth('paid_at', now()->month)
                ->sum('amount'),
            'total_revenue' => Payment::where('status', 'paid')->sum('amount'),
        ];

        return view('admin.payments.index', compact('payments', 'stats'));
    }

    /**
     * Show payment detail with proof
     */
    public function show($id)
    {
        $payment = Payment::with(['order.user', 'order.program'])->findOrFail($id);

        // If it's an AJAX request, return modal view
        if (request()->ajax() || request()->wantsJson()) {
            return view('admin.payments.modal', compact('payment'))->render();
        }

        return view('admin.payments.show', compact('payment'));
    }

    /**
     * Approve payment
     */
    public function approve(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $payment = Payment::findOrFail($id);

            // Validate payment is still pending
            if ($payment->status !== 'pending') {
                return back()->with('error', 'Pembayaran sudah diproses sebelumnya.');
            }

            // Update payment status
            $payment->update([
                'status' => 'paid',
                'paid_at' => now(),
                'notes' => $request->input('notes', 'Pembayaran diverifikasi oleh admin'),
            ]);

            // Update order status
            $payment->order->update([
                'status' => 'processing',
            ]);

            DB::commit();

            return redirect()->route('admin.payments.index')->with('success', 'Pembayaran berhasil dikonfirmasi! Order #' . $payment->order->order_number . ' sekarang dalam status processing.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Payment approval failed', [
                'payment_id' => $id,
                'admin_id' => auth()->id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Gagal mengonfirmasi pembayaran. Silakan coba lagi.');
        }
    }

    /**
     * Reject payment
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'reason' => ['required', 'string', 'max:500'],
        ], [
            'reason.required' => 'Alasan penolakan wajib diisi.',
            'reason.max' => 'Alasan maksimal 500 karakter.',
        ]);

        try {
            DB::beginTransaction();

            $payment = Payment::findOrFail($id);

            // Validate payment is still pending
            if ($payment->status !== 'pending') {
                return back()->with('error', 'Pembayaran sudah diproses sebelumnya.');
            }

            // Update payment status
            $payment->update([
                'status' => 'rejected',
                'notes' => $request->reason,
            ]);

            // Update order status
            $payment->order->update([
                'status' => 'cancelled',
            ]);

            DB::commit();

            return back()->with('success', 'Pembayaran berhasil ditolak. User perlu upload ulang bukti pembayaran.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Payment rejection failed', [
                'payment_id' => $id,
                'admin_id' => auth()->id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Gagal menolak pembayaran. Silakan coba lagi.');
        }
    }

    /**
     * View payment proof image (admin only)
     */
    public function viewProof($id)
    {
        // Authorization check happens via admin auth middleware in route
        $payment = Payment::findOrFail($id);

        if (!$payment->proof_url) {
            abort(404, 'Bukti pembayaran tidak ditemukan');
        }

        $path = storage_path('app/private/payment-proofs/' . $payment->proof_url);

        if (!file_exists($path)) {
            abort(404, 'File bukti pembayaran tidak ditemukan');
        }

        return response()->file($path);
    }
}

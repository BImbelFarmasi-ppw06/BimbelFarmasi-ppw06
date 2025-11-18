<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    /**
     * Show program detail and order form
     */
    public function create($slug)
    {
        $program = Program::where('slug', $slug)->where('is_active', true)->firstOrFail();
        
        return view('pages.order.create', compact('program'));
    }

    /**
     * Store order
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'program_id' => ['required', 'exists:programs,id'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        $program = Program::findOrFail($validated['program_id']);

        // Create order
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
     * Show payment page
     */
    public function payment($orderNumber)
    {
        $order = Order::with('program')
            ->where('order_number', $orderNumber)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Redirect if already paid
        if ($order->payment && $order->payment->status === 'paid') {
            return redirect()->route('order.success', $orderNumber);
        }

        return view('pages.order.payment', compact('order'));
    }

    /**
     * Process payment
     */
    public function processPayment(Request $request, $orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $validated = $request->validate([
            'payment_method' => ['required', 'in:bank_transfer,ewallet,qris'],
            'proof' => ['required', 'image', 'max:2048'], // 2MB max
        ], [
            'payment_method.required' => 'Metode pembayaran wajib dipilih.',
            'proof.required' => 'Bukti pembayaran wajib diupload.',
            'proof.image' => 'File harus berupa gambar.',
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

        return redirect()->route('order.success', $orderNumber)
            ->with('success', 'Bukti pembayaran berhasil diupload! Kami akan memverifikasi dalam 1x24 jam.');
    }

    /**
     * Show success page
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
     * Show user's orders
     */
    public function myOrders()
    {
        // Only show orders that have payment uploaded
        $orders = Order::with(['program', 'payment'])
            ->where('user_id', Auth::id())
            ->whereHas('payment') // Must have payment proof uploaded
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages.order.my-orders', compact('orders'));
    }
}

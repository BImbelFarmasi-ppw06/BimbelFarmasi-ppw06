<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestimonialController extends Controller
{
    /**
     * Display all approved testimonials
     */
    public function index()
    {
        $testimonials = Testimonial::with(['user', 'program'])
            ->approved()
            ->latest()
            ->paginate(12);

        $averageRating = Testimonial::approved()->avg('rating');
        $totalTestimonials = Testimonial::approved()->count();

        return view('pages.testimonials.index', compact('testimonials', 'averageRating', 'totalTestimonials'));
    }

    /**
     * Show form to create testimonial for a specific order
     */
    public function create($orderNumber)
    {
        $order = Order::with(['program', 'payment'])
            ->where('order_number', $orderNumber)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Check if payment is approved
        if (!$order->payment || $order->payment->status !== 'approved') {
            return redirect()->route('order.myOrders')
                ->with('error', 'Anda hanya bisa memberikan testimoni setelah pembayaran disetujui.');
        }

        // Check if testimonial already exists
        $existingTestimonial = Testimonial::where('order_id', $order->id)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingTestimonial) {
            return redirect()->route('testimonials.edit', $existingTestimonial->id)
                ->with('info', 'Anda sudah memberikan testimoni untuk order ini. Silakan edit jika ingin mengubah.');
        }

        return view('pages.testimonials.create', compact('order'));
    }

    /**
     * Store a new testimonial
     */
    public function store(Request $request, $orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Validate
        $validated = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['required', 'string', 'min:10', 'max:1000'],
        ], [
            'rating.required' => 'Rating wajib diisi.',
            'rating.min' => 'Rating minimal 1 bintang.',
            'rating.max' => 'Rating maksimal 5 bintang.',
            'comment.required' => 'Komentar wajib diisi.',
            'comment.min' => 'Komentar minimal 10 karakter.',
            'comment.max' => 'Komentar maksimal 1000 karakter.',
        ]);

        // Create testimonial
        Testimonial::create([
            'user_id' => Auth::id(),
            'program_id' => $order->program_id,
            'order_id' => $order->id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'is_approved' => false, // Needs admin approval
        ]);

        return redirect()->route('order.myOrders')
            ->with('success', 'Terima kasih! Testimoni Anda telah dikirim dan menunggu persetujuan admin.');
    }

    /**
     * Show form to edit testimonial
     */
    public function edit($id)
    {
        $testimonial = Testimonial::with(['order.program'])
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('pages.testimonials.edit', compact('testimonial'));
    }

    /**
     * Update testimonial
     */
    public function update(Request $request, $id)
    {
        $testimonial = Testimonial::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Validate
        $validated = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['required', 'string', 'min:10', 'max:1000'],
        ], [
            'rating.required' => 'Rating wajib diisi.',
            'rating.min' => 'Rating minimal 1 bintang.',
            'rating.max' => 'Rating maksimal 5 bintang.',
            'comment.required' => 'Komentar wajib diisi.',
            'comment.min' => 'Komentar minimal 10 karakter.',
            'comment.max' => 'Komentar maksimal 1000 karakter.',
        ]);

        // Update testimonial
        $testimonial->update([
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'is_approved' => false, // Reset approval status
        ]);

        return redirect()->route('order.myOrders')
            ->with('success', 'Testimoni Anda telah diupdate dan menunggu persetujuan admin.');
    }

    /**
     * Delete testimonial
     */
    public function destroy($id)
    {
        $testimonial = Testimonial::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $testimonial->delete();

        return redirect()->route('order.myOrders')
            ->with('success', 'Testimoni Anda telah dihapus.');
    }

    /**
     * Show user's own testimonials
     */
    public function myTestimonials()
    {
        $testimonials = Testimonial::with(['program', 'order'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('pages.testimonials.my-testimonials', compact('testimonials'));
    }
}

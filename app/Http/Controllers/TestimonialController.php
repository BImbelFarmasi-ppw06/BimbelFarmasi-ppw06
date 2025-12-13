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
            ->orderBy('rating', 'desc')
            ->latest()
            ->paginate(6);

        $averageRating = Testimonial::approved()->avg('rating') ?? 0;
        $totalTestimonials = Testimonial::approved()->count();
        
        // Calculate satisfaction rate (percentage of ratings >= 4)
        $highRatings = Testimonial::approved()->where('rating', '>=', 4)->count();
        $satisfactionRate = $totalTestimonials > 0 
            ? round(($highRatings / $totalTestimonials) * 100) 
            : 0;

        return view('pages.testimonials.index', compact(
            'testimonials', 
            'averageRating', 
            'totalTestimonials', 
            'satisfactionRate'
        ));
    }

    /**
     * Show form to create testimonial for a specific order
     */
    public function create($orderNumber)
    {
        $order = Order::with(['program'])
            ->where('order_number', $orderNumber)
            ->where('user_id', Auth::id())
            ->firstOrFail();

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
            'is_approved' => true, // Auto approve
        ]);

        return redirect()->route('order.my-orders')
            ->with('success', 'Terima kasih! Testimoni Anda telah berhasil dipublikasikan.');
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
            'is_approved' => true, // Keep approved
        ]);

        return redirect()->route('order.my-orders')
            ->with('success', 'Testimoni Anda telah berhasil diupdate.');
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

        return redirect()->route('order.my-orders')
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
            ->paginate(10);

        return view('pages.testimonials.my-testimonials', compact('testimonials'));
    }
}

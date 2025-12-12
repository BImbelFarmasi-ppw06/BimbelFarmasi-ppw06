<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminCourseController extends Controller
{
    /**
     * Display list of all courses/materials
     */
    public function index()
    {
        $courses = Course::with(['order.user', 'order.program'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.courses.index', compact('courses'));
    }

    /**
     * Show form to upload course material for a specific order
     */
    public function create(Request $request)
    {
        // Get paid orders without course materials yet
        $orders = Order::with(['user', 'program', 'payment'])
            ->whereHas('payment', function($query) {
                $query->where('status', 'paid');
            })
            ->whereDoesntHave('courses')
            ->orderBy('created_at', 'desc')
            ->get();

        $selectedOrder = null;
        if ($request->has('order_id')) {
            $selectedOrder = Order::with(['user', 'program'])->find($request->order_id);
        }

        return view('admin.courses.create', compact('orders', 'selectedOrder'));
    }

    /**
     * Store course material
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => ['required', 'exists:orders,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'content' => ['required', 'string'],
            'video_url' => ['nullable', 'url'],
            'duration_minutes' => ['nullable', 'integer', 'min:1'],
            'files.*' => ['nullable', 'file', 'max:10240'], // 10MB max per file
        ]);

        $order = Order::with('user')->findOrFail($validated['order_id']);

        // Handle file uploads
        $fileUrls = [];
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('course-materials', 'public');
                $fileUrls[] = $path;
            }
        }

        // Create course
        $course = Course::create([
            'order_id' => $order->id,
            'user_id' => $order->user_id,
            'title' => $validated['title'],
            'description' => $validated['description'],
            'content' => $validated['content'],
            'video_url' => $validated['video_url'],
            'duration_minutes' => $validated['duration_minutes'],
            'file_urls' => $fileUrls ? json_encode($fileUrls) : null,
            'status' => 'not_started',
        ]);

        return redirect()
            ->route('admin.courses.index')
            ->with('success', 'Materi berhasil diupload untuk ' . $order->user->name);
    }

    /**
     * Show course details
     */
    public function show(Course $course)
    {
        $course->load(['order.user', 'order.program', 'user']);
        return view('admin.courses.show', compact('course'));
    }

    /**
     * Show edit form
     */
    public function edit(Course $course)
    {
        $course->load(['order.user', 'order.program']);
        return view('admin.courses.edit', compact('course'));
    }

    /**
     * Update course material
     */
    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'content' => ['required', 'string'],
            'video_url' => ['nullable', 'url'],
            'duration_minutes' => ['nullable', 'integer', 'min:1'],
            'files.*' => ['nullable', 'file', 'max:10240'],
        ]);

        // Handle new file uploads
        $fileUrls = $course->file_urls ? json_decode($course->file_urls, true) : [];
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('course-materials', 'public');
                $fileUrls[] = $path;
            }
        }

        $course->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'content' => $validated['content'],
            'video_url' => $validated['video_url'],
            'duration_minutes' => $validated['duration_minutes'],
            'file_urls' => !empty($fileUrls) ? json_encode($fileUrls) : null,
        ]);

        return redirect()
            ->route('admin.courses.show', $course)
            ->with('success', 'Materi berhasil diupdate');
    }

    /**
     * Delete course material
     */
    public function destroy(Course $course)
    {
        // Delete uploaded files
        if ($course->file_urls) {
            $files = json_decode($course->file_urls, true);
            foreach ($files as $file) {
                Storage::disk('public')->delete($file);
            }
        }

        $course->delete();

        return redirect()
            ->route('admin.courses.index')
            ->with('success', 'Materi berhasil dihapus');
    }

    /**
     * Delete a specific file from course
     */
    public function deleteFile(Course $course, Request $request)
    {
        $fileToDelete = $request->input('file');
        
        if ($course->file_urls) {
            $files = json_decode($course->file_urls, true);
            $files = array_filter($files, function($file) use ($fileToDelete) {
                return $file !== $fileToDelete;
            });

            // Delete from storage
            Storage::disk('public')->delete($fileToDelete);

            // Update course
            $course->update([
                'file_urls' => !empty($files) ? json_encode(array_values($files)) : null
            ]);
        }

        return back()->with('success', 'File berhasil dihapus');
    }
}

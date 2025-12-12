<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminClassController extends Controller
{
    /**
     * Display list of all programs/classes
     */
    public function index()
    {
        $programs = Program::withCount('orders')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.classes.index', compact('programs'));
    }

    /**
     * Show form to create new program
     */
    public function create()
    {
        return view('admin.classes.create');
    }

    /**
     * Store new program
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'duration' => ['required', 'string', 'max:100'],
            'tutor' => ['nullable', 'string', 'max:255'],
            'schedule' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:active,inactive'],
            'features' => ['nullable', 'array'],
            'features.*' => ['string', 'max:255'],
        ], [
            'name.required' => 'Nama program wajib diisi.',
            'description.required' => 'Deskripsi program wajib diisi.',
            'price.required' => 'Harga program wajib diisi.',
            'price.numeric' => 'Harga harus berupa angka.',
            'duration.required' => 'Durasi program wajib diisi.',
            'status.required' => 'Status program wajib dipilih.',
        ]);

        try {
            DB::beginTransaction();

            // Prepare features - filter out empty values but keep as array
            // Model will handle JSON encoding via casts
            $features = $request->features ? array_filter($request->features) : [];

            $program = Program::create([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'price' => $validated['price'],
                'duration' => $validated['duration'],
                'tutor' => $validated['tutor'] ?? null,
                'schedule' => $validated['schedule'] ?? null,
                'status' => $validated['status'],
                'features' => $features, // Pass array directly, model will JSON encode it
            ]);

            DB::commit();

            return redirect()->route('admin.classes.index')
                ->with('success', 'Program berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Gagal menambahkan program: ' . $e->getMessage());
        }
    }

    /**
     * Show form to edit program
     */
    public function edit($id)
    {
        $program = Program::findOrFail($id);
        return view('admin.classes.edit', compact('program'));
    }

    /**
     * Update program
     */
    public function update(Request $request, $id)
    {
        $program = Program::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'duration' => ['required', 'string', 'max:100'],
            'tutor' => ['nullable', 'string', 'max:255'],
            'schedule' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:active,inactive'],
            'features' => ['nullable', 'array'],
            'features.*' => ['string', 'max:255'],
        ]);

        try {
            DB::beginTransaction();

            // Prepare features - filter out empty values but keep as array
            // Model will handle JSON encoding via casts
            $features = $request->features ? array_filter($request->features) : [];

            $program->update([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'price' => $validated['price'],
                'duration' => $validated['duration'],
                'tutor' => $validated['tutor'] ?? null,
                'schedule' => $validated['schedule'] ?? null,
                'status' => $validated['status'],
                'features' => $features, // Pass array directly, model will JSON encode it
            ]);

            DB::commit();

            return redirect()->route('admin.classes.index')
                ->with('success', 'Program berhasil diupdate!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Gagal mengupdate program: ' . $e->getMessage());
        }
    }

    /**
     * Show program detail with materials and students
     */
    public function show($id)
    {
        $program = Program::withCount('orders')
            ->with([
                'orders.user', 
                'orders.payment',
                'courses' => function($query) {
                    $query->orderBy('created_at', 'desc');
                },
                'quizBanks' => function($query) {
                    $query->withCount('questions')->orderBy('created_at', 'desc');
                }
            ])
            ->findOrFail($id);

        // Get paid students only
        $students = $program->orders()
            ->whereHas('payment', function($query) {
                $query->where('status', 'paid');
            })
            ->with(['user', 'payment'])
            ->latest()
            ->get();

        return view('admin.classes.show', compact('program', 'students'));
    }
    
    /**
     * Store course material for program
     */
    public function storeMaterial(Request $request, $id)
    {
        $program = Program::findOrFail($id);
        
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'file' => ['required', 'file', 'mimes:pdf,doc,docx,ppt,pptx,zip', 'max:10240'], // 10MB
            'type' => ['required', 'in:material,assignment'],
        ]);

        try {
            DB::beginTransaction();

            $filePath = $request->file('file')->store('course-materials', 'public');

            $program->courses()->create([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'file_path' => $filePath,
                'file_name' => $request->file('file')->getClientOriginalName(),
                'file_size' => $request->file('file')->getSize(),
                'type' => $validated['type'],
            ]);

            DB::commit();

            return back()->with('success', 'Materi berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menambahkan materi: ' . $e->getMessage());
        }
    }
    
    /**
     * Delete course material
     */
    public function deleteMaterial($programId, $materialId)
    {
        try {
            $program = Program::findOrFail($programId);
            $course = $program->courses()->findOrFail($materialId);
            
            // Delete file from storage
            if ($course->file_path && \Storage::disk('public')->exists($course->file_path)) {
                \Storage::disk('public')->delete($course->file_path);
            }
            
            $course->delete();

            return back()->with('success', 'Materi berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus materi: ' . $e->getMessage());
        }
    }

    /**
     * Delete program
     */
    public function destroy($id)
    {
        try {
            $program = Program::findOrFail($id);

            // Check if program has active orders
            $activeOrders = $program->orders()
                ->whereIn('status', ['pending', 'processing'])
                ->count();

            if ($activeOrders > 0) {
                return back()->with('error', 'Tidak dapat menghapus program yang memiliki order aktif.');
            }

            $program->delete();

            return redirect()->route('admin.classes.index')
                ->with('success', 'Program berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus program: ' . $e->getMessage());
        }
    }
}

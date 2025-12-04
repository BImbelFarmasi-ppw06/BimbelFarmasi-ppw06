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
            'slug' => ['required', 'string', 'max:255', 'unique:programs,slug'],
            'type' => ['required', 'in:bimbel,cpns,joki'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'duration_months' => ['nullable', 'integer', 'min:1'],
            'total_sessions' => ['nullable', 'integer', 'min:1'],
            'is_active' => ['required', 'boolean'],
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

            // Prepare features JSON
            $features = $request->features ? array_filter($request->features) : [];

            $program = Program::create([
                'name' => $validated['name'],
                'slug' => $validated['slug'],
                'type' => $validated['type'],
                'description' => $validated['description'],
                'price' => $validated['price'],
                'duration_months' => $validated['duration_months'] ?? null,
                'total_sessions' => $validated['total_sessions'] ?? null,
                'is_active' => $validated['is_active'],
                'features' => $features,
            ]);

            DB::commit();

            return redirect()->route('admin.classes.index')
                ->with('success', 'Program berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Program creation failed', [
                'admin_id' => auth()->id(),
                'data' => $request->except(['_token']),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()
                ->withInput()
                ->with('error', 'Gagal menambahkan program. Silakan coba lagi.');
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
            'slug' => ['required', 'string', 'max:255', 'unique:programs,slug,' . $id],
            'type' => ['required', 'in:bimbel,cpns,joki'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'duration_months' => ['nullable', 'integer', 'min:1'],
            'total_sessions' => ['nullable', 'integer', 'min:1'],
            'is_active' => ['required', 'boolean'],
            'features' => ['nullable', 'array'],
            'features.*' => ['string', 'max:255'],
        ]);

        try {
            DB::beginTransaction();

            $features = $request->features ? array_filter($request->features) : [];

            $program->update([
                'name' => $validated['name'],
                'slug' => $validated['slug'],
                'type' => $validated['type'],
                'description' => $validated['description'],
                'price' => $validated['price'],
                'duration_months' => $validated['duration_months'] ?? null,
                'total_sessions' => $validated['total_sessions'] ?? null,
                'is_active' => $validated['is_active'],
                'features' => $features,
            ]);

            DB::commit();

            return redirect()->route('admin.classes.index')
                ->with('success', 'Program berhasil diupdate!');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Program update failed', [
                'program_id' => $id,
                'admin_id' => auth()->id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()
                ->withInput()
                ->with('error', 'Gagal mengupdate program. Silakan coba lagi.');
        }
    }

    /**
     * Show program detail
     */
    public function show($id)
    {
        $program = Program::withCount('orders')
            ->with(['orders' => function($query) {
                $query->with(['user', 'payment'])->latest();
            }])
            ->findOrFail($id);

        return view('admin.classes.show', compact('program'));
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
            \Log::error('Program deletion failed', [
                'program_id' => $id,
                'admin_id' => auth()->id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Gagal menghapus program. Silakan coba lagi.');
        }
    }
}

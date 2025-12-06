<?php

namespace App\Http\Controllers\Admin;

use App\Models\Program;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class AdminProgramController extends Controller
{
    public function index()
    {
        $programs = Program::latest()->get();
        return view('admin.programs.index', compact('programs'));
    }

    public function create()
    {
        return view('admin.programs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:50',
            'description' => 'required|string',
            'features' => 'required|array|min:1',
            'features.*' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'duration_months' => 'required|integer|min:1',
            'total_sessions' => 'required|integer|min:1',
            'is_active' => 'boolean'
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active');

        Program::create($validated);

        return redirect()->route('admin.programs.index')
                        ->with('success', 'Program berhasil ditambahkan!');
    }

    public function show(Program $program)
    {
        return view('admin.programs.show', compact('program'));
    }

    public function edit(Program $program)
    {
        return view('admin.programs.edit', compact('program'));
    }

    public function update(Request $request, Program $program)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:50',
            'description' => 'required|string',
            'features' => 'required|array|min:1',
            'features.*' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'duration_months' => 'required|integer|min:1',
            'total_sessions' => 'required|integer|min:1',
            'is_active' => 'boolean'
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active');

        $program->update($validated);

        return redirect()->route('admin.programs.index')
                        ->with('success', 'Program berhasil diupdate!');
    }

    public function destroy(Program $program)
    {
        $program->delete();

        return redirect()->route('admin.programs.index')
                        ->with('success', 'Program berhasil dihapus!');
    }
}
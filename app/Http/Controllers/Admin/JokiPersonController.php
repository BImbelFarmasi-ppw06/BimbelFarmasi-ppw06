<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JokiPerson;
use Illuminate\Http\Request;

class JokiPersonController extends Controller
{
    public function index()
    {
        $jokiPersons = JokiPerson::orderBy('order')->orderBy('created_at', 'desc')->get();
        return view('admin.joki.index', compact('jokiPersons'));
    }

    public function create()
    {
        return view('admin.joki.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'expertise' => 'nullable|string|max:255',
            'wa_link' => 'required|url|max:500',
            'description' => 'nullable|string',
            'order' => 'nullable|integer|min:0',
        ]);

        JokiPerson::create($validated);

        return redirect()->route('admin.joki.index')
            ->with('success', 'Penjoki berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $joki = JokiPerson::findOrFail($id);
        return view('admin.joki.edit', compact('joki'));
    }

    public function update(Request $request, $id)
    {
        $joki = JokiPerson::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'expertise' => 'nullable|string|max:255',
            'wa_link' => 'required|url|max:500',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'order' => 'nullable|integer|min:0',
        ]);

        $joki->update($validated);

        return redirect()->route('admin.joki.index')
            ->with('success', 'Penjoki berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $joki = JokiPerson::findOrFail($id);
        $joki->delete();

        return redirect()->route('admin.joki.index')
            ->with('success', 'Penjoki berhasil dihapus!');
    }
}

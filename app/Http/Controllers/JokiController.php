<?php

namespace App\Http\Controllers;

use App\Models\JokiPerson;
use Illuminate\Http\Request;

class JokiController extends Controller
{
    public function index()
    {
        $jokiPersons = JokiPerson::where('is_active', true)
            ->orderBy('order')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('pages.joki-tugas', compact('jokiPersons'));
    }
}

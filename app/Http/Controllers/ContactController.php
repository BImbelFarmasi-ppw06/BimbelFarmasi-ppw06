<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Controller untuk menangani form kontak dari user
 */
class ContactController extends Controller
{
    /**
     * Proses submit form kontak
     * Validasi input: name, email, phone, subject, message
     * TODO: Simpan ke database / kirim email notifikasi
     * @param Request - Data form kontak
     * @return redirect dengan pesan sukses
     */
    public function store(Request $request)
    {
        // Validasi data form
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        // TODO: Tambahkan logic untuk:
        // 1. Simpan ke tabel contacts di database
        // 2. Kirim email notifikasi ke admin
        // 3. Log submission untuk tracking
        // Saat ini hanya redirect dengan pesan sukses

        return redirect()->route('kontak')->with('success', 'Terima kasih! Pesan Anda telah berhasil dikirim. Kami akan segera menghubungi Anda.');
    }
}

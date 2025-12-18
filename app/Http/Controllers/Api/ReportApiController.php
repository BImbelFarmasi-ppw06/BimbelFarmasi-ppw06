<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReportApiController extends Controller
{
    /**
     * Get all reports
     * GET /api/reports
     */
    public function index()
    {
        // Untuk sementara, kita buat dummy data karena belum ada model Report
        // Nanti bisa diganti dengan data dari database
        $reports = collect([
            [
                'id' => 1,
                'judul_utama' => 'Pembinaan Character Menuju Masa depan Indah',
                'nama' => 'John Doe',
                'alasan' => 'Kurang jelas suara videonya',
                'created_at' => now()->format('Y-m-d H:i:s'),
            ],
        ]);

        return response()->json($reports, 200);
    }

    /**
     * Get report by ID
     * GET /api/reports/{id}
     */
    public function show($id)
    {
        // Dummy data
        $reports = [
            4 => [
                'id' => 4,
                'judul_utama' => 'Pembinaan Character Menuju Masa depan Indah',
                'nama' => 'Jane Smith',
                'alasan' => 'Video tidak dapat diputar',
                'created_at' => now()->format('Y-m-d H:i:s'),
            ],
        ];

        if (!isset($reports[$id])) {
            return response()->json([
                'message' => 'Report not found'
            ], 404);
        }

        return response()->json($reports[$id], 200);
    }

    /**
     * Create new report
     * POST /api/reports
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul_utama' => 'required|string|max:500',
            'nama' => 'required|string|max:255',
            'alasan' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 400);
        }

        // Create report (dummy response)
        $report = [
            'id' => rand(1, 1000),
            'judul_utama' => $request->judul_utama,
            'nama' => $request->nama,
            'alasan' => $request->alasan,
            'created_at' => now()->format('Y-m-d H:i:s'),
        ];

        return response()->json([
            'message' => 'Report created successfully',
            'data' => $report
        ], 201);
    }

    /**
     * Delete report
     * DELETE /api/deletereports/{id}
     */
    public function destroy($id)
    {
        // Dummy validation
        if ($id < 1) {
            return response()->json([
                'message' => 'Report not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Report deleted successfully'
        ], 200);
    }
}

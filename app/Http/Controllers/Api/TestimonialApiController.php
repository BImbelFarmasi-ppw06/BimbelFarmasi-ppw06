<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TestimonialApiController extends Controller
{
    /**
     * Get all testimonials
     * GET /api/testimoni
     */
    public function index()
    {
        $testimonials = Testimonial::with(['user', 'program'])
            ->approved()
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($testimonial) {
                return [
                    'id' => $testimonial->id,
                    'pekerjaan' => $testimonial->user->pekerjaan ?? 'N/A',
                    'program_studi' => $testimonial->user->program_studi ?? 'N/A',
                    'angkatan' => $testimonial->user->angkatan ?? 'N/A',
                    'judul_utama' => $testimonial->program->name ?? 'N/A',
                    'link_video' => $testimonial->link_video ?? null,
                    'rating' => $testimonial->rating,
                    'comment' => $testimonial->comment,
                    'created_at' => $testimonial->created_at->format('Y-m-d H:i:s'),
                ];
            });

        if ($testimonials->isEmpty()) {
            return response()->json([], 200);
        }

        return response()->json($testimonials, 200);
    }

    /**
     * Get testimonial by ID
     * GET /api/testimoni/{id}
     */
    public function show($id)
    {
        $testimonial = Testimonial::with(['user', 'program'])->find($id);

        if (!$testimonial) {
            return response()->json([
                'message' => 'Testimonial not found'
            ], 404);
        }

        $data = [
            'id' => $testimonial->id,
            'pekerjaan' => $testimonial->user->pekerjaan ?? 'N/A',
            'program_studi' => $testimonial->user->program_studi ?? 'N/A',
            'angkatan' => $testimonial->user->angkatan ?? 'N/A',
            'judul_utama' => $testimonial->program->name ?? 'N/A',
            'link_video' => $testimonial->link_video ?? null,
            'rating' => $testimonial->rating,
            'comment' => $testimonial->comment,
            'created_at' => $testimonial->created_at->format('Y-m-d H:i:s'),
        ];

        return response()->json($data, 200);
    }

    /**
     * Create new testimonial
     * POST /api/posttestimoni
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'pekerjaan' => 'required|string|max:255',
            'program_studi' => 'required|string|max:255',
            'angkatan' => 'required|string|max:10',
            'judul_utama' => 'required|string|max:500',
            'link_video' => 'nullable|url',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 400);
        }

        // Update user data
        $user = \App\Models\User::find($request->user_id);
        $user->update([
            'pekerjaan' => $request->pekerjaan,
            'program_studi' => $request->program_studi,
            'angkatan' => $request->angkatan,
        ]);

        // Find or create program based on judul_utama
        $program = \App\Models\Program::firstOrCreate(
            ['name' => $request->judul_utama],
            [
                'slug' => \Illuminate\Support\Str::slug($request->judul_utama),
                'description' => 'Program testimoni',
                'price' => 0,
            ]
        );

        // Create testimonial
        $testimonial = Testimonial::create([
            'user_id' => $request->user_id,
            'program_id' => $program->id,
            'rating' => 5, // Default rating
            'comment' => 'Testimoni melalui API',
            'link_video' => $request->link_video,
            'is_approved' => true,
        ]);

        return response()->json([
            'message' => 'Testimonial created successfully',
            'data' => [
                'id' => $testimonial->id,
                'pekerjaan' => $request->pekerjaan,
                'program_studi' => $request->program_studi,
                'angkatan' => $request->angkatan,
                'judul_utama' => $request->judul_utama,
                'link_video' => $request->link_video,
            ]
        ], 201);
    }

    /**
     * Update testimonial
     * PUT /api/updatetestimoni/{id}
     */
    public function update(Request $request, $id)
    {
        $testimonial = Testimonial::find($id);

        if (!$testimonial) {
            return response()->json([
                'message' => 'Testimonial not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'pekerjaan' => 'required|string|max:255',
            'program_studi' => 'required|string|max:255',
            'angkatan' => 'required|string|max:10',
            'judul_utama' => 'required|string|max:500',
            'link_video' => 'nullable|url',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Update user data
        $user = $testimonial->user;
        if ($user) {
            $user->update([
                'pekerjaan' => $request->pekerjaan,
                'program_studi' => $request->program_studi,
                'angkatan' => $request->angkatan,
            ]);
        }

        // Update program
        $program = \App\Models\Program::firstOrCreate(
            ['name' => $request->judul_utama],
            [
                'slug' => \Illuminate\Support\Str::slug($request->judul_utama),
                'description' => 'Program testimoni',
                'price' => 0,
            ]
        );

        // Update testimonial
        $testimonial->update([
            'program_id' => $program->id,
            'link_video' => $request->link_video,
        ]);

        return response()->json([
            'message' => 'Testimonial updated successfully',
            'data' => [
                'id' => $testimonial->id,
                'pekerjaan' => $request->pekerjaan,
                'program_studi' => $request->program_studi,
                'angkatan' => $request->angkatan,
                'judul_utama' => $request->judul_utama,
                'link_video' => $request->link_video,
            ]
        ], 200);
    }

    /**
     * Delete testimonial
     * DELETE /api/deletetestimoni/{id}
     */
    public function destroy($id)
    {
        $testimonial = Testimonial::find($id);

        if (!$testimonial) {
            return response()->json([
                'message' => 'Testimonial not found'
            ], 404);
        }

        $testimonial->delete();

        return response()->json([
            'message' => 'Testimonial deleted successfully'
        ], 200);
    }
}

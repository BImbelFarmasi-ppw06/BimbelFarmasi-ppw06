<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Testimonials",
 *     description="API Endpoints for testimonials"
 * )
 */
class TestimonialController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/testimonials",
     *     summary="Get all approved testimonials",
     *     tags={"Testimonials"},
     *     @OA\Response(
     *         response=200,
     *         description="List of testimonials",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="array", @OA\Items(type="object"))
     *         )
     *     )
     * )
     */
    public function index()
    {
        $testimonials = Testimonial::with('user')
            ->where('is_approved', true)
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $testimonials
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/user/testimonials",
     *     summary="Get user's testimonials",
     *     tags={"Testimonials"},
     *     security={{"sanctum":{}}},
     *     @OA\Response(response=200, description="User's testimonials")
     * )
     */
    public function myTestimonials(Request $request)
    {
        $testimonials = Testimonial::where('user_id', $request->user()->id)
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $testimonials
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/testimonials",
     *     summary="Create new testimonial",
     *     tags={"Testimonials"},
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"rating","comment"},
     *             @OA\Property(property="rating", type="integer", minimum=1, maximum=5),
     *             @OA\Property(property="comment", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Testimonial created successfully"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
        ]);

        $testimonial = Testimonial::create([
            'user_id' => $request->user()->id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'is_approved' => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Testimonial submitted successfully. Waiting for approval.',
            'data' => $testimonial
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/testimonials/{id}",
     *     summary="Get testimonial by ID",
     *     tags={"Testimonials"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Testimonial details")
     * )
     */
    public function show(Request $request, $id)
    {
        $testimonial = Testimonial::findOrFail($id);

        if ($testimonial->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        return response()->json([
            'success' => true,
            'data' => $testimonial
        ]);
    }

    /**
     * @OA\Put(
     *     path="/api/v1/testimonials/{id}",
     *     summary="Update testimonial",
     *     tags={"Testimonials"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="rating", type="integer", minimum=1, maximum=5),
     *             @OA\Property(property="comment", type="string")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Testimonial updated successfully")
     * )
     */
    public function update(Request $request, $id)
    {
        $testimonial = Testimonial::findOrFail($id);

        if ($testimonial->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $validated = $request->validate([
            'rating' => 'sometimes|integer|min:1|max:5',
            'comment' => 'sometimes|string',
        ]);

        $testimonial->update($validated);
        $testimonial->is_approved = false; // Reset approval status
        $testimonial->save();

        return response()->json([
            'success' => true,
            'message' => 'Testimonial updated successfully. Waiting for re-approval.',
            'data' => $testimonial
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/testimonials/{id}",
     *     summary="Delete testimonial",
     *     tags={"Testimonials"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Testimonial deleted successfully")
     * )
     */
    public function destroy(Request $request, $id)
    {
        $testimonial = Testimonial::findOrFail($id);

        if ($testimonial->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $testimonial->delete();

        return response()->json([
            'success' => true,
            'message' => 'Testimonial deleted successfully'
        ]);
    }
}

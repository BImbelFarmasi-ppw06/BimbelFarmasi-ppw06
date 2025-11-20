<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

/**
 * @OA\Tag(
 *     name="Contact",
 *     description="API Endpoints for contact form"
 * )
 */
class ContactController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/v1/contact",
     *     summary="Submit contact form",
     *     tags={"Contact"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","email","message"},
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", format="email", example="john@example.com"),
     *             @OA\Property(property="phone", type="string", example="08123456789"),
     *             @OA\Property(property="subject", type="string", example="Inquiry about program"),
     *             @OA\Property(property="message", type="string", example="I would like to know more about...")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Message sent successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Thank you! Your message has been sent successfully.")
     *         )
     *     ),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        // TODO: Implement email sending or database storage
        // For now, just return success response
        
        return response()->json([
            'success' => true,
            'message' => 'Thank you! Your message has been sent successfully. We will contact you soon.'
        ]);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * @OA\Tag(
 *     name="Payments",
 *     description="API Endpoints for payment management"
 * )
 */
class PaymentController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/v1/orders/{orderNumber}/payment",
     *     summary="Upload payment proof",
     *     tags={"Payments"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="orderNumber",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"payment_method","proof_image"},
     *                 @OA\Property(property="payment_method", type="string", enum={"bca","mandiri","bni","bri"}),
     *                 @OA\Property(property="proof_image", type="string", format="binary"),
     *                 @OA\Property(property="notes", type="string")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Payment proof uploaded successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Order not found"),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function uploadProof(Request $request, $orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->where('user_id', $request->user()->id)
            ->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found'
            ], 404);
        }

        $validated = $request->validate([
            'payment_method' => 'required|in:bca,mandiri,bni,bri',
            'proof_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'notes' => 'nullable|string',
        ]);

        // Store payment proof
        $path = $request->file('proof_image')->store('payments', 'public');

        // Create or update payment
        $payment = Payment::updateOrCreate(
            ['order_id' => $order->id],
            [
                'payment_method' => $validated['payment_method'],
                'proof_path' => $path,
                'amount' => $order->total_amount,
                'status' => 'pending',
                'notes' => $validated['notes'] ?? null,
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Payment proof uploaded successfully. Please wait for admin verification.',
            'data' => $payment
        ]);
    }
}

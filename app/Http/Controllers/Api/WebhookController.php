<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Order;
use App\Models\User;

class WebhookController extends Controller
{
    /**
     * Webhook untuk menerima notifikasi dari proyek lain
     * Endpoint: POST /api/v1/webhook/external
     */
    public function receiveExternal(Request $request)
    {
        try {
            // Validasi signature untuk keamanan
            $signature = $request->header('X-Webhook-Signature');
            $secret = env('WEBHOOK_SECRET', 'your-webhook-secret');
            
            $payload = $request->getContent();
            $expectedSignature = hash_hmac('sha256', $payload, $secret);
            
            if ($signature !== $expectedSignature) {
                Log::warning('Invalid webhook signature', [
                    'received' => $signature,
                    'expected' => $expectedSignature
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid signature'
                ], 401);
            }
            
            // Log webhook data
            Log::info('Webhook received from external project', [
                'data' => $request->all()
            ]);
            
            // Proses data webhook
            $event = $request->input('event');
            $data = $request->input('data');
            
            switch ($event) {
                case 'user.created':
                    $this->handleUserCreated($data);
                    break;
                    
                case 'payment.success':
                    $this->handlePaymentSuccess($data);
                    break;
                    
                case 'enrollment.updated':
                    $this->handleEnrollmentUpdated($data);
                    break;
                    
                default:
                    Log::info('Unknown webhook event: ' . $event);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Webhook processed successfully'
            ], 200);
            
        } catch (\Exception $e) {
            Log::error('Webhook processing error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Webhook processing failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Handle user created event dari proyek lain
     */
    private function handleUserCreated($data)
    {
        // Cek apakah user sudah ada
        $user = User::where('email', $data['email'])->first();
        
        if (!$user) {
            // Buat user baru dari data webhook
            User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'] ?? null,
                'password' => bcrypt(str_random(16)), // Random password
                'external_id' => $data['id'] ?? null
            ]);
            
            Log::info('User created from webhook: ' . $data['email']);
        }
    }
    
    /**
     * Handle payment success event
     */
    private function handlePaymentSuccess($data)
    {
        $order = Order::where('order_number', $data['order_number'])->first();
        
        if ($order) {
            $order->update([
                'status' => 'paid',
                'payment_status' => 'verified',
                'external_payment_id' => $data['payment_id'] ?? null
            ]);
            
            Log::info('Order updated from webhook: ' . $data['order_number']);
        }
    }
    
    /**
     * Handle enrollment updated event
     */
    private function handleEnrollmentUpdated($data)
    {
        // Update enrollment data
        Log::info('Enrollment updated from webhook', $data);
    }
    
    /**
     * Send data ke proyek lain
     * Method untuk integrasi keluar
     */
    public function sendToExternal(Request $request)
    {
        $validated = $request->validate([
            'endpoint' => 'required|url',
            'event' => 'required|string',
            'data' => 'required|array'
        ]);
        
        try {
            $externalApiKey = env('EXTERNAL_API_KEY', 'your-api-key');
            
            $response = \Http::withHeaders([
                'Authorization' => 'Bearer ' . $externalApiKey,
                'Content-Type' => 'application/json',
                'X-Source' => 'BimbelFarmasi'
            ])->post($validated['endpoint'], [
                'event' => $validated['event'],
                'data' => $validated['data'],
                'timestamp' => now()->toISOString()
            ]);
            
            if ($response->successful()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Data sent successfully',
                    'response' => $response->json()
                ]);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to send data',
                'status_code' => $response->status()
            ], $response->status());
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error sending data to external API',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ExternalApiService
{
    protected $baseUrl;
    protected $apiKey;
    protected $timeout;
    
    public function __construct()
    {
        $this->baseUrl = env('EXTERNAL_API_URL', 'https://api.external-project.com');
        $this->apiKey = env('EXTERNAL_API_KEY', 'your-api-key');
        $this->timeout = 30;
    }
    
    /**
     * Send user data to external project
     */
    public function sendUser($user)
    {
        try {
            $response = Http::timeout($this->timeout)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type' => 'application/json'
                ])
                ->post($this->baseUrl . '/api/users', [
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'source' => 'BimbelFarmasi'
                ]);
            
            if ($response->successful()) {
                Log::info('User sent to external API', ['user_id' => $user->id]);
                return $response->json();
            }
            
            Log::error('Failed to send user to external API', [
                'user_id' => $user->id,
                'status' => $response->status()
            ]);
            
            return null;
            
        } catch (\Exception $e) {
            Log::error('Error sending user to external API: ' . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Send order data to external project
     */
    public function sendOrder($order)
    {
        try {
            $response = Http::timeout($this->timeout)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type' => 'application/json'
                ])
                ->post($this->baseUrl . '/api/orders', [
                    'order_number' => $order->order_number,
                    'user_email' => $order->user->email,
                    'program' => $order->program->name,
                    'amount' => $order->total_price,
                    'status' => $order->status,
                    'source' => 'BimbelFarmasi'
                ]);
            
            if ($response->successful()) {
                Log::info('Order sent to external API', ['order_id' => $order->id]);
                return $response->json();
            }
            
            return null;
            
        } catch (\Exception $e) {
            Log::error('Error sending order to external API: ' . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Get data from external project
     */
    public function getData($endpoint)
    {
        try {
            $response = Http::timeout($this->timeout)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Accept' => 'application/json'
                ])
                ->get($this->baseUrl . $endpoint);
            
            if ($response->successful()) {
                return $response->json();
            }
            
            Log::error('Failed to get data from external API', [
                'endpoint' => $endpoint,
                'status' => $response->status()
            ]);
            
            return null;
            
        } catch (\Exception $e) {
            Log::error('Error getting data from external API: ' . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Sync enrollment status with external project
     */
    public function syncEnrollment($userId, $programId, $status)
    {
        try {
            $response = Http::timeout($this->timeout)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type' => 'application/json'
                ])
                ->post($this->baseUrl . '/api/enrollments/sync', [
                    'user_id' => $userId,
                    'program_id' => $programId,
                    'status' => $status,
                    'source' => 'BimbelFarmasi',
                    'synced_at' => now()->toISOString()
                ]);
            
            return $response->successful();
            
        } catch (\Exception $e) {
            Log::error('Error syncing enrollment: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Verify payment with external payment gateway
     */
    public function verifyPayment($transactionId)
    {
        try {
            $response = Http::timeout($this->timeout)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Accept' => 'application/json'
                ])
                ->get($this->baseUrl . '/api/payments/' . $transactionId . '/verify');
            
            if ($response->successful()) {
                return $response->json();
            }
            
            return null;
            
        } catch (\Exception $e) {
            Log::error('Error verifying payment: ' . $e->getMessage());
            return null;
        }
    }
}

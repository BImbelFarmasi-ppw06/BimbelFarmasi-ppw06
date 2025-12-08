<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\Program;

class IntegrationController extends Controller
{
    /**
     * API untuk sinkronisasi users ke proyek lain
     * GET /api/v1/integration/users
     */
    public function syncUsers(Request $request)
    {
        // Validasi API key dari proyek lain
        $apiKey = $request->header('X-API-Key');
        
        if ($apiKey !== env('INTEGRATION_API_KEY')) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid API key'
            ], 401);
        }
        
        $users = User::select('id', 'name', 'email', 'phone', 'created_at')
            ->when($request->since, function($query, $since) {
                return $query->where('updated_at', '>=', $since);
            })
            ->limit($request->limit ?? 100)
            ->get();
        
        return response()->json([
            'success' => true,
            'data' => $users,
            'total' => $users->count()
        ]);
    }
    
    /**
     * API untuk sinkronisasi orders ke proyek lain
     * GET /api/v1/integration/orders
     */
    public function syncOrders(Request $request)
    {
        $apiKey = $request->header('X-API-Key');
        
        if ($apiKey !== env('INTEGRATION_API_KEY')) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid API key'
            ], 401);
        }
        
        $orders = Order::with(['user:id,name,email', 'program:id,name,price'])
            ->select('id', 'order_number', 'user_id', 'program_id', 'total_price', 'status', 'created_at')
            ->when($request->status, function($query, $status) {
                return $query->where('status', $status);
            })
            ->when($request->since, function($query, $since) {
                return $query->where('created_at', '>=', $since);
            })
            ->limit($request->limit ?? 100)
            ->get();
        
        return response()->json([
            'success' => true,
            'data' => $orders,
            'total' => $orders->count()
        ]);
    }
    
    /**
     * API untuk menerima data enrollment dari proyek lain
     * POST /api/v1/integration/enrollment
     */
    public function receiveEnrollment(Request $request)
    {
        $apiKey = $request->header('X-API-Key');
        
        if ($apiKey !== env('INTEGRATION_API_KEY')) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid API key'
            ], 401);
        }
        
        $validated = $request->validate([
            'user_email' => 'required|email',
            'program_slug' => 'required|string',
            'enrolled_at' => 'required|date',
            'valid_until' => 'required|date',
            'status' => 'required|in:active,inactive,expired'
        ]);
        
        try {
            $user = User::where('email', $validated['user_email'])->first();
            $program = Program::where('slug', $validated['program_slug'])->first();
            
            if (!$user || !$program) {
                return response()->json([
                    'success' => false,
                    'message' => 'User or program not found'
                ], 404);
            }
            
            // Update atau create enrollment
            \DB::table('user_programs')->updateOrInsert(
                [
                    'user_id' => $user->id,
                    'program_id' => $program->id
                ],
                [
                    'enrolled_at' => $validated['enrolled_at'],
                    'valid_until' => $validated['valid_until'],
                    'status' => $validated['status'],
                    'updated_at' => now()
                ]
            );
            
            return response()->json([
                'success' => true,
                'message' => 'Enrollment data received and processed'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error processing enrollment',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * API untuk mendapatkan statistik (untuk dashboard proyek lain)
     * GET /api/v1/integration/statistics
     */
    public function getStatistics(Request $request)
    {
        $apiKey = $request->header('X-API-Key');
        
        if ($apiKey !== env('INTEGRATION_API_KEY')) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid API key'
            ], 401);
        }
        
        $statistics = [
            'users' => [
                'total' => User::count(),
                'active' => User::whereNotNull('email_verified_at')->count(),
                'today' => User::whereDate('created_at', today())->count()
            ],
            'orders' => [
                'total' => Order::count(),
                'pending' => Order::where('status', 'pending')->count(),
                'paid' => Order::where('status', 'paid')->count(),
                'revenue' => Order::where('status', 'paid')->sum('total_price')
            ],
            'programs' => [
                'total' => Program::count(),
                'active' => Program::where('is_active', true)->count()
            ]
        ];
        
        return response()->json([
            'success' => true,
            'data' => $statistics,
            'generated_at' => now()->toISOString()
        ]);
    }
    
    /**
     * API untuk validasi user dari proyek lain
     * POST /api/v1/integration/validate-user
     */
    public function validateUser(Request $request)
    {
        $apiKey = $request->header('X-API-Key');
        
        if ($apiKey !== env('INTEGRATION_API_KEY')) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid API key'
            ], 401);
        }
        
        $validated = $request->validate([
            'email' => 'required|email'
        ]);
        
        $user = User::where('email', $validated['email'])->first();
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found',
                'exists' => false
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'exists' => true,
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'verified' => !is_null($user->email_verified_at)
            ]
        ]);
    }
}

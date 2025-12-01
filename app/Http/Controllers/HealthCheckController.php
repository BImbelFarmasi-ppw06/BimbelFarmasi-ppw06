<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class HealthCheckController extends Controller
{
    /**
     * Basic health check (uptime only)
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function ping(): JsonResponse
    {
        return response()->json([
            'status' => 'ok',
            'timestamp' => now()->toIso8601String(),
        ]);
    }

    /**
     * Detailed health check (database, cache, storage)
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function health(): JsonResponse
    {
        $checks = [
            'database' => $this->checkDatabase(),
            'cache' => $this->checkCache(),
            'storage' => $this->checkStorage(),
        ];

        $allHealthy = collect($checks)->every(fn($check) => $check['status'] === 'ok');

        return response()->json([
            'status' => $allHealthy ? 'healthy' : 'degraded',
            'timestamp' => now()->toIso8601String(),
            'checks' => $checks,
            'version' => config('app.version', '1.0.0'),
        ], $allHealthy ? 200 : 503);
    }

    /**
     * Application metrics (admin only)
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function metrics(): JsonResponse
    {
        return response()->json([
            'app' => [
                'name' => config('app.name'),
                'env' => config('app.env'),
                'debug' => config('app.debug'),
                'version' => config('app.version', '1.0.0'),
                'timezone' => config('app.timezone'),
            ],
            'system' => [
                'php_version' => PHP_VERSION,
                'laravel_version' => app()->version(),
                'memory_usage' => round(memory_get_usage(true) / 1024 / 1024, 2) . ' MB',
                'memory_peak' => round(memory_get_peak_usage(true) / 1024 / 1024, 2) . ' MB',
                'memory_limit' => ini_get('memory_limit'),
            ],
            'database' => [
                'driver' => config('database.default'),
                'connections' => $this->getDatabaseConnections(),
            ],
            'cache' => [
                'driver' => config('cache.default'),
                'status' => $this->checkCache()['status'],
            ],
            'storage' => [
                'disk' => config('filesystems.default'),
                'status' => $this->checkStorage()['status'],
            ],
            'timestamp' => now()->toIso8601String(),
        ]);
    }

    /**
     * Check database connection
     * 
     * @return array
     */
    private function checkDatabase(): array
    {
        try {
            DB::select('SELECT 1');
            return [
                'status' => 'ok',
                'message' => 'Database connection successful',
                'driver' => config('database.default'),
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Database connection failed',
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Check cache functionality
     * 
     * @return array
     */
    private function checkCache(): array
    {
        try {
            $key = 'health_check_' . time();
            $value = 'test_' . str()->random(10);
            
            Cache::put($key, $value, 10);
            $retrieved = Cache::get($key);
            Cache::forget($key);
            
            if ($retrieved === $value) {
                return [
                    'status' => 'ok',
                    'message' => 'Cache read/write successful',
                    'driver' => config('cache.default'),
                ];
            }
            
            return [
                'status' => 'error',
                'message' => 'Cache verification failed',
                'detail' => 'Retrieved value does not match',
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Cache operation failed',
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Check storage functionality
     * 
     * @return array
     */
    private function checkStorage(): array
    {
        try {
            $testFile = 'health_check_' . time() . '.txt';
            $testContent = 'health_check_' . str()->random(10);
            
            Storage::put($testFile, $testContent);
            $exists = Storage::exists($testFile);
            $content = Storage::get($testFile);
            Storage::delete($testFile);
            
            if ($exists && $content === $testContent) {
                return [
                    'status' => 'ok',
                    'message' => 'Storage read/write successful',
                    'disk' => config('filesystems.default'),
                ];
            }
            
            return [
                'status' => 'error',
                'message' => 'Storage verification failed',
                'detail' => 'File operations incomplete',
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Storage operation failed',
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Get number of active database connections
     * 
     * @return int
     */
    private function getDatabaseConnections(): int
    {
        try {
            $driver = config('database.default');
            $connection = config("database.connections.{$driver}.driver");
            
            if ($connection === 'mysql') {
                $connections = DB::select("SHOW STATUS WHERE variable_name = 'Threads_connected'");
                return (int) ($connections[0]->Value ?? 0);
            }
            
            // For other database drivers, return 1 if connected
            return 1;
        } catch (\Exception $e) {
            return 0;
        }
    }
}

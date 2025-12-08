# Monitoring & Observability Setup Guide

## Overview

This guide outlines the monitoring and observability strategy for the Bimbel Farmasi application, including error tracking, performance monitoring, and health checks.

## Error Monitoring with Sentry

### Installation

```bash
# Install Sentry Laravel SDK
composer require sentry/sentry-laravel

# Publish Sentry configuration
php artisan vendor:publish --provider="Sentry\Laravel\ServiceProvider"

# Install Sentry JavaScript SDK for frontend
npm install --save @sentry/browser @sentry/tracing
```

### Configuration

#### 1. Environment Variables (.env)

```dotenv
# Sentry Configuration
SENTRY_LARAVEL_DSN=https://your-dsn@sentry.io/project-id
SENTRY_TRACES_SAMPLE_RATE=0.2
SENTRY_ENVIRONMENT=production

# Optional: Set release version for deployment tracking
SENTRY_RELEASE=1.0.0
```

#### 2. Backend Configuration (config/sentry.php)

```php
<?php

return [
    'dsn' => env('SENTRY_LARAVEL_DSN'),

    // Capture percentage (0.0 to 1.0)
    'traces_sample_rate' => (float) env('SENTRY_TRACES_SAMPLE_RATE', 0.0),

    // Environment
    'environment' => env('SENTRY_ENVIRONMENT', env('APP_ENV')),

    // Release version
    'release' => env('SENTRY_RELEASE'),

    // Send default PII (Personally Identifiable Information)
    'send_default_pii' => false,

    // Breadcrumbs
    'breadcrumbs' => [
        'logs' => true,
        'cache' => true,
        'livewire' => true,
        'sql_queries' => true,
        'sql_bindings' => true,
        'queue_info' => true,
        'command_info' => true,
    ],

    // Integrations
    'integrations' => [
        \Sentry\Integration\IgnoreErrorsIntegration::class => [
            'ignore_exceptions' => [
                // Ignore common exceptions
                Illuminate\Auth\AuthenticationException::class,
                Symfony\Component\HttpKernel\Exception\NotFoundHttpException::class,
            ],
        ],
    ],

    // Before send callback
    'before_send' => function (\Sentry\Event $event): ?\Sentry\Event {
        // Don't send errors in local environment
        if (app()->environment('local')) {
            return null;
        }

        // Filter sensitive data
        if ($event->getRequest()) {
            $request = $event->getRequest();
            $data = $request->getData();

            // Remove sensitive fields
            $sensitiveFields = ['password', 'password_confirmation', 'token', 'credit_card'];
            foreach ($sensitiveFields as $field) {
                if (isset($data[$field])) {
                    $data[$field] = '[Filtered]';
                }
            }

            $request->setData($data);
        }

        return $event;
    },
];
```

#### 3. Frontend Configuration (resources/js/sentry.js)

```javascript
import * as Sentry from '@sentry/browser';
import { BrowserTracing } from '@sentry/tracing';

// Initialize Sentry for frontend errors
if (import.meta.env.VITE_SENTRY_DSN) {
  Sentry.init({
    dsn: import.meta.env.VITE_SENTRY_DSN,
    environment: import.meta.env.VITE_APP_ENV || 'production',
    release: import.meta.env.VITE_SENTRY_RELEASE,

    // Performance monitoring
    integrations: [new BrowserTracing()],

    // Sample rate for performance monitoring
    tracesSampleRate: 0.2,

    // Filter errors
    beforeSend(event, hint) {
      // Don't send errors in development
      if (import.meta.env.DEV) {
        return null;
      }

      // Filter out known browser extension errors
      if (event.exception?.values?.[0]?.value?.includes('chrome-extension://')) {
        return null;
      }

      return event;
    },

    // Ignore specific errors
    ignoreErrors: [
      'Non-Error promise rejection captured',
      'ResizeObserver loop limit exceeded',
      'Network request failed',
    ],
  });
}

// Export for manual error reporting
export function captureException(error, context = {}) {
  Sentry.captureException(error, { extra: context });
}

export function captureMessage(message, level = 'info') {
  Sentry.captureMessage(message, level);
}
```

#### 4. Import Sentry in app.jsx

```javascript
import './sentry'; // Add this line at the top
import './bootstrap';
// ... rest of app.jsx
```

#### 5. Environment Variables for Frontend (.env)

```dotenv
VITE_SENTRY_DSN=https://your-frontend-dsn@sentry.io/project-id
VITE_SENTRY_RELEASE=1.0.0
```

### Usage

#### Backend Error Tracking

```php
// Automatic error tracking (configured in Handler.php)
// All uncaught exceptions are automatically sent to Sentry

// Manual error reporting
\Sentry\captureException($exception);

// Add context to errors
\Sentry\configureScope(function (\Sentry\State\Scope $scope): void {
    $scope->setUser([
        'id' => auth()->id(),
        'email' => auth()->user()?->email,
    ]);
    $scope->setTag('feature', 'payment');
    $scope->setExtra('order_id', $order->id);
});
```

#### Frontend Error Tracking

```javascript
import { captureException, captureMessage } from './sentry';

try {
  // Some code
} catch (error) {
  captureException(error, {
    component: 'OrderForm',
    action: 'submit',
  });
}

// Manual message
captureMessage('Payment processed successfully', 'info');
```

## Health Check Endpoints

### Implementation

Create health check controller:

```php
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
        ], $allHealthy ? 200 : 503);
    }

    /**
     * Application metrics
     */
    public function metrics(): JsonResponse
    {
        return response()->json([
            'app' => [
                'name' => config('app.name'),
                'env' => config('app.env'),
                'debug' => config('app.debug'),
                'version' => config('app.version', '1.0.0'),
            ],
            'system' => [
                'php_version' => PHP_VERSION,
                'laravel_version' => app()->version(),
                'memory_usage' => memory_get_usage(true) / 1024 / 1024 . ' MB',
                'memory_peak' => memory_get_peak_usage(true) / 1024 / 1024 . ' MB',
            ],
            'database' => [
                'connections' => $this->getDatabaseConnections(),
            ],
            'cache' => [
                'driver' => config('cache.default'),
            ],
        ]);
    }

    private function checkDatabase(): array
    {
        try {
            DB::select('SELECT 1');
            return ['status' => 'ok', 'message' => 'Database connection successful'];
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    private function checkCache(): array
    {
        try {
            $key = 'health_check_' . time();
            Cache::put($key, 'test', 10);
            $value = Cache::get($key);
            Cache::forget($key);

            if ($value === 'test') {
                return ['status' => 'ok', 'message' => 'Cache read/write successful'];
            }

            return ['status' => 'error', 'message' => 'Cache verification failed'];
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    private function checkStorage(): array
    {
        try {
            $testFile = 'health_check_' . time() . '.txt';
            Storage::put($testFile, 'test');
            $exists = Storage::exists($testFile);
            Storage::delete($testFile);

            if ($exists) {
                return ['status' => 'ok', 'message' => 'Storage read/write successful'];
            }

            return ['status' => 'error', 'message' => 'Storage verification failed'];
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    private function getDatabaseConnections(): int
    {
        try {
            $connections = DB::select("SHOW STATUS WHERE variable_name = 'Threads_connected'");
            return (int) ($connections[0]->Value ?? 0);
        } catch (\Exception $e) {
            return 0;
        }
    }
}
```

### Routes (routes/web.php or routes/api.php)

```php
// Health check endpoints (no authentication required)
Route::get('/ping', [HealthCheckController::class, 'ping']);
Route::get('/health', [HealthCheckController::class, 'health']);

// Metrics endpoint (require admin authentication)
Route::get('/metrics', [HealthCheckController::class, 'metrics'])
    ->middleware(['auth', 'admin']);
```

### Testing Health Checks

```bash
# Basic ping
curl http://localhost:8000/ping

# Detailed health check
curl http://localhost:8000/health

# Metrics (requires authentication)
curl -H "Authorization: Bearer YOUR_TOKEN" http://localhost:8000/metrics
```

## Structured Logging

### Configuration (config/logging.php)

```php
'channels' => [
    'stack' => [
        'driver' => 'stack',
        'channels' => ['daily', 'sentry'],
        'ignore_exceptions' => false,
    ],

    'daily' => [
        'driver' => 'daily',
        'path' => storage_path('logs/laravel.log'),
        'level' => env('LOG_LEVEL', 'debug'),
        'days' => 14,
        'formatter' => env('LOG_FORMATTER', \Monolog\Formatter\JsonFormatter::class),
    ],

    'sentry' => [
        'driver' => 'sentry',
        'level' => 'error',
    ],
],
```

### Usage

```php
use Illuminate\Support\Facades\Log;

// Structured logging
Log::info('Payment processed', [
    'user_id' => $user->id,
    'order_id' => $order->id,
    'amount' => $payment->amount,
    'method' => $payment->payment_method,
]);

Log::error('Payment failed', [
    'user_id' => $user->id,
    'order_id' => $order->id,
    'error' => $exception->getMessage(),
    'trace' => $exception->getTraceAsString(),
]);

// Context for all logs
Log::withContext([
    'user_id' => auth()->id(),
    'ip' => request()->ip(),
    'user_agent' => request()->userAgent(),
]);
```

## Performance Monitoring

### Laravel Telescope (Development)

```bash
composer require laravel/telescope --dev
php artisan telescope:install
php artisan migrate
```

### Query Logging

```php
// app/Providers/AppServiceProvider.php
use Illuminate\Support\Facades\DB;

public function boot()
{
    if (config('app.debug')) {
        DB::listen(function ($query) {
            Log::debug('SQL Query', [
                'sql' => $query->sql,
                'bindings' => $query->bindings,
                'time' => $query->time . 'ms',
            ]);
        });
    }
}
```

## Monitoring Dashboard

### Simple Metrics Endpoint

Create dashboard view for admins to view metrics:

```blade
<!-- resources/views/admin/monitoring/dashboard.blade.php -->
<div class="grid grid-cols-3 gap-4">
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-2">System Health</h3>
        <div id="health-status"></div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-2">Database</h3>
        <div id="db-status"></div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-2">Cache</h3>
        <div id="cache-status"></div>
    </div>
</div>

<script>
async function fetchHealth() {
    const response = await fetch('/health');
    const data = await response.json();

    document.getElementById('health-status').innerHTML = `
        <p class="text-2xl font-bold ${data.status === 'healthy' ? 'text-green-600' : 'text-red-600'}">
            ${data.status.toUpperCase()}
        </p>
    `;

    // Update other metrics...
}

// Refresh every 30 seconds
setInterval(fetchHealth, 30000);
fetchHealth();
</script>
```

## Deployment Considerations

### 1. Sentry Release Tracking

```bash
# In deployment script
export SENTRY_RELEASE=$(git rev-parse --short HEAD)
php artisan config:cache
npm run build
```

### 2. Health Check in Load Balancer

Configure Nginx/ALB health check:

```nginx
location /ping {
    access_log off;
    return 200 "OK";
}
```

### 3. Uptime Monitoring

Use external services:

- **UptimeRobot** (Free)
- **Pingdom**
- **StatusCake**
- **Better Uptime**

Configure to check `/ping` endpoint every 5 minutes.

## Alert Configuration

### Sentry Alerts

1. Go to Sentry project settings
2. Configure alert rules:
   - New issue created → Slack/Email notification
   - Error rate > 10/min → Slack notification
   - Performance regression → Email notification

### Custom Alerts

```php
// app/Notifications/SystemHealthAlert.php
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\SlackMessage;

class SystemHealthAlert extends Notification
{
    public function via($notifiable)
    {
        return ['slack', 'mail'];
    }

    public function toSlack($notifiable)
    {
        return (new SlackMessage)
            ->error()
            ->content('🚨 System Health Check Failed')
            ->attachment(function ($attachment) {
                $attachment->title('Health Check Status')
                    ->fields([
                        'Database' => 'Error',
                        'Cache' => 'OK',
                        'Storage' => 'OK',
                    ]);
            });
    }
}
```

## Best Practices

1. ✅ **Don't log sensitive data** (passwords, tokens, credit cards)
2. ✅ **Use structured logging** (JSON format for easy parsing)
3. ✅ **Set appropriate log retention** (14-30 days for application logs)
4. ✅ **Monitor error rates** (set alerts for unusual spikes)
5. ✅ **Track performance metrics** (response time, database queries)
6. ✅ **Use health checks in deployment** (wait for /health before routing traffic)
7. ✅ **Filter noise** (ignore common errors like 404s, bot traffic)
8. ✅ **Add context to errors** (user ID, request ID, feature name)

## References

- [Sentry Laravel Documentation](https://docs.sentry.io/platforms/php/guides/laravel/)
- [Laravel Logging](https://laravel.com/docs/11.x/logging)
- [Laravel Telescope](https://laravel.com/docs/11.x/telescope)
- [Health Check Pattern](https://microservices.io/patterns/observability/health-check-api.html)

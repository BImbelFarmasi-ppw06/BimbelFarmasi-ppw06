<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Prevent clickjacking
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        
        // Prevent MIME type sniffing
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        
        // XSS Protection
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        
        // Referrer Policy
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        
        // Content Security Policy
        $response->headers->set('Content-Security-Policy', 
            "default-src 'self'; " .
            "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.tailwindcss.com https://cdn.jsdelivr.net https://www.googletagmanager.com https://www.google-analytics.com https://app.midtrans.com https://app.sandbox.midtrans.com; " .
            "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; " .
            "font-src 'self' https://fonts.gstatic.com; " .
            "img-src 'self' data: https: http:; " .
            "media-src 'self' data: blob: https://app.midtrans.com https://app.sandbox.midtrans.com; " .
            "connect-src 'self' https://api.midtrans.com https://api.sandbox.midtrans.com https://app.midtrans.com https://app.sandbox.midtrans.com https://www.google-analytics.com; " .
            "frame-src 'self' https://app.midtrans.com https://app.sandbox.midtrans.com https://calendar.google.com https://www.google.com https://drive.google.com;"
        );
        
        // Force HTTPS (only  ein production)
        if (app()->environment('production')) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }
        
        // Permissions Policy (formerly Feature Policy)
        $response->headers->set('Permissions-Policy', 
            'geolocation=(), microphone=(), camera=()'
        );

        return $response;
    }
}

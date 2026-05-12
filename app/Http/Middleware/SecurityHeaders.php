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
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Prevent page from being displayed in an iframe (Clickjacking protection)
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        
        // Prevent browser from guessing the content type
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        
        // Basic XSS Protection
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        
        // Control how much referrer information is shared
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        
        // Force HTTPS if the application is in production
        if (config('app.env') === 'production') {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }

        // Set Permissions Policy (optional, but good)
        $response->headers->set('Permissions-Policy', 'geolocation=(), midi=(), sync-xhr=(), microphone=(), camera=(), magnetometer=(), gyroscope=(), fullscreen=(self), payment=()');

        return $response;
    }
}

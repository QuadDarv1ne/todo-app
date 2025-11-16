<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CacheControl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Skip cache headers for non-GET/HEAD requests
        if (!$request->isMethodCacheable()) {
            return $response;
        }

        // Skip for authenticated routes
        if ($request->user()) {
            $response->headers->set('Cache-Control', 'no-cache, no-store, must-revalidate, private');
            $response->headers->set('Pragma', 'no-cache');
            $response->headers->set('Expires', '0');
            return $response;
        }

        // Public pages: enable caching
        $publicRoutes = ['home', 'login', 'register'];
        
        if (in_array($request->route()?->getName(), $publicRoutes)) {
            // Cache for 1 hour for public pages
            $response->headers->set('Cache-Control', 'public, max-age=3600, stale-while-revalidate=86400');
            $response->headers->set('Vary', 'Accept-Encoding');
        }

        return $response;
    }
}

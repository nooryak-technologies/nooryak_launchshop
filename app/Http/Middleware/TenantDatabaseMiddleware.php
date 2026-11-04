<?php

namespace App\Http\Middleware;

use Closure;

class TenantDatabaseMiddleware
{
    /**
     * Handle incoming request.
     * LaunchShop runs as a single unified multi-merchant platform.
     * All merchant stores and administrative data reside in the primary database.
     */
    public function handle($request, Closure $next)
    {
        return $next($request);
    }
}

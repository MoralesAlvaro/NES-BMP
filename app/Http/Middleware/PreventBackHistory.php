<?php

namespace App\Http\Middleware;

use Closure;

class PreventBackHistory
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        return $response->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }
}

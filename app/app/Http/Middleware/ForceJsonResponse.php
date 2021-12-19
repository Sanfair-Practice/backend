<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;

class ForceJsonResponse
{

    public function handle(Request $request, \Closure $next): mixed
    {
        $request->headers->set('Accept', 'application/json');
        return $next($request);
    }
}

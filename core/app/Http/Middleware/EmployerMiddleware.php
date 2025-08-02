<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EmployerMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard('employer')->check()) {
            return redirect()->route('employer.login')->with('error', 'Please login as employer to access this page.');
        }

        return $next($request);
    }
}

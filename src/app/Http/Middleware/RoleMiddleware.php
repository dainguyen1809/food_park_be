<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role)
    {

        if ($request->user()->role === $role) {
            return $next($request);
        }

        return response()->json([
            'statusCode' => 502,
            'message' => 'Bad Request',
            'redirect_url' => env('FRONTEND_URL').'/dashboard',
        ], 502);
    }
}

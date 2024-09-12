<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DynamicRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        $uri = $request->path();

        $section = explode('/', $uri)[2];



        $requiredRole = 'moderator_' . $section;

        if (!$user->hasRole($requiredRole)) {
            return response()->json(['message' => 'Access denied for section:' . $section], 403);
        }


        return $next($request);
    }
}

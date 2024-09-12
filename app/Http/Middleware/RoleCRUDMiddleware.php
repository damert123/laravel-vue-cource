<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleCRUDMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        switch ($request->method()) {
            case 'GET':
                if (!$user->hasPermission('read')){
                    return response(['message.' => 'Access denied'], 403);
                }
                break;

            case 'POST':
                if (!$user->hasPermission('create')){
                    return response(['message.' => 'Access denied'], 403);
                }
                break;

            case 'PUT':
            case 'PATCH':
                if (!$user->hasPermission('update')){
                    return response(['message.' => 'Access denied'], 403);
                }
                break;


            case 'DELETE':
                if (!$user->hasPermission('delete')){
                    return response(['message.' => 'Access denied'], 403);
                }
                break;
        }


        return $next($request);
    }
}

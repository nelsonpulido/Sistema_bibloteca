<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $tipo_usuario)
    {
        if (!$request->user() || $request->user()->tipo_usuario !== $tipo_usuario){
            return response()->json(['error' => 'Unauthorized'],401);
        }
        return $next($request);
    } 
}
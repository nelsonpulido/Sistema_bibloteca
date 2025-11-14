<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class TipoUsuarioMiddleware
{
    public function handle(Request $request, Closure $next, $tipo)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Token inválido o ausente'], 401);
        }

        if (!$user) {
            return response()->json(['error' => 'Usuario no autenticado'], 401);
        }

        if (strtolower($user->tipo_usuario) !== strtolower($tipo)) {
            return response()->json(['error' => 'No tienes permiso para acceder a esta ruta'], 403);
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserType
{
    public function handle(Request $request, Closure $next, string $tipo): Response
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            if (!$user) {
                return response()->json(['error' => 'Usuario no encontrado'], 404);
            }

            // Verificar el rol del usuario
            if ($user->rol !== $tipo) {
                return response()->json([
                    'error' => 'No tienes permisos para acceder a este recurso',
                    'rol_requerido' => $tipo,
                    'tu_rol' => $user->rol
                ], 403);
            }

        } catch (\Exception $e) {
            return response()->json(['error' => 'Error de autenticación: ' . $e->getMessage()], 401);
        }

        return $next($request);
    }
}
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class TipoUsuarioMiddleware
{
    public function handle(Request $request, Closure $next, string $tipo)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            if (!$user) {
                \Log::error('TipoUsuarioMiddleware: Usuario no encontrado');
                return response()->json(['error' => 'Usuario no encontrado'], 404);
            }

            // Log para debug
            \Log::info('TipoUsuarioMiddleware Check:', [
                'email' => $user->email,
                'tipo_usuario_db' => $user->tipo_usuario,
                'tipo_requerido' => $tipo,
                'ruta' => $request->path()
            ]);

            // Comparación case-insensitive
            if (strtolower(trim($user->tipo_usuario)) !== strtolower(trim($tipo))) {
                \Log::warning('TipoUsuarioMiddleware: Acceso denegado', [
                    'usuario' => $user->email,
                    'tiene_rol' => $user->tipo_usuario,
                    'necesita_rol' => $tipo
                ]);
                
                return response()->json([
                    'error' => 'No tienes permisos',
                    'tu_rol' => $user->tipo_usuario,
                    'rol_requerido' => $tipo
                ], 403);
            }

            \Log::info('TipoUsuarioMiddleware: Acceso permitido');

        } catch (\Exception $e) {
            \Log::error('TipoUsuarioMiddleware Exception: ' . $e->getMessage());
            return response()->json([
                'error' => 'Error de autenticación',
                'message' => $e->getMessage()
            ], 401);
        }

        return $next($request);
    }
}
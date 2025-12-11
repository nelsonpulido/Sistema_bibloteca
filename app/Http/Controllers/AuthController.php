<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    public function Login(Request $request)
    {
        // Validar datos
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        
        $credentials = $request->only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Credenciales incorrectas'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'No se pudo crear el token'], 500);
        }

        $user = JWTAuth::user();

        return response()->json([
            'message' => 'Login exitoso',
            'tipo_usuario' => $user->tipo_usuario ?? null,
            'token' => $token,
            'user' => $user
            ])
            ->cookie('token', $token, 60 * 24, null, null, false, true);
    }
}

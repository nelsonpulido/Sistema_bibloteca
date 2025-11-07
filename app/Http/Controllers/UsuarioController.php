<?php

namespace App\Http\Controllers;

use App\Services\UsuarioService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Throwable;

class UsuarioController extends Controller
{
    
    public function index()
    {
        try {
            $usuarios = UsuarioService::listarUsuarios();

            return response()->json([
                'success' => true,
                'data' => $usuarios
            ], 200);

        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al listar usuarios',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    
    public function store(Request $request)
    {
        $rules = [
            'dni'            => 'required|string|max:20|unique:usuarios,dni',
            'nombre'         => 'required|string|max:50',
            'apellidos'      => 'required|string|max:50',
            'email'          => 'required|email|max:100|unique:usuarios,email',
            'telefono'       => 'nullable|string|max:20',
            'direccion'      => 'nullable|string|max:180',
            'fecha_registro' => 'nullable|date',
            'tipo_usuario'   => 'required|string|max:30',
            'contrasena'     => 'required|string|min:6',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $data = $request->only([
                'dni', 'nombre', 'apellidos', 'email', 'telefono',
                'direccion', 'fecha_registro', 'tipo_usuario'
            ]);

            $data['contrasena'] = Hash::make($request->input('contrasena'));
            $data['activo'] = true;

            $usuario = UsuarioService::crearUsuario($data);

            return response()->json([
                'success' => true,
                'message' => 'Usuario creado correctamente',
                'data' => $usuario
            ], 201);

        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'No se pudo crear el usuario',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    
    public function show($id)
    {
        $usuario = UsuarioService::obtenerUsuario($id);

        if (!$usuario) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $usuario
        ], 200);
    }

    
    public function update(Request $request, $id)
    {
        $rules = [
            'dni'            => 'sometimes|string|max:20|unique:usuarios,dni,' . $id . ',id_usuario',
            'nombre'         => 'sometimes|string|max:50',
            'apellidos'      => 'sometimes|string|max:50',
            'email'          => 'sometimes|email|max:100|unique:usuarios,email,' . $id . ',id_usuario',
            'telefono'       => 'nullable|string|max:20',
            'direccion'      => 'nullable|string|max:180',
            'fecha_registro' => 'nullable|date',
            'tipo_usuario'   => 'sometimes|string|max:30',
            'contrasena'     => 'sometimes|string|min:6',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $data = $request->except('contrasena');
            if ($request->filled('contrasena')) {
                $data['contrasena'] = Hash::make($request->input('contrasena'));
            }

            $usuario = UsuarioService::actualizarUsuario($data, $id);

            if (!$usuario) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no encontrado'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Usuario actualizado correctamente',
                'data' => $usuario
            ], 200);

        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'No se pudo actualizar el usuario',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Desactivar un usuario.
     */
    public function destroy($id)
    {
        $usuario = UsuarioService::desactivarUsuario($id);

        if (!$usuario) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Usuario desactivado correctamente ✅',
            'data' => $usuario
        ], 200);
    }

    /**
     * Reactivar un usuario.
     */
    public function reactivar($id)
    {
        $usuario = UsuarioService::reactivarUsuario($id);

        if (!$usuario) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Usuario reactivado correctamente ✅',
            'data' => $usuario
        ], 200);
    }
}

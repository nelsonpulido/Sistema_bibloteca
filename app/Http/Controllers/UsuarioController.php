<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Throwable;

class UsuarioController extends Controller
{
    /**
     * Listar todos los usuarios.
     */
    public function index()
    {
        try {
            $usuarios = Usuario::with('empleado')->get();
            return response()->json([
                'success' => true,
                'data'    => $usuarios
            ], 200);

        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al listar usuarios',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Registrar un nuevo usuario.
     */
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
            'activo'         => 'nullable|boolean',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()
            ], 422);
        }

        try {
            $data = $request->only([
                'dni',
                'nombre',
                'apellidos',
                'email',
                'telefono',
                'direccion',
                'fecha_registro',
                'tipo_usuario',
                'activo'
            ]);

            // Hashear la contraseña antes de guardar
            $data['contrasena'] = Hash::make($request->input('contrasena'));

            $usuario = Usuario::create($data);

            return response()->json([
                'success' => true,
                'message' => 'Usuario creado correctamente',
                'data'    => $usuario
            ], 201);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'No se pudo crear el usuario',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mostrar un usuario específico.
     */
    public function show($id)
    {
        try {
            $usuario = Usuario::with(['empleado', 'prestamos'])
                              ->where('id_usuario', $id)
                              ->first();

            if (!$usuario) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no encontrado'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data'    => $usuario
            ], 200);
            
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener el usuario',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualizar un usuario existente.
     */
    public function update(Request $request, $id)
    {
        $usuario = Usuario::where('id_usuario', $id)->first();

        if (!$usuario) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no encontrado'
            ], 404);
        }

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
            'activo'         => 'nullable|boolean',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()
            ], 422);
        }

        try {
            $data = $request->only([
                'dni','nombre','apellidos','email','telefono',
                'direccion','fecha_registro','tipo_usuario','activo'
            ]);

            if ($request->filled('contrasena')) {
                $data['contrasena'] = Hash::make($request->input('contrasena'));
            }

            $usuario->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Usuario actualizado correctamente',
                'data'    => $usuario
            ], 200);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'No se pudo actualizar el usuario',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar un usuario.
     */
    public function destroy($id)
    {
        $usuario = Usuario::where('id_usuario', $id)->first();

        if (!$usuario) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no encontrado'
            ], 404);
        }

        try {
            $usuario->delete();
            return response()->json([
                'success' => true,
                'message' => 'Usuario eliminado correctamente'
            ], 200);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'No se pudo eliminar el usuario',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}

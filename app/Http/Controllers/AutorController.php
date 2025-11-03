<?php

namespace App\Http\Controllers;

use App\Models\Autor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class AutorController extends Controller
{
    /**
     * Mostrar todos los autores
     */
    public function index()
    {
        try {
            $autores = Autor::all();

            return response()->json([
                'success' => true,
                'data' => $autores
            ], 200);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al listar los autores',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Crear un nuevo autor
     */
    public function store(Request $request)
    {
        $rules = [
            'nombre' => 'required|string|max:100',
            'nacionalidad' => 'nullable|string|max:50',
            'fecha_nacimiento' => 'nullable|date',
            'biografia' => 'nullable|string|max:500'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $autor = Autor::create([
                'nombre' => $request->nombre,
                'nacionalidad' => $request->nacionalidad,
                'fecha_nacimiento' => $request->fecha_nacimiento,
                'biografia' => $request->biografia,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Autor creado correctamente',
                'data' => $autor
            ], 201);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'No se pudo crear el autor',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mostrar un autor específico
     */
    public function show($id)
    {
        try {
            $autor = Autor::find($id);

            if (!$autor) {
                return response()->json([
                    'success' => false,
                    'message' => 'Autor no encontrado'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $autor
            ], 200);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener el autor',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualizar un autor existente
     */
    public function update(Request $request, $id)
    {
        $autor = Autor::find($id);

        if (!$autor) {
            return response()->json([
                'success' => false,
                'message' => 'Autor no encontrado'
            ], 404);
        }

        $rules = [
            'nombre' => 'sometimes|string|max:100',
            'nacionalidad' => 'nullable|string|max:50',
            'fecha_nacimiento' => 'nullable|date',
            'biografia' => 'nullable|string|max:500'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $autor->update($request->only(['nombre', 'nacionalidad', 'fecha_nacimiento', 'biografia']));

            return response()->json([
                'success' => true,
                'message' => 'Autor actualizado correctamente',
                'data' => $autor
            ], 200);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'No se pudo actualizar el autor',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar un autor
     */
    public function destroy($id)
    {
        $autor = Autor::find($id);

        if (!$autor) {
            return response()->json([
                'success' => false,
                'message' => 'Autor no encontrado'
            ], 404);
        }

        try {
            $autor->delete();

            return response()->json([
                'success' => true,
                'message' => 'Autor eliminado correctamente'
            ], 200);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'No se pudo eliminar el autor',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

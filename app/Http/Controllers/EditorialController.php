<?php

namespace App\Http\Controllers;

use App\Models\Editorial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class EditorialController extends Controller
{
    /**
     * Mostrar todas las editoriales
     */
    public function index()
    {
        try {
            $editoriales = Editorial::all();

            return response()->json([
                'success' => true,
                'data' => $editoriales
            ], 200);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al listar las editoriales',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Crear una nueva editorial
     */
    public function store(Request $request)
    {
        $rules = [
            'nombre' => 'required|string|max:100|unique:editoriales,nombre',
            'direccion' => 'nullable|string|max:150',
            'telefono' => 'nullable|string|max:20',
            'correo' => 'nullable|email|max:100'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $editorial = Editorial::create([
                'nombre' => $request->nombre,
                'direccion' => $request->direccion,
                'telefono' => $request->telefono,
                'correo' => $request->correo,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Editorial creada correctamente',
                'data' => $editorial
            ], 201);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'No se pudo crear la editorial',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mostrar una editorial específica
     */
    public function show($id)
    {
        try {
            $editorial = Editorial::find($id);

            if (!$editorial) {
                return response()->json([
                    'success' => false,
                    'message' => 'Editorial no encontrada'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $editorial
            ], 200);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener la editorial',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualizar una editorial
     */
    public function update(Request $request, $id)
    {
        $editorial = Editorial::find($id);

        if (!$editorial) {
            return response()->json([
                'success' => false,
                'message' => 'Editorial no encontrada'
            ], 404);
        }

        $rules = [
            'nombre' => 'sometimes|string|max:100|unique:editoriales,nombre,' . $id . ',id_editorial',
            'direccion' => 'nullable|string|max:150',
            'telefono' => 'nullable|string|max:20',
            'correo' => 'nullable|email|max:100'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $editorial->update($request->only(['nombre', 'direccion', 'telefono', 'correo']));

            return response()->json([
                'success' => true,
                'message' => 'Editorial actualizada correctamente',
                'data' => $editorial
            ], 200);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'No se pudo actualizar la editorial',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar una editorial
     */
    public function destroy($id)
    {
        $editorial = Editorial::find($id);

        if (!$editorial) {
            return response()->json([
                'success' => false,
                'message' => 'Editorial no encontrada'
            ], 404);
        }

        try {
            $editorial->delete();

            return response()->json([
                'success' => true,
                'message' => 'Editorial eliminada correctamente'
            ], 200);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'No se pudo eliminar la editorial',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

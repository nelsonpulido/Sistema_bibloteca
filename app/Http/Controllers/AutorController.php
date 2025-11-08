<?php

namespace App\Http\Controllers;

use App\Services\AutorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class AutorController extends Controller
{
    protected $autorService;

    public function __construct(AutorService $autorService)
    {
        $this->autorService = $autorService;
    }

    /**
     * Listar todos los autores
     */
    public function index()
    {
        try {
            $autores = $this->autorService->obtenerTodos();

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
            $autor = $this->autorService->crear($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Autor creado correctamente',
                'data' => $autor
            ], 201);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear el autor',
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
            $autor = $this->autorService->obtenerPorId($id);

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
            $autor = $this->autorService->actualizar($id, $request->all());

            if (!$autor) {
                return response()->json([
                    'success' => false,
                    'message' => 'Autor no encontrado'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Autor actualizado correctamente',
                'data' => $autor
            ], 200);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el autor',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Desactivar un autor (cambia activo a false)
     */
    public function desactivar($id)
    {
        try {
            $resultado = $this->autorService->desactivar($id);

            if (!$resultado) {
                return response()->json([
                    'success' => false,
                    'message' => 'Autor no encontrado'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Autor desactivado correctamente'
            ], 200);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al desactivar el autor',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Reactivar un autor (cambia activo a true)
     */
    public function reactivar($id)
    {
        try {
            $resultado = $this->autorService->reactivar($id);

            if (!$resultado) {
                return response()->json([
                    'success' => false,
                    'message' => 'Autor no encontrado'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Autor reactivado correctamente'
            ], 200);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al reactivar el autor',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar un autor físicamente
     */
    public function destroy($id)
    {
        try {
            $resultado = $this->autorService->eliminar($id);

            if (!$resultado) {
                return response()->json([
                    'success' => false,
                    'message' => 'Autor no encontrado'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Autor eliminado correctamente'
            ], 200);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el autor',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

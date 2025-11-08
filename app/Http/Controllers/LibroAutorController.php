<?php

namespace App\Http\Controllers;

use App\Services\LibroAutorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class LibroAutorController extends Controller
{
    protected $libroAutorService;

    public function __construct(LibroAutorService $libroAutorService)
    {
        $this->libroAutorService = $libroAutorService;
    }

    /**
     * Listar todas las relaciones libro-autor
     */
    public function index()
    {
        try {
            $relaciones = $this->libroAutorService->obtenerTodos();

            return response()->json([
                'success' => true,
                'data' => $relaciones
            ], 200);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al listar las relaciones libro-autor',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Crear una nueva relación libro-autor
     */
    public function store(Request $request)
    {
        $rules = [
            'id_libro' => 'required|exists:libros,id_libro',
            'id_autor' => 'required|exists:autores,id_autor',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $relacion = $this->libroAutorService->crear($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Relación libro-autor creada correctamente',
                'data' => $relacion
            ], 201);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear la relación libro-autor',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mostrar una relación libro-autor específica
     */
    public function show($id)
    {
        try {
            $relacion = $this->libroAutorService->obtenerPorId($id);

            if (!$relacion) {
                return response()->json([
                    'success' => false,
                    'message' => 'Relación libro-autor no encontrada'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $relacion
            ], 200);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener la relación libro-autor',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualizar una relación libro-autor
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'id_libro' => 'sometimes|exists:libros,id_libro',
            'id_autor' => 'sometimes|exists:autores,id_autor',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $relacion = $this->libroAutorService->actualizar($id, $request->all());

            if (!$relacion) {
                return response()->json([
                    'success' => false,
                    'message' => 'Relación libro-autor no encontrada'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Relación libro-autor actualizada correctamente',
                'data' => $relacion
            ], 200);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la relación libro-autor',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar una relación libro-autor
     */
    public function destroy($id)
    {
        try {
            $resultado = $this->libroAutorService->eliminar($id);

            if (!$resultado) {
                return response()->json([
                    'success' => false,
                    'message' => 'Relación libro-autor no encontrada'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Relación libro-autor eliminada correctamente'
            ], 200);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la relación libro-autor',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

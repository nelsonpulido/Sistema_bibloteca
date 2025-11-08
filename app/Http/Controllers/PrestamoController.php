<?php

namespace App\Http\Controllers;

use App\Models\Prestamo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class PrestamoController extends Controller
{
    /**
     * Mostrar todos los préstamos
     */
    public function index()
    {
        try {
            $prestamos = Prestamo::with(['usuario', 'libro'])->get();

            return response()->json([
                'success' => true,
                'data' => $prestamos
            ], 200);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al listar los préstamos',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Crear un nuevo préstamo
     */
    public function store(Request $request)
    {
        $rules = [
            'id_usuario' => 'required|exists:usuarios,id_usuario',
            'id_libro' => 'required|exists:libros,id_libro',
            'fecha_prestamo' => 'required|date',
            'fecha_devolucion' => 'nullable|date|after_or_equal:fecha_prestamo',
            'estado' => 'required|string|max:20'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $prestamo = Prestamo::create($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Préstamo registrado correctamente',
                'data' => $prestamo
            ], 201);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar el préstamo',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mostrar un préstamo específico
     */
    public function show($id)
    {
        try {
            $prestamo = Prestamo::with(['usuario', 'libro'])->find($id);

            if (!$prestamo) {
                return response()->json([
                    'success' => false,
                    'message' => 'Préstamo no encontrado'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $prestamo
            ], 200);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener el préstamo',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualizar un préstamo existente
     */
    public function update(Request $request, $id)
    {
        $prestamo = Prestamo::find($id);

        if (!$prestamo) {
            return response()->json([
                'success' => false,
                'message' => 'Préstamo no encontrado'
            ], 404);
        }

        $rules = [
            'fecha_prestamo' => 'sometimes|date',
            'fecha_devolucion' => 'nullable|date|after_or_equal:fecha_prestamo',
            'estado' => 'sometimes|string|max:20'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $prestamo->update($request->only([
                'fecha_prestamo',
                'fecha_devolucion',
                'estado'
            ]));

            return response()->json([
                'success' => true,
                'message' => 'Préstamo actualizado correctamente',
                'data' => $prestamo
            ], 200);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el préstamo',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar un préstamo
     */
    public function desactivar($id)
{
    $prestamo = Prestamo::find($id);

    if (!$prestamo) {
        return response()->json([
            'success' => false,
            'message' => 'Préstamo no encontrado'
        ], 404);
    }

    try {
        $prestamo->estado = 'inactivo';
        $prestamo->save();

        return response()->json([
            'success' => true,
            'message' => 'Préstamo desactivado correctamente',
            'data' => $prestamo
        ], 200);
    } catch (Throwable $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error al desactivar el préstamo',
            'error' => $e->getMessage()
        ], 500);
    }
}

/**
 * Reactivar un préstamo (volverlo a estado activo o prestado)
 */
public function reactivar($id)
{
    $prestamo = Prestamo::find($id);

    if (!$prestamo) {
        return response()->json([
            'success' => false,
            'message' => 'Préstamo no encontrado'
        ], 404);
    }

    try {
        $prestamo->estado = 'prestado';
        $prestamo->save();

        return response()->json([
            'success' => true,
            'message' => 'Préstamo reactivado correctamente',
            'data' => $prestamo
        ], 200);
    } catch (Throwable $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error al reactivar el préstamo',
            'error' => $e->getMessage()
        ], 500);
    }
 }
 }
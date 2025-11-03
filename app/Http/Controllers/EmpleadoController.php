<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class EmpleadoController extends Controller
{
    /**
     * Mostrar todos los empleados
     */
    public function index()
    {
        try {
            $empleados = Empleado::with('usuario')->get();

            return response()->json([
                'success' => true,
                'data' => $empleados
            ], 200);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al listar los empleados',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Crear un nuevo empleado
     */
    public function store(Request $request)
    {
        $rules = [
            'id_usuario' => 'required|exists:usuarios,id_usuario|unique:empleados,id_usuario',
            'cargo' => 'required|string|max:100',
            'fecha_contratacion' => 'required|date',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $empleado = Empleado::create($request->only([
                'id_usuario', 'cargo', 'fecha_contratacion'
            ]));

            return response()->json([
                'success' => true,
                'message' => 'Empleado creado correctamente',
                'data' => $empleado
            ], 201);

            
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'No se pudo crear el empleado',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mostrar un empleado específico
     */
    public function show($id)
    {
        try {
            $empleado = Empleado::with('usuario')->where('id_empleado', $id)->first();

            if (!$empleado) {
                return response()->json([
                    'success' => false,
                    'message' => 'Empleado no encontrado'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $empleado
            ], 200);

            
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener el empleado',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualizar un empleado
     */
    public function update(Request $request, $id)
    {
        $empleado = Empleado::where('id_empleado', $id)->first();

        if (!$empleado) {
            return response()->json([
                'success' => false,
                'message' => 'Empleado no encontrado'
            ], 404);
        }

        $rules = [
            'id_usuario' => 'sometimes|exists:usuarios,id_usuario|unique:empleados,id_usuario,' . $id . ',id_empleado',
            'cargo' => 'sometimes|string|max:100',
            'fecha_contratacion' => 'sometimes|date',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $empleado->update($request->only([
                'id_usuario', 'cargo', 'fecha_contratacion'
            ]));

            return response()->json([
                'success' => true,
                'message' => 'Empleado actualizado correctamente',
                'data' => $empleado
            ], 200);


        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'No se pudo actualizar el empleado',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar un empleado
     */
    public function destroy($id)
    {
        $empleado = Empleado::where('id_empleado', $id)->first();

        if (!$empleado) {
            return response()->json([
                'success' => false,
                'message' => 'Empleado no encontrado'
            ], 404);
        }

        try {
            $empleado->delete();

            return response()->json([
                'success' => true,
                'message' => 'Empleado eliminado correctamente'
            ], 200);


        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'No se pudo eliminar el empleado',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}


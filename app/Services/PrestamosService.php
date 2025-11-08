<?php

namespace App\Services;

use App\Models\Prestamo;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PrestamoService
{
    /**
     * Obtener todos los préstamos
     */
    public function obtenerTodos()
    {
        return Prestamo::all();
    }

    /**
     * Obtener un préstamo por ID
     */
    public function obtenerPorId($id)
    {
        return Prestamo::findOrFail($id);
    }

    /**
     * Crear un préstamo
     */
    public function crear($datos)
    {
        return Prestamo::create($datos);
    }

    /**
     * Actualizar un préstamo existente
     */
    public function actualizar($id, $datos)
    {
        $prestamo = Prestamo::find($id);
        if ($prestamo) {
            $prestamo->update($datos);
            return $prestamo->fresh();
        }
        return null;
    }

    /**
     * Actualizar estado del préstamo (por ejemplo, marcar como devuelto o activo)
     */
    public function actualizarPrestamo($id)
    {
        $prestamo = Prestamo::find($id);
        if ($prestamo) {
            // 🔹 Usa el campo correcto según tu base de datos
            $prestamo->update(['estado' => 'activo']); 
            return $prestamo->fresh();
        }
        return false;
    }
}
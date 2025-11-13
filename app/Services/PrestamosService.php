<?php

namespace App\Services;

use App\Models\Prestamo;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PrestamoService
{
    
    public function obtenerTodos()
    {
        return Prestamo::all();
    }

    
    public function obtenerPorId($id)
    {
        return Prestamo::findOrFail($id);
    }

    
    public function crear($datos)
    {
        return Prestamo::create($datos);
    }

    
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
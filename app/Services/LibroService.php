<?php

namespace App\Services; // 👈 En plural (Services), asegúrate de que el nombre del folder coincida

use App\Models\Libro;

class LibroService
{
    
    public function obtenerTodos()
    {
        return Libro::all();
    }

    
    public function obtenerPorId($id)
    {
        return Libro::find($id);
    }

    
    public function crear($datos)
    {
        return Libro::create($datos);
    }

    // Actualizar un libro existente
    public function actualizar($id, $datos)
    {
        $libro = Libro::find($id);
        if ($libro) {
            $libro->update($datos);
            return $libro;
        }
        return null;
    }

    
    public function Desactivar($id)
    {
        $libro = Libro::find($id);
        if ($libro) {
            $libro->update(['activo' => false]);
            return true;
        }
        return false;
    }
}

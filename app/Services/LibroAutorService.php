<?php

namespace App\Services;

use App\Models\LibroAutor;
use Illuminate\Support\Facades\DB;

class LibroAutorService
{
    /**
     * Obtener todas las relaciones libro-autor
     */
    public function obtenerTodos()
    {
        return LibroAutor::with(['libro', 'autor'])->get();
    }

    /**
     * Obtener una relación libro-autor específica
     */
    public function obtenerPorId($id)
    {
        return LibroAutor::with(['libro', 'autor'])->find($id);
    }

    /**
     * Crear una nueva relación entre libro y autor
     */
    public function crear($datos)
    {
        return LibroAutor::create($datos);
    }

    /**
     * Actualizar una relación libro-autor
     */
    public function actualizar($id, $datos)
    {
        $relacion = LibroAutor::find($id);
        if ($relacion) {
            $relacion->update($datos);
            return $relacion;
        }
        return null;
    }

    /**
     * Eliminar una relación libro-autor
     */
    public function eliminar($id)
    {
        $relacion = LibroAutor::find($id);
        if ($relacion) {
            $relacion->delete();
            return true;
        }
        return false;
    }
}

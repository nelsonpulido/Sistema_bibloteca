<?php

namespace App\Services;

use App\Models\LibroAutor;
use Illuminate\Support\Facades\DB;

class LibroAutorService
{
    
    public function obtenerTodos()
    {
        return LibroAutor::with(['libro', 'autor'])->get();
    }

    
    public function obtenerPorId($id)
    {
        return LibroAutor::with(['libro', 'autor'])->find($id);
    }

    
    public function crear($datos)
    {
        return LibroAutor::create($datos);
    }

    
    public function actualizar($id, $datos)
    {
        $relacion = LibroAutor::find($id);
        if ($relacion) {
            $relacion->update($datos);
            return $relacion;
        }
        return null;
    }

    
    public function desactivar($id)
    {
        $relacion = LibroAutor::find($id);
        if ($relacion) {
            $relacion->update(['activo' => false]);
            return true;
        }
        return false;
    }
}

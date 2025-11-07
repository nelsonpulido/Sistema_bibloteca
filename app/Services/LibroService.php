<?php

namespace App\Service;

use App\Models\Libro;

class LibroService
{
    public function obtener todos()
    {
        return libro::all();
    }

    public function ObtenerPorId($id)
    {
        return libro::find($id);
    }

    public function crear($datos)
    {
        return libro::create($datos);
    }

    public function actualizar($id, $datos)
    {
        $Libro = Libro::find($id);
        if ($libro) {
            $Libro->update($datos);
            return $libro;
        }
        return null;
    }

    public function eliminar($id)
    {
        $libro = libro::find($id);
        if ($Libro) {
            $Libro->update(Estado Activo Inactivo );
            return true;
        }
        return false
    }
}


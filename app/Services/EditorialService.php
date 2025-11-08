<?php

namespace App\Services;

use App\Models\Editorial;

class EditorialService
{
    public static function listarEditoriales()
    {
        return Editorial::all();
    }

    public static function obtenerEditorial($id)
    {
        return Editorial::find($id);
    }

    public static function crearEditorial(array $data)
    {
        return Editorial::create($data);
    }

    public static function actualizarEditorial($id, array $data)
    {
        $editorial = Editorial::find($id);
        if (!$editorial) return null;

        $editorial->update($data);
        return $editorial;
    }

    public static function Desactivar($id)
    {
        $editorial = Editorial::find($id);
        if (!$editorial) return null;

        $editorial->update(['activo' => false]); // Desactivar en lugar de borrar
        return $editorial;
    }

    public static function reactivar($id)
    {
        $editorial = Editorial::find($id);
        if (!$editorial) return null;

        $editorial->update(['activo' => true]);
        return $editorial;
    }
}

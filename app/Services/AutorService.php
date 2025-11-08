<?php

namespace App\Services;

use App\Models\Autor;

class AutorService
{
    /**
     * Obtener todos los autores
     */
    public function obtenerTodos()
    {
        return Autor::all();
    }

    /**
     * Obtener un autor por ID
     */
    public function obtenerPorId($id)
    {
        return Autor::find($id);
    }

    /**
     * Crear un nuevo autor
     */
    public function crear(array $datos)
    {
        $datos['activo'] = true; // Por defecto activo
        return Autor::create($datos);
    }

    /**
     * Actualizar un autor
     */
    public function actualizar($id, array $datos)
    {
        $autor = Autor::find($id);

        if ($autor) {
            $autor->update($datos);
            return $autor;
        }

        return null;
    }

    /**
     * Desactivar un autor (en lugar de eliminarlo)
     */
    public function desactivar($id)
    {
        $autor = Autor::find($id);

        if ($autor) {
            $autor->update(['activo' => false]);
            return true;
        }

        return false;
    }

    /**
     * Reactivar un autor
     */
    public function reactivar($id)
    {
        $autor = Autor::find($id);

        if ($autor) {
            $autor->update(['activo' => true]);
            return true;
        }

        return false;
    }

    /**
     * Eliminar físicamente un autor
     */
    public function eliminar($id)
    {
        $autor = Autor::find($id);

        if ($autor) {
            $autor->delete();
            return true;
        }

        return false;
    }
}

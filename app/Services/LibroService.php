<?php

namespace App\Services; // 👈 En plural (Services), asegúrate de que el nombre del folder coincida

use App\Models\Libro;

class LibroService
{
    // Obtener todos los libros
    public function obtenerTodos()
    {
        return Libro::all();
    }

    // Obtener un libro por su ID
    public function obtenerPorId($id)
    {
        return Libro::find($id);
    }

    // Crear un nuevo libro
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

    // Eliminar un libro (aquí mejor lo marcamos como inactivo en lugar de borrarlo)
    public function eliminar($id)
    {
        $libro = Libro::find($id);
        if ($libro) {
            $libro->update(['activo' => false]);
            return true;
        }
        return false;
    }
}

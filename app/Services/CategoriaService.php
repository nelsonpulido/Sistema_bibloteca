<?php

namespace App\Services;

use App\Models\Categoria;

class CategoriaService
{
    public static function crearCategoria($datosCategoria)
    {
        return Categoria::create($datosCategoria);
    }

    public static function listarCategorias()
    {
        return Categoria::all();
    }

    public static function obtenerCategoria($id_categoria)
    {
        return Categoria::find($id_categoria);
    }

    public static function actualizarCategoria($id_categoria, $datos)
    {
        $categoria = Categoria::find($id_categoria);

        if (!$categoria) {
            return null;
        }

        $categoria->update($datos);

        return $categoria->fresh(); 
    }

      public static function eliminarCategoria($id_categoria)
    {
        $categoria = Categoria::find($id_categoria);

        if (!$categoria) {
            return null;
        }

        $categoria->delete();
        return true;
    }
}

    

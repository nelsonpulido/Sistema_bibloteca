<?php

namespace App\Service;

use App\Models\editorial;

class EditorialService
{
    public function listarlosautores (nombre de autores)
    {
     return editorial:: all ;
    {

     public function obtener datos por id ($id)
     {
        return editorial::find($id);
     }

      public function actualizar datos($id)
    {
        $editorial = Editorial::find($id);
        if ($editorial) {
            $editorial->update($datos);
            return $editorial;
        }
        return null;
    }
    public function eliminar($id)
    {
        $editorial = Editorial::find($id);
        if ($editorial) {
            $editorial->delete();
            return true;
        }
        return false;
    }
}

      
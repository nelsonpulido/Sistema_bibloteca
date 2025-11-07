<?php

namespace App\Services;

use App\Models\Usuario;

class UsuarioService
{
    
    public static function crearUsuario($registroUsuario)
    {
        return Usuario::create($registroUsuario);
    }

    
    public static function listarUsuarios()
    {
        return Usuario::all();
    }

    
    public static function obtenerUsuario($id_usuario)
    {
        $usuario = Usuario::find($id_usuario);

        if (!$usuario) {
            return null;
        }

        return $usuario;
    }

    
    public static function actualizarUsuario($camposActualizados, $id_usuario)
    {
        $usuario = Usuario::find($id_usuario);

        if (!$usuario) {
            return null;
        }

        $usuario->update($camposActualizados);

        return $usuario->fresh(); 
    }

    
    public static function desactivarUsuario($id_usuario)
    {
        $usuario = Usuario::find($id_usuario);

        if (!$usuario) {
            return null;
        }

        $usuario->update(['activo' => false]);

        return $usuario->fresh();
    }

    
    public static function reactivarUsuario($id_usuario)
    {
        $usuario = Usuario::find($id_usuario);

        if (!$usuario) {
            return null;
        }

        $usuario->update(['activo' => true]);

        return $usuario->fresh();
    }
}

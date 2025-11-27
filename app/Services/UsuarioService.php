<?php

namespace App\Services;

use App\Models\Usuario;

class UsuarioService
{
    // Crear usuario
    public static function crearUsuario($registroUsuario)
    {
        return Usuario::create($registroUsuario);
    }

    // Listar usuarios
    public static function listarUsuarios()
    {
        return Usuario::all();
    }

    // Obtener usuario por ID
    public static function obtenerUsuario($id_usuario)
    {
        return Usuario::find($id_usuario);
    }

    // Actualizar usuario
    public static function actualizarUsuario($camposActualizados, $id_usuario)
    {
        $usuario = Usuario::find($id_usuario);

        if (!$usuario) {
            return null;
        }

        $usuario->update($camposActualizados);

        return $usuario->fresh();
    }

    // Desactivar usuario
    public static function desactivar($id_usuario)
    {
        $usuario = Usuario::find($id_usuario);

        if (!$usuario) {
            return null;
        }

        $usuario->update(['activo' => false]);

        return $usuario->fresh();
    }

    // Reactivar usuario
    public static function reactivar($id_usuario)
    {
        $usuario = Usuario::find($id_usuario);

        if (!$usuario) {
            return null;
        }

        $usuario->update(['activo' => true]);

        return $usuario->fresh();
    }

    // Alias para mantener compatibilidad con el controller
    public static function desactivarUsuario($id_usuario)
    {
        return self::desactivar($id_usuario);
    }

    public static function reactivarUsuario($id_usuario)
    {
        return self::reactivar($id_usuario);
    }
}
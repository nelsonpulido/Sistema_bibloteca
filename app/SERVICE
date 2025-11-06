<?php
namespace App\service;

use App\Models\User;

class UserService

{

public static function  crearUsuario($reguistroUsuario){
 return User::create($reguistroUsuario);
}

public static function listarUsuarios(){
    return User::get();

}

public static function obtenerUsuario($id_usuario){
    $usuario = User::find($id_usuario);
    
    if(!$usuario)
    {
        return null;

    }
    return $usuario;
}
  
public static function actualizarUsuario($camposActualizados, $id_usuario)
   {
    $usuario= User::find($id_usuario);

    if(!$usuario)
    {
     return null;
    }

    $usuario->update($camposActualizados);

    return $usuario->fresh();
   }
   public static function eliminarUsuario($id_usuario){

    if ($usuario){
        return null;
    
    }
    $usuario->delete();

    return true;

   }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory;

    protected $table = 'empleados';
    // Escribir la llave primaria NO OLVIDARRRRR
    protected $primaryKey = 'id_empleado';

    protected $fillable = [
        'id_usuario',
        'cargo',
        'fecha_contratacion',
    ];

    // Un empleado pertenece a un usuario
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }    
    //  Foranea y luego Primaria no olvidar
}

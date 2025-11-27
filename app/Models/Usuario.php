<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';

    protected $fillable = [
        'dni',
        'nombre',
        'apellidos',
        'email',
        'telefono',
        'direccion',
        'fecha_registro',
        'tipo_usuario',
        'password',
        'activo',
    ];

    // Relación con empleado
    public function empleado()
    {
        return $this->hasOne(Empleado::class, 'id_usuario', 'id_usuario');
    }

    // Relación con préstamos
    public function prestamos()
    {
        return $this->hasMany(Prestamo::class, 'id_usuario', 'id_usuario');
    }
}
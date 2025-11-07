<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Editorial extends Model
{ 
    use HasFactory;

    protected $table = 'editoriales';
    protected $primaryKey = 'id_editorial';

    
    protected $fillable = [
        'nombre',
        'direccion',
        'telefono',
        'correo',
        'pais',
        'ciudad',
        'activo'
    ];

    public function libros()
    {
        return $this->hasMany(Libro::class, 'id_editorial', 'id_editorial');
    }
}

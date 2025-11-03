<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Autor extends Model
{
    use HasFactory;
    
    protected $table = 'autores';
    protected $primaryKey = 'id_autor';

    protected $Fillable =[
        'id_autor',
        'nombre',
        'apellidos',
        'nacionalidad',
        'fecha_nacimiento',
        'biografia',
    ];
     
    public function libros()
    {
        return $this->belongsToMany(Libro::class, 'libro_autor', 'id_autor', 'id_libro');
    }


    
    //
}

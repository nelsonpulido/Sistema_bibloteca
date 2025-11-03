<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Libro extends Model
{
    use HasFactory;

    protected $table = 'libros';
    protected $primaryKey = 'id_libro';

    protected $fillable = [
        'id_categoria',
        'id_editorial',
        'titulo',
        'anio_publicacion',
        'estado',
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria', 'id_categoria');
    }

    public function editorial()
    {
        return $this->belongsTo(Editorial::class, 'id_editorial', 'id_editorial');
    }

    public function autores()
    {
        return $this->belongsToMany(Autor::class, 'libro_autor', 'id_libro', 'id_autor');
    }

    public function prestamos()
    {
        return $this->hasMany(Prestamo::class, 'id_libro', 'id_libro');
    }
}

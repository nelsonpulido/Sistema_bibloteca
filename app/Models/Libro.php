<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Libro extends Model
{
    protected $table = 'libros';
    
    // IMPORTANTE: Define la clave primaria correcta
    protected $primaryKey = 'id_libro';
    
    public $timestamps = true;

    protected $fillable = [
        'isbn',
        'titulo',
        'id_categoria',
        'id_editorial',
        'anio_publicacion',
        'idioma',
        'numero_paginas',
        'cantidad_disponible',
        'cantidad_total',
        'ubicacion',
        'estado'
    ];
    
    // Validaciones y valores por defecto
    protected $attributes = [
        'estado' => 'disponible',
        'idioma' => 'Español',
        'cantidad_disponible' => 0,
        'cantidad_total' => 0
    ];

    protected $casts = [
        'anio_publicacion' => 'integer',
        'numero_paginas' => 'integer',
        'cantidad_disponible' => 'integer',
        'cantidad_total' => 'integer',
    ];

    // Relaciones
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
        return $this->belongsToMany(
            Autor::class,
            'libro_autor',
            'id_libro',
            'id_autor'
        );
    }

    public function prestamos()
    {
        return $this->hasMany(Prestamo::class, 'id_libro', 'id_libro');
    }
}
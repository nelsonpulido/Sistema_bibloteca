<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('libros', function (Blueprint $table) {
            $table->id('id_libro');
            $table->string('isbn', 20)->unique();
            $table->string('titulo');
            $table->unsignedBigInteger('id_categoria');
            $table->unsignedBigInteger('id_editorial');
            $table->year('anio_publicacion')->nullable();
            $table->string('idioma', 50)->nullable();
            $table->integer('numero_paginas')->nullable();
            $table->integer('cantidad_disponible');
            $table->integer('cantidad_total');
            $table->string('ubicacion', 180)->nullable();
            $table->string('estado', 30)->default('disponible');
            $table->timestamps();

            $table->foreign('id_categoria')->references('id_categoria')->on('categorias')->onDelete('cascade');
            $table->foreign('id_editorial')->references('id_editorial')->on('editoriales')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('libros');
    }
};

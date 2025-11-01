<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('libro_autor', function (Blueprint $table) {
            $table->unsignedBigInteger('id_libro');
            $table->unsignedBigInteger('id_autor');
            $table->primary(['id_libro', 'id_autor']);

            $table->foreign('id_libro')->references('id_libro')->on('libros')->onDelete('cascade');
            $table->foreign('id_autor')->references('id_autor')->on('autores')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('libro_autor');
    }
};

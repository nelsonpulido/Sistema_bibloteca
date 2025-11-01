<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('autores', function (Blueprint $table) {
            $table->id('id_autor');
            $table->string('nombre', 50);
            $table->string('apellidos', 50);
            $table->string('nacionalidad', 50)->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->string('biografia', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('autores');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id('id_usuario');
            $table->string('dni', 20);
            $table->string('nombre', 50);
            $table->string('apellidos', 50);
            $table->string('email', 100)->unique();
            $table->string('telefono', 20)->nullable();
            $table->string('direccion', 180)->nullable();
            $table->date('fecha_registro')->nullable();
            $table->string('tipo_usuario', 30);
            $table->string('password', 180);
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};

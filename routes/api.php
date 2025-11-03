<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Importamos los controladores
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\EditorialController;
use App\Http\Controllers\AutorController;
use App\Http\Controllers\LibroController;
use App\Http\Controllers\PrestamoController;





Route::get('/user', function () {
    return response()->json([
        'status' => 'OK',
        'message' => 'API funcionando correctamente 🚀'
    ]);
});

//  Rutas para la gestión de usuarios
Route::apiResource('usuarios', UsuarioController::class);

//  Rutas para la gestión de empleados
Route::apiResource('empleados', EmpleadoController::class);

//  Rutas para la gestión de categorías
Route::apiResource('categorias', CategoriaController::class);

Route::apiResource('editoriales', EditorialController::class);

//  Rutas para la gestión de autores
Route::apiResource('autores', AutorController::class);

//  Rutas para la gestión de libros
Route::apiResource('libros', LibroController::class);

// Rutas para la gestión de préstamos
Route::apiResource('prestamos', PrestamoController::class);

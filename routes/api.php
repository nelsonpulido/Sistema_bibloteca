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
use App\Http\Controllers\LibroAutorController;
use App\Http\Controllers\PrestamoController;

Route::get('/user', function () {
    return response()->json([
        'status' => 'OK',
        'message' => 'API funcionando correctamente 🚀'
    ]);
});

//  Rutas para la gestión de usuarios
Route::apiResource('usuarios', UsuarioController::class);
Route::put('usuarios/{id}/reactivar', [UsuarioController::class, 'reactivar']);


//  Rutas para la gestión de empleados
Route::apiResource('empleados', EmpleadoController::class);

//  Rutas para la gestión de categorías
Route::apiResource('categorias', CategoriaController::class);

//  Rutas para la gestión de editoriales
Route::apiResource('editoriales', EditorialController::class);
Route::put('editoriales/{id}/reactivar', [EditorialController::class, 'reactivar']);
Route::put('editoriales/{id}/reactivar', [EditorialController::class, 'desactivar']);

//  Rutas para la gestión de autores
Route::apiResource('autores', AutorController::class);
Route::put('/autores/{id}/desactivar', [AutorController::class, 'desactivar']);
Route::put('/autores/{id}/reactivar', [AutorController::class, 'reactivar']);

//  Rutas para la gestión de libros
Route::apiResource('libros', LibroController::class);
Route::put('libros/{id}/desactivar', [LibroController::class, 'desactivar']);
Route::put('libros/{id}/reactivar', [LibroController::class, 'reactivar']);

//  Rutas para la tabla pivote libro_autor
Route::apiResource('libro_autor', LibroAutorController::class);

//  Rutas para la gestión de préstamos
Route::apiResource('prestamos', PrestamoController::class);
Route::put('prestamos/{id}/desactivar', [PrestamoController::class, 'desactivar']);
Route::put('prestamos/{id}/reactivar', [PrestamoController::class, 'reactivar']);


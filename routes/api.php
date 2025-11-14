<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\EditorialController;
use App\Http\Controllers\AutorController;
use App\Http\Controllers\LibroController;
use App\Http\Controllers\LibroAutorController;
use App\Http\Controllers\PrestamoController;
use App\Http\Controllers\AuthController;


// ----------------------
// 🔐 LOGIN JWT
// ----------------------
Route::post('/registro', [UsuarioController::class, 'store']);

Route::post('/login', [AuthController::class, 'login']);


// ----------------------
// PRUEBA API
// ----------------------
Route::get('/user', function () {
    return response()->json([
        'status' => 'OK',
        'message' => 'API funcionando correctamente 🚀'
    ]);
});


// ----------------------
// 🟥 RUTAS ADMIN
// ----------------------
Route::middleware(['auth:api', 'tipo_usuario:admin'])->group(function () {

    // Usuarios
    Route::apiResource('usuarios', UsuarioController::class);
    Route::put('usuarios/{id}/reactivar', [UsuarioController::class, 'reactivar']);

    // Empleados
    Route::apiResource('empleados', EmpleadoController::class);
    Route::put('empleados/{id}/desactivar', [EmpleadoController::class, 'inactivo']);

    // Categorías
    Route::apiResource('categorias', CategoriaController::class);

    // Editoriales
    Route::apiResource('editoriales', EditorialController::class);
    Route::put('editoriales/{id}/desactivar', [EditorialController::class, 'desactivar']);
    Route::put('editoriales/{id}/reactivar', [EditorialController::class, 'reactivar']);

    // Autores
    Route::apiResource('autores', AutorController::class);
    Route::put('autores/{id}/desactivar', [AutorController::class, 'desactivar']);
    Route::put('autores/{id}/reactivar', [AutorController::class, 'reactivar']);

    // Libros
    Route::apiResource('libros', LibroController::class);
    Route::put('libros/{id}/desactivar', [LibroController::class, 'desactivar']);
    Route::put('libros/{id}/reactivar', [LibroController::class, 'reactivar']);

    // Libro-autor
    Route::apiResource('libro_autor', LibroAutorController::class);
    Route::put('libro_autor/{id}/desactivar', [LibroAutorController::class, 'desactivar']);
    Route::put('libro_autor/{id}/reactivar', [LibroAutorController::class, 'reactivar']);

    // Préstamos
    Route::apiResource('prestamos', PrestamoController::class);
    Route::put('prestamos/{id}/desactivar', [PrestamoController::class, 'desactivar']);
    Route::put('prestamos/{id}/reactivar', [PrestamoController::class, 'reactivar']);
});


// ----------------------
// 🟦 RUTAS BIBLIOTECARIO
// ----------------------
Route::middleware(['auth:api', 'tipo_usuario:bibliotecario'])->group(function () {

    Route::get('libros', [LibroController::class, 'index']);
    Route::get('autores', [AutorController::class, 'index']);
    Route::get('categorias', [CategoriaController::class, 'index']);

    Route::apiResource('prestamos', PrestamoController::class)->only(['index', 'store', 'update']);
});


// ----------------------
// 🟩 RUTAS USUARIO NORMAL
// ----------------------
Route::middleware(['auth:api', 'tipo_usuario:usuario'])->group(function () {

    Route::get('libros', [LibroController::class, 'index']);
    Route::get('autores', [AutorController::class, 'index']);
    Route::get('categorias', [CategoriaController::class, 'index']);

    Route::get('prestamos', [PrestamoController::class, 'index']);
});

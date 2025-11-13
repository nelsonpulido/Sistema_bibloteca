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
Route::put('empleados/{id}/desactivar', [EmpleadoController::class, 'inactivo']);

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
Route::put('libro_autor/{id}/reactivar', [LibroAutorController::class, 'desactivar']);

//  Rutas para la gestión de préstamos
Route::apiResource('prestamos', PrestamoController::class);
Route::put('prestamos/{id}/desactivar', [PrestamoController::class, 'desactivar']);
Route::put('prestamos/{id}/reactivar', [PrestamoController::class, 'reactivar']);

Route::middleware(['auth:api', 'tipo_usuario:admin'])->group(fuction ()); 

// rol de tipo usuario
route::middleware (['auth:api','tipo_usuario:admin'])->group(function (){
    route::post('/register',[AuthController::class, '']);
});

route::middleware (['auth:api','tipo_usuario:bliblotecario'])->group(function (){
    route::post('/consultaReguistro',[AuthController::class, '']); 
});


route::middleware (['auth:api','tipo_usuario:Usuario'])->group(function (){
    route::post('/seguimiento',[AuthController::class, '']);
});




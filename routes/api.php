<?php

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
use App\Http\Controllers\DashboardController;

// Rutas públicas
Route::post('registro', [UsuarioController::class, 'store']);
Route::post('login', [AuthController::class, 'login']);

Route::get('user', function () {
    return response()->json(['status' => 'OK', 'message' => 'API OK']);
});

// =====================
// RUTAS ADMIN - ACCESO COMPLETO
// =====================
Route::middleware(['jwt.auth', 'tipo_usuario:admin'])->group(function () {
    
    // Dashboard
    Route::get('statistics', [DashboardController::class, 'getStatistics']);
    Route::get('recent-activity', [DashboardController::class, 'getRecentActivity']);
    Route::get('popular-books', [DashboardController::class, 'getPopularBooks']);
    Route::get('reports', [DashboardController::class, 'getReports']);
    
    // Usuarios
    Route::apiResource('usuarios', UsuarioController::class);
    Route::put('usuarios/{id}/reactivar', [UsuarioController::class, 'reactivar']);
    
    // Empleados
    Route::apiResource('empleados', EmpleadoController::class);
    Route::put('empleados/{id}/desactivar', [EmpleadoController::class, 'inactivo']);
    
    // Categorías - ADMIN TIENE ACCESO COMPLETO
    Route::apiResource('categorias', CategoriaController::class);
    
    // Editoriales
    Route::apiResource('editoriales', EditorialController::class);
    Route::put('editoriales/{id}/desactivar', [EditorialController::class, 'desactivar']);
    Route::put('editoriales/{id}/reactivar', [EditorialController::class, 'reactivar']);
    
    // Autores - ADMIN TIENE ACCESO COMPLETO
    Route::apiResource('autores', AutorController::class);
    Route::put('autores/{id}/desactivar', [AutorController::class, 'desactivar']);
    Route::put('autores/{id}/reactivar', [AutorController::class, 'reactivar']);
    
    // Libros - ADMIN TIENE ACCESO COMPLETO
    Route::apiResource('libros', LibroController::class);
    Route::put('libros/{id}/desactivar', [LibroController::class, 'desactivar']);
    Route::put('libros/{id}/reactivar', [LibroController::class, 'reactivar']);
    
    // Libro-Autor
    Route::apiResource('libro_autor', LibroAutorController::class);
    Route::put('libro_autor/{id}/desactivar', [LibroAutorController::class, 'desactivar']);
    Route::put('libro_autor/{id}/reactivar', [LibroAutorController::class, 'reactivar']);
    
    // Préstamos - ADMIN TIENE ACCESO COMPLETO
    Route::apiResource('prestamos', PrestamoController::class);
    Route::put('prestamos/{id}/desactivar', [PrestamoController::class, 'desactivar']);
    Route::put('prestamos/{id}/reactivar', [PrestamoController::class, 'reactivar']);
});

// =====================
// RUTAS BIBLIOTECARIO - ACCESO LIMITADO
// =====================
Route::middleware(['jwt.auth', 'tipo_usuario:Bibliotecario'])->group(function () {
    // Solo consulta de catálogo
    Route::get('libros', [LibroController::class, 'index']);
    Route::get('autores', [AutorController::class, 'index']);
    Route::get('categorias', [CategoriaController::class, 'index']);
    
    // Gestión de préstamos
    Route::get('prestamos', [PrestamoController::class, 'index']);
    Route::post('prestamos', [PrestamoController::class, 'store']);
    Route::put('prestamos/{id}', [PrestamoController::class, 'update']);
    Route::get('prestamos/{id}', [PrestamoController::class, 'show']);
});

// =====================
// RUTAS USUARIO NORMAL - SOLO LECTURA
// =====================
Route::middleware(['jwt.auth', 'tipo_usuario:usuario'])->group(function () {
    // Solo consulta de catálogo
    Route::get('libros', [LibroController::class, 'index']);
    Route::get('autores', [AutorController::class, 'index']);
    Route::get('categorias', [CategoriaController::class, 'index']);
    
    // Ver sus propios préstamos
    Route::get('prestamos', [PrestamoController::class, 'index']);
});
<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Empleado;
use App\Models\Libro;
use App\Models\Prestamo;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function getStatistics()
    {
        try {
            $statistics = [
                'total_usuarios' => Usuario::count(),
                'total_empleados' => Empleado::count(),
                'total_libros' => Libro::count(),
                'prestamos_activos' => Prestamo::where('estado', 'activo')->count(),
                'activeUsers' => Usuario::where('activo', 1)->count(),
                'borrowedBooks' => Prestamo::whereNotNull('fecha_prestamo')
                    ->whereNull('fecha_devolucion')->count(),
                'pendingAlerts' => 0,
                'totalBooks' => Libro::count(),
                'totalAuthors' => \App\Models\Autor::count()
            ];

            return response()->json($statistics);
            
        } catch (\Exception $e) {
            \Log::error('Error en getStatistics: ' . $e->getMessage());
            
            return response()->json([
                'error' => 'Error al obtener estadísticas',
                'message' => $e->getMessage(),
                'total_usuarios' => 0,
                'total_empleados' => 0,
                'total_libros' => 0,
                'prestamos_activos' => 0,
                'activeUsers' => 0,
                'borrowedBooks' => 0,
                'pendingAlerts' => 0,
                'totalBooks' => 0,
                'totalAuthors' => 0
            ], 200); // Devuelve 200 con datos vacíos en lugar de 500
        }
    }

    public function getRecentActivity()
    {
        try {
            $recentActivity = Prestamo::with(['usuario', 'libro'])
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get();

            return response()->json($recentActivity);
        } catch (\Exception $e) {
            return response()->json([], 200);
        }
    }

    public function getPopularBooks()
    {
        try {
            $popularBooks = Libro::take(10)->get();
            return response()->json($popularBooks);
        } catch (\Exception $e) {
            return response()->json([], 200);
        }
    }

    public function getReports()
    {
        try {
            return response()->json([]);
        } catch (\Exception $e) {
            return response()->json([], 200);
        }
    }
}
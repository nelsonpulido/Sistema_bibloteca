<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class LibroController extends Controller
{
    /**
     * Mostrar todos los libros
     */
    public function index()
    {
        try {
            $libros = Libro::with(['categoria', 'editorial', 'autores'])->get();

            return response()->json([
                'success' => true,
                'data' => $libros
            ], 200);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al listar los libros',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Crear un nuevo libro
     */
    public function store(Request $request)
    {
        $rules = [
            'titulo' => 'required|string|max:100',
            'anio_publicacion' => 'nullable|integer',
            'isbn' => 'nullable|string|max:20|unique:libros',
            'id_categoria' => 'required|exists:categorias,id_categoria',
            'id_editorial' => 'required|exists:editoriales,id_editorial',
            'autores' => 'array',
            'autores.*' => 'exists:autores,id_autor'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $libro = Libro::create([
                'titulo' => $request->titulo,
                'anio_publicacion' => $request->anio_publicacion,
                'isbn' => $request->isbn,
                'id_categoria' => $request->id_categoria,
                'id_editorial' => $request->id_editorial,
            ]);

            if ($request->has('autores')) {
                $libro->autores()->sync($request->autores);
            }

            return response()->json([
                'success' => true,
                'message' => 'Libro creado correctamente',
                'data' => $libro
            ], 201);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear el libro',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mostrar un libro específico
     */
    public function show($id)
    {
        try {
            $libro = Libro::with(['categoria', 'editorial', 'autores'])->find($id);

            if (!$libro) {
                return response()->json([
                    'success' => false,
                    'message' => 'Libro no encontrado'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $libro
            ], 200);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener el libro',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualizar un libro existente
     */
    public function update(Request $request, $id)
    {
        $libro = Libro::find($id);

        if (!$libro) {
            return response()->json([
                'success' => false,
                'message' => 'Libro no encontrado'
            ], 404);
        }

        $rules = [
            'titulo' => 'sometimes|string|max:100',
            'anio_publicacion' => 'nullable|integer',
            'isbn' => 'nullable|string|max:20|unique:libros,isbn,' . $id . ',id_libro',
            'id_categoria' => 'sometimes|exists:categorias,id_categoria',
            'id_editorial' => 'sometimes|exists:editoriales,id_editorial',
            'autores' => 'array',
            'autores.*' => 'exists:autores,id_autor'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $libro->update($request->only([
                'titulo',
                'anio_publicacion',
                'isbn',
                'id_categoria',
                'id_editorial'
            ]));

            if ($request->has('autores')) {
                $libro->autores()->sync($request->autores);
            }

            return response()->json([
                'success' => true,
                'message' => 'Libro actualizado correctamente',
                'data' => $libro
            ], 200);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el libro',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar un libro
     */
    public function destroy($id)
    {
        $libro = Libro::find($id);

        if (!$libro) {
            return response()->json([
                'success' => false,
                'message' => 'Libro no encontrado'
            ], 404);
        }

        try {
            $libro->delete();

            return response()->json([
                'success' => true,
                'message' => 'Libro eliminado correctamente'
            ], 200);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el libro',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}



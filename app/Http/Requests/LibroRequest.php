<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LibroRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return True;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'titulo' => 'required|string|max:150',
            'anio_publicacion' => 'nullable|integer',
            'isbn' => 'nullable|string|max:20|unique:libros,isbn',
            'id_categoria' => 'required|exists:categorias,id_categoria',
            'id_editorial' => 'required|exists:editoriales,id_editorial',
        ];
    }
}

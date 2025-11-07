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
        $isUpdate = in_array($this->method(), ['PUT', 'PATCH']);

        return [
            'titulo' => ($isUpdate ? 'sometimes' : 'required').'|string|max:50',
            'anio_publicacion' => 'nullable|integer',
            'isbn' => ($isUpdate ? 'sometimes' : 'required').'|string|max:20|unique:libros,isbn,',
            
            'id_categoria' => 'required|exists:categorias,id_categoria',
            'id_editorial' => 'required|exists:editoriales,id_editorial',
        ];
    }

    public function messages(): array
    {
        return [
            'titulo.required' => 'El título del libro es obligatorio.',
            'isbn.unique' => 'El ISBN ya está registrado.',
            'id_categoria.required' => 'Debe seleccionar una categoría.',
            'id_editorial.required' => 'Debe seleccionar una editorial.',
        ];
    }
}

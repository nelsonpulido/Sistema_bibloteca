<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PrestamoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return TRue;
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
            'id_usuario' => ($isUpdate ? 'sometimes' : 'required').'|exists:usuarios,id',
            'id_libro' => ($isUpdate ? 'sometimes' : 'required').'|exists:libros,id_libro',
            'fecha_prestamo' => ($isUpdate ? 'sometimes' : 'required').'|date',
            'fecha_devolucion' => 'nullable|date|after_or_equal:fecha_prestamo',
            'estado' => ($isUpdate ? 'sometimes' : 'required').'|string|max:30',
        ];
    }

    public function messages(): array
    {
        return [
            'id_usuario.required' => 'Debe seleccionar un usuario.',
            'id_libro.required' => 'Debe seleccionar un libro.',
            'fecha_prestamo.required' => 'La fecha de préstamo es obligatoria.',
            'estado.required' => 'El estado del préstamo es obligatorio.',
        ];
    }
}
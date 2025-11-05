<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsuarioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'dni' => 'required|string|max:20',
            'nombre' => 'required|string|max:50',
            'apellidos' => 'required|string|max:50',
            'email' => 'required|email|max:100|unique:usuarios,email',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:180',
            'fecha_registro' => 'nullable|date',
            'tipo_usuario' => 'required|string|max:30',
            'contraseña' => 'required|string|min:6',
            'activo' => 'boolean',
        ];
    }
}

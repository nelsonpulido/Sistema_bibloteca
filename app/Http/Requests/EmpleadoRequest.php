<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmpleadoRequest extends FormRequest
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
        $isUpdate = in_array($this->method(),['PUT', 'PATCH']);

       return [
            'id_usuario' =>($isUpdate ? 'sometimes' : 'required').'|required|exists:usuarios,id',
            'cargo' =>($isUpdate ? 'sometimes' : 'required').'|required|string|max:30',
            'fecha_contratacion' => 'nullable|date',
        ];
    }

    public function messages(): array
    {
        return [
            'id_usuario.required' => 'Debe asociar un usuario.',
            'id_usuario.exists' => 'El usuario no existe.',
            'cargo.required' => 'El cargo es obligatorio.',
            'cargo.max' => 'El cargo no puede tener más de 30 caracteres.',
        ];
    }
}

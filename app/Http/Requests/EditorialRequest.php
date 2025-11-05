<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditorialRequest extends FormRequest
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
            'nombre' => ($isUpdate ? 'sometimes' : 'required').'|required|string|max:50',
            'direccion' => 'nullable|string|max:50',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:30',
        ];
    }

    public function message():array
    {
        return [
            'nombre.required' => 'El nombre de la editorial es obligatorio.',
            'nombre.max' => 'El nombre no puede tener más de 50 caracteres.',
        ];
    }
}

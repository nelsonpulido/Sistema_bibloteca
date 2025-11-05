<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AutorRequest extends FormRequest
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
        $isUpdate = in_array($this->method(),['PUT','PATCH']);
        return [
            'nombre' =>($isUpdate ? 'sometimes' : 'required').'|required|string|max:50',
            'nacionalidad' => 'nullable|string|max:50',
            'fecha_nacimiento' => 'nullable|date',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre del autor es obligatorio.',
            'nombre.max' => 'El nombre no puede superar los 100 caracteres.',
        ];
    }
}

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
        $isUpdate = in_array($this->method(),['PUT', 'PATCH']);


        return [
            'dni'=>($isUpdate ? 'sometime' : 'required').'|string|max:10',
            'nombre'=>($isUpdate ? 'sometime' : 'required').'|string,max:30|min:15',
            'apellidos'=>($isUpdate ? 'sometime' : 'required').'|string|max:20|min:10',
            'email'=>($isUpdate ? 'sometime' : 'required').'|email|max:50|unique:usuarios,email',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:50',
            'fecha_registro' => 'nullable|date',
            'tipo_usuario' => ($isUpdate ? 'sometimes' : 'required').'|string|max:30',
            'password' => ($isUpdate ? 'sometimes' : 'required').'|string|min:6',
            'activo' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'dni.required' => 'El DNI es obligatorio.',
            'dni.max' => 'El DNI no puede tener más de 10 caracteres.',

            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.max' => 'El nombre no puede superar los 30 caracteres.',

            'apellidos.required' => 'Los apellidos son obligatorios.',
            'apellidos.max' => 'Los apellidos no pueden superar los 20 caracteres.',

            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Debe ingresar un correo válido.',
            'email.unique' => 'Este correo ya está registrado.',

            'tipo_usuario.required' => 'Debe especificar el tipo de usuario.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
        ];
    }
}

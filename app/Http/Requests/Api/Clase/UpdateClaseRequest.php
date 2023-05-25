<?php

namespace App\Http\Requests\Api\Clase;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClaseRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nombre' => 'required|string',
            'descripcion' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'nombre.required' => 'El nombre de la clase es obligatorio.',
            'nombre.string' => 'El nombre de la clase debe ser una cadena de texto.',
            'descripcion.string' => 'La descripción de la clase debe ser una cadena de texto.',
        ];
    }
}

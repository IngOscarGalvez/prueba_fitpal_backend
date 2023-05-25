<?php

namespace App\Http\Requests\Api\Clase;

use App\Traits\ApiResponser;
use Illuminate\Http\Response;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class CreateClaseRequest extends FormRequest
{
    use ApiResponser;

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

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->errorResponse('Unprocessable Entity', Response::HTTP_UNPROCESSABLE_ENTITY,$validator->errors()));
    }
}

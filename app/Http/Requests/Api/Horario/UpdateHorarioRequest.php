<?php

namespace App\Http\Requests\Api\Horario;

use App\Traits\ApiResponser;
use Illuminate\Http\Response;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class UpdateHorarioRequest extends FormRequest
{
    use ApiResponser;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'fecha' => 'required|date',
            'hora_inicio' => 'required',
            'hora_final' => 'required|after:hora_inicio',
            'clase_id' => 'required|exists:clases,id'
        ];
    }

    public function messages()
    {
        return [
            'fecha.required' => 'La fecha es requerida.',
            'fecha.date' => 'La fecha debe ser una fecha válida.',
            'hora_inicio.required' => 'La hora de inicio es requerida.',
            'hora_inicio.date_format' => 'La hora de inicio debe tener el formato HH:mm.',
            'hora_final.required' => 'La hora final es requerida.',
            'hora_final.date_format' => 'La hora final debe tener el formato HH:mm.',
            'hora_final.after' => 'La hora debe ser mayor a la hora de inicio',
            'clase_id.required' => 'El ID de la clase es requerido.',
            'clase_id.exists' => 'El ID de la clase no existe en la base de datos.'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->errorResponse('Unprocessable Entity', Response::HTTP_UNPROCESSABLE_ENTITY,$validator->errors()));
    }
}

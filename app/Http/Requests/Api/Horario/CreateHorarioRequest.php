<?php

namespace App\Http\Requests\Api\Horario;

use App\Traits\ApiResponser;
use Illuminate\Http\Response;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;



class CreateHorarioRequest extends FormRequest
{
    use ApiResponser;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'fecha' => ['required','date'],
            'hora_inicio' => ['required'],
            'hora_final' => ['required','after:hora_inicio'],
            'clase_id' => ['required','exists:clases,id']
        ];
    }

    public function messages()
    {
        return [
            'fecha.required' => 'El campo fecha es obligatorio.',
            'fecha.date' => 'El campo fecha debe ser una fecha válida.',
            'hora_inicio.required' => 'El campo hora inicio es obligatorio.',
            'hora_inicio.date_format' => 'El campo hora inicio debe tener el formato HH:mm.',
            'hora_final.required' => 'El campo hora final es obligatorio.',
            'hora_final.date_format' => 'El campo hora final debe tener el formato HH:mm.',
            'hora_final.after' => 'La hora debe ser mayor a la hora de inicio',
            'clase_id.required' => 'El campo clase ID es obligatorio.',
            'clase_id.exists' => 'El ID de la clase no existe en la base de datos.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->errorResponse('Unprocessable Entity', Response::HTTP_UNPROCESSABLE_ENTITY,$validator->errors()));
    }

}

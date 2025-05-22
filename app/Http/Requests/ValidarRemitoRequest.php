<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidarRemitoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'conclusion'   => 'required',
            'nro_nota'     => 'required|integer',
            'remitente'    => 'required|integer|not_in:0',
            'muestras'     => 'required',
        ];
    }

    public function messages()
{
    return [
        'conclusion.required' => 'La conclusión es requerido',
        'nro_nota.required|integer'   => 'Se necesita un numero de nota... solo el número',
        'remitente.required|integer|not_in:0'  => 'El remitente es requerido',
        'muestras.required'   => 'Las muestras a remitir son requeridas',
    ];
}
}

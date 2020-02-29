<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidarFormularioRequest extends FormRequest
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
            'tipo_prestacion'   => 'required',
            'entrada'           => 'required',
            'matriz'            => 'required',
            'tipo_muestra'      => 'required',
            'muestra'           => 'required',
            'solicitante'       => 'required|integer|not_in:0',
            'remitente'         => 'required|integer|not_in:0',
            'localidad'         => 'required|integer|not_in:0',
            'provincia'         => 'required',
        ];
    }
    public function messages()
    {
        return [

            'solicitante.required'   => 'El :attribute es obligatorio.',
                    
        ];
    }
    public function attributes()
    {
        return [

            'solicitante'        => 'Solicitante',
                
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EnderecoRequest extends FormRequest
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
            'cep' => 'required|digits:8',
            'endereco' => 'required',
            'bairro' => 'required',
            'numero' => 'required|numeric',
            'estado' => 'required|uf',
            'cidade' => 'required'
        ];
    }
}

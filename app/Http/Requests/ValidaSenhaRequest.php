<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidaSenhaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function rules()
    {
        return [
            'email' => 'required|email|exists:acesso',
            'senha' =>'required|required_with:confirma_senha|same:confirma_senha|min:8',
            'confirma_senha' => 'min:8',
        ];
    }

    public function messages()
    {
        return [
            'email.exists' => 'Não foi possível encontrar seu email.',
        ];
    }
}

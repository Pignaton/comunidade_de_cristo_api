<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecuperaSenhaRequest extends FormRequest
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
            'email' => 'required|email|exists:acesso',
        ];
    }

    public function messages()
    {
        return [
            'email.exists' => 'Não foi possível encontrar seu email.',
        ];
    }
}

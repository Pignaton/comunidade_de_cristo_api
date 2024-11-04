<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AcessoRequest extends FormRequest
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
            'nome' => 'required|regex:/^([a-zA-ZwÀ-ú]+)(\s[a-zA-ZwÀ-ú]+)*$/|min:3|max:20',
            'email' => 'required|email|unique:acesso|max:50',
        ];
    }

    public function messages()
    {
        return [
            'nome.regex' => 'O campo nome deve conter só letras',
            'email' => 'O campo de e-mail deve estar preenchido',
        ];
    }
}

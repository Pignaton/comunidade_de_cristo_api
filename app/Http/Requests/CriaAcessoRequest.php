<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CriaAcessoRequest extends FormRequest
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
            'nome' => 'required|regex:/^([a-zA-ZwÀ-ú]+)(\s[a-zA-ZwÀ-ú]+)*$/|max:50',
            'email' => 'required|email|unique:acesso,email|max:50',
            'telefone' => 'nullable|min:14|max:15', //regex:/^\(?\d{2}\)?\s?\d{4,5}-\d{4}$/
            'sexo' => 'required|in:M,F',
            'senha' => 'required|min:6',
            'confirma_senha' => 'required|same:senha',
        ];
    }

    public function messages()
    {
        return [
            'nome.required' => 'O campo nome é obrigatório.',
            'nome.regex' => 'O campo nome deve conter apenas letras e espaços.',
            'email.required' => 'O campo e-mail é obrigatório.',
            'email.email' => 'O campo de e-mail deve ser um endereço de e-mail válido.',
            'email.unique' => 'O e-mail já está em uso.',
            //'telefone.regex' => 'O telefone deve seguir o formato (XX) XXXXX-XXXX ou (XX) XXXX-XXXX.',
            'telefone.min' => 'O telefone deve seguir o formato (XX) XXXXX-XXXX ou (XX) XXXX-XXXX.',
            'telefone.max' => 'O telefone não pode exceder 15 caracteres.',
            'sexo.required' => 'O campo sexo é obrigatório.',
            'sexo.in' => 'O valor selecionado para sexo é inválido.',
            'senha.required' => 'O campo senha é obrigatório.',
            'senha.min' => 'A senha deve ter no mínimo 6 caracteres.',
            'confirma_senha.required' => 'A confirmação da senha é obrigatória.',
            'confirma_senha.same' => 'A confirmação da senha deve coincidir com a senha.',
        ];
    }
}

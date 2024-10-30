<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CadastroRequest extends FormRequest
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
            'email' => 'nullable|email|unique:pessoa|max:50',
            'idade' => 'required|numeric|min:1|max:99',
            'culto' => 'required',
            'campanha' => 'nullable',
            'sexo' => 'required|in:M,F', //required_without_all
            'telefone' => 'nullable|min:14|max:15', //regex:/^\(?\d{2}\)?\s?\d{4,5}-\d{4}$/
            'cep' => 'nullable|digits:8',
            //'membro_igreja' => 'nullable|in:S,N'
        ];
    }

    public function messages()
    {
        return [
            'nome.required' => 'O campo nome é obrigatório.',
            'nome.regex' => 'O campo nome deve conter apenas letras e espaços.',
            'email.email' => 'O campo de e-mail deve ser um endereço de e-mail válido.',
            'email.unique' => 'O e-mail já está em uso.',
            'idade.numeric' => 'A idade deve ser um número.',
            'idade.min' => 'A idade deve ser pelo menos 1.',
            'idade.max' => 'A idade deve ser no máximo 99.',
            'culto.required' => 'Deve selecionar pelo menos o dia do culto.',
            'sexo.required' => 'O sexo deve ser selecionado.',
            //'telefone.regex' => 'O telefone deve seguir o formato (XX) XXXXX-XXXX ou (XX) XXXX-XXXX.',
            'telefone.min' => 'O telefone deve seguir o formato (XX) XXXXX-XXXX ou (XX) XXXX-XXXX.',
            //'telefone.max' => 'O telefone não pode exceder 15 caracteres.',
            'cep.digits' => 'O CEP deve conter exatamente 8 dígitos.',
        ];
    }

}

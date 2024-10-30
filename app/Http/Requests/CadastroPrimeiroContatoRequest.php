<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CadastroPrimeiroContatoRequest extends FormRequest
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
            'cod_pessoa' => 'required',
            'nome_remetente' => 'required|regex:/^([a-zA-ZwÀ-ú]+)(\s[a-zA-ZwÀ-ú]+)*$/|max:50',
            'ind_status_contato_via' => 'required|in:W,L',
            'ind_status_celula' => 'required|in:S,N',
            'descricao' => 'nullable|max:200',
        ];
    }

    public function messages()
    {
        return [
            'nome_remetente.regex' => 'O campo nome deve conter só letras',
            'ind_status_celula' => 'Deve estar devidamente selecionado',
            'ind_status_contato_via' => 'O contato deve estar devidamente selecionado',
            'descricao' => 'Limite de máximo 200 caracteres'
        ];
    }

}

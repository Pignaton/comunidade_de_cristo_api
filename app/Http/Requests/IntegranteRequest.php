<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IntegranteRequest extends FormRequest
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
            //'cod_pequeno_grupo' => 'required',
            'nome' => 'required|regex:/^([a-zA-ZwÀ-ú]+)(\s[a-zA-ZwÀ-ú]+)*$/|min:3|max:20',
            //'sobrenome' => 'required|regex:/^([a-zA-ZwÀ-ú]+)(\s[a-zA-ZwÀ-ú]+)*$/|min:3|max:20',
            'email' => 'required|email|unique:integrante|max:50',
           //'idade' => 'required|numeric|min:1|max:99',
            'cpf' => 'required|cpf|unique:integrante',
            'data_nascimento' => 'required|date_format:"d/m/Y"',
            'estado_civil' => 'required|in:S,C,V,A,D,N,I',
            'ind_sexo' => 'required|in:M,F', //required_without_all
            'telefone' => 'required|celular',//(01)[0-9]{9}
            'senha' =>'required|required_with:confirma_senha|same:confirma_senha|min:8',
            'confirma_senha' => 'min:8',
            'cep' => 'required|digits:8',
            'endereco' => 'required',
            'bairro' => 'required',
            'numero' => 'required|numeric',
            'estado' => 'required|uf',
            'cidade' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'nome.regex' => 'O campo nome deve conter só letras',
            'culto.required' => 'Deve selecionar pelo menos o dia do culto',
            'email' => 'O campo de e-mail deve estar preenchido',
            //'idade' => 'A idade do membro deve estar preenchida',
            'sexo' => 'O Sexo deve estar devidamente selecionado',
            'data_nascimento.date_format' => 'O campo data nascimento não corresponde ao formato dia/mes/Ano.',
            //'cod_pequeno_grupo.required' => 'selecione uma opção no pequeno grupo'
        ];
    }
}

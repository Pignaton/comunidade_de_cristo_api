<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PequenoGrupoRequest extends FormRequest
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
            'cod_integrante' => 'required',
            'nom_grupo' => 'required|min:3|max:20',
            'tipo_pequeno_grupo' => 'required|in:A,B,C,D',
            'pequeno_grupo_genero' => 'required|in:M,H,O',
            'qtd_integrante' => 'required|numeric',
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
            'qtd_integrante.required' => 'Informe a quantidade de integrantes.',
            'pequeno_grupo_genero.required' => 'Informe o genero do grupo.',
            'tipo_pequeno_grupo.required' => 'Informe o tipo do grupo.',
            'nom_grupo.required' => 'O campo nome do grupo é obrigatório.',
            'cod_integrante.required' => 'Selecione o lider do PG.',
        ];
    }
}

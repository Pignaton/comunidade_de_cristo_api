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
            'nome'  => 'required|regex:/^([a-zA-ZwÀ-ú]+)(\s[a-zA-ZwÀ-ú]+)*$/|max:50',
            'email' => 'nullable|email|unique:pessoa||max:50',
            'idade' => 'required|numeric|min:1|max:99',
            'culto' => 'required',
            'campanha' => 'nullable',
            'sexo'  => 'required', Rule::in(['M', 'F']), //required_without_all
            'telefone' => 'nullable|regex:/[0-9]{9}/'//(01)[0-9]{9}
        ];
    }

    public function messages()
    {
        return [
            'nome.regex' => 'O campo nome deve conter só letras',
            'culto.required' => 'Deve selecionar pelo menos o dia do culto',
            'email' => 'O campo de e-mail deve estar preenchido',
            'idade' => 'A idade do membro deve estar preenchida',
            'sexo' => 'O Sexo deve estar devidamente selecionado'
        ];
    }
}

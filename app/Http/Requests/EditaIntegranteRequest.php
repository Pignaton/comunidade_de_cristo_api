<?php

namespace App\Http\Requests;

use App\Models\Acesso;
use App\Models\Integrante;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditaIntegranteRequest extends FormRequest
{
    protected $idColumn = 'cod_integrante';
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        ;//return auth()->check();
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
            'email' => 'required', 'email', Rule::unique((new Integrante)->getTable())->ignore($this->cod_integrante, 'cod_integrante'), 'max:50',
            'email' => Rule::unique((new Acesso)->getTable())->ignore($this->cod_integrante, 'cod_integrante'),
            'cpf' => 'required|cpf|unique:integrante,cpf,'.$this->cod_integrante.',cod_integrante',
            'data_nascimento' => 'required|date_format:"d/m/Y"|date',
            'estado_civil' => 'required|in:S,C,V,A,D,N,I',
            'ind_sexo' => 'required|in:M,F', //required_without_all
            'telefone' => 'required|celular',//(01)[0-9]{9}
        ];
    }
}

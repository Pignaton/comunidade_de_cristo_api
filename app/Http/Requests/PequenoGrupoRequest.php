<?php

namespace App\Http\Requests;

use App\Models\Integrante;
use App\Models\LiderPequenoGrupo;
use App\Models\PequenoGrupo;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PequenoGrupoRequest extends FormRequest
{
    protected $idColumn = 'cod_integrante';
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
        //Rule::exists((new LiderPequenoGrupo)->getTable(), 'cod_pequeno_grupo')->where( 'cod_lider_pequeno_grupo',$this->cod_integrante),
        return [

            'cod_integrante' => 'required|exists:integrante,cod_integrante|'.Rule::unique((new LiderPequenoGrupo)->getTable())->ignore($this->cod_integrante, 'cod_lider_pequeno_grupo'),
            'nom_grupo' => 'required|min:3|max:20',
            'tipo_pequeno_grupo' => 'required|in:A,B,C,D',
            'pequeno_grupo_genero' => 'required|in:M,H,O',
            'qtd_integrante' => 'required|numeric|min:1|max:99',
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
        $nomePG = $this->buscaPequenoGrupo($this->cod_integrante);
        $nomePG = $nomePG === null ? '' : '/ PG: ' . $nomePG->nom_grupo;

        return [
            'qtd_integrante.required' => 'Informe a quantidade de integrantes.',
            'pequeno_grupo_genero.required' => 'Informe o genero do grupo.',
            'tipo_pequeno_grupo.required' => 'Informe o tipo do grupo.',
            'nom_grupo.required' => 'O campo nome do grupo é obrigatório.',
            'cod_integrante.required' => 'Selecione o lider do PG.',
            'cod_integrante.unique' => 'O integrante já é lider de um PG' . $nomePG . '.',
            'cod_integrante.exists' => 'O integrante/PG não existe.',
        ];
    }

    //Retorna qual grupo o lider de PG pertence.
    protected function buscaPequenoGrupo()
    {
        return DB::table('lider_pequeno_grupo as a')
            ->select('nom_grupo')
            ->join('pequeno_grupo as pg', 'a.cod_pequeno_grupo', '=', 'pg.cod_pequeno_grupo')
            ->where('cod_integrante', $this->cod_integrante)->first();
    }
}

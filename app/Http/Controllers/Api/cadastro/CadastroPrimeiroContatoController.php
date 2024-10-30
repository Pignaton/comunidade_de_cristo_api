<?php

namespace App\Http\Controllers\Api\Cadastro;

use App\Http\Requests\CadastroPrimeiroContatoRequest;
use App\Models\Campanha;
use App\Models\Culto;
use App\Models\Endereco;
use App\Models\PrimeiroContato;
use App\Models\Sistema;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Validation\Rules\Exists;

class CadastroPrimeiroContatoController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function cadastroPrimeiroContato(CadastroPrimeiroContatoRequest $request)
    {
        $array = ['error' => ''];

        $array['sucesso'] = $request->validated();

        $primeiroContatoExist = PrimeiroContato::where(['cod_pessoa' => $request->cod_pessoa])->first();

        if ($primeiroContatoExist === null) {
            $pessoa = new PrimeiroContato();
            $pessoa->cod_pessoa = $request->cod_pessoa;
            $pessoa->nome_remetente = $request->nome_remetente;
            $pessoa->ind_status_contato_via = $request->ind_status_contato_via;
            $pessoa->ind_status_celula = $request->ind_status_celula;
            $pessoa->nome_celula = $request->nome_celula;
            $pessoa->descricao = $request->descricao;
            $pessoa->save();
        } else {
            PrimeiroContato::where('cod_pessoa', $request->cod_pessoa)
                ->update(['nome_remetente' => $request->nome_remetente,
                    'ind_status_contato_via' => $request->ind_status_contato_via,
                    'ind_status_celula' => $request->ind_status_celula,
                    'nome_celula' => $request->nome_celula,
                    'descricao' => $request->descricao
                ]);
        }

        return $array;
    }

    public function getPrimeiroContato(Request $request): array
    {
        $array = ['error' => ''];

        $pessoa = PrimeiroContato::where(['cod_pessoa' => $request->cod_pessoa])->get();
        if($pessoa){
            $array['informacao'] = $pessoa;
            return $array;
        }

        return $array;
    }
}

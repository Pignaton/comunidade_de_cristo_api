<?php

namespace App\Http\Controllers\Api\Cadastro;

use App\Http\Requests\CadastroRequest;
use App\Models\Campanha;
use App\Models\Culto;
use App\Models\Endereco;
use App\Models\Pessoa;
use App\Models\Sistema;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class CadastroController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function cadastro(CadastroRequest $request)
    {
        $array = ['error' => ''];

        $array['sucesso'] = $request->validated();

        $pessoa = new Pessoa();
        $pessoa->cod_culto = $request->culto;
        $pessoa->cod_campanha = $request->campanha;
        $pessoa->nome = $request->nome;
        $pessoa->idade = $request->idade;
        $pessoa->email = $request->email;
        $pessoa->telefone = $request->telefone;
        $pessoa->sexo = $request->sexo;
        $pessoa->estado_civil = $request->estado_civil;
        $pessoa->save();

        if (!empty($request->cep) || !empty($request->bairro)) {
            $endereco = new Endereco();
            $endereco->cod_pessoa = $pessoa->cod_pessoa;
            $endereco->cep = $request->cep;
            $endereco->endereco = $request->endereco;
            $endereco->bairro = $request->bairro;
            $endereco->numero = $request->numero;
            $endereco->complemento = $request->complemento;
            $endereco->cidade = $request->cidade;
            $endereco->estado = $request->estado;
            $endereco->save();
        }

        return $array;
    }

    public function listaCultos()
    {
        $array = ['error' => ''];

        $cultos = Culto::all();

        if ($cultos) {
            $array['cultos'] = $cultos;
            return $array;
        } else {
            $array['error'] = 'Ocorreu um erro!';
            return $array;
        }
        return $array;
    }

    public function listaCampanhas()
    {
        $array = ['error' => ''];

        $campanhas = Campanha::all();

        if ($campanhas) {
            $array['campanhas'] = $campanhas;
            return $array;
        } else {
            $array['error'] = 'Ocorreu um erro!';
            return $array;
        }
        return $array;
    }

    public function exibeCampos()
    {
        $array = ['error' => ''];
        $sistema = Sistema::all();
        $array['sistema'] = $sistema;
        return $array;
    }
}

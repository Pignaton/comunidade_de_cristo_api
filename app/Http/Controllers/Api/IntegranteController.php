<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\IntegranteRequest;
use App\Http\Controllers\Controller;
use App\Models\EnderecoIntegrante;
use App\Models\Integrante;
use App\Models\Acesso;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class IntegranteController extends Controller
{
    public function cadastro(IntegranteRequest $request)
    {
        $array = ['error' => ''];

        $request->validated();

        $integrante = new Integrante();
        $integrante->cod_pequeno_grupo = $request->cod_pequeno_grupo;
        $integrante->nome = $request->nome;
        $integrante->idade = $request->idade;
        $integrante->email = $request->email;
        $integrante->cpf = $request->cpf;
        $integrante->telefone = $request->telefone;
        $integrante->data_nascimento = converteDateBD($request->data_nascimento);
        $integrante->estado_civil = $request->estado_civil;
        $integrante->ind_sexo = $request->ind_sexo;
        $integrante->save();

        $endereco = new EnderecoIntegrante();
        $endereco->cod_integrante = $integrante->cod_integrante;
        $endereco->cep = $request->cep;
        $endereco->endereco = $request->endereco;
        $endereco->bairro = $request->bairro;
        $endereco->numero = $request->numero;
        $endereco->complemento = $request->complemento;
        $endereco->cidade = $request->cidade;
        $endereco->estado = $request->estado;
        $endereco->longitude = $request->longitude;
        $endereco->latitude = $request->latitude;
        $endereco->save();

        $senha_hash = Hash::make($request->senha);

        //cria o usuário
        $nomeCompleto = $request->nome . ' ' . $request->sobrenome;
        $nomeSobrenome = explode(' ', $nomeCompleto);
        $rest = substr($nomeSobrenome[0], 0, 1);
        $usuario = strtolower($rest . $nomeSobrenome[1]);

        // Cria ACESSO para o integrante
        $acesso = new Acesso();
        $acesso->cod_integrante = $integrante->cod_integrante;
        $acesso->nome = $nomeCompleto;
        $acesso->usuario = $usuario;
        $acesso->email = $request->email;
        $acesso->senha = $senha_hash;
        $acesso->nivel = 0;
        $acesso->save();

        $array['sucesso'] = 'Seu cadastro foi feito com sucesso.';

        return $array;
    }

    public function listaIntegranteUnico(Request $request)
    {
        $array = ['error' => ''];

        $integrante = Integrante::find($request->cod_integrante);
        $endereco = EnderecoIntegrante::where('cod_integrante', $request->cod_integrante)->get();
        if (empty($integrante)) {
            $array['error'] = 'Não foi possivel encontrar esse visitante.';
            return $array;
        }
        $array['integrantes'] = $integrante;
        $array['endereco'] = $endereco;

        return $array;
    }

    public function listaIntegrantes()
    {
        $array = ['error' => ''];

        $integrante = Integrante::listaIntegrantes();
        $array['integrantes'] = $integrante;

        return $array;
    }


    public function deletaIntegrante(Request $request)
    {
        $array = ['error' => ''];

        if (empty($request->cod_integrante)) {
            $array['error'] = 'Informe o codigo integrante';
        }
        $integrante = Integrante::find($request->cod_integrante);
        if ($integrante === null) {
            $array['error'] = 'Não foi possivel deletar esse integrante';
            return $array;
        }
        $integrante->delete();

        $array['sucesso'] = $integrante;
        return $array;
    }
}

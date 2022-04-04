<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\EditaIntegranteRequest;
use App\Http\Requests\EnderecoRequest;
use App\Http\Requests\IntegranteRequest;
use App\Http\Controllers\Controller;
use App\Mail\InformaCadastro;
use App\Mail\LiberaAcesso;
use App\Models\EnderecoIntegrante;
use App\Models\Integrante;
use App\Models\Acesso;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use DateTime;

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

        $maildata = [
            'nome' => $request->nome,
            'email' => $request->email,
        ];

        Mail::to($request->email)->send(new InformaCadastro($maildata));

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

    protected function statusIntegrante(Request $request)
    {
        $array = ['error' => ''];

        if ($request->status === 'A') {
            $status = 'ativado';
        } elseif ($request->status === 'I') {
            $status = 'inativado';
        } else {
            $status = 'Bloqueado';
        }

        $acesso = Acesso::find($request->cod_usuario);
        $acesso->status = $request->status;
        $acesso->save();

        if ($acesso !== null) {
            $usuario = Acesso::where('cod_usuario', $request->cod_usuario)->first();
            if ($request->status === 'A') {
                $maildata = ['nome' => $usuario->nome];
                Mail::to($usuario->email)->send(new LiberaAcesso($maildata));
            }
        }

        $array['sucesso'] = 'Acesso do ' . $usuario->nome . ' foi ' . $status;

        return $array;
    }

    public function editaIntegrante(EditaIntegranteRequest $request)
    {
        $array = ['error' => ''];

        // Separa em dia, mês e ano
        list($dia, $mes, $ano) = explode('/', $request->data_nascimento);
        // Descobre que dia é hoje e retorna a unix timestamp
        $hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        // Descobre a unix timestamp da data de nascimento
        $diadonascimento = mktime( 0, 0, 0, $mes, $dia, $ano);
        // Depois apenas fazemos o cálculo já citado
        $idade = floor((((($hoje - $diadonascimento) / 60) / 60) / 24) / 365.25);

        $integrante = Integrante::find($request->cod_integrante);
        $integrante->nome = $request->nome;
        $integrante->email = $request->email;
        $integrante->idade = $idade;
        $integrante->cpf = $request->cpf;
        $integrante->telefone = $request->telefone;
        $integrante->data_nascimento = converteDateBD($request->data_nascimento);
        $integrante->estado_civil = $request->estado_civil;
        $integrante->ind_sexo = $request->ind_sexo;
        $integrante->save();

        // Cria ACESSO para o integrante
        Acesso::where('cod_integrante', $request->cod_integrante)
            ->update(['nome' => $request->nome, 'email' => $request->email]);

        $array['sucesso'] = 'Seu conta foi atualizado.';

        return $array;
    }

    protected function alteraSenhaIntegrante(Request $request)
    {
        $array = ['error' => ''];

        $request->validate([
            'senha' => 'required|required_with:confirma_senha|same:confirma_senha|min:8',
            'confirma_senha' => 'min:8',
        ]);

        $senha_hash = Hash::make($request->senha);

        Acesso::where('cod_integrante', $request->cod_integrante)
            ->update(['senha' => $senha_hash]);

        $array['sucesso'] = 'Senha atualizado com sucesso.';
        return $array;
    }

    protected function alteraEnderecoIntegrante(EnderecoRequest $request)
    {
        $array = ['error' => ''];

        EnderecoIntegrante::where('cod_integrante', $request->cod_integrante)
        ->update(['cep' => $request->cep,
        'endereco' => $request->endereco,
        'bairro' => $request->bairro,
        'numero' => $request->numero,
        'complemento' => $request->complemento,
        'cidade' => $request->cidade,
        'estado' => $request->estado,
        'longitude' => $request->longitude,
        'latitude' => $request->latitude,
        ]);

        $array['sucesso'] = 'Endereço atualizado.';

        return $array;
    }
}

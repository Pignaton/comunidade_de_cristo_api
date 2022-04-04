<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PequenoGrupoRequest;
use App\Models\Integrante;
use App\Models\LiderPequenoGrupo;
use App\Models\PequenoGrupo;
use App\Models\EnderecoPequenoGrupo;
use Illuminate\Http\Request;

class PequenoGrupoController extends Controller
{
    public function cadastro(PequenoGrupoRequest $request)
    {
        $array = ['error' => ''];

        $request->validated();

        $pg = new PequenoGrupo();
        $pg->nom_grupo = $request->nom_grupo;
        $pg->tipo_pequeno_grupo = $request->tipo_pequeno_grupo;
        $pg->pequeno_grupo_genero = $request->pequeno_grupo_genero;
        $pg->qtd_integrante = $request->qtd_integrante;
        $pg->save();

        //pega as informações do lider;
        $integrante = Integrante::find($request->cod_integrante);

        $lpg = new LiderPequenoGrupo();
        $lpg->cod_pequeno_grupo = $pg->cod_pequeno_grupo;
        $lpg->cod_integrante = $request->cod_integrante;
        $lpg->nom_lider = $integrante->nome;
        $lpg->idade = $integrante->idade;
        $lpg->email = $integrante->email;
        $lpg->save();

        $endereco = new EnderecoPequenoGrupo();
        $endereco->cod_pequeno_grupo = $pg->cod_pequeno_grupo;
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

        $array['sucesso'] = 'Pg cadastrado com sucesso.';
        return $array;
    }

    public function listaPequenoGrupoUnico(Request $request)
    {
        $array = ['error' => ''];

        $pg = PequenoGrupo::find($request->cod_pequeno_grupo);
        $endereco = EnderecoPequenoGrupo::where('cod_pequeno_grupo', $request->cod_pequeno_grupo)->get();

        if (empty($pg)) {
            $array['error'] = 'Não encontramos esse PG.';
            return $array;
        }
        $array['pg'] = $pg;
        $array['endereco'] = $endereco;

        return $array;
    }

    public function listaPequenoGrupo()
    {
        $array = ['error' => ''];

        $pg = PequenoGrupo::listaPequenosGrupos();
        $array['pg'] = $pg;

        return $array;
    }

    public function deletaPequenoGrupo(Request $request)
    {
        $array = ['error' => ''];

        if (empty($request->cod_pequeno_grupo)) {
            $array['error'] = 'Informe o codigo pequeno grupo';
        }
        $pg = PequenoGrupo::find($request->cod_pequeno_grupo);
        if ($pg === null) {
            $array['error'] = 'Não foi possivel deletar esse pequeno grupo';
            return $array;
        }
        $pg->delete();

        $array['sucesso'] = $pg;
        return $array;
    }

    public function editaPequenoGrupo(PequenoGrupoRequest $request)
    {
        $array = ['error' => ''];

        $request->validated();

        $pg = PequenoGrupo::find($request->cod_pequeno_grupo);
        $pg->nom_grupo = $request->nom_grupo;
        $pg->tipo_pequeno_grupo = $request->tipo_pequeno_grupo;
        $pg->pequeno_grupo_genero = $request->pequeno_grupo_genero;
        $pg->qtd_integrante = $request->qtd_integrante;
        $pg->save();

        //pega as informações do lider
        $integrante = Integrante::find($request->cod_integrante);

        LiderPequenoGrupo::where('cod_pequeno_grupo', $request->cod_pequeno_grupo)
            ->update([
                'cod_integrante' => $integrante->cod_integrante,
                'nom_lider' => $integrante->nome,
                'idade' => $integrante->idade,
                'email' => $integrante->email
            ]);

        EnderecoPequenoGrupo::where('cod_pequeno_grupo', $request->cod_pequeno_grupo)
            ->update([
                'cep' => $request->cep,
                'endereco' => $request->endereco,
                'bairro' => $request->bairro,
                'numero' => $request->numero,
                'complemento' => $request->complemento,
                'cidade' => $request->cidade,
                'estado' => $request->estado,
                'longitude' => $request->longitude,
                'latitude' => $request->latitude
            ]);

        $array['sucesso'] = 'Informações atualizadas com sucesso.';
        return $array;
    }

    public function listaIntegrantesPequenoGrupo(Request $request)
    {
        $array = ['error' => ''];

        $lista = PequenoGrupo::listaIntegrantePequenoGrupo($request->cod_pequeno_grupo);
        $lider = LiderPequenoGrupo::where('cod_pequeno_grupo', $request->cod_pequeno_grupo)->first();

        $array['lider'] = $lider;
        $array['lista'] = $lista;
        return $array;
    }
}

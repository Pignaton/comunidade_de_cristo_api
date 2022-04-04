<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CultoRequest;
use App\Models\Campanha;
use App\Models\Culto;
use App\Models\Sistema;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;

class ConfiguracoesController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    protected $redirectTo = RouteServiceProvider::HOME;


    public function listaCultos()
    {
        $array = ['error' => ''];

        $cultos = Culto::all();
        $array['cultos'] = $cultos;

        return $array;
    }

    public function listaCampanhas()
    {
        $array = ['error' => ''];

        $campanhas = Campanha::all();
        $array['campanhas'] = $campanhas;

        return $array;
    }

    protected function criaCulto(Request $request)
    {

        if ($this->validador($request->all())->fails()) {
            $array['error'] = $this->validador($request->all())->errors();
            return $array;
        }

        $culto = new Culto();
        $culto->nom_culto = $request->nomeCulto;
        $culto->dia_culto = $request->diaCulto;
        $culto->ind_periodo = $request->periodo;
        $culto->save();

        $array['sucesso'] = 'Culto adicionado com sucesso';
        return $array;
    }

    protected function criaCampanha(Request $request)
    {
        $validador = Validator::make($request->all(), [
            'nomeCampanha' => 'required|max:50|unique:App\Models\Campanha,nom_campanha'
        ]);

        if ($validador->fails()) {
            $array['error'] = $validador->errors();
            return $array;
        }

        $campanha = new Campanha();
        $campanha->nom_campanha = $request->nomeCampanha;
        $campanha->save();

        $array['sucesso'] = 'Campanha adicionada com sucesso';
        return $array;
    }


    //Exibe ou não o campo culto ou campanha no cadastro
    protected function exibeCampos(Request $request)
    {
        $array = ['error' => ''];

        $nom_campo = $request->nom_campo;
        $status = $request->status;

        if ($status === true || $status === 'true') {
            $status = '1';
        } else {
            $status = '0';
        }

        $status === '1' ? $nome = 'ativado' : $nome = 'inativado';

        Sistema::where('nom_campo', $nom_campo)->update(['status' => $status]);

        $array['sucesso'] = 'Status do campo ' . $nom_campo . ' alterado para ' . $nome;

        return $array;

    }

    protected function visualizacaoDoCulto(Request $request)
    {
        $array = ['error' => ''];

        $cod_culto = $request->cod_culto;
        $status = $request->status;

        //$status === 'A' ? $status = 'I' : $status = 'A';
        $status === 'A' ? $nome = 'ativado' : $nome = 'inativado';

        $culto = Culto::find($cod_culto);
        $culto->status = $status;
        $culto->save();

        $array['sucesso'] = 'Culto foi ' . $nome;
        return $array;

    }

    protected function visualizacaoDaCampanha(Request $request)
    {
        $array = ['error' => ''];

        $cod_campanha = $request->cod_campanha;
        $status = $request->status;

        // $status === 'A' ? $status = 'I' : $status = 'A';
        $status === 'A' ? $nome = 'ativado' : $nome = 'inativado';

        $campanha = Campanha::find($cod_campanha);
        $campanha->status = $status;
        $campanha->save();

        $array['sucesso'] = 'Campanha foi ' . $nome;
        return $array;
    }

    public function deletaCulto(Request $request)
    {
        $array = ['error' => ''];

        $culto = Culto::find($request->cod_culto);
        if ($culto === null) {
            $array['error'] = 'Não possivel realizar essa operação';
            return $array;
        }

        $culto->delete();

        $array['sucesso'] = 'Operação realizado com sucesso.';
        return $array;
    }

    public function deletaCampanha(Request $request)
    {
        $array = ['error' => ''];

        $campanha = Campanha::find($request->cod_campanha);

        if ($campanha === null) {
            $array['error'] = 'Não possivel realizar essa operação';
            return $array;
        }

        $campanha->delete();

        $array['sucesso'] = 'Operação realizado com sucesso.';
        return $array;
    }

    protected function editaCulto(Request $request)
    {
        $array = ['error' => ''];

        if ($this->validador($request->all())->fails()) {
            $array['error'] = $this->validador($request->all())->errors();
            return $array;
        }

        Culto::where('cod_culto', $request->cod_culto)
            ->update([
                'nom_culto' => $request->nomeCulto,
                'dia_culto' => $request->diaCulto,
                'ind_periodo' => $request->periodo
            ]);

        $array['sucesso'] = 'Culto ' . $request->nom_culto . ' foi alterado com sucesso.';

        return $array;
    }

    protected function editaCampanha(Request $request)
    {
        $array = ['error' => ''];

        $validador = Validator::make($request->all(), [
            'nomeCampanha' => 'required|max:50'
        ]);

        if ($validador->fails()) {
            $array['error'] = $validador->errors();
            return $array;
        }

        Campanha::where('cod_campanha', $request->cod_campanha)
            ->update(['nom_campanha' => $request->nomeCampanha]);

        $array['sucesso'] = 'Campanha ' . $request->nomeCampanha . ' foi alterado com sucesso.';

        return $array;
    }

    protected function validador($data)
    {
        return Validator::make($data, [
            'nomeCulto' => 'required|string|min:3|max:50|unique:App\Models\Culto,nom_culto',
            'diaCulto' => 'required|in:S,T,Q,U,S,A,D',
            'periodo' => 'required|in:M,T,N,I'
        ]);
    }

}

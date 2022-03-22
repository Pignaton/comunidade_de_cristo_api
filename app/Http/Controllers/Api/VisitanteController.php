<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Pessoa;
use Illuminate\Http\Request;

class VisitanteController extends Controller
{
    public function listaVisitante()
    {
        $array = ['error' => ''];

        $pessoas = Pessoa::enderecoPessoa();
        if($pessoas){
            $array['pessoas'] = $pessoas;
            return $array;
        }

        return $array;
    }

    public function deletaVisitante(Request $request) {
        $array = ['error' => ''];
        $cod_pessoa = $request->cod_pessoa;
        $pessoa = Pessoa::find($cod_pessoa);
        $pessoa->delete();
        $array['sucesso'] = $pessoa;
        return $array;
    }
}

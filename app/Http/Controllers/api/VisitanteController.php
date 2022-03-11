<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Pessoa;

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
}

<?php

namespace App\Http\Controllers\api\cadastro;

use App\Models\Campanha;
use App\Models\Culto;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class CadastroController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function cadastro(Request $request)
    {

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
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CultoRequest;
use App\Models\Acesso;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;

class AcessoController extends BaseController
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public function meuDados(Request $request) {
        
        $array = ['error' => ''];
        
    
        $usuario = Acesso::select('nome', 'email')
            ->where('cod_usuario', $request->cod_usuario)
            ->first();
    
        if ($usuario) {
            $array['usuario'] = $usuario;
        } else {
            $array['error'] = 'Usuário não encontrado.';
        }
    
        return $array;
    }
    
    public function editaMeuDados(Request $request) {
        
    }
}
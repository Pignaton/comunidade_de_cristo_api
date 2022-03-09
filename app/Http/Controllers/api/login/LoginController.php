<?php

namespace App\Http\Controllers\api\login;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;

class LoginController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function naoautorizado()
    {
        return response()->json([
            'error' => 'Não autorizado'
        ], 401);
    }

    public function login(Request $request)
    {
        $array = ['error' => ''];

        $validador = Validator::make($request->all(), [
            'email' => 'required',
            'senha' => 'required'
        ]);

        if (!$validador->fails()) {
            $email = $request->input('email');
            $senha = $request->input('senha');

            $token = auth()->attempt([
                'email' => $email,
                'password' => $senha
            ]);

            if(!$token){
                $array['error'] = 'Email e/ou Senha estão errados.';
                return $array;
            }

            $array['token'] = $token;

            $user = auth()->user();
            $array['user'] = $user;


        } else {
            $array['error'] = $validador->errors()->first();
            return $array;
        }

        return $array;
    }
    public function validaToken() {
        $array = ['error' => ''];

        $user = auth()->user();
        $array['user'] = $user;

        return $array;
    }
    public function logout() {
        $array = ['error' => ''];
        auth()->logout();
        return $array;
    }
}

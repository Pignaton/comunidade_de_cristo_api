<?php

namespace App\Http\Controllers\Api\Login;

use App\Http\Requests\RecuperaSenhaRequest;
use App\Http\Requests\ValidaSenhaRequest;
use App\Mail\AlteraSenhaMail;
use App\Mail\RecuperaSenha;
use App\Models\Acesso;
use App\Models\RedefinicaoSenha;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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

            if (!$token) {
                $array['error'] = 'Email e/ou Senha estão errados.';
                return $array;
            }

            $acesso = Acesso::where('email', $request->email)->first();

            if ($acesso->status === 'B') {
                $array['error'] = 'Usuário foi bloqueado. Contate o administrador do sistema para saber mais.';
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

    public function validaToken()
    {
        $array = ['error' => ''];

        $user = auth()->user();
        $array['user'] = $user;

        return $array;
    }

    public function logout()
    {
        $array = ['error' => ''];
        auth()->logout();
        return $array;
    }

    public function resetaSenhaApp(RecuperaSenhaRequest $request)
    {

        if (!empty($request->code_validation)) {
            $deleteCode = RedefinicaoSenha::where('email', $request->email, 'cod_validation', $request->code_validation)->first();
            if ($deleteCode) {
                $deleteCode->delete();
            }
        }

        $code = str_pad(rand(0, 999999), 6, 0, STR_PAD_LEFT);

        $salvatoken = new RedefinicaoSenha();
        $salvatoken->email = $request->email;
        $salvatoken->code_validation = $code;
        $salvatoken->created_at = now();
        $salvatoken->expires_at = date('Y-m-d H:i:s', strtotime('+30 minutes'));
        $salvatoken->save();

        $maildata = [
            'email' => $request->email,
            'code' => $code,
        ];

        Mail::to($request->email)->send(new AlteraSenhaMail($maildata));

        return ['status' => 'success', 'message' => 'Código de redefinição enviado com sucesso.'];

    }

    public function alteraSenha(Request $request)
    {

        $response = ['message' => '', 'sucesso' => ''];

        $codigoRecuperacao = RedefinicaoSenha::where('email', $request->email)
            ->where('code_validation', $request->code_validation)
            ->first();

        if (!$codigoRecuperacao) {
            return response()->json(['message' => 'Código inválido.'], 400);
        }

        $codigoRecuperacao = Carbon::parse($codigoRecuperacao->created_at)->addMinutes(30)->isPast();

        if ($codigoRecuperacao) {
            return response()->json(['message' => 'Código expirado. Por favor, solicite um novo.'], 400);
        }

        $novaSenha = Hash::make($request->senha);
        Acesso::where('email', $request->email)->update(['senha' => $novaSenha]);
        RedefinicaoSenha::where('email', $request->email)->delete();
        $response['sucesso'] = [
            'status' => 'success',
            'message' => 'Senha alterada com sucesso.'
        ];

        return response()->json($response);
    }

    public function recuperaSenha(RecuperaSenhaRequest $request)
    {
        $array = ['error' => ''];

        $existe = RedefinicaoSenha::where('email', $request->email)->exists();
        if ($existe === true) {
            $array['error'] = 'Já foi realizado solicitação com esse email.';
            return $array;
        }

        $array['sucesso'] = $request->validated();

        $token = md5($request->email);

        $salvatoken = new RedefinicaoSenha();
        $salvatoken->email = $request->email;
        $salvatoken->token = $token;
        $salvatoken->created_at = date('Y-m-d H:i:s', strtotime('+30 minutes'));
        $salvatoken->save();

        $acesso = Acesso::where('email', $request->email)->first();

        $maildata = [
            'nome' => $acesso->nome,
            'email' => $request->email,
            'token' => $token,
        ];

        Mail::to($request->email)->send(new RecuperaSenha($maildata));

        return $array;
    }

    public function resetaSenha(Request $request)
    {
        $redefinicao = RedefinicaoSenha::where('token', $request->token)->first();

        if (!empty($redefinicao->created_at) && $redefinicao->created_at >= date('Y-m-d H:i:s')) {
            return view('/autenticacao/reseta-senha', ['dado' => $redefinicao]);
        }
        RedefinicaoSenha::where('token', $request->token)->delete();
        return view('/pages/404');
    }

    public function validaSenha(ValidaSenhaRequest $request)
    {
        $request->validated();
        $novaSenha = hash::make($request->senha);
        Acesso::where('email', $request->email)->update(['senha' => $novaSenha]);
        RedefinicaoSenha::where('email', $request->email)->delete();
        return view('autenticacao/altera-senha-sucesso');
    }
}

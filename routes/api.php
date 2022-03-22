<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\login\LoginController;
use App\Http\Controllers\Api\Cadastro\CadastroController;
use App\Http\Controllers\Api\VisitanteController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/ping', function (){
    return ['pong' => true];
});


Route::get('/401', [LoginController::class, 'naoautorizado'])->name('login');

Route::post('/auth/login', [LoginController::class, 'login']);

// Routas tela de cadastro
Route::post('/cadastro', [CadastroController::class, 'cadastro']);
Route::get('lista/cultos', [CadastroController::class, 'listaCultos']);
Route::get('lista/campanhas', [CadastroController::class, 'listaCampanhas']);
Route::get('sistema/exibe-campos', [CadastroController::class, 'exibeCampos']);

Route::middleware('auth:api')->group(function(){
    Route::post('/auth/validacao', [LoginController::class, 'validaToken']);
    Route::post('/auth/logout', [LoginController::class, 'logout']);

    Route::get('/lista/visitantes', [VisitanteController::class, 'listaVisitante']);
    Route::delete('/visitantes/deleta/{cod_pessoa}', [VisitanteController::class, 'deletaVisitante']);
    //Route::put('/lista-visitantes/edita/{cod_pessoa}', [VisitanteController::class, 'atualizaVisitante']);
});



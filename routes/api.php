<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Login\LoginController;
use App\Http\Controllers\Api\Cadastro\CadastroController;
use App\Http\Controllers\Api\VisitanteController;
use App\Http\Controllers\Api\IntegranteController;
use App\Http\Controllers\Api\PequenoGrupoController;
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
Route::post('recupera-senha', [LoginController::class, 'recuperaSenha']);

// Routas tela de cadastro
Route::post('/cadastro', [CadastroController::class, 'cadastro']);
Route::get('lista/cultos', [CadastroController::class, 'listaCultos']);
Route::get('lista/campanhas', [CadastroController::class, 'listaCampanhas']);
Route::get('sistema/exibe-campos', [CadastroController::class, 'exibeCampos']);

Route::post('/cadastra/integrante',[IntegranteController::class, 'cadastro']);

Route::middleware('auth:api')->group(function(){
    Route::post('/auth/validacao', [LoginController::class, 'validaToken']);
    Route::post('/auth/logout', [LoginController::class, 'logout']);

    Route::get('/lista/integrantes', [IntegranteController::class, 'listaIntegrantes']);
    Route::get('/lista/integrante/{cod_integrante}', [IntegranteController::class, 'listaIntegranteUnico']);
    Route::delete('/deleta/integrante/{cod_integrante}', [IntegranteController::class, 'deletaIntegrante']);
    //Route::put('/integrante/edita/{cod_pequeno_grupo}', [IntegranteController::class, 'editaIntegrante']);

    Route::post('/cadastra/pequeno-grupo',[PequenoGrupoController::class, 'cadastro']);
    Route::get('/lista/pequenos-grupos', [PequenoGrupoController::class, 'listaPequenoGrupo']);
    Route::get('/lista/pequeno-grupo/{cod_pequeno_grupo}', [PequenoGrupoController::class, 'listaPequenoGrupoUnico']);
    Route::delete('/deleta/pequeno-grupo/{cod_pequeno_grupo}', [PequenoGrupoController::class, 'deletaPequenoGrupo']);
    //Route::put('/pequeno-grupo/edita/{cod_pequeno_grupo}', [PequenoGrupoController::class, 'editaPequenoGrupo']);
    Route::get('/lista/integrantes/pequeno-grupo/{cod_pequeno_grupo}', [PequenoGrupoController::class, 'listaIntegrantesPequenoGrupo']);


    Route::get('/lista/visitantes', [VisitanteController::class, 'listaVisitante']);
    Route::delete('/visitante/deleta/{cod_pessoa}', [VisitanteController::class, 'deletaVisitante']);
    //Route::put('/visitante/edita/{cod_pessoa}', [VisitanteController::class, 'atualizaVisitante']);
});



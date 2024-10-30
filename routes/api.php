<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Login\LoginController;
use App\Http\Controllers\Api\AcessoController;
use App\Http\Controllers\Api\Cadastro\CadastroController;
use App\Http\Controllers\Api\Cadastro\CadastroPrimeiroContatoController;
use App\Http\Controllers\Api\VisitanteController;
use App\Http\Controllers\Api\IntegranteController;
use App\Http\Controllers\Api\PequenoGrupoController;
use App\Http\Controllers\Api\ConfiguracoesController;

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

Route::get('/ping', function () {
    return ['pong' => true];
});


Route::get('/401', [LoginController::class, 'naoautorizado'])->name('login');

Route::post('/auth/login', [LoginController::class, 'login']);
Route::post('/auth/reseta-senha', [LoginController::class, 'resetaSenhaApp']);
Route::post('/auth/alterar-senha', [LoginController::class, 'alteraSenha']);

// Routas tela de cadastro
Route::post('/cadastro', [CadastroController::class, 'cadastro']);
Route::get('lista/cultos', [CadastroController::class, 'listaCultos']);
//Route::get('lista/culto/{cod_culto}', [CadastroController::class, 'getCultos']);
Route::get('lista/campanhas', [CadastroController::class, 'listaCampanhas']);
Route::get('sistema/exibe-campos', [CadastroController::class, 'exibeCampos']);

Route::get('/minha-conta/{cod_usuario}', [AcessoController::class, 'meuDados']);

Route::post('/cadastra/integrante', [IntegranteController::class, 'cadastro']);

Route::middleware('auth:api')->group(function () {
    Route::post('/auth/validacao', [LoginController::class, 'validaToken']);
    Route::post('/auth/logout', [LoginController::class, 'logout']);
    Route::get('/auth/recupera-senha', [LoginController::class, 'recuperaSenha']);


    Route::get('edita/minha-conta/{cod_pessoa}', [AcessoController::class, 'editaMeuDados']);

    Route::get('/lista/integrantes', [IntegranteController::class, 'listaIntegrantes']);
    Route::get('/lista/integrante/{cod_integrante}', [IntegranteController::class, 'listaIntegranteUnico']);
    Route::delete('/deleta/integrante/{cod_integrante}', [IntegranteController::class, 'deletaIntegrante']);
    Route::put('/edita/integrante/{cod_integrante}', [IntegranteController::class, 'editaIntegrante']);
    Route::patch('/status/integrante/{cod_usuario}', [IntegranteController::class, 'statusIntegrante']);

    // configura conta
    Route::put('/edita/integrante/{cod_integrante}', [IntegranteController::class, 'editaIntegrante']);
    Route::patch('/integrante/altera-senha/{cod_integrante}', [IntegranteController::class, 'alteraSenhaIntegrante']);
    Route::put('/edita/integrante/endereco/{cod_integrante}', [IntegranteController::class, 'alteraEnderecoIntegrante']);

    Route::post('/cadastra/pequeno-grupo', [PequenoGrupoController::class, 'cadastro']);
    Route::get('/lista/pequenos-grupos', [PequenoGrupoController::class, 'listaPequenoGrupo']);
    Route::get('/lista/pequeno-grupo/{cod_pequeno_grupo}', [PequenoGrupoController::class, 'listaPequenoGrupoUnico']);
    Route::delete('/deleta/pequeno-grupo/{cod_pequeno_grupo}', [PequenoGrupoController::class, 'deletaPequenoGrupo']);
    Route::put('/edita/pequeno-grupo/{cod_pequeno_grupo}', [PequenoGrupoController::class, 'editaPequenoGrupo']);
    Route::get('/lista/integrantes/pequeno-grupo/{cod_pequeno_grupo}', [PequenoGrupoController::class, 'listaIntegrantesPequenoGrupo']);


    Route::get('/lista/visitantes', [VisitanteController::class, 'listaVisitante']);
    Route::delete('/visitante/deleta/{cod_pessoa}', [VisitanteController::class, 'deletaVisitante']);
    Route::get('/visitante/{cod_pessoa}', [VisitanteController::class, 'getVisitante']);
    //Route::put('/visitante/edita/{cod_pessoa}', [VisitanteController::class, 'atualizaVisitante']);

    Route::post('/cadastro/primeiro-contato', [CadastroPrimeiroContatoController::class, 'cadastroPrimeiroContato']);
    Route::get('/lista/primeiro-contato/{cod_pessoa}', [CadastroPrimeiroContatoController::class, 'getPrimeiroContato']);

    //Configurações do sistema
    Route::get('/configuracao/lista/cultos', [ConfiguracoesController::class, 'listaCultos']);
    Route::post('/cadastra/culto', [ConfiguracoesController::class, 'criaCulto']);
    Route::delete('/deleta/culto/{cod_culto}', [ConfiguracoesController::class, 'deletaCulto']);
    Route::patch('/status/culto/{cod_culto}/{status}', [ConfiguracoesController::class, 'visualizacaoDoCulto']);
    Route::put('/edita/culto/{cod_culto}', [ConfiguracoesController::class, 'editaCulto']);

    Route::get('/configuracao/lista/campanhas', [ConfiguracoesController::class, 'listaCampanhas']);
    Route::post('/cadastra/campanha', [ConfiguracoesController::class, 'criaCampanha']);
    Route::delete('/deleta/campanha/{cod_campanha}', [ConfiguracoesController::class, 'deletaCampanha']);
    Route::patch('/status/campanha/{cod_campanha}/{status}', [ConfiguracoesController::class, 'visualizacaoDaCampanha']);
    Route::patch('/edita/campanha/{cod_campanha}', [ConfiguracoesController::class, 'editaCampanha']);

    Route::put('/sistema/exibe-campos/status/{nom_campo}/{status}', [ConfiguracoesController::class, 'exibeCampos']);

});

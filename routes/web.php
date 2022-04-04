<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Login\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('teste');
});*/
Route::get('/mailable', function () {
    $invoice = [
        'nome' => 'Kaleb Pignaton',
        'email' => 'kpignaton@ymail.com',
        'token' => '1',
    ];

    return new App\Mail\RecuperaSenha($invoice);
});
Route::get('/acesso', function () {
    $invoice = [
        'nome' => 'Kaleb Pignaton',
        'email' => 'kpignaton@ymail.com',
        'token' => '1',
    ];

    return new App\Mail\LiberaAcesso($invoice);
});
Route::get('reseta-senha/token/{token}', [LoginController::class, 'resetaSenha']);
Route::put('valida-senha', [LoginController::class, 'validaSenha']);

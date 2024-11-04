<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pessoa;
use Illuminate\Http\Request;
//use Maatwebsite\Excel\Facades\Excel;

class VisitanteController extends Controller
{
    public function listaVisitante(Request $request)
    {
        $response = ['error' => '', 'pessoas' => [], 'página_atual' => 1, 'ultima_pagina' => 1];

        $nome = $request->query('nome');
        $page = $request->query('page', 1);

         if (!empty($nome)) {
            $nome = strtolower(trim($nome));
        }

         $query = Pessoa::query();

        if (!empty($nome)) {
            $query->where('nome', 'like', '%' . $nome . '%');
        }

         $pessoas = $query->with('primeiro_contato')->paginate(10);

        if ($pessoas->isNotEmpty()) {

          $response['pessoas'] = $pessoas->map(function ($pessoa) {
                return [
                    'cod_pessoa' => $pessoa->cod_pessoa,
                    'nome' => $pessoa->nome,
                    'idade' => $pessoa->idade,
                    'estado_civil' => $pessoa->estado_civil,
                    'created_at' => $pessoa->created_at->format('d/m/Y'),
                    'primeiro_contato' => $pessoa->primeiro_contato->map(function ($contato) {
                        return [
                            'nome_remetente' => $contato->nome_remetente,
                            ];
                    }),
                ];
            });

            $response['pagina_atual'] = $pessoas->currentPage();
            $response['ultima_pagina'] = $pessoas->lastPage();
        } else {
            $response['error'] = 'Nenhum visitante encontrado.';
        }

        return response()->json($response, 200);
    }

    public function getVisitante(Request $request) {
        $array = ['error' => ''];

        $pessoas = Pessoa::enderecoPessoa($request->cod_pessoa,null,null,null);

        foreach ($pessoas as $pessoa) {
            $pessoa->cod_culto = getCulto($pessoa->cod_culto);
        }

        if($pessoas){
            $array['pessoa'] = $pessoas;
            return $array;
        }

        return $array;
    }

    public function deletaVisitante(Request $request) {
        $array = ['error' => ''];
        $cod_pessoa = $request->cod_pessoa;
        if(empty($cod_pessoa)){
            $array['error'] = 'Informe o codigo visitante';
        }
        $pessoa = Pessoa::find($cod_pessoa);
        $pessoa->delete();
        $array['sucesso'] = $pessoa;
        return $array;
    }

    public function exportVisitantes()
    {
        $fileName = 'visitantes.xlsx';
      //  return Excel::download(new VisitantesExport, $fileName, \Maatwebsite\Excel\Excel::XLSX);
    }
}

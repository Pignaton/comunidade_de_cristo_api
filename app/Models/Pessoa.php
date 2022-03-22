<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Pessoa extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pessoa';
    protected $primaryKey = 'cod_pessoa';
    public $timestamps = true;

    public static function enderecoPessoa()
    {
        return DB::table('pessoa as p')
            ->select('p.cod_pessoa', 'p.cod_culto', 'p.cod_campanha', 'p.nome', 'p.idade', 'p.email', 'p.telefone', 'p.sexo',
            'p.estado_civil', 'p.created_at', 'e.cod_endereco', 'e.cep', 'e.endereco', 'e.bairro', 'e.numero', 'e.complemento', 'e.cidade', 'e.estado')
            ->leftJoin('endereco as e', 'e.cod_pessoa', '=', 'p.cod_pessoa')
            ->whereRaw('deleted_at is null')
            ->get();
    }
}

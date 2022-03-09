<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pessoa extends Model
{
    use HasFactory;

    protected $table = 'pessoa';
    protected $primaryKey = 'cod_pessoa';
    public $timestamps = true;

    public function enderecoPessoa()
    {
        return DB::table('pessoa as p')
            ->leftJoin('endereco as e', 'p.cod_pessoa', '=', 'e.cod_pessoa')
            ->get();
    }
}

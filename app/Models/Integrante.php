<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Integrante extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'integrante';
    protected $primaryKey = 'cod_integrante';
    public $timestamps = true;
    public $fillable = [
        'cod_integrante',
        'cod_pequeno_grupo',
        'nome',
        'idade',
        'email',
        'cpf',
        'data_nascimento',
        'estado_civil',
        'ind_sexo'
    ];

    public $hidden = [
        'updated_at',
        'deleted_at'
    ];

    public static function listaIntegrantes()
    {
        return DB::table('integrante as a')
            ->join('endereco_integrante as b', 'b.cod_integrante', '=', 'a.cod_integrante')
            ->whereRaw('deleted_at is null')
            ->get();
    }
}

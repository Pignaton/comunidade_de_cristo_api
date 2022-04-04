<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class PequenoGrupo extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pequeno_grupo';
    protected $primaryKey = 'cod_pequeno_grupo';
    public $timestamps = true;
    public $fillable = [
        'cod_pequeno_grupo',
        'nom_grupo',
        'tipo_pequeno_grupo',
        'pequeno_grupo_genero',
        'qtd_integrante'
    ];

    public $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public static function listaPequenosGrupos()
    {
        return DB::table('pequeno_grupo as a')
            ->join('endereco_pequeno_grupo as b', 'a.cod_pequeno_grupo', '=', 'b.cod_pequeno_grupo')
            ->whereRaw('deleted_at is null')
            ->get();
    }

    public static function listaIntegrantePequenoGrupo($cod_pequeno_grupo)
    {
        return DB::table('integrante as a')
            ->select('a.cod_integrante', 'a.cod_pequeno_grupo', 'a.nome', 'a.idade', 'a.email')
            ->leftJoin('lider_pequeno_grupo as lpg', 'a.cod_integrante', '=', 'lpg.cod_integrante')
            ->join('pequeno_grupo as b', 'a.cod_pequeno_grupo', '=', 'b.cod_pequeno_grupo')
            ->where('a.cod_pequeno_grupo', $cod_pequeno_grupo)
            ->whereRaw('lpg.cod_lider_pequeno_grupo is null')
            ->whereRaw('a.deleted_at is null')
            ->whereRaw('b.deleted_at is null')
            ->get();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use App\Models\PrimeiroContato;

class Pessoa extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pessoa';
    protected $primaryKey = 'cod_pessoa';
    public $timestamps = true;
    public $hidden = [
        "updated_at",
        "deleted_at"
    ];

    public function primeiro_contato()
    {
        return $this->hasMany(PrimeiroContato::class, 'cod_pessoa', 'cod_pessoa');
    }
    
    public static function enderecoPessoa($cod_pessoa = null, $nome = null, $sexo = null, $estadoCivil = null)
    {
        $query = DB::table('pessoa as p');
        $query->select('p.cod_pessoa', 'p.cod_culto', 'p.cod_campanha', 'p.nome', 'p.idade', 'p.email', 'p.telefone', 'p.sexo',
            'p.estado_civil', 'p.created_at', 'e.cod_endereco', 'e.cep', 'e.endereco', 'e.bairro', 'e.numero', 'e.complemento', 'e.cidade', 'e.estado');
        $query->leftJoin('endereco as e', 'e.cod_pessoa', '=', 'p.cod_pessoa');
        if ($cod_pessoa !== null) {
            $query->where('p.cod_pessoa', '=', $cod_pessoa);
        }
        if ($nome !== null) {
            $query->where('p.nome', 'like', "%{$nome}%");
        }
        if ($sexo !== null) {
            $query->where('p.sexo', '=', $sexo);
        }
        if ($estadoCivil !== null) {
            $query->where('p.estado_civil', '=', $estadoCivil);
        }
        $query->whereRaw('p.deleted_at is null');
        $result = $query->get();

        return $result;
    }
}

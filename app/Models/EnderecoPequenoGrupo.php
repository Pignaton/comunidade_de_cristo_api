<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnderecoPequenoGrupo extends Model
{
    use HasFactory;

    protected $table = 'endereco_pequeno_grupo';
    protected $primaryKey = 'cod_endereco_pequeno_grupo';
    public $timestamps = true;
    public $fillable = [
        'cod_endereco_pequeno_grupo',
        'cod_pequeno_grupo',
        'cep',
        'endereco',
        'bairro',
        'numero',
        'cidade',
        'estado'
    ];

    public $hidden = [
        'updated_at',
        'created_at'
    ];
}

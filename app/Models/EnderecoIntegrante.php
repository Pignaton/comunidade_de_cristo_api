<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnderecoIntegrante extends Model
{
    use HasFactory;

    protected $table = 'endereco_integrante';
    protected $primaryKey = 'cod_endereco_integrante';
    public $timestamps = true;
    public $fillable = [
        'cod_integrante',
        'cod_endereco_integrante',
        'cep',
        'endereco',
        'bairro',
        'numero',
        'cidade',
        'estado',
    ];

    public $hidden = [
        'updated_at',
    ];
}

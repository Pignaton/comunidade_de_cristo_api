<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LiderPequenoGrupo extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'lider_pequeno_grupo';
    protected $primaryKey = 'cod_lider_pequeno_grupo';
    public $timestamps = true;
    public $fillable = [
        'cod_lider_pequeno_grupo',
        'cod_integrante',
        'cod_pequeno_grupo',
        'nom_lider',
        'idade',
        'email'
    ];

    public $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}

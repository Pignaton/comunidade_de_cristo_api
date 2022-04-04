<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RedefinicaoSenha extends Model
{
    use HasFactory;

    protected $table = 'redefinicao_senha';
    public $timestamps = false;
    public $fillable = [
        'email',
        'token',
        'created_at'
    ];
}

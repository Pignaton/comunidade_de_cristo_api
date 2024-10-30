<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class PrimeiroContato extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'primeiro_contato';
    //protected $primaryKey = 'cod_pessoa';
    public $timestamps = true;
    public $hidden = [
        "updated_at",
        "deleted_at",
    ];
}

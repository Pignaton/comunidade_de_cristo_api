<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Culto extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'culto';
    protected $primaryKey = 'cod_culto';

    public $timestamps = true;
    public $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    public $fillable = [
        'cod_culto',
        'nom_culto',
        'dia_culto',
        'ind_periodo',
        'status'
    ];
}

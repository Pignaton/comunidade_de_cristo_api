<?php

use App\Models\Culto;

function getCulto($codCulto)
{

    $culto = Culto::select('nom_culto')->where(['status' => 'A', 'cod_culto' => $codCulto])->first();

    if ($culto) {
        $array = $culto->nom_culto;
    } else {
        $array = 'Culto não encontrado';
    }
    return $array;
}

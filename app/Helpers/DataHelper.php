<?php

function converteDateBD($date)
{
    if ($date != '') {
        $dia = substr($date, 0, 2);
        $mes = substr($date, 3, 2);
        $ano = substr($date, 6, 4);
        return $ano . '/' . $mes . '/' . $dia;
    } else {
        return '';
    }
}

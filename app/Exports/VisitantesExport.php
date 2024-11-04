<?php

namespace App\Exports;

use App\Models\Visitante;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VisitantesExport implements FromCollection
{
    public function collection()
    {
        return Visitante::all();
    }
    public function headings(): array
    {
        return [
            'Inscrição',
            'Nome Candidato',
            'Nota',
            'Data lancto Nota',
            'Ausente',
            'Notificado',
            'Dt. Inicio Matr',
            'Dt. Prova Agendada',
            'Tipo',
            'Cod. Ra',
            'Ano',
            'E-Mail',
            'Matricula confirmada'
        ];
    }
}

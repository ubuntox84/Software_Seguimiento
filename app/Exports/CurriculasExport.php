<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use App\Models\Curricula;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;

class CurriculasExport implements FromCollection, WithHeadings
{
    use Exportable;

    protected $curriculas;

    public function __construct(array $curriculas)
    {
        $this->curriculas = $curriculas;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function headings(): array
    {
        return [
            'Id',
            'Nombre',
            'Código',
            'Resolución',
            'Escuela Profesional',
            'Semestre Inicio',
            'Estado',
            'Créditos  Obligatorios',
            'Créditos Electivos',
            'Créditos Actividades Libres',
            'Créditos Prácticas Pre Profesionales',
            'Facultad',
            'Departamento',
            'Fecha Aprobación',
            'Fecha Activa',
            'Fecha Inactiva',
          
        ];
    }
    public function collection()
    {

        $results = Curricula::whereIn('id', $this->curriculas)->get();

        return $results->map(function ($row) {
            $customRow = new \stdClass();
            $customRow->id = $row->id;
            $customRow->name = $row->name;
            $customRow->code = $row->code;
            $customRow->resolution = $row->resolution;
            $customRow->profesional_school = $row->profesional_school;
            $customRow->semester_start = $row->semester_start;
            $customRow->state = $row->state;
            $customRow->compulsory = $row->compulsory;
            $customRow->elective = $row->elective;
            $customRow->free_activity = $row->free_activity;
            $customRow->pre_professional_practice = $row->pre_professional_practice;
            $customRow->Faculty = $row->faculties->name;
            $customRow->Department = $row->departments->name ?? 'No asignado';
            $customRow->date_approved = $row->date_approved;
            $customRow->date_active = $row->date_active;
            $customRow->date_inactive = $row->date_inactive;
          
            return $customRow;
        });
    }
}
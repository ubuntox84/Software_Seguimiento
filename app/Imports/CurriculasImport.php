<?php

namespace App\Imports;

use App\Models\Curricula;
use App\Models\Department;
use App\Models\Faculty;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CurriculasImport implements ToModel, WithHeadingRow
{

    private $rows = 0;
    private $faculties;
    private $departments;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function __construct()
    {
        $this->faculties = Faculty::pluck('id', 'name');
        $this->departments = Department::pluck('id', 'name');
    }

    public function model(array $row)
    {
        ++$this->rows;
        return new Curricula([
            'name'     => $row['nombre'],
            'resolution'    => $row['resolucion'],
            'state'    => $row['estado'],
            'date_approved'    => Carbon::parse($row['fecha_aprobacion']),
            'date_active'    =>  Carbon::parse($row['fecha_activa']),
            'date_inactive'    => Carbon::parse($row['fecha_inactiva']),
            'faculty_id'    => $this->faculties[$row['facultad']],
            'department_id'    => $this->departments[$row['departamento']] ?? null,
            'code'    => $row['codigo'],
            'profesional_school'    => $row['escuela_profesional'],
            'semester_start'    => $row['semestre_inicio'],
            'compulsory'    => $row['creditos_obligatorios'],
            'elective'    => $row['creditos_electivos'],
            'free_activity'    => $row['creditos_actividades_libres'],
            'pre_professional_practice'    => $row['creditos_practicas_pre_profesionales'],
        ]);
    }

    public function getRowCount(): int
    {
        return $this->rows;
    }
}

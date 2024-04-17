<?php

namespace App\Imports;

use App\Models\AreaKnowledge;
use App\Models\Course;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class FreeActivityCoursesImport implements ToModel, WithHeadingRow
{
    private $rows = 0;
    private $areaCount = 0;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Buscar o crear un área por su nombre
        $area = AreaKnowledge::firstOrCreate(['name' => $row['area_nombre']]);
         if (!$area->wasRecentlyCreated) {
            // El área ya existía, no contamos como área nueva
        } else {
            $this->areaCount++; // Incrementar el contador de áreas si es una nueva área
        }
        $cursoExistente = Course::where('code', $row['codigo'])->first();
        
        if ($cursoExistente) {
            return null; // No registrar si el curso ya existe
        }
        
        $curse = new Course([
            'code'     => $row['codigo'],
            'name'     => $row['nombre'],
            'theoretic_hour'    => $row['horas_teoricas'],
            'practical_hour'    => $row['horas_practicas'],
            'prerequisite'    => $row['pre_requisitos'],
            'type_course'    => $row['tipo_de_curso'],
            'university_law'    => $row['ley_universitaria'],
            'credits'    => $row['creditos'],
            'cycle'    => $row['ciclo'],
            'area_knowledge_id'    => $area->id
            
        ]);
        // Asignar el área al curso
        $curse->areaKnowledges()->associate($area);
        $curse->save();
        ++$this->rows;

        return $curse;
    }
    public function getRowCount(): int
    {
        return $this->rows;
    }
    public function getAreaCount()
    {
        return $this->areaCount;
    }
}

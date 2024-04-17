<?php

namespace App\Imports;

use App\Models\AreaKnowledge;
use App\Models\Course;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToModel;

class CoursesImport implements ToModel, WithHeadingRow, OnEachRow
{
    private $rows = 0;
    private $areasKnowledge;
    private $curricula_id;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function __construct($id)
    {
        
        $this->curricula_id = $id;
        $this->areasKnowledge=AreaKnowledge::where('curricula_id',$id)->pluck('id','name');
    }
   
    public function model(array $row)
    {
        // dd($row);
        ++$this->rows;
        // dd($row);
        return new Course([

            'code'     => $row['codigo'], 
            'name'     => $row['nombre'], 
            'theoretic_hour'    => $row['horas_teoricas'],
            'practical_hour'    => $row['horas_practicas'],
            'prerequisite'    => $row['pre_requisitos'],
            'type_course'    => $row['tipo_de_curso'],
            'university_law'    => $row['ley_universitaria'],
            'credits'    => $row['creditos'],
            'cycle'    => $row['ciclo'],
            'curricula_id'=>$this->curricula_id,
            'area_knowledge_id'    =>$this->areasKnowledge[$row['area_nombre']],
        ]); 
// $course->save();
//          // Agregar prerequisitos si existen en la fila
//     if ($row['requisitos']) {
//         $prerequisiteCodes = explode(',', $row['requisitos']);

//         foreach ($prerequisiteCodes as $prerequisiteCode) {
//             $prerequisite = Course::where('code', $prerequisiteCode)->first();
//             // dd($course->id);
//             if ($prerequisite) {
//                 $course->prerequisites()->attach($prerequisite->id);
//             }
//         }
//     }

//     return $course;
       

    }
     public function onRow(Row $row)
    {
        $row = $row->toArray();
        if ($row['requisitos']) {
            $course = Course::where('code',$row['codigo'])->first();
        $prerequisiteCodes = explode(',', $row['requisitos']);
        $prerequisiteCodes = array_map('trim', $prerequisiteCodes);
        // if( count($prerequisiteCodes)>1){
        //     dd($prerequisiteCodes);
        // }

        foreach ($prerequisiteCodes as $prerequisiteCode) {
            $prerequisite = Course::where('code', $prerequisiteCode)->first();
            // dd($course->id);
            if ($prerequisite) {
               $course->prerequisites()->attach($prerequisite->id);
            }
        }

        
    }
}
   
    public function getRowCount(): int
    {
        return $this->rows;
    }
}

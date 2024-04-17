<?php

namespace App\Exports;

use App\Models\Course;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;

// use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromQuery;

class CoursesExport implements FromCollection, WithHeadings
{
    use Exportable;

    protected $courses;

    public function __construct(array $courses)
    {
        $this->courses = $courses;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {
        return [
            'Id',
            'Código',
            'Nombre',
            'Horas Teóricas',
            'Horas Prácticas ',
            'Pre Requisitos',
            'Requisitos',
            'Tipo de Curso',
            'Ley Universitaria',
            'Créditos',
            'Ciclo',
            'Id Área de conocimiento',
            'Área Nombre',
            // 'Fecha Creación',
            // 'Fecha Actualización ',

        ];
    }
    public function collection()
    {
        // return Course::whereIn('id', $this->courses)->get();
        // return Course::with(['areaKnowledges' => function ($query) {
        //     $query->whereIn('id', $this->courses);
        // }])->get()->map(function($row) {
        //     // dd(  $row);
        //      $row->code;
        //     $row->name;
        //     $row->theoretic_hour;
        //     $row->practical_hour;
        //     $row->prerequisite;
        //     $row->type_course;
        //     $row->university_lay;
        //     $row->credits;
        //     $row->cycle;
        //     $row->areaKnowledgesName = $row->areaKnowledges->name;
        //     return $row;
        // });
        $results = Course::with('areaKnowledges','prerequisites')
                        ->whereIn('id', $this->courses)   
                        ->orderBy('area_knowledge_id')
                        ->get();

// dd($results); // Verificar los resultados

return $results->map(function($row) {
    $customRow = new \stdClass();
    $customRow->id = $row->id;
    $customRow->code = $row->code;
    $customRow->name = $row->name;
    $customRow->theoretic_hour = $row->theoretic_hour;
    $customRow->practical_hour = $row->practical_hour;
    $customRow->prerequisite = $row->prerequisite;
    $customRow->requisitos =$row->prerequisites->pluck('code')->implode(', ');
    $customRow->type_course = $row->type_course;
    $customRow->university_law = $row->university_law;
    $customRow->credits = $row->credits;
    $customRow->cycle = $row->cycle;
    $customRow->area_knowledge_id = $row->area_knowledge_id;
    $customRow->Area_Knowledges = $row->areaKnowledges->name;
    return $customRow;
            // $row->code;
            // $row->name;
            // $row->theoretic_hour;
            // $row->practical_hour;
            // $row->prerequisite;
            // $row->type_course;
            // $row->university_lay;
            // $row->credits;
            // $row->cycle;
            // $row->area_knowledge_id;
            // $row->areaKnowledgesName = $row->areaKnowledges->name;
            // // unset($row->areaKnowledges);
            // return $row;
        });
    }

    // public function collection()
    // {
    //     return Course::query()->whereKey($this->courses)->with('areaKnowledges:name');
    // }
    // public function map($row): array
    // {
    //     return [
    //         $row->code,
    //         $row->name,
    //         $row->theoretic_hour,
    //         $row->practical_hour,
    //         $row->prerequisite,
    //         $row->type_course,
    //         $row->university_lay,
    //         $row->credits,
    //         $row->cycle,
    //         $row->areaKnowledges->name
    //     ];
    // }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    const TYPECOURSE = [
        'actividad_libre' => 'Actividad Libre',
        'electivo' => 'Electivo',
        'obligatorio' => 'Obligatorio',
        'practicas' => 'Prácticas',
    ];

    const UNIVERSITYLAW = [
        'cursos_generales' => 'Cursos Generales',
        'curso_formacion_especifica' => 'Cursos de Formación Específica',
        'curso_formacion_especializada' => 'Cursos de Formación Especializada',
        'fisico_deportivo' => 'FISICO DEPORTIVAS',
        'artistico_cultural' => 'ARTISTICO CULTURAL',
        'civico_comunitario' => 'CIVICO COMUNITARIA',


    ];
    protected $fillable = [
        'code',
        'name',
        'theoretic_hour',
        'practical_hour',
        'type_course',
        'prerequisite',
        'credits',
        'university_law',
        'area_knowledge_id',
        'curricula_id',
        'credits',
        'cycle',
    ];
    public function areaKnowledges()
    {
        return $this->belongsTo(AreaKnowledge::class, 'area_knowledge_id', 'id');
    }
    public function curriculas()
    {
        return $this->belongsTo(Curricula::class, 'curricula_id', 'id');
    }

    public function prerequisites()
    {
        return $this->belongsToMany(Course::class, 'prerequisites', 'course_id', 'prerequisite_id');
    }
    
}

<?php

namespace Database\Seeders;

use App\Models\AreaKnowledge;
use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class CoursesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $areas=AreaKnowledge::pluck('id');
       

        for ($i=0; $i <100 ; $i++) { 
            Course::create([
           'code'=>fake()->unique()->text('8'),
            'name'=>fake()->unique()->text('15'),
            'theoretic_hour'=>fake()->numberBetween($min = 3, $max = 4),
            'practical_hour'=>fake()->numberBetween($min = 3, $max = 4),
            'prerequisite'=>fake()->numberBetween($min = 100, $max = 160),
            'type_course'=> Arr::random(['obligatorio', 'actividad_libre','electivo']),
            'university_law'=> Arr::random(['cursos_generales', 'curso_formacion_especifica','curso_formacion_especializada']),
            'credits'=>fake()->numberBetween($min = 1, $max = 4),
            'cycle'=>fake()->numberBetween($min = 1, $max = 20),
            'area_knowledge_id'=>AreaKnowledge::inRandomOrder()->first()->id,
        ]);
        }
    }
}

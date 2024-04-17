<?php

namespace Database\Factories;

use App\Models\AreaKnowledge;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
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
        ];
    }
}

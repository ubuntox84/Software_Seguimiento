<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Validation\Rules\Unique;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Curricula>
 */
class CurriculaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name'=>fake()->unique()->text('50'),
            'resolution'=>fake()->unique()->text('15'),
            'state'=>1,
            'date_approved'=>fake()->date(),
            'date_active'=>fake()->date(),
            'date_inactive'=>fake()->date(),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Curricula;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AreaKnowledge>
 */
class AreaKnowledgeFactory extends Factory
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
            // 'code'=>fake()->unique()->text('15')
            'curricula_id'=>Curricula::where('state',1)->first()->id,
        ];
    }
}

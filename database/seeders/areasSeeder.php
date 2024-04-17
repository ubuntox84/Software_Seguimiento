<?php

namespace Database\Seeders;

use App\Models\AreaKnowledge;
use App\Models\Curricula;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class areasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $curriculas=Curricula::pluck('id');
       

        for ($i=0; $i <20 ; $i++) { 
            AreaKnowledge::create([
            'name'=>fake()->unique()->text('20'),
             'curricula_id' => $curriculas->random()
        ]);
        }
    }
}

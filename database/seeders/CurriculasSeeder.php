<?php

namespace Database\Seeders;

use App\Models\Curricula;
use App\Models\Faculty;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CurriculasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faculty_ids=Faculty::pluck('id');
       

        for ($i=0; $i <20 ; $i++) { 
            Curricula::create([
            'name'=>fake()->unique()->text('20'),
            'resolution'=>fake()->unique()->text('20'),
             'faculty_id' => $faculty_ids->random()
        ]);
        }

    }
}

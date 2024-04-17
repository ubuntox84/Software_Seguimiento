<?php

namespace Database\Seeders;

use App\Models\Faculty;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FacultiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         Faculty::create(['name' => 'Facultad de Agronomía']);
         Faculty::create(['name' => 'Facultad de Zootecnia']);
         Faculty::create(['name' => 'Facultad de Ingeniería en Industrias Alimentarias']);
         Faculty::create(['name' => 'Facultad de Recursos Naturales Renovables']);
         Faculty::create(['name' => 'Facultad de Ciencias Económicas y Administrativas']);
         Faculty::create(['name' => 'Facultad de Ingeniería en Informática y Sistemas']);
         Faculty::create(['name' => 'Facultad de Ciencias Contables']);
         Faculty::create(['name' => 'Facultad en Ingeniería Mecánica']);
    }
}

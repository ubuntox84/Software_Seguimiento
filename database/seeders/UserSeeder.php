<?php

namespace Database\Seeders;

use App\Models\Faculty;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faculty_ids=Faculty::pluck('id');

        User::create([
            'name'=>'Jhon mp',
            'email'=>'jhon@seguimientofiis1.onmicrosoft.com',
            'password'=>bcrypt('password')
        ])->assignRole('admin');

        
         User::create([
            'name'=>'Carlos',
            'email'=>'carlos@seguimientofiis1.onmicrosoft.com',
            'password'=>bcrypt('password'),
             'faculty_id' => $faculty_ids->random()
        ])->assignRole('admin');
         User::create([
            'name'=>'pedro',
            'email'=>'pedro@seguimientofiis1.onmicrosoft.com',
            'password'=>bcrypt('password'),
             'faculty_id' => $faculty_ids->random()
        ])->assignRole('commission');;
         User::create([
            'name'=>'christian',
            'email'=>'christian@seguimientofiis1.onmicrosoft.com',
            'password'=>bcrypt('password'),
             'faculty_id' => $faculty_ids->random()
        ])->assignRole('user');
    }
}

<?php

namespace App\Imports;

use App\Models\Department;
use App\Models\Faculty;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DepartmentsImport implements ToModel, WithHeadingRow
{
     
    private $rows = 0;
    private $faculties;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function __construct()
    {
        $this->faculties=Faculty::pluck('id','name');
    }
    public function model(array $row)
    {
        ++$this->rows;
        return new Department([
                'name'     => $row['nombre'],
                'faculty_id'    =>$this->faculties[$row['facultad']],
        ]);
    }
      public function getRowCount(): int
    {
        return $this->rows;
    }
}

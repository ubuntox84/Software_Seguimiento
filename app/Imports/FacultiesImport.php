<?php

namespace App\Imports;

use App\Models\Faculty;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class FacultiesImport implements ToModel, WithHeadingRow
{
     private $rows = 0;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
         ++$this->rows;
        return new Faculty([
              'name'     => $row['nombre'], 
                'abbreviation'    => $row['abreviacion'],
        ]);
    }

    public function getRowCount(): int
    {
        return $this->rows;
    }
}

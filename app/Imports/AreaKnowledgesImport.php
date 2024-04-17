<?php

namespace App\Imports;

use App\Models\AreaKnowledge;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AreaKnowledgesImport implements ToModel, WithHeadingRow
{ 
    private $rows = 0;
    private $curricula_id;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
     public function __construct($id)
    {
        $this->curricula_id = $id;
    }
   
    public function model(array $row)
    {
       
        ++$this->rows;
        // dd($row);
        return  AreaKnowledge::firstOrCreate([
            'name'     => $row['area_nombre'],
            'curricula_id'=>$this->curricula_id
        ]); 

        // $table->unique(['name', 'curricula_id']);
        
    }

    public function getRowCount(): int
    {
        return $this->rows;
    }
}

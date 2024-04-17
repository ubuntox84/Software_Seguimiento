<?php

namespace App\Exports;

use App\Models\Department;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DepartmentsExport implements FromCollection, WithHeadings
{
  
    use Exportable;
    
    protected $departments;
    
    public function __construct(array $departments)
    {
        $this->departments = $departments;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
     public function headings(): array
    {
        return [
            'Id',
            'Nombre',
            'Facultad',
        ];
    }
    public function collection()
    {
       
        $results = Department::with('faculties')->whereIn('id', $this->departments)->get();

        return $results->map(function ($row) {
            $customRow = new \stdClass();
            $customRow->id = $row->id;
            $customRow->name = $row->name;
            $customRow->Faculty = $row->faculties->name;
            return $customRow;
        });
    } 
}

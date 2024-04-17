<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\Exportable;
use App\Models\Faculty;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FacultiesExport implements FromCollection,  WithHeadings
{
    use Exportable;
    
    protected $faculties;
    
    public function __construct(array $faculties)
    {
        $this->faculties = $faculties;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
     public function headings(): array
    {
        return [
            'Id',
            'Nombre',
            'Abreviación',
            'Departamentos'
        ];
    }
    public function collection()
    {
       
        $results = Faculty::with('departments')->whereIn('id', $this->faculties)->get();

        return $results->map(function ($row) {
            $customRow = new \stdClass();
            $customRow->id = $row->id;
            $customRow->name = $row->name;
            $customRow->abbreviation = $row->abbreviation;
            $customRow->department = $row->departments->pluck('name')->implode(', ');
            return $customRow;
        });
    }
}

<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings
{

    use Exportable;

    protected $users;
    /**
    * @return \Illuminate\Support\Collection
    */
      public function __construct(array $users)
    {
        $this->users = $users;
    }
     public function headings(): array
    {
        return [
            'Id',
            'Código',
            'Nombre',
            'Apellido',
            'email ',
            'Facultad',
            'Rol',
            // 'Fecha Creación',
            // 'Fecha Actualización ',

        ];
    }
    public function collection()
    {
         $results = User::with('faculties','roles')
                        ->whereIn('id', $this->users)   
                        ->get();

        return $results->map(function($row) {
            // dd($row->roles->name);
        $customRow = new \stdClass();
        $customRow->id = $row->id;
        $customRow->code = $row->code;
        $customRow->name = $row->name;
        $customRow->surname = $row->surname;
        $customRow->email = $row->email;
        $customRow->Faculty = $row->faculties->name;
        $customRow->rol = $row->roles->pluck('name')->implode(', ');
        return $customRow;

     });
    }
}

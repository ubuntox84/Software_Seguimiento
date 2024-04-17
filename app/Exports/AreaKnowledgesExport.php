<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\AreaKnowledge;

class AreaKnowledgesExport implements FromCollection, WithHeadings
{
    use Exportable;

    protected $areasKnowledge;

    public function __construct(array $areasKnowledge)
    {
        $this->areasKnowledge = $areasKnowledge;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function headings(): array
    {
        return [
            'Id',
            'Nombre',
            'Currículo Id'

        ];
    }
    public function collection()
    {

        $results = AreaKnowledge::with('curriculas')->whereIn('id', $this->areasKnowledge)->get();

        return $results->map(function ($row) {
            $customRow = new \stdClass();
            $customRow->id = $row->id;
            $customRow->name = $row->name;
            $customRow->curricula_id = $row->curricula_id;
            return $customRow;
        });
    }
}

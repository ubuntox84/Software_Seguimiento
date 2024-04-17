<?php

namespace App\Http\Livewire;

use App\Csv;
use App\Imports\CurriculasImport;
use App\Models\Curricula;
// use Validator;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

use Maatwebsite\Excel\Facades\Excel;
use Livewire\WithFileUploads;

class ImportCurriculas extends Component
{
    use WithFileUploads;

    public $showModal = false;
    public $upload;
    public $nameUpload;
  
    // public $selectedColumn;
    public $columns;
    // public $fieldColumnMap = [
    //     'name' => '',
    //     'resolution' => '',
    //     'state' => '',
    //     'date_approved' => '',
    //     'date_active' => '',
    //     'date_inactive' => '',
    // ];

    protected $rules = [
        'upload' => 'required|mimes:xlsx|max:10024',
        // 'fieldColumnMap.name' => 'required',
        // 'fieldColumnMap.resolution' => 'required',
        // 'fieldColumnMap.state' => 'required',
        // 'fieldColumnMap.date_approved' => 'required',
        // 'fieldColumnMap.date_active' => 'required',
        // 'fieldColumnMap.date_inactive' => 'required',
    ];

    // protected $customAttributes = [
    //     'fieldColumnMap.name' => 'name',
    //     'fieldColumnMap.resolution' => 'resolution',
    // ];
    protected $messages = [

        'upload.required' => 'El Archivo excel es obligatorio',
        'upload.mimes' => 'El Archivo de ser en formato xlsx',
        'upload.mimes' => 'El Archivo debe pesar menos que 10MB',
        // 'fieldColumnMap.name.required' => 'El compo Nombre es obligatorio',
        // 'fieldColumnMap.resolution.required' => 'El compo Resolución es obligatorio',
        // 'fieldColumnMap.state.required' => 'El compo Estado es obligatorio',
        // 'fieldColumnMap.date_approved.required' => 'El campo Fecha de aprobación  es obligatorio',
        // 'fieldColumnMap.date_active.required' => 'El compo Fecha Activa  es obligatorio',
        // 'fieldColumnMap.date_inactive.required' => 'El compo Fecha Inactiva es obligatorio',
    ];
    
    public function updatedUpload($value)
    {
        // $this->validate();
        $this->nameUpload = $this->upload->getClientOriginalName();
        // $this->columns = Excel::toArray(new CurriculasImport($selectedColumn = array_values($this->fieldColumnMap)), $this->upload, null, \Maatwebsite\Excel\Excel::XLSX)[0][0];
        // dd($this->columns);
        // $this->guessWhichColumnsMapToWhichFields();
        // dd( $this->columns );
        // hacer algo con el nombre del archivo
    }
    public function cancelForm()
    {
        $this->reset();
        
    }

    public function import(){
        $this->validate();
        // $selectedColumn = [];
        // foreach ($this->fieldColumnMap as $value) {
        //     $selectedColumn[] = $value;
        // }
        
        $import = new CurriculasImport();
        
        Excel::import( $import , $this->upload);
        $this->emit('refreshCurriculas');
        $this->notify('Importado '.$import->getRowCount().' Curriculas!');
        $this->reset();
    }
    public function mount()
    {
       
    }
    
    public function updatingUpload($value)
    {
        Validator::make(
            ['upload' => $value],
            ['upload' => 'required|mimes:xlsx'],
            [
                'mimes' => 'El Archivo de ser en formato xlsx',
            ],
           
        )->validate();
    }

    // public function updatedUpload()
    // {
    //     $this->columns = Csv::from($this->upload)->columns();
    // }

    // public function import()
    // {
    //     $this->validate();

    //     $importCount = 0;

    //     Csv::from($this->upload)
    //         ->eachRow(function ($row) use (&$importCount) {
    //             Curricula::create(
    //                 $this->extractFieldsFromRow($row)
    //             );

    //             $importCount++;
    //         });

    //     $this->reset();

    //     $this->emit('refreshCurriculas');

    //     $this->notify('Imported '.$importCount.' Curriculas!');
    // } 

    // public function extractFieldsFromRow($row)
    // {
    //     $this->selectedColumn = collect($this->fieldColumnMap)
    //         ->filter()
    //         ->mapWithKeys(function($heading, $field) use ($row) {
    //             return [$field => $row[$heading]];
    //         })
    //         ->toArray();

    //     return $this->selectedColumn;
    // }

    // public function guessWhichColumnsMapToWhichFields()
    // {
    //     $guesses = [
    //         'name' => ['nombre', 'label'],
    //         'resolution' => ['resolución', 'label'],
    //         'state' => ['estado', 'state'],
    //         'date_approved' => ['fecha aprobación', 'date', 'time'],
    //         'date_active' => ['fecha activa', 'date', 'time'],
    //         'date_inactive' => ['fecha inactiva', 'date', 'time'],
    //     ];

    //     foreach ($this->columns as $column) {
    //         $match = collect($guesses)->search(fn($options) => in_array(strtolower($column), $options));

    //         if ($match) $this->fieldColumnMap[$match] = $column;
    //     }
    // }

}

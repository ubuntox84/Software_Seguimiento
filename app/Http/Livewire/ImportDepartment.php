<?php

namespace App\Http\Livewire;

use App\Imports\DepartmentsImport;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class ImportDepartment extends Component
{
      use WithFileUploads;

    public $showModal = false;
    public $upload;
    public $nameUpload;
  
    public $columns;
   

    protected $rules = [
        'upload' => 'required|mimes:xlsx|max:10024',
       
    ];

    protected $messages = [

        'upload.required' => 'El Archivo excel es obligatorio',
        'upload.mimes' => 'El Archivo debe ser en formato xlsx',
        'upload.max' => 'El Archivo debe pesar menos que 10MB',
      
    ];
    
    public function updatedUpload($value)
    {
        $this->validate();
        $this->nameUpload = $this->upload->getClientOriginalName();
       
    }
    public function cancelForm()
    {
        $this->reset();
        
    }

    public function import(){
        $this->validate();
      
        
        $import = new DepartmentsImport();
        
        Excel::import( $import , $this->upload);
        $this->emit('refreshDepartments');
        $this->notify('Importado '.$import->getRowCount().' Departamentos!');
        $this->reset();
    }
    public function mount()
    {
       
    }
    


    public function render()
    {
        return view('livewire.import-department');
    }
}

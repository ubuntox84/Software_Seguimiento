<?php

namespace App\Http\Livewire;

use App\Imports\FacultiesImport;
use Maatwebsite\Excel\Facades\Excel;
use Livewire\Component;
use Livewire\WithFileUploads;

class ImportFaculty extends Component
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
      
        
        $import = new FacultiesImport();
        
        Excel::import( $import , $this->upload);
        $this->emit('refreshFaculties');
        $this->notify('Importado '.$import->getRowCount().' Facultad!');
        $this->reset();
    }
    public function mount()
    {
       
    }
    

  
    public function render()
    {
        return view('livewire.import-faculty');
    }
}

<?php

namespace App\Http\Livewire;

use App\Models\Curricula;
use Livewire\Component;

class CreateCurricula extends Component
{
    

    public $curricula;

    public $curricula_id;
    public $name;
    public $resolution;
    public $date_approved;
    public $date_active;
    public $date_inactive;

    public $deleteId = '';
    public $search;
    public $sortField;
    public $sortAsc=false;

   

    protected $rules =[
       'name'=>'required|unique:curriculas|min:4|max:200',
       'resolution'=>'required|unique:curriculas|min:4|max:100',
       'date_approved'=>'required',
       'date_active'=>'required',
       'date_inactive'=>'required',
    ];

    protected $messages = [
       
        'name.required' => 'El  campo es obligatorio',
        'name.unique' => 'Este campo ya se encuentra registrado',
        'name.max' => 'Este campo no debe tener mas de 200 caracteres',
        'name.min' => 'Este campo debe tener mínimo 4 caracteres',
        
        'resolution.required' => 'El  campo es obligatorio',
        'resolution.unique' => 'Este campo ya se encuentra registrado',
        'resolution.max' => 'Este campo no debe tener mas de 100 caracteres',
        'resolution.min' => 'Este campo debe tener mínimo 4 caracteres',

        'date_approved.required' => 'La fecha de aprobación  es obligatorio',
        'date_active.required' => 'La fecha activa es obligatorio',
        'date_inactive.required' => 'La fecha inactiva es obligatorio',
    ];
public function cleanField(){
        
        $this->curricula_id='';
        $this->name='';
        $this->resolution='';
        $this->date_approved='';
        $this->date_active='';
        $this->date_inactive='';
        $this->resetValidation();
    }
     public function createCurricula(){
        $this->validate();
       Curricula::where('state', '=', true)
	    ->update([
		'state' => false, 
		
	]);

        Curricula::create([
            'name'=> $this->name,
            'resolution'=> $this->resolution,
            'state'=> true,
            'date_approved'=> $this->date_approved,
            'date_active'=> $this->date_active,
            'date_inactive'=> $this->date_inactive
        ]);

        $this->reset();

        $this->emit('refreshCurricula');
        $this->emit('messageSuccess','Currícula creada con éxito ');

    }
    public function cancelForm(){
        $this->reset();
        $this->resetValidation();
    }
    public function render()
    {
        return view('livewire.create-curricula');
    }
}

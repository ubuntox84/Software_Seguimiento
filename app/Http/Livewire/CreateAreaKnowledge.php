<?php

namespace App\Http\Livewire;
use App\Models\AreaKnowledge;
use App\Models\Curricula;
use Livewire\Component;

class CreateAreaKnowledge extends Component
{
    public $code;
    public $name;
    public $curricula_id;
    public $areaKnowledge;

    protected $rules =[
        'code'=>'required|unique:area_knowledge|min:1|max:50',
        'name'=>'required|unique:area_knowledge|min:4|max:100',
     ];

     protected $messages = [
        'code.required' => 'El  código es obligatorio',
        'code.unique' => 'Este código ya se encuentra registrado',
        'code.max' => 'Este código no debe tener mas de 50 caracteres',
        'code.min' => 'Este código debe tener mínimo 1 caracteres',

        'name.required' => 'El  nombre es obligatorio',
        'name.unique' => 'Este nombre ya se encuentra registrado',
        'name.max' => 'Este nombre no debe tener mas de 100 caracteres',
        'name.min' => 'Este nombre debe tener mínimo 4 caracteres',
        
     
    ];
    public function createAreaKnowledge()
    {
        $this->validate();
        $curricula =  Curricula::where('state', 1)->firstOrFail();
        AreaKnowledge::create([
            'curricula_id'=>$curricula->id,
            'code'=> $this->code,
            'name'=> $this->name,
        ]);

        $this->emit('refreshCourse');
        $this->emit('messageSuccess','Área de conocimiento creada con éxito ');
        $this->reset();
        // $this->emit('refreshCourseArea');
        // $this->render();
    }
    public function cancelFormArea(){
        $this->emit('closeModalCreateArea');    
        $this->reset();
        $this->resetValidation();


    }
    public function mount(AreaKnowledge $areaKnowledge)
    {
        $this->areaKnowledge = $areaKnowledge;
    }
    
    public function render()
    {
        return view('livewire.create-area-knowledge');
    }
}
        
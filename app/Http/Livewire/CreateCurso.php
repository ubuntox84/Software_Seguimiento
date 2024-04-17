<?php

namespace App\Http\Livewire;

use App\Models\AreaKnowledge;
use App\Models\Course;
use Livewire\Component;

class CreateCurso extends Component
{

    public $readyToLoad = false;

    public $code;
    public $name;
    public $theoreticalHour;
    public $practicalHour;
    public $credits;
    public $typeCourse;
    public $cycle;
    public $area_knowledge_id;

    protected $rules =[
        'code'=>'required|unique:courses|min:1|max:20',
        'name'=>'required|min:2|max:200',
        'theoreticalHour'=>'required',
        'practicalHour'=>'required',
        'cycle'=>'required',
        'credits'=>'required',
        'typeCourse'=>'required',
        'area_knowledge_id'=>'required'
     ];
    protected $messages = [
        'code.required' => 'El   Código es obligatorio',
        'code.unique' => 'El  Código ya se encuentra registrado',
        'code.max' => 'El  Código no debe tener mas de 20 caracteres',
        'code.min' => 'El  Código debe tener mínimo 1 caracteres',

        'name.required' => 'El  nombre es obligatorio',
        'name.max' => 'El  nombre no debe tener mas de 200 caracteres',
        'name.min' => 'El  nombre debe tener mínimo 2 caracteres',
        
        'practicalHour.required' => 'El    horas prácticas   es obligatorio',
        'theoreticalHour.required' => 'El  horas teóricas    es obligatorio',
        'cycle.required' => 'El  ciclo teóricas    es obligatorio',
        'credits.required' => 'El   crédito   es obligatorio',
        'typeCourse.required' => 'El   tipo de curso es obligatorio',

        'area_knowledge_id.required'=>'El  área de conocimiento es obligatorio'
     
    ];
    
    protected $listeners = [
        'loadAreaKnowlead'=>'render'
    ];
    // public function loadData(){
    //     dd('hoad');
    //     $this->render();
    // }

    public function createCourse(){
        $this->validate();
        Course::create([
            'code'=>$this->code,
            'name'=>$this->name,
            'theoretic_hour'=>$this->theoreticalHour,
            'practical_hour'=>$this->practicalHour,
            'type_course'=>$this->typeCourse,
            'area_knowledge_id'=>$this->area_knowledge_id,
            'credits'=>$this->credits,
            'cycle'=>$this->cycle,
        ]);
        $this->reset();
        
        $this->resetValidation();
        $this->emit('refreshCourse');
        $this->emit('messageSuccess','Curso creado con éxito ');
    }
  
    public function cancelFormCourse(){

        $this->emit('closeModalCreateCurso');  
        $this->reset();
        $this->resetValidation();

    }
    public function areaKnowledge(){
        $this->render();
    }
    public function render()
    {
        return view('livewire.create-curso',[
            'areaKnowledges' => AreaKnowledge::with('curriculas')->whereHas('curriculas',function($query){
                $query->where('state',1);
            })->get(),
        ]);
    }
}

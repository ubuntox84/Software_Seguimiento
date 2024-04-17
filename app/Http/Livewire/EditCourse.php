<?php

namespace App\Http\Livewire;

use App\Models\AreaKnowledge;
use App\Models\Course;
use Livewire\Component;

use Illuminate\Validation\Rule;

class EditCourse extends Component
{
    public $code;
    public $name;
    public $theoreticalHour;
    public $practicalHour;
    public $credits;
    public $typeCourse;
    public $cycle;
    public $area_knowledge_id;
    public $course_id;
    protected function rules()
    {
        return [
            'name' => [
                'required',
                Rule::unique('courses')->ignore($this->course_id),

                'min:2',
                'max:20'
            ],
            'name' => 'required|min:2|max:200',
            'theoreticalHour' => 'required',
            'practicalHour' => 'required',
            'cycle' => 'required',
            'credits' => 'required',
            'typeCourse' => 'required',
            'area_knowledge_id' => 'required'
        ];
    }
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

        'area_knowledge_id.required' => 'El  área de conocimiento es obligatorio'

    ];
    protected $listeners = [
        'loadFormEditCourse'
    ];
    public function cancelFormCourse()
    {

        $this->emit('closeModalEditCurso');
        $this->reset();
        $this->resetValidation();
    }
    public function loadFormEditCourse($id)
    {

        $course = Course::findOrFail($id);
        $this->course_id = $course->id;
        $this->code = $course->code;
        $this->name = $course->name;
        $this->theoreticalHour = $course->theoretic_hour;
        $this->practicalHour = $course->practical_hour;
        $this->credits = $course->credits;
        $this->typeCourse = $course->type_course;
        $this->cycle = $course->cycle;
        $this->area_knowledge_id = $course->area_knowledge_id;
    }
    public function updateCourse(){
        $this->validate();
        
        $course = Course::findOrFail($this->course_id);
        $course->update([
            'code'=>$this->code,
            'name'=>$this->name,
            'theoretic_hour'=>$this->theoreticalHour,
            'practical_hour'=>$this->practicalHour,
            'type_course'=>$this->typeCourse,
            'area_knowledge_id'=>$this->area_knowledge_id,
            'credits'=>$this->credits,
            'cycle'=>$this->cycle,
        ]);
        
        $this->resetValidation();
        $this->emit('refreshCourse');
        $this->emit('messageSuccess','Curso actualizado con éxito ');
    }
  
    public function render()
    {
        return view('livewire.edit-course', [
            'areaKnowledges' => AreaKnowledge::with('curriculas')->get(),
        ]);
    }
}

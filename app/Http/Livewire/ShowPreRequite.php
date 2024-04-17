<?php

namespace App\Http\Livewire;

use App\Models\Course;
use App\Models\Curricula;
use Livewire\Component;

class ShowPreRequite extends Component
{
    public $coursePre;
    public $course_id;
    public $add_course_id='';
    public $courses=[];
    public $curricula_id;
    public $selectCourses =[];
    public $select2Initialized ;
    public $curriculaState;
    
  protected $messages = [
       
    'selectCourses.*.unique' => 'Este curso ya está en la lista de requisitos previos.',
];
  public function rules()
{
    return [
        'selectCourses.*' => 'nullable|integer|exists:courses,id|unique:prerequisites,prerequisite_id,NULL,id,course_id,' . $this->course_id,
    ];
}
protected $listeners = ['refresh' => '$refresh'];
    public $showModalPre = false;
   
    public function savePre(){
      $this->validate();
      $course = Course::find($this->course_id);
      $course->prerequisites()->attach($this->selectCourses);
      $this->notify('Se agregaron los cursos prerrequisitos  con Éxito!');
      $this->render();
      $this->add_course_id='';
      $this->selectCourses=[];
      $this->emitSelf('refresh'); 
    }
    public function updatedshowModalPre(){
      // dd(empty($this->selectCourses));
      if (!$this->showModalPre && empty($this->selectCourses)) {
        $this->emitUp('refreshAreaknowledge');
        $this->cancelForm();
      }
    }
    public function handleChange($value){
      if (!in_array($value,$this->selectCourses)) {
        $this->selectCourses = [...$this->selectCourses, $value];
    }
      $this->add_course_id='';
    }
   public function removeSelectCourse($id)
    {
     $posicion = array_search($id, $this->selectCourses); 
     if ($posicion !== false) {
      unset($this->selectCourses[$posicion]);
      }
    }
    public function deletePrerequisite($id){
      $course = Course::find($this->course_id);
      $course->prerequisites()->detach($id);
      $this->notify('Prerequisito eliminado  con Éxito!');
      $this->emitSelf('refresh'); 
    }
    public function showPreRequisites()
    {
      $this->showModalPre=true;
    }
    public function cancelForm()
    {
     
      $this->selectCourses=[];
      $this->showModalPre=false;

    
      $this->resetValidation();
    }

    public function mount(Course $course)
{
    
   $this->curriculaState = Curricula::find($this->curricula_id);
 
    $this->courses = Course::query()->select('id','name',)->whereHas('areaKnowledges', function ($query)  {
      $query->where('curricula_id', $this->curricula_id);   
   })->get();
}



    public function render()
    {
   
        return view('livewire.show-pre-requite',[
          
        ]);
        
    }
}

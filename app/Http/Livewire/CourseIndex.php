<?php

namespace App\Http\Livewire;

use App\Models\AreaKnowledge;
use App\Models\Course;
use App\Models\Curricula;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class CourseIndex extends Component
{
    use WithPagination;

    public $coursesAdd = [];
    public $activeIndex;
    public $nameAreaKnowledge = '';
    public $area_knowledge_id;

    public $sizePage = 10;
    public $search;
    public $showModal;
    public $deleteById;



    
    protected $rules = [
        'coursesAdd.*.code' => 'required|unique:courses|min:1|max:20',
        'coursesAdd.*.name' => 'required|unique:courses|min:2|max:200',
        'coursesAdd.*.theoreticalHour' => 'required',
        'coursesAdd.*.practicalHour' => 'required',
        'coursesAdd.*.credits' => 'required',
        'coursesAdd.*.typeCourse' => 'required',
        'area_knowledge_id' => 'required'
    ];
    protected $messages = [
        'coursesAdd.*.code.required' => 'El  campo Código es obligatorio',
        'coursesAdd.*.code.unique' => 'El campo Código ya se encuentra registrado',
        'coursesAdd.*.code.max' => 'El campo Código no debe tener mas de 20 caracteres',
        'coursesAdd.*.code.min' => 'El campo Código debe tener mínimo 1 caracteres',

        'coursesAdd.*.name.required' => 'El campo nombre es obligatorio',
        'coursesAdd.*.name.unique' => 'El campo nombre ya se encuentra registrado',
        'coursesAdd.*.name.max' => 'El campo nombre no debe tener mas de 200 caracteres',
        'coursesAdd.*.name.min' => 'El campo nombre debe tener mínimo 2 caracteres',

        'coursesAdd.*.practicalHour.required' => 'El   campo horas prácticas   es obligatorio',
        'coursesAdd.*.theoreticalHour.required' => 'El campo horas teóricas    es obligatorio',
        'coursesAdd.*.credits.required' => 'El  campo crédito   es obligatorio',
        'coursesAdd.*.typeCourse.required' => 'El  campo tipo de curso es obligatorio',

        'area_knowledge_id.required' => 'El campo área de conocimiento es obligatorio'

    ];
    protected $listeners = [
        'refreshCourse' => 'render',
    ];
    public function loadDataCursos()
    {
       ddd($this->activeIndex);
    }
    public function registrar()
    {

        $this->validate();
        $curricula = Curricula::where('state', 1)->firstOrFail();
        foreach ($this->coursesAdd as $course) {

            $courseNew = new Course();
            $courseNew->code = $course['code'];
            $courseNew->name = $course['name'];
            $courseNew->theoretic_hour = $course['theoreticalHour'];
            $courseNew->practical_hour = $course['practicalHour'];
            $courseNew->type_course = $course['typeCourse'];
            $courseNew->curricula_id = $curricula->id;
            $courseNew->area_knowledge_id = $this->area_knowledge_id;
            $courseNew->credits = $course['credits'];
            $courseNew->cycle = $course['cycle'];
            $courseNew->save();
        }
        $this->render();
        $this->coursesAdd = [];
        $this->emit('messageSuccess', 'Curso registrado con  éxito');
        $this->resetExcept('sizePage');
        $this->resetErrorBag();
        $this->resetValidation();
    }
    public function deleteId($id,$name)
    {
        $this->deleteById = $id;
        $this->showModal = $name;
        $this->emit('showModalConfirm');
    }
    public function deleteAreaKnowledge()
    {
        AreaKnowledge::findOrFail($this->deleteById)->delete();
        // $this->curricula = Curricula::find($this->id);
        $this->deleteById='';
        $this->emit('messageSuccess','Área de conocimiento  eliminada con éxito');
        $this->resetExcept('sizePage');
    }
    public function deleteCourse()
    {
        Course::findOrFail($this->deleteById)->delete();
        // $this->curricula = Curricula::find($this->id);
        $this->deleteById='';
        $this->emit('messageSuccess','Curso  eliminada con éxito');
        $this->resetExcept('sizePage');
    }
    // public function refreshAreaKnowledgeOnCurse()
    // {
    //     $this->nameAreaKnowledge = '';
    //     $this->area_knowledge_id = '';
    //     $this->render();
    // }
    public function render()
    {
        $searchCourse =$this->search;
        return view('livewire.course-index', [
            'areaKnowledgesList' => AreaKnowledge::with('courses')->when(strlen($this->search) >= 2, function ($query) use ($searchCourse) {
                         $query->whereHas('courses',function($query) use ($searchCourse)  {
                            $query->where('name', 'like', '%' . $searchCourse . '%')
                                    ->orWhere('code', 'like', '%'.$searchCourse.'%');
                        })->orWhere('name', 'like', '%'.$this->search.'%')
                        ;
                    })->whereHas('curriculas',function($query)  {
                        $query->where('curriculas.state',1);
                    })
                    ->paginate($this->sizePage),
        ]);
    }
}
// $posts = Post::when($request->has('author'), function ($query) use ($request) {
//     $query->whereHas('user', function ($query) use ($request) {
//         $query->where('name', 'like', '%' . $request->input('author') . '%');
//     });
// })->get();